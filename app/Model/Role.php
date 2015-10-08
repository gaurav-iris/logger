<?php
App::uses('AppModel', 'Model');
/**
 * Role Model
 *
 * @property OrganizationsUser $OrganizationsUser
 */
class Role extends AppModel {

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
	public $hasMany = array(
		'OrganizationsUser' => array(
			'className' => 'OrganizationsUser',
			'foreignKey' => 'role_id',
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

        public function getName($id){
            $this->id = $id;
            return $this->field('title');
        }
}
