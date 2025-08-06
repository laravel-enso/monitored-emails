<?php

use LaravelEnso\Migrator\Database\Migration;

return new class extends Migration {
    protected array $permissions = [
        ['name' => 'administration.index', 'description' => 'Show index for monitored emails', 'is_default' => false],

        ['name' => 'administration.create', 'description' => 'Create monitored email', 'is_default' => false],
        ['name' => 'administration.store', 'description' => 'Store a new monitored email', 'is_default' => false],
        ['name' => 'administration.edit', 'description' => 'Edit monitored email', 'is_default' => false],
        ['name' => 'administration.update', 'description' => 'Update monitored email', 'is_default' => false],
        ['name' => 'administration.destroy', 'description' => 'Delete monitored email', 'is_default' => false],
        ['name' => 'administration.initTable', 'description' => 'Init table for monitored emails', 'is_default' => false],

        ['name' => 'administration.tableData', 'description' => 'Get table data for monitored emails', 'is_default' => false],

        ['name' => 'administration.exportExcel', 'description' => 'Export excel for monitored emails', 'is_default' => false],

    ];

    protected array $menu = [
        'name' => 'Monitored Emails', 'icon' => 'envelope-open', 'route' => 'administration.index', 'order_index' => 9999, 'has_children' => false
    ];

    protected ?string $parentMenu = 'Administration';
};
