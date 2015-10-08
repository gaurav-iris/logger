<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class JappController extends AppController{
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = "japp";
        
        $this->loadModel('Seting');
        $settings = $this->Setting->find('all');
        
        $jsonConfig = array();
        foreach($settings as $setting){
            if($setting['Setting']['serialized']){
                $arr = unserialize($setting['Setting']['value']);
                    if(is_array($arr)){
                        foreach($arr as $k=>$v){
                            $jsonConfig[$k] = $v;
                        }
                    }else{
                        $jsonConfig[$setting['Setting']['key']] = $setting['Setting']['value'];
                    }
            }
            $jsonConfig[$setting['Setting']['key']] = $setting['Setting']['value'];
        }
        $this->loadModel('Tool');
        $user = array();
        $user['id'] = CakeSession::read("Auth.User.id");
        $user['kon'] = CakeSession::read("Auth.User.role_id");
        $user['usr'] = CakeSession::read("Auth.User.username");
        $user['fn'] = CakeSession::read("Auth.User.first_name");
        $user['ln'] = CakeSession::read("Auth.User.last_name");
        $user['em'] = CakeSession::read("Auth.User.email_id");
        if(CakeSession::read("Auth.User.image")){
            $img = CakeSession::read("Auth.User.image");
            $user['imx50'] = $this->Tool->resize($img,50,50);
            $user['imx150'] = $this->Tool->resize($img,150,150);
        }
        $this->set('player',json_encode($user));
        $this->set('config',  json_encode($jsonConfig));
        $this->set('title','Logstaff');
    }
    
    public function index(){
        
    }
}
