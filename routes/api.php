<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\MonitoredEmails\Http\Controllers\Administration\Create;
use LaravelEnso\MonitoredEmails\Http\Controllers\Administration\Destroy;
use LaravelEnso\MonitoredEmails\Http\Controllers\Administration\Edit;
use LaravelEnso\MonitoredEmails\Http\Controllers\Administration\ExportExcel;
use LaravelEnso\MonitoredEmails\Http\Controllers\Administration\Index;
use LaravelEnso\MonitoredEmails\Http\Controllers\Administration\InitTable;
use LaravelEnso\MonitoredEmails\Http\Controllers\Administration\Store;
use LaravelEnso\MonitoredEmails\Http\Controllers\Administration\TableData;
use LaravelEnso\MonitoredEmails\Http\Controllers\Administration\TestEmail;
use LaravelEnso\MonitoredEmails\Http\Controllers\Administration\Update;

Route::middleware(['api', 'auth', 'core'])
    ->prefix('api/administration/monitoredEmails')
    ->as('administration.monitoredEmails.')
    ->group(function () {
        Route::get('', Index::class)->name('index');
        Route::get('create', Create::class)->name('create');
        Route::post('', Store::class)->name('store');
        Route::get('{monitoredEmail}/edit', Edit::class)->name('edit');
        Route::patch('{monitoredEmail}', Update::class)->name('update');
        Route::delete('{monitoredEmail}', Destroy::class)->name('destroy');
        Route::get('initTable', InitTable::class)->name('initTable');
        Route::get('tableData', TableData::class)->name('tableData');
        Route::get('exportExcel', ExportExcel::class)->name('exportExcel');
        Route::get('{monitoredEmail}/testEmail', TestEmail::class)->name('testEmail');
    });
