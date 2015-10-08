<?php
App::uses('AppModel', 'Model');
/**
 * Setting Model
 *
 */
class Setting extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'key';
        
        public function load(){
            $settings = $this->find('all');  
              foreach ($settings as $variable){  
                  
                if($variable['Setting']['serialized']){
                    $arr = unserialize($variable['Setting']['value']);
                    if(is_array($arr)){
                        foreach($arr as $k=>$v){
                            Configure::write($variable['Setting']['group'].'.'.$k,$v);
                        }
                    }else{
                        Configure::write($variable['Setting']['group'].'.'.$variable['Setting']['key'],$variable['Setting']['value']);
                    }
                }else{
                    Configure::write($variable['Setting']['group'].'.'.$variable['Setting']['key'],$variable['Setting']['value']);
                }
            }  
        }

}
