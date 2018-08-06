<?php
/**
 * This file is the model file of the plugin. Used for
 *  management logs.
 *
 * CakeTheme: Set theme for application.
 * @copyright Copyright 2016, Andrey Klimov.
 * @package plugin.Model
 */

App::uses('CakeThemeAppModel', 'CakeTheme.Model');
App::uses('CakeSession', 'Model/Datasource');

/**
 * Log for CakeTheme.
 *
 * @package plugin.Model
 */
class Log extends CakeThemeAppModel
{

    /**
     * Name of the model.
     *
     * @var string
     */
    public $name = 'Log';

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = [
        'Employee' => [
            'className' => 'CakeLdap.Employee',
            'foreignKey' => 'user_id',
        ],
    ];

    /**
     * List of behaviors to load when the model object is initialized. Settings can be
     * passed to behaviors by using the behavior name as index.
     *
     * For example:
     *
     * ```
     * public $actsAs = array(
     *     'Translate',
     *     'MyBehavior' => array('setting1' => 'value1')
     * );
     * ```
     *
     * @var array
     * @link http://book.cakephp.org/2.0/en/models/behaviors.html#using-behaviors
     */
    public $actsAs = [
        'Containable'
    ];

    /**
     * Return information about log by record ID.
     *
     * @param int|string $id The ID of the record to read.
     * @return mixed See Model::find() Null on failure or an array of extension data on success.
     */
    public function get($id = null)
    {
        if (empty($id)) {
            return false;
        }

        $fields = [
            $this->alias . '.id',
            $this->alias . '.title',
            $this->alias . '.description',
            $this->alias . '.change',
            $this->alias . '.model',
            $this->alias . '.foreign_id',
            $this->alias . '.action',
            $this->alias . '.user_id',
            $this->alias . '.created',
            $this->alias . '.modified',
            'Employee.' . CAKE_LDAP_LDAP_ATTRIBUTE_NAME
        ];

        $conditions = [$this->alias . '.id' => $id];
        $contain = ['Employee'];

        return $this->find('first', compact('fields', 'conditions', 'contain'));
    }

    /**
     * Return information about logon user.
     *
     * @return array|null Return array of information about logon user, or
     *  Null on failure.
     */
    public function getActiveUser()
    {
        $result = null;
        $userInfo = CakeSession::read('Auth.User');
        if (empty($userInfo) || !isset($userInfo['id']) ||
            !isset($userInfo['user'])) {
            return $result;
        }

        $result = [
            $this->Employee->alias => [
                $this->Employee->primaryKey => $userInfo['id'],
                $this->Employee->displayField => $userInfo['user'],
            ]
        ];

        return $result;
    }

    /**
     * Clear logs
     *
     * @return bool Success
     */
    public function clearLogs()
    {
        $ds = $this->getDataSource();

        return $ds->truncate($this);
    }
}
