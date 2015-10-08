<?php
App::uses('AppModel', 'Model');
/**
 * Activity Model
 *
 * @property Timesheet $Timesheet
 */
class Activity extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'notes';


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
        
        public function saveActivities12($timeframs,$timesheet_id){
            if($timeframs){
                foreach($timeframs as $item){
                    $frame = json_decode($item);
                    $this->create();
                    $this->save(
                            array(
                                'timesheet_id'  =>  $timesheet_id,
                                'keystrokes'   =>   $frame->keysArr,
                                'mouseclicks'   =>  $frame->mouseArr,
                                'start'         =>  date('Y-m-d H:i:s', strtotime('-1 minutes', strtotime($frame->ts))),
                                'end'           =>  $frame->ts
                            )
                    );
                }
             }
        }
        
        public function saveActivities($timeframs,$timesheet_id){
            CakeLog::write('debug',  print_r($timeframs,true).'\n');
            
            $this->Activity->recursive = -1;
            $activity = $this->findByTimesheetId($timesheet_id);
            if($activity){
                $acts = ($activity['Activity']['gzip'])?gzuncompress($activity['Activity']['acts']):$activity['Activity']['acts'];
                $newacts = $this->minifyTimeframes($timeframs);
                $acts .= $newacts;
                
                $avgdata = $this->averageActivity($timeframs);
                $activity['Activity']['avg'] = $activity['Activity']['avg'] + $avgdata['a'];
                $activity['Activity']['pkts'] = $activity['Activity']['pkts'] + $avgdata['p'];
                
                $activity['Activity']['acts'] = ($activity['Activity']['gzip'])?gzcompress($acts):$acts;
                $this->save($activity['Activity']);
            }else{
                $newacts = $this->minifyTimeframes($timeframs);
                $avgdata = $this->averageActivity($timeframs);
                $newacts = (Configure::read('config.gzcompress'))?gzcompress($newacts):$newacts;
                $this->create();
                CakeLog::write('debug', 'Saving now'.'\n');
                $this->save(array('timesheet_id'=>$timesheet_id,'avg'=>$avgdata['a'],'pkts'=>$avgdata['p'],'acts'=>$newacts,'gzip'=>Configure::read('config.gzcompress')));
            }
            
        }
        
        public function minifyTimeframes($timeframs){
            $str = "";
            CakeTime::toServer($this->data[$this->alias]['start'],$this->request->data['tzid']);
            if($timeframs){
                $post = Router::getRequest();
                foreach($timeframs as $item){
                    $frame = json_decode($item);
                    $start = date('Y-m-d H:i:s', strtotime('-1 minutes', strtotime($frame->ts)));
                    $atom = array(
                        't'   =>  $frame->userActivity,
                        'k'   =>  $frame->keys,
                        'm'   =>  $frame->mouse,
                        'n'   =>  $frame->notes,
                        's'   =>  CakeTime::toServer($start,$post['data']['tzid']),
                        'e'   =>  CakeTime::toServer($frame->ts,$post['data']['tzid']),
                    );
                    $str .= json_encode($atom) . '|';
                }
                return $str;
             }
             return false;
        }
        
        public function averageActivity($timeframs){
           $avg = 0;
           $pkts = 0;
            if($timeframs){
                foreach($timeframs as $item){
                    $frame = json_decode($item);
                    $avg+=$frame->userActivity;
                    $pkts++;
                }
                return array('a'=>$avg,'p'=>$pkts);
             }
             return false;
        }
}
