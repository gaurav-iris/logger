<?php
App::uses('AppModel', 'Model');
/**
 * Project Model
 *
 * @property Task $Task
 * @property Timesheet $Timesheet
 * @property Organization $Organization
 * @property User $User
 */
class Project extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
        public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
        );
	public $hasMany = array(
		'Task' => array(
			'className' => 'Task',
			'foreignKey' => 'project_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Timesheet' => array(
			'className' => 'Timesheet',
			'foreignKey' => 'project_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Organization' => array(
			'className' => 'Organization',
			'joinTable' => 'organizations_projects',
			'foreignKey' => 'project_id',
			'associationForeignKey' => 'organization_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'User' => array(
			'className' => 'User',
			'joinTable' => 'projects_users',
			'foreignKey' => 'project_id',
			'associationForeignKey' => 'user_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

        public function generateSlug($title = null, $id = null) {
            if (!$title) {
                throw new NotFoundException(__('Invalid Title'));
            }

            $title = strtolower($title);
            $slug  = Inflector::slug($title, '-');

            $conditions = array();
            $conditions[$this->alias . '.slug'] = $slug;

            if ($id) {
                $conditions[$this->primaryKey. ' NOT'] = $id;
            }

            $total = $this->find('count', array('conditions' => $conditions, 'recursive' => -1));
            if ($total > 0) {
                for ($number = 2; $number > 0; $number ++) {
                    $conditions[$this->alias . '.slug'] = $slug . '-' . $number;
                    $conditions['user_id'] = CakeSession::read("Auth.User.id");
                    $total = $this->find('count', array('conditions' => $conditions, 'recursive' => -1));
                    if ($total == 0) {
                        return $slug . '-' . $number;
                    }
                }
            }

            return $slug;
        }
        
        public function beforeSave($options = array()) {
            if (!empty($this->data[$this->alias]['title']) && empty($this->data[$this->alias]['slug'])) {
                if (!empty($this->data[$this->alias][$this->primaryKey])) {
                    $this->data[$this->alias]['slug'] = $this->generateSlug($this->data[$this->alias]['title'], $this->data[$this->alias][$this->primaryKey]);
                } else {
                    $this->data[$this->alias]['slug'] = $this->generateSlug($this->data[$this->alias]['title']);
                }
            }
            return true;
        }
}
