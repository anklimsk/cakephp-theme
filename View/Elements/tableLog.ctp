<?php
/**
 * This file is the view file of the plugin. Used for rendering
 *  table information of logs.
 *
 * CakeTheme: Set theme for application.
 * @copyright Copyright 2016, Andrey Klimov.
 * @package plugin.View.Elements
 */

if (!isset($logs)) {
    $logs = [];
}

if (empty($logs)) {
    return;
}

    $this->loadHelper('CakeTheme.ViewExtension');
?>
<div class="table-responsive table-filter">
<?php echo $this->Filter->openFilterForm(); ?>  
        <table class="table table-hover table-striped table-condensed">
            <thead>
<?php
    $formInputs = [
        'Log.title' => [
            'label' => __d('view_extension', 'Title'),
        ],
        'Log.description' => [
            'label' => __d('view_extension', 'Description'),
        ],
        'Log.change' => [
            'label' => __d('view_extension', 'Change'),
        ],
        'Log.model' => [
            'label' => __d('view_extension', 'Model'),
        ],
        'Log.foreign_id' => [
            'label' => __d('view_extension', 'Record'),
        ],
        'Log.action' => [
            'label' => __d('view_extension', 'Action'),
        ],
        'Employee.name' => [
            'label' => __d('view_extension', 'User'),
        ],
        'Log.created' => [
            'label' => __d('view_extension', 'Created'),
        ],
        'Log.modified' => [
            'label' => __d('view_extension', 'Modified'),
        ],
    ];
    echo $this->Filter->createFilterForm($formInputs);
?>
            </thead>
            <tbody> 
<?php
foreach ($logs as $log) {
    $tableRow = [];
    $attrRow = [];

    $actions = [];
    $actions[] = $this->ViewExtension->buttonLink(
        'fas fa-trash-alt',
        'btn-danger',
        ['controller' => 'logs', 'action' => 'delete', 'plugin' => 'cake_theme', $log['Log']['id']],
        ['title' => __d('view_extension', 'Delete record of log'), 'action-type' => 'confirm-post',
            'data-confirm-msg' => __d(
                'view_extension',
                'Are you sure you wish to delete record of log \'%s\'?',
                h($log['Log']['title'])
            )]
    );
    if (empty($actions)) {
        $actions = __d('view_extension', '&lt;None&gt;');
    } else {
        $actions = implode('', $actions);
    }

    $tableRow[] = $this->ViewExtension->popupModalLink(
        h($log['Log']['title']),
        ['controller' => 'logs', 'action' => 'view', 'plugin' => 'cake_theme', $log['Log']['id']]
    );
    $tableRow[] = $this->ViewExtension->truncateText(h($log['Log']['description']), 100);
    $tableRow[] = $this->ViewExtension->showEmpty(
        $log['Log']['change'],
        $this->ViewExtension->truncateText(h($log['Log']['change']), 100)
    );
    $tableRow[] = h($log['Log']['model']);
    $tableRow[] = ($log['Log']['action'] !== 'delete' ? $this->ViewExtension->popupModalLink(
        h($log['Log']['foreign_id']),
        ['controller' => Inflector::tableize($log['Log']['model']), 'action' => 'view',
            'plugin' => null,
            $log['Log']['foreign_id']]
    ) : $this->Html->tag('del', h($log['Log']['foreign_id'])));
    $tableRow[] = h($log['Log']['action']);
    $tableRow[] = $this->ViewExtension->showEmpty(
        $log['Log']['user_id'],
        $this->ViewExtension->popupModalLink(
            h($log['Employee']['name']),
            ['controller' => 'employees', 'action' => 'view', 'plugin' => 'cake_ldap',
            'prefix' => false,
            $log['Employee']['id']]
        )
    );
    $tableRow[] = [$this->ViewExtension->timeAgo($log['Log']['created']),
        ['class' => 'text-center']];
    $tableRow[] = [$this->ViewExtension->timeAgo($log['Log']['modified']),
        ['class' => 'text-center']];
    $tableRow[] = [$actions, ['class' => 'action text-center']];

    echo $this->Html->tableCells($tableRow, $attrRow, $attrRow);
}
?>
            </tbody>
        </table>
<?php
    echo $this->Filter->closeFilterForm();
    echo $this->Html->div('confirm-form-block', $this->fetch('confirm-form'));
?>
    </div>
<?php
    echo $this->ViewExtension->buttonsPaging();

