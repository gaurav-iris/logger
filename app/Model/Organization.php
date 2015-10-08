<?php
App::uses('AppModel', 'Model');
/**
 * Organization Model
 *
 * @property User $User
 * @property Timezone $Timezone
 * @property Project $Project
 * @property User $User
 */
class Organization extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

        public $helpers = array('Image');

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
        public $validate = array(
          
            'title' => array(
                'required' => array(
                    'rule' => array('notEmpty'),
                    'message' => 'Please provide name!'
                ),
                'min_length' => array(
                    'rule' => array('minLength', '2'), 
                    'message' => 'Organization name must be greater than 2 chars'
                )
            )
         );
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Timezone' => array(
			'className' => 'Timezone',
			'foreignKey' => 'timezone_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Project' => array(
			'className' => 'Project',
			'joinTable' => 'organizations_projects',
			'foreignKey' => 'organization_id',
			'associationForeignKey' => 'project_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'OrganizationUser' => array(
			'className' => 'User',
			'joinTable' => 'organizations_users',
			'foreignKey' => 'organization_id',
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
        
        public function beforeSave($options = array()) {
//            $this->data[$this->alias]['slug'] = strtolower(Inflector::slug($this->data[$this->alias]['title'],'-'));
            if (!empty($this->data[$this->alias]['title']) && empty($this->data[$this->alias]['slug'])) {
            if (!empty($this->data[$this->alias][$this->primaryKey])) {
                $this->data[$this->alias]['slug'] = $this->generateSlug($this->data[$this->alias]['title'], $this->data[$this->alias][$this->primaryKey]);
            } else {
                $this->data[$this->alias]['slug'] = $this->generateSlug($this->data[$this->alias]['title']);
            }
        }

        return true;
        }

        public function findWithUserId($uid){
            $this->recursive=-1;
            $result = $this->query("SELECT *
                        FROM `organizations` Organization
                        LEFT JOIN `organizations_users` OrganizationsUser ON ( Organization.id = OrganizationsUser.organization_id )
                        WHERE OrganizationsUser.user_id ='$uid' group by Organization.id");
            return $result;
        }
        
        public function findOrgUsrProject($org_id,$uid){
            $this->recursive=-1;
            $result = $this->query("SELECT *
                        FROM `projects` Project
                        LEFT JOIN organizations_projects OrganizationProject ON ( Project.id = OrganizationProject.project_id )
                        LEFT JOIN projects_users ProjectUser ON ( Project.id = ProjectUser.project_id )
                        WHERE ProjectUser.user_id ='$uid'
                        AND OrganizationProject.organization_id ='$org_id'");
            return $result;
        }
        
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


}
