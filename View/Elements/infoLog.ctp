<?php
/**
 * This file is the view file of the plugin. Used for rendering
 *  informations of log.
 *
 * CakeTheme: Set theme for application.
 * @copyright Copyright 2016, Andrey Klimov.
 * @package plugin.View.Elements
 */

if (!isset($log) || empty($log)) {
    return;
}

    $this->loadHelper('CakeTheme.ViewExtension');
?> 
<dl class="dl-horizontal">
<?php
    echo $this->Html->tag('dt', __d('view_extension', 'Title') . ':');
    echo $this->Html->tag('dd', h($log['Log']['title']));
    echo $this->Html->tag('dt', __d('view_extension', 'Description') . ':');
    echo $this->Html->tag('dd', $this->ViewExtension->truncateText(h($log['Log']['description']), 100));
    echo $this->Html->tag('dt', __d('view_extension', 'Change') . ':');
    echo $this->Html->tag('dd', $this->ViewExtension->showEmpty(
        $log['Log']['change'],
        $this->ViewExtension->truncateText(h($log['Log']['change']), 100)
    ));
    echo $this->Html->tag('dt', __d('view_extension', 'Model') . ':');
    echo $this->Html->tag('dd', h($log['Log']['model']));
    echo $this->Html->tag('dt', __d('view_extension', 'Record') . ':');
    echo $this->Html->tag('dd', ($log['Log']['action'] !== 'delete' ? $this->ViewExtension->popupModalLink(
        h($log['Log']['foreign_id']),
        ['controller' => Inflector::pluralize(mb_strtolower($log['Log']['model'])),
            'action' => 'view',
        $log['Log']['foreign_id']]
    ) : $this->Html->tag('del', h($log['Log']['foreign_id']))));
    echo $this->Html->tag('dt', __d('view_extension', 'Action') . ':');
    echo $this->Html->tag('dd', h($log['Log']['action']));
    echo $this->Html->tag('dt', __d('view_extension', 'User') . ':');
    echo $this->Html->tag('dd', $this->ViewExtension->showEmpty(
        $log['Log']['user_id'],
        $this->ViewExtension->popupModalLink(
            h($log['Employee']['name']),
            ['controller' => 'employees', 'action' => 'view', 'plugin' => 'cake_ldap',
            'prefix' => false,
            $log['Employee']['id']]
        )
    ));
    echo $this->Html->tag('dt', __d('view_extension', 'Created') . ':');
    echo $this->Html->tag('dd', $this->ViewExtension->timeAgo($log['Log']['created']));
    echo $this->Html->tag('dt', __d('view_extension', 'Modified') . ':');
    echo $this->Html->tag('dd', $this->ViewExtension->timeAgo($log['Log']['modified']));
?>
</dl>
