<?php
App::uses('AppModel', 'Model');
/**
 * Screenshot Model
 *
 * @property Timesheet $Timesheet
 */
class Screenshot extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'image';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Timesheet' => array(
			'className' => 'Timesheet',
			'foreignKey' => 'timesheet_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
}
