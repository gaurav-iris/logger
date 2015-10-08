<?php
App::uses('AppModel', 'Model');
/**
 * Package Model
 *
 * @property Organization $Organization
 */
class Package extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Organization' => array(
			'className' => 'Organization',
			'joinTable' => 'organizations_packages',
			'foreignKey' => 'package_id',
			'associationForeignKey' => 'organization_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
