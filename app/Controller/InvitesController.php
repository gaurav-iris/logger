<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 */
class InvitesController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;
        public $components = array(
            'Session',
            'Email'
            );
        
        public function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow(array('verify'));
        }

            public function index(){
            $invites = array();
            if($this->request->is('ajax')){
                $this->loadModel('Organization');
                $this->Organization->recursive = 0;
                if(isset($this->request->data['o_id']) && $this->request->data['o_id']){
                    $users = $this->request->data['User'];
                    foreach($users as $key=>$user){ 
                        if(isset($user['email']) && $user['email']!=''){
                            $invites[$key]['email'] = $user['email'];
                            $invites[$key]['role_id'] = $user['role_id'];
                            $invites[$key]['user_id'] = CakeSession::read('Auth.User.id');
                            $invites[$key]['organization_id'] = $this->request->data['o_id'];
                            $invites[$key]['code'] = md5(time()) . '-X1As'.substr(md5(rand()),0, 5);
                            $this->_sendInvitation($invites[$key]);
                            $this->Invite->create();
                            $this->Invite->save(array('Invite'=>$invites[$key]));
                        }
                    }
                }else{
                    die(json_encode(array('status'=>false,'error'=>'Invalid Organization')));
                }
                die(json_encode(array('status'=>true,'error'=>'Invitations Sent')));
//                print_r($invites); exit;
            }
        }
        
        function _sendInvitation($data) {
            $this->Email->to = $data['email'];
            $org = $this->Organization->findById($data['organization_id']);
            $this->Email->subject = CakeSession::read('Auth.User.first_name'). ' '.CakeSession::read('Auth.User.last_name') . ' invites you to join '.$org['Organization']['title'].' on Logstaff ';
            $this->Email->replyTo = Configure::read('config.admin_email');
            $this->Email->from = "Logstaff <".Configure::read('config.admin_email').">";
            $this->Email->template = 'invite'; // note no '.ctp'
            $this->Email->sendAs = 'html'; // because we like to send pretty mail
            $this->set('user',CakeSession::read('Auth.User.first_name'). ' '.CakeSession::read('Auth.User.last_name'));
            $this->set('data', $data);
            $this->set('org',$org['Organization']);
            $this->Email->send();
         }
         
        public function verify($code){
            if($this->Session->check('Auth.User')){
                $this->redirect(array('action' => 'index'));     
            }
            $invite = $this->Invite->findByCodeAndAccepted($code,0);
            
            if($invite){
                $this->set('invited',true);
                $this->set('invitation',$invite['Invite']);
            }
        }
}
