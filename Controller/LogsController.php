<?php
/**
 * This file is the controller file of the plugin.
 *  Used for management the payments of trip.
 *
 * CakeTheme: Set theme for application.
 * @copyright Copyright 2016, Andrey Klimov.
 * @package plugin.Controller
 */

App::uses('CakeThemeAppController', 'CakeTheme.Controller');

/**
 * The controller is used for management the logs.
 *
 * This controller allows to perform the following operations:
 *  - to obtain, delete and clear logs.
 *
 * @package plugin.Controller
 */
class LogsController extends CakeThemeAppController
{

    /**
     * The name of this controller. Controller names are plural, named after the model they manipulate.
     *
     * @var string
     * @link http://book.cakephp.org/2.0/en/controllers.html#controller-attributes
     */
    public $name = 'Logs';

    /**
     * Array containing the names of components this controller uses. Component names
     * should not contain the "Component" portion of the class name.
     *
     * Example: `public $components = array('Session', 'RequestHandler', 'Acl');`
     *
     * @var array
     * @link http://book.cakephp.org/2.0/en/controllers/components.html
     */
    public $components = [
        'Paginator',
        'CakeTheme.Filter',
        'CakeTheme.ViewExtension',
    ];

    /**
     * An array containing the names of helpers this controller uses. The array elements should
     * not contain the "Helper" part of the class name.
     *
     * Example: `public $helpers = array('Html', 'Js', 'Time', 'Ajax');`
     *
     * @var mixed
     * @link http://book.cakephp.org/2.0/en/controllers.html#components-helpers-and-uses
     */
    public $helpers = ['Time'];

    /**
     * An array containing the class names of models this controller uses.
     *
     * Example: `public $uses = array('Product', 'Post', 'Comment');`
     *
     * Can be set to several values to express different options:
     *
     * - `true` Use the default inflected model name.
     * - `array()` Use only models defined in the parent class.
     * - `false` Use no models at all, do not merge with parent class either.
     * - `array('Post', 'Comment')` Use only the Post and Comment models. Models
     *   Will also be merged with the parent class.
     *
     * The default value is `true`.
     *
     * @var mixed
     * @link http://book.cakephp.org/2.0/en/controllers.html#components-helpers-and-uses
     */
    public $uses = ['CakeTheme.Log'];

    /**
     * Settings for component 'Paginator'
     *
     * @var array
     */
    public $paginate = [
        'page' => 1,
        'limit' => 20,
        'maxLimit' => 250,
        'fields' => [
            'Log.id',
            'Log.title',
            'Log.description',
            'Log.change',
            'Log.model',
            'Log.foreign_id',
            'Log.action',
            'Log.user_id',
            'Log.created',
            'Log.modified',
            'Employee.' . CAKE_LDAP_LDAP_ATTRIBUTE_NAME
        ],
        'order' => [
            'Log.modified' => 'desc',
        ],
        'contain' => ['Employee']
    ];

    /**
     * Used to view a complete list of logs.
     *
     * @return void
     */
    public function index()
    {
        $this->Paginator->settings = $this->paginate;
        $conditions = $this->Filter->getFilterConditions();

        $logs = $this->Paginator->paginate('Log', $conditions);
        if (empty($logs)) {
            $this->Flash->information(__d('view_extension', 'Logs not found'));
        }

        $this->ViewExtension->setRedirectUrl(true, 'log');
        $pageHeader = __d('view_extension', 'Index of logs');
        $headerMenuActions = [];
        if (!empty($logs)) {
            $headerMenuActions[] = [
                'fas fa-trash-alt',
                __d('view_extension', 'Clear logs'),
                ['controller' => 'logs', 'action' => 'clear', 'prefix' => false],
                [
                    'title' => __d('view_extension', 'Clear logs'),
                    'action-type' => 'confirm-post',
                    'data-confirm-msg' => __d('view_extension', 'Are you sure you wish to clear logs?'),
                ]
            ];
        }
        $this->set(compact('logs', 'pageHeader', 'headerMenuActions'));
    }

    /**
     * Used to view information about log.
     *
     * @param int|string $id ID of record for viewing.
     *  was not found
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Log->exists($id)) {
            return $this->ViewExtension->setExceptionMessage(new NotFoundException(__d('view_extension', 'Invalid ID for record of log')));
        }

        $log = $this->Log->get($id);
        $pageHeader = __d('view_extension', 'Information of record log');
        $headerMenuActions = [
            [
                'far fa-trash-alt',
                __d('view_extension', 'Delete record of log'),
                ['controller' => 'logs', 'action' => 'delete', $log['Log']['id'], 'plugin' => 'cake_theme', 'prefix' => false],
                ['title' => __d('view_extension', 'Delete record of log'), 'action-type' => 'confirm-post']
            ]
        ];
        $this->set(compact('log', 'pageHeader', 'headerMenuActions'));
    }

    /**
     * Used to delete log.
     *
     * @param int|string $id ID of record for deleting
     * @throws MethodNotAllowedException if request is not `POST` or `DELETE`
     * @return void
     */
    public function delete($id = null)
    {
        $this->Log->id = $id;
        if (!$this->Log->exists()) {
            return $this->ViewExtension->setExceptionMessage(new NotFoundException(__d('view_extension', 'Invalid ID for record of log')));
        }

        $this->request->allowMethod('post', 'delete');
        $this->ViewExtension->setRedirectUrl(null, 'log');
        if ($this->Log->delete()) {
            $this->Flash->success(__d('view_extension', 'The record of log has been deleted.'));
        } else {
            $this->Flash->error(__d('view_extension', 'The record of log could not be deleted. Please, try again.'));
        }

        return $this->ViewExtension->redirectByUrl(null, 'log');
    }

    /**
     * Used to clear logs.
     *
     * @throws MethodNotAllowedException if request is not `POST` or `DELETE`
     * @return void
     */
    public function clear()
    {
        $this->request->allowMethod('post', 'delete');
        if ($this->Log->clearLogs()) {
            $this->Flash->success(__d('view_extension', 'The logs has been cleared.'));
        } else {
            $this->Flash->error(__d('view_extension', 'The logs could not be cleared. Please, try again.'));
        }

        return $this->redirect(['controller' => 'logs', 'action' => 'index', 'plugin' => 'cake_theme']);
    }
}
