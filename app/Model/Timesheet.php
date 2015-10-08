<?php
App::uses('AppModel', 'Model');
/**
 * Timesheet Model
 *
 * @property User $User
 * @property Project $Project
 * @property Timezone $Timezone
 * @property Activity $Activity
 */
class Timesheet extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'session_key';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
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
		),
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id',
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
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Activity' => array(
			'className' => 'Activity',
			'foreignKey' => 'timesheet_id',
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
                'Screenshot' => array(
			'className' => 'Screenshot',
			'foreignKey' => 'timesheet_id',
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

        public function getTimeByProject($project_id,$user_id){
            $day_start = date('Y-m-d') . ' 00:00:00';
            $day_end   = date('Y-m-d') . ' 23:59:59';
            
            $this->recursive = -1;
            $time = $this->find('all',array(
                'fields'=>array('(SUM(Timesheet.duration)) as time'),
                'conditions'    =>  array('Timesheet.project_id'=>$project_id,'Timesheet.user_id'=>$user_id,"start >=" => $day_start,"end <=" => $day_end)
            ));
            if(isset($time[0][0]['time']))
                return $time[0][0]['time'];
            else return 0;
        }
        
        public function getTimeByUser($user_id){
            $day_start = date('Y-m-d') . ' 00:00:00';
            $day_end   = date('Y-m-d') . ' 23:59:59';
            
            $this->recursive = -1;
            $time = $this->find('all',array(
                'fields'=>array('(SUM(Timesheet.duration)) as time'),
                'conditions'    =>  array('Timesheet.user_id'=>$user_id,"start >=" => $day_start,"end <=" => $day_end)
            ));
            if(isset($time[0][0]['time']))
                return $time[0][0]['time'];
            else return 0;
        }
        
        public function beforeSave($options = array()){
            $post = Router::getRequest();
            if (!isset($this->data[$this->alias]['id'])) {
                $this->data[$this->alias]['start'] = CakeTime::toServer($this->data[$this->alias]['start'],$post['data']['tzid']);
            }
            if (isset($this->data[$this->alias]['end'])) {
                $this->data[$this->alias]['end'] = CakeTime::toServer($this->data[$this->alias]['end'],$post['data']['tzid']);
            }
        }
}
