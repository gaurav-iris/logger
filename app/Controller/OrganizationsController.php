<?php
App::uses('AppController', 'Controller');
/**
 * Organizations Controller
 *
 */
class OrganizationsController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;
        
        public $components = array('Session');
        
       
        
        public function beforeFilter() {
            parent::beforeFilter();
            $this->uid = CakeSession::read("Auth.User.id");
            $this->set('user_id',$this->uid);
        }
        
        public function create(){
            $this->set('title','Crete New Organization | Logstaff');
            
            if($this->request->is('ajax')){
                $this->Organization->create();
                $data['Organization'] = $this->request->data['org'];
                $data['Organization']['slug'] = '';
                $data['Organization']['user_id'] = $this->uid;
                if ($this->Organization->save($data)) {
                    $orgUser['OrganizationsUser'] = array(
                        'organization_id'=>$this->Organization->id,
                        'user_id' => $this->uid,
                        'role_id' => 1
                        );
                    $this->Organization->OrganizationsUser->save($orgUser);
                    die(json_encode(array('status'=>true,'msg'=>'Organization created','id'=>$this->Organization->id)));
                }
            }
            
            if($this->request->is('post')){
                $this->Organization->create();
                if ($this->Organization->save($this->request->data)) {
                        $this->Session->setFlash(__('The setting has been saved.'));
                        return $this->redirect(array('action' => 'index'));
                } else {
                        $this->Session->setFlash(__('The setting could not be saved. Please, try again.'));
                }
            }
            $this->loadModel('Timezone');
            $timezones = $this->Timezone->find('list');
            $this->set('user_id',$this->uid);
            $this->set(compact('timezones'));
        }
        
        public function addTimezones(){
            $this->loadModel('Timezone');
            $all = timezone_identifiers_list();
            $tz=array();
            foreach ($all as $timezone){
                $tz[] = array(
                    'title' => str_replace('/', ' ', $timezone),
                    'value' =>  $timezone,
                    'status' => 1
                );
            }
            
            $this->Timezone->saveMany($tz);
            exit;
        }
       
        public function index(){
            $this->set('title','Organizations | Logstaff');
            
            $this->getList();
            $this->loadModel('OrganizationsUser');
            $this->set('orgs',$orgs);

        }
        
        public function getList(){
            $this->loadModel('Tool');
            $this->Organization->Behaviors->load('Containable');
            $this->recursive = -1;
            $orgs = $this->Organization->find('all',array(
                        'contain'  => array('Project','Timezone','OrganizationUser','User'),
                        'joins'    => array(
                            'LEFT JOIN organizations_users as ou ON (ou.organization_id=Organization.id)'
                        ),
                        'conditions'=>array(
                            'ou.user_id'   => $this->uid
                        ),
                        'group'=>array('Organization.id')
                    )
                 );
                 
            if($this->request->is('ajax')){
                $this->loadModel('Role');
            	$json=array();
                  foreach($orgs as $key=>$item){
                        $item['Organization']['href'] = $this->_site('organizations/'.$item['Organization']['slug']);
                        if($item['Organization']['logo']){
                            $item['Organization']['logo'] = $this->Tool->crop($item['Organization']['logo'],150,150);
                        }
                  	$projects=$orgs=array();
                  	foreach($item['Project'] as $prj){
                            $projects[] = array(
                                'id'=>$prj['id'],
                                'title'=>$prj['title'],
                                'slug'=>$prj['slug'],
                                'status'	=>	$prj['status']
                            );
                  	}
                  	foreach($item['OrganizationUser'] as $org){
                            $orgs[] = array(
                                'id'	=>	$org['id'],
                                'role_id'	=>	$org['OrganizationsUser']['role_id'],
                                'role'	=>	$this->Role->getName($org['OrganizationsUser']['role_id']),
                                'user'	=>	$org['username'],
                                'display'	=>	$org['first_name'] . ' ' . $org['last_name'],
                                'email'		=>	$org['email'],
                                'image'		=>	($org['image'])?$this->Tool->crop($org['image'],32,32):'',
                                'in'    => substr($org['first_name'], 0,1) . substr($org['last_name'],0,1),
                            );
                  	}
                  	$json['org'][] = array(
                            'oz' =>$item['Organization'],
                            'tz' => $item['Timezone']['title'],
                            'pz' =>	$projects,
                            'uz' =>	$orgs
                        );
                  }
                 
                  die(json_encode($json));
            }
        }

        public function edit($slug){
            $this->set('title','Update Organization | Logstaff');
            if($this->request->data){
                if ($this->Organization->save($this->request->data)) {
                        $this->Session->setFlash(__('The Organization has been saved.'));

                        return $this->redirect(array('action' => 'index'));
                } else {
                        $this->Session->setFlash(__('The Organization could not be saved. Please, try again.'));
                }
            }else{
                $this->request->data = $this->Organization->findByUserIdAndSlug($this->uid,$slug);
                $timezones = $this->Organization->Timezone->find('list');
                $this->set(compact('timezones'));
            }
        }
        
//        public function view($slug){
//            $org = $this->Organization->findByUserIdAndSlug($this->uid,$slug);
////            print_r($org); exit;
//            $this->set(compact('org'));
//        }
        
        public function ajax(){
            if($this->request->is('ajax')){
                if($this->request->is('post')){
                    $post = $this->request->data;
                    $path = $post['_p'];

                    if($path == "organizations"){
                        $this->getList();
                    }else{
                        $actions = explode('/',$path);
                        
                        if(isset($actions[0])){
                            switch(count($actions)){
                                case 2:
                                    $this->fetchBySlug($actions[1]);
                                    die(json_encode(array('status'=>true,'org'=>$this->org)));
                                    break;
                            }
                        }
                    }
                }
            }
            die();
        }

        public function fetchBySlug($slug){
            $this->loadModel('Tool');
            $this->loadModel('Role');
            $org = $this->Organization->findByUserIdAndSlug($this->uid,$slug); 
           
            $this->org = array();
            $users = array();
//            print_r($org['OrganizationUser']); exit;
            foreach($org['OrganizationUser'] as $u){
                $users[] = array(
                    'id'	=>	$u['id'],
                    'role_id'	=>	$u['OrganizationsUser']['role_id'],
                    'ouid'      =>      $u['OrganizationsUser']['id'],
                    'role'	=>	$this->Role->getName($u['OrganizationsUser']['role_id']),
                    'user'	=>	$u['username'],
                    'display'	=>	$u['first_name'] . ' ' . $u['last_name'],
                    'email'	=>	$u['email'],
                    'image'	=>	($u['image'])?$this->Tool->crop($u['image'],32,32):'',
                    'in'        =>  substr($u['first_name'], 0,1) . substr($u['last_name'],0,1),
                    'vr'        => ($u['verified'])?'Verified':'Inactive',
                    'status'    =>  ($u['status'])?'On':'Off',
                );
            }
            $org['Organization']['href'] = $this->_site('organizations/view/'.$org['Organization']['slug']);
            $org['Organization']['logo'] = $this->Tool->crop($org['Organization']['logo'],150,150);           
            $this->org['oz'] = $org['Organization'];
            $this->org['pz'] = $org['Project'];
            $this->org['tz'] = $org['Timezone'];
            $this->org['uz'] = $users;
        }
        
        public function sfu(){
            if($this->request->is('ajax')){
                $post = $this->request->data;
                    if (!$this->Organization->exists($post['id'])) {
			throw new NotFoundException(__('Invalid Organization'));
                    }
                    $this->Organization->save(array('id'=>$post['id'],$post['f']=>$post['value']));
            }
            die($post['value']);
        }
}
