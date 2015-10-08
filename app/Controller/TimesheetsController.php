<?php
App::uses('AppController', 'Controller');
/**
 * Timesheets Controller
 *
 */
class TimesheetsController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $components = array('Paginator', 'Session');

         public $paginate = array(
            'limit' => 5,
            'contain' => array('Project')
        );
         
        public function beforeFilter() {
            parent::beforeFilter();
            $this->uid = CakeSession::read("Auth.User.id");
        }

        public function index(){
	        if(isset($_GET['date'])){
	                $this->getList($_GET['date']);
	            }else{
	                $this->getList();
            }
        }
        
        public function getList($date=''){
            if(!$date) $date = date('Y-m-d');
            $this->date = $date;
            
//            $day_start = $date . ' 00:00:00';
//            $day_end   = $date . ' 23:59:59';
            
            $day_start = CakeTime::toServer($date . ' 00:00:00','UTC');
            $day_end   = CakeTime::toServer($date . ' 23:59:59','UTC');
//            echo $day_start, $day_end . '\n';
             $day_start = date("Y-m-d H:i:s", strtotime($day_start . '-5 hours -30 minutes'));
              $day_end = date("Y-m-d H:i:s", strtotime($day_end . '-5 hours -30 minutes'));

//            $tzs = CakeTime::listTimezones();
//            print_r($tzs); exit;
//            echo $day_start, $day_end; exit;
            
            $this->Timesheet->recursive = -1;
            $this->Timesheet->Behaviors->load('Containable');
            $total = 0;
            if($this->request->is('ajax')){
                $timesheet = $this->Timesheet->find('all',array(
                    'contain' => array('Project'),
                    'conditions' => array('Timesheet.user_id'=>$this->uid,"start >=" => $day_start,"start <=" => $day_end)
                ));

                $json = array();
                foreach($timesheet as $item){
                    $json['ts'][] = array(
                        'id' => $item['Timesheet']['id'],
                        'project' => $item['Project']['title'],
                        'start'   => CakeTime::toServer($item['Timesheet']['start']),
                        'end'     => CakeTime::toServer($item['Timesheet']['end']),
                        'duration'=>gmdate("H:i:s", $item['Timesheet']['duration'])
                     );
                     $total += $item['Timesheet']['duration'];
                }
                $json['status']=true;
                $json['total']=gmdate(Configure::read('config.tm.time'), $total);
                $json['date'] = date(Configure::read('config.tm.date'),  strtotime($this->date));
                $json['prev'] = date('Y-m-d', strtotime($this->date .' -1 day'));
                if($this->date < date('Y-m-d'))
                    $json['next'] = date('Y-m-d', strtotime($this->date .' +1 day'));
                die(json_encode($json));
            }
            
           
            $this->Paginator->settings = array(
                'limit' => 5,
                'contain' => array('Project'),
                'conditions' => array('user_id'=>$this->uid,"start >=" => $day_start,"start <=" => $day_end)
            );
            $this->set('timesheets', $this->Paginator->paginate('Timesheet'));
        }
        
        public function ajax(){
        	if($this->request->is('ajax')){
        		if($this->request->is('post')){
        			$post = $this->request->data;
        			$path = $post['_p'];
        			switch($path){
        				case "timesheets":
        					if(isset($post['_a']) && $post['_a']){
        						parse_str($post['_a'],$params);
        						$this->getList($params['day']);
        					}else{
        						$this->getList();
        					}
        					break;
        				default:
        					die(json_encode(array('error'=>'Page Not found')));
        			}
        		}
        	}
        }
}
