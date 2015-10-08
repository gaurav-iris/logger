<?php
App::uses('AppModel', 'Model');
/**
 * Timezone Model
 *
 * @property Organization $Organization
 * @property Timesheet $Timesheet
 */
class Timezone extends AppModel {

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
		'Organization' => array(
			'className' => 'Organization',
			'foreignKey' => 'timezone_id',
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
			'foreignKey' => 'timezone_id',
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

}
