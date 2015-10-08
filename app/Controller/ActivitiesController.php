<?php
App::uses('AppController', 'Controller');
/**
 * Activities Controller
 *
 */
class ActivitiesController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	
	public $components = array('Paginator', 'Session');
        
        public $intervals= array();
        public function beforeFilter() {
            parent::beforeFilter();
            $this->uid = CakeSession::read("Auth.User.id");
        }
        
        public function index(){
            $this->set('title','Activities | Logstaff');
            $this->activities = array();
            if(isset($_GET['date'])){
                $this->getDayActivity($_GET['date']);
            }else{
                $this->getDayActivity();
            }
            
             if($this->request->is('ajax')){
             	
                 $json = array(
                     'status'=>true,
                     'acts'=>$this->activities,
                     'day_total'=>$this->day_total,
                     'date'=>$this->day
                 );
                 die(json_encode($json));
             }
            $this->set('activities',$this->activities);
            $this->set('total',$this->day_total);
        }

        public function extractActiviy($activity){
            $acts = ($activity['gzip'])?gzuncompress($activity['acts']):$activity['acts'];
            $str = trim($acts,'|');
            $array = json_decode('[' . str_replace('|',',', $str) . ']');
            return $array;
        }
        
        public function view(){
           
            
        }
        
        public function getDayActivity($params = ''){
            
            
            if($params){
                if(isset($params['tz'])){ 
                    Configure::write('Config.timezone',$params['tz']); 
                    date_default_timezone_set($params['tz']);
                }
                $this->day = (isset($params['day']))?$params['day']:date('Y-m-d');
            }else{
                $this->day = date('Y-m-d');
            }
            
            $day = $this->day;
            $day_start = CakeTime::toServer($day . ' 00:00:00','UTC');
            $day_end   = CakeTime::toServer($day . ' 23:59:59','UTC');
            $day_start = date("Y-m-d H:i:s", strtotime($day_start . '-5 hours -30 minutes'));
            $day_end = date("Y-m-d H:i:s", strtotime($day_end . '-5 hours -30 minutes'));
            
            
//            $day_start = $day . ' 00:00:00';
//            $day_end   = $day . ' 23:59:59';
            
//           echo $day_start, $day_end; exit;
            $this->activities = array();
            
            $this->loadModel('Timesheet');
            $this->loadModel('Screenshot');
            $this->loadModel('Activity');
            $this->Timesheet->Behaviors->load('Containable');
            $this->Timesheet->recursive = -1;
            if($day!=date('Y-m-d')){
                $timesheets = Cache::read('act'.$day.$this->uid, 'long');
            }else{
                $timesheets = false;
            }
            $timesheets = false;
            
            if (!$timesheets) {
                $timesheets = $this->Timesheet->find('all',array(
                    'conditions'=>array(
                        "Timesheet.user_id"   => $this->uid,
                        "Timesheet.start >="  => $day_start,
                        "Timesheet.end <="    => $day_end,
                    ),
                    'order'=>array('Timesheet.start'),
                    'contain'  =>  array('Activity','Screenshot','Project')
                ));
                Cache::write('act'.$day.$this->uid, $timesheets, 'long');
            }
            
            $this->day_total = 0;
            $total_avg = 0;
//            print_r($timesheets); exit;
            foreach($timesheets as $key=>$timesheet){
                if(!isset($timesheet['Activity'][0])) continue;
                $activity = $timesheet['Activity'][0];
                $this->day_total += $timesheet['Timesheet']['duration'];
                $total_avg += $activity['avg']/$activity['pkts'];
                
                $activities = $this->extractActiviy($activity);
//                print_r($activities); exit;
                foreach ($activities as $index=>$activity){
                    $activity->s = CakeTime::toServer($activity->s,'UTC');
                    $activity->e = CakeTime::toServer($activity->e,'UTC');
                    
                    $date = strtotime($activity->s); $hour = (int)date('H', $date);
                    $m = substr(date('i', strtotime($activity->s)),0, 1);
                    $start = (!isset($this->activities[$hour][$m]['start']))?$activity->s:$this->activities[$hour][$m]['start'];
                    $end = $activity->e;
                    $mouse = (!isset($this->activities[$hour][$m]['mouse']))?$activity->m:$this->activities[$hour][$m]['mouse']+$activity->m;
                    $keys = (!isset($this->activities[$hour][$m]['keys']))?$activity->k:$this->activities[$hour][$m]['keys']+$activity->k;
                    
                    $time = ($hour>12)?($hour-12).'PM':$hour.'AM';
                    $this->activities[$hour][$m]['timesheet_id'] = $timesheet['Timesheet']['id'];
                    $this->activities[$hour][$m]['project_id'] = $timesheet['Project']['id'];
                    $this->activities[$hour][$m]['project_title'] = $timesheet['Project']['title'];
                    $this->activities[$hour][$m]['mouse'] = $mouse;
                    $this->activities[$hour][$m]['keys'] = $keys;
                    if($activity->n)
                        $this->activities[$hour][$m]['notes'][] = $activity->n;
                    $this->activities[$hour][$m]['screenshot'] = '';
                    $this->activities[$hour][$m]['start'] = date('h:i',strtotime($start));
                    $this->activities[$hour][$m]['end'] = date('h:i',strtotime($end));
                    $this->activities[$hour][$m]['time'] = $time;
                    $this->activities[$hour][$m]['duration'] = (isset($this->activities[$hour][$m]['duration']))?$this->activities[$hour][$m]['duration']+1:1;
                }
                 //exit;
                foreach($this->activities as $h=>$hour)
                    foreach($hour as $m=>$min){
                        $_m = round($min['mouse']/10);
                        $_k = round($min['keys']/10);
//                        $_o = round(sqrt(pow($_m,2)+ pow($_k,2)));
                        $this->activities[$h][$m]['_m'] = $_m;
                        $this->activities[$h][$m]['_k'] = $_k;
                        $this->activities[$h][$m]['_o'] = $_m+$_k;
                    }
                foreach ($timesheet['Screenshot'] as $screen){
                    $newtime = CakeTime::toServer($screen['timestamp'],'UTC');
                    $date = strtotime($newtime); $hour = (int)date('H', $date);
                    $m = substr(date('i', strtotime($newtime)),0, 1);
                    if($screen){
                        if(isset($this->activities[$hour][$m])){
                            $this->activities[$hour][$m]['screenshot'][] = $this->_site('sc/'.$screen['slug']."/".Configure::read('config.screen_width')."/".Configure::read('config.screen_height'));
                            $this->activities[$hour][$m]['lightbox'][] = $this->_site($screen['path'].$screen['image']);
                        }
                    }else{
                        $this->activities[$hour][$m]['screenshot'][] = $this->_site($this->Tool->crop('/shot-in-process.png',Configure::read('config.screen_width'),Configure::read('config.screen_height')));           
                    }
                }
            }
//             print_r($this->activities); exit;
            if($this->request->is('post')){
            	 $json = array(
                     'status'=>true,
                     'acts'=>$this->activities,
                     'day_total'=>$this->day_total,
                     'date'=>$this->day,
                     'avg' => $total_avg
                 );
                 $json['total']=gmdate(Configure::read('config.tm.time'), $this->day_total);
                 $json['date'] = date(Configure::read('config.tm.date'),  strtotime($day));
                 $json['prev'] = date('Y-m-d', strtotime($day .' -1 day'));
                 if($day < date('Y-m-d'))
                     $json['next'] = date('Y-m-d', strtotime($day .' +1 day'));
                 die(json_encode($json));
            }
        }
       
        public function ajax(){
            if($this->request->is('ajax')){
                if($this->request->is('post')){
                    $post = $this->request->data;
                    $path = $post['_p'];
                    switch($path){
                        case "activities":
                            if(isset($post['_a']) && $post['_a']){
                                    parse_str($post['_a'],$params);
                                    $this->getDayActivity($params);
                            }else{
                                    $this->getDayActivity();
                            }
                            break;
                        default:
                            die(json_encode(array('error'=>'Page Not found')));
                    }
                }
            }
        }

}
