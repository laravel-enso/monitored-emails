<?php

use LaravelEnso\Migrator\Database\Migration;

return new class extends Migration {
    protected array $permissions = [
        ['name' => 'administration.monitoredEmails.index', 'description' => 'Show index for monitored emails', 'is_default' => false],

        ['name' => 'administration.monitoredEmails.create', 'description' => 'Create monitored email', 'is_default' => false],
        ['name' => 'administration.monitoredEmails.store', 'description' => 'Store a new monitored email', 'is_default' => false],
        ['name' => 'administration.monitoredEmails.edit', 'description' => 'Edit monitored email', 'is_default' => false],
        ['name' => 'administration.monitoredEmails.update', 'description' => 'Update monitored email', 'is_default' => false],
        ['name' => 'administration.monitoredEmails.destroy', 'description' => 'Delete monitored email', 'is_default' => false],
        ['name' => 'administration.monitoredEmails.initTable', 'description' => 'Init table for monitored emails', 'is_default' => false],

        ['name' => 'administration.monitoredEmails.tableData', 'description' => 'Get table data for monitored emails', 'is_default' => false],

        ['name' => 'administration.monitoredEmails.exportExcel', 'description' => 'Export excel for monitored emails', 'is_default' => false],

        ['name' => 'administration.monitoredEmails.testMail', 'description' => 'Route for testing emails', 'is_default' => false],

    ];

    protected array $menu = [
        'name' => 'Monitored Emails', 'icon' => 'envelope-open', 'route' => 'administration.monitoredEmails.index', 'order_index' => 9999, 'has_children' => false,
    ];

    protected ?string $parentMenu = 'Administration';
};
