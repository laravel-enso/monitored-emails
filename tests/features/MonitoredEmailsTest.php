<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Forms\TestTraits\CreateForm;
use LaravelEnso\Forms\TestTraits\DestroyForm;
use LaravelEnso\Forms\TestTraits\EditForm;
use LaravelEnso\MonitoredEmails\Commands\FetchUnreadEmails as FetchUnreadEmailsCommand;
use LaravelEnso\MonitoredEmails\Enums\Protocol;
use LaravelEnso\MonitoredEmails\Http\Controllers\Administration\TestEmail as TestEmailController;
use LaravelEnso\MonitoredEmails\Jobs\FetchUnreadEmails as FetchUnreadEmailsJob;
use LaravelEnso\MonitoredEmails\Models\MonitoredEmail;
use LaravelEnso\MonitoredEmails\Models\MonitoredMessage;
use LaravelEnso\MonitoredEmails\Services\FetchUnreadEmails as FetchUnreadEmailsService;
use LaravelEnso\Tables\Traits\Tests\Datatable;
use LaravelEnso\Users\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Webklex\PHPIMAP\Client;
use Webklex\PHPIMAP\Folder;
use Webklex\PHPIMAP\Message;
use Webklex\PHPIMAP\Query\WhereQuery;
use Webklex\PHPIMAP\Support\MessageCollection;

class MonitoredEmailsTest extends TestCase
{
    use CreateForm, Datatable, DestroyForm, EditForm, RefreshDatabase;

    private string $permissionGroup = 'administration.monitoredEmails';
    private MonitoredEmail $testModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed()
            ->actingAs(User::first());

        $this->testModel = new MonitoredEmail([
            'email' => 'inbox@example.com',
            'password' => 'secret',
            'folder' => 'INBOX',
            'host' => 'mail.example.com',
            'port' => null,
            'protocol' => Protocol::SecureIMAP->value,
            'is_active' => true,
        ]);
    }

    protected function tearDown(): void
    {
        \Mockery::close();

        parent::tearDown();
    }

    #[Test]
    public function can_store_monitored_email(): void
    {
        $response = $this->post(
            route('administration.monitoredEmails.store', [], false),
            $this->testModel->toArray()
        );

        $monitoredEmail = MonitoredEmail::query()
            ->where('email', $this->testModel->email)
            ->where('folder', $this->testModel->folder)
            ->first();

        $response->assertStatus(200)
            ->assertJsonStructure(['message'])
            ->assertJsonFragment([
                'redirect' => 'administration.monitoredEmails.edit',
                'param' => ['monitoredEmail' => $monitoredEmail?->id],
            ]);

        $this->assertNotNull($monitoredEmail);
    }

    #[Test]
    public function validates_required_fields_on_store(): void
    {
        $this->post(route('administration.monitoredEmails.store', [], false), [])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'email', 'password', 'folder', 'host', 'protocol', 'is_active',
            ]);
    }

    #[Test]
    public function can_update_monitored_email(): void
    {
        $this->testModel->save();
        $this->testModel->folder = 'Archive';

        $this->patch(
            route('administration.monitoredEmails.update', $this->testModel->id, false),
            $this->testModel->toArray()
        )->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertSame('Archive', $this->testModel->fresh()->folder);
    }

    #[Test]
    public function stores_password_encrypted_and_returns_it_decrypted_via_cast(): void
    {
        $this->testModel->save();

        $storedPassword = DB::table('monitored_emails')
            ->where('id', $this->testModel->id)
            ->value('password');

        $this->assertNotSame('secret', $storedPassword);
        $this->assertSame('secret', $this->testModel->fresh()->password);
    }

    #[Test]
    public function test_email_returns_success_when_folder_exists(): void
    {
        $folder = \Mockery::mock(Folder::class);
        $client = \Mockery::mock(Client::class);
        $client->shouldReceive('getFolder')->once()->with('INBOX')->andReturn($folder);
        $client->shouldReceive('disconnect')->once();

        $monitoredEmail = \Mockery::mock($this->testModel)->makePartial();
        $monitoredEmail->shouldReceive('connect')->once()->andReturn($client);

        $response = (new TestEmailController())($monitoredEmail);

        $this->assertSame([
            'status' => true,
            'message' => __('Server connection accepted.'),
        ], $response);
    }

    #[Test]
    public function test_email_returns_failure_when_folder_is_missing(): void
    {
        $client = \Mockery::mock(Client::class);
        $client->shouldReceive('getFolder')->once()->with('INBOX')->andReturn(null);
        $client->shouldReceive('disconnect')->never();

        $monitoredEmail = \Mockery::mock($this->testModel)->makePartial();
        $monitoredEmail->shouldReceive('connect')->once()->andReturn($client);

        $response = (new TestEmailController())($monitoredEmail);

        $this->assertSame(false, $response['status']);
        $this->assertSame(__('Folder Not Found'), $response['message']);
    }

    #[Test]
    public function command_dispatches_jobs_only_for_active_monitored_emails(): void
    {
        Bus::fake();

        $this->testModel->save();
        MonitoredEmail::query()->create([
            'email' => 'inactive@example.com',
            'password' => 'secret',
            'folder' => 'Archive',
            'host' => 'mail.example.com',
            'port' => null,
            'protocol' => Protocol::SecureIMAP,
            'is_active' => false,
        ]);

        $this->artisan('enso:monitored-emails:fetch-unread-emails')
            ->assertSuccessful();

        Bus::assertDispatched(FetchUnreadEmailsJob::class, 1);
    }

    #[Test]
    public function service_persists_messages_once_and_marks_them_seen(): void
    {
        $this->testModel->save();

        $message = Mockery::mock(Message::class);
        $message->shouldReceive('getMessageId')->twice()->andReturn('<message-1>');
        $message->shouldReceive('getFrom')->twice()->andReturn([(object) ['mail' => 'sender@example.com']]);
        $message->shouldReceive('getSubject')->twice()->andReturn('Subject');
        $message->shouldReceive('getTextBody')->twice()->andReturn('');
        $message->shouldReceive('getHtmlBody')->twice()->andReturn('<p>Hello</p>');
        $message->shouldReceive('getDate')->twice()->andReturn('2026-04-20 10:00:00');
        $message->shouldReceive('setFlag')->twice()->with('Seen');

        $query = \Mockery::mock(WhereQuery::class);
        $query->shouldReceive('unseen')->once()->andReturnSelf();
        $query->shouldReceive('get')->once()->andReturn(new MessageCollection([$message, $message]));

        $folder = \Mockery::mock(Folder::class);
        $folder->shouldReceive('query')->once()->andReturn($query);

        $client = \Mockery::mock(Client::class);
        $client->shouldReceive('getFolder')->once()->with('INBOX')
            ->andReturn($folder);

        $monitoredEmail = \Mockery::mock($this->testModel)->makePartial();
        $monitoredEmail->shouldReceive('connect')->once()->andReturn($client);

        MonitoredMessage::withoutEvents(fn () => (new FetchUnreadEmailsService($monitoredEmail))->handle());

        $this->assertDatabaseCount('monitored_email_messages', 1);

        $stored = MonitoredMessage::query()->first();

        $this->assertSame($this->testModel->id, $stored->mail_id);
        $this->assertSame('<message-1>', $stored->message_id);
        $this->assertSame('sender@example.com', $stored->from);
        $this->assertSame('Subject', $stored->subject);
        $this->assertSame('<p>Hello</p>', $stored->body);
        $this->assertFalse($stored->has_attachments);
        $this->assertFalse($stored->is_processed);
    }
}
