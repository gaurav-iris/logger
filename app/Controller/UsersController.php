<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property AclComponent $Acl
 * @property SecurityComponent $Security
 * @property SessionComponent $Session
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */

        var $scaffold;
        
        public $components = array(
            'Paginator',
            'Session',
            'Email',
            'Auth' => array(
                'loginRedirect' => array('controller' => 'japp'),
                'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
                'authError' => 'You must be logged in to view this page.',
                'loginError' => 'Invalid Username or Password entered, please try again.'

        ));
        var $helpers = array('Image');
        
        public function beforeFilter() {
            CakePlugin::load('Upload'); 
            $this->Auth->allow(array('login','add','signup','logout','verify'));
            parent::beforeFilter();
        }
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add1() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$organizations = $this->User->Organization->find('list');
		$this->set(compact('organizations'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$organizations = $this->User->Organization->find('list');
		$this->set(compact('organizations'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

        
        public function login(){
            
            if($this->Session->check('Auth.User')){
                $this->redirect(array('action' => 'index'));     
            }

          
            if ($this->request->is('post')) {
                if ($this->Auth->login()) {
                    $this->Session->setFlash(__('Welcome, '. $this->Auth->user('first_name')));
                    $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->Session->setFlash(__('Invalid username or password'));
                }
            } 
        }
        
        
        public function logout(){
            $this->Session->setFlash(__('Thanks for using our services, '. $this->Auth->user('first_name')));
            $this->Auth->logout();
            $this->redirect($this->Auth->redirectUrl());
        }
        
        public function signup(){
            $invited = false;
            if($this->Session->check('Auth.User')){
                $this->redirect(array('action' => 'index'));     
            }
            if($this->request->is('post')){
                $this->User->create();
                $post = $this->request->data;
                if(!isset($post['User']['code'])){
                    $post['User']['code'] = md5(time());
                }else{
                    $invited = true;
                    $this->loadModel('Invite');
                    $invite = $this->Invite->findByCodeAndAccepted($post['User']['code'],0);
                    $invite['Invite']['accepted'] = 1;
                    $this->Invite->save($invite);
                    
                }
                
                
                if($this->User->save($post)){
                    if($invited){
                        $this->loadModel('OrganizationsUser');
                        $this->OrganizationsUser->create();
                        $this->OrganizationsUser->save(array(
                            'OrganizationsUser'=>array(
                                'organization_id'=>$invite['Invite']['organization_id'],
                                'user_id'        =>$this->User->id,
                                'role_id'        =>$invite['Invite']['role_id']
                             )
                        ));
                    }
                    $data = $this->User->read();
                    $this->set('user',$data);
                    $this->set('verify',true);
                    $this->_sendNewUserMail($data);
                }else{
                    $this->Session->setFlash(__('Some of the fields require your attention.'));
                }
            } 
        }
        
        function _sendNewUserMail($User) {
            $this->Email->to = $User['User']['email'];
            $this->Email->bcc = array(Configure::read('config.admin_email'));
            $this->Email->subject = 'Welcome to Logstaff.com';
            $this->Email->replyTo = Configure::read('config.admin_email');
            $this->Email->from = "Logstaff <".Configure::read('config.admin_email').">";
            $this->Email->template = 'welcome_user'; // note no '.ctp'
            $this->Email->sendAs = 'html'; // because we like to send pretty mail
            $this->set('User', $User);
            $this->Email->send();
         }
         
         public function verify($code){
             $user = $this->User->findByCodeAndVerified($code,0);
             if($user){
                 $this->set('verified',true);
                 $this->set('user',$user['User']);
                 unset($user['User']['password']);
                 $user['User']['status'] = 1;
                 $user['User']['verified'] = 1;
                 $this->User->save($user['User']);
             }else{
                 $this->set('error',true);
             }
             
         }
         
         public function profile(){
             $uid = CakeSession::read("Auth.User.id");
             $this->set('title','Update Your Profile | Logstaff');
               if($this->request->data){ 
//                   print_r($this->request->data); exit;
                   unset($this->request->data['photo']);
                  	if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
                                
				return $this->redirect(array('action' => 'index'));
			} else {
                           	$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $uid));
			$this->request->data = $this->User->find('first', $options);
		}
		
         }
         
         public function ajax(){
             if($this->request->is('ajax')){
                if($this->request->is('post')){
                    $uid = CakeSession::read("Auth.User.id");
                    $post = $this->request->data;
                    $path = $post['_p'];
                    $this->loadModel('Role');
                    $this->loadModel('Tool');
                    $this->loadModel('Timezone');
                    if($path == "profile"){
                        $userdata = $this->User->findById($uid);
                        $user = array(
                            'un'    => $userdata['User']['username'],
                            'fn'    => $userdata['User']['first_name'],
                            'ln'    => $userdata['User']['last_name'],
                            'em'    => $userdata['User']['email'],
                            'rl'    => $userdata['Role']['title'],
                            'tz'    => $userdata['Timezone']['title'],
                            'im'    => $this->Tool->crop($userdata['User']['image'],150,150),
                            'cr'    => $userdata['User']['created'],
                            'up'    => $userdata['User']['updated']
                        );
                       
                        $timezones = Cache::read('timezones', 'long');
                        if(!$timezones){
                            $timezones = $this->Timezone->find('list');
                            Cache::write('timezones', $timezones, 'long');
                        }
                        die(json_encode(array('u'=>$user,'t'=>$timezones)));
                    }
                }
            }
            die();
         }
         
         public function search(){
             if($this->request->is('ajax')){
                if($this->request->is('post')){
                    $uid = CakeSession::read("Auth.User.id");
                    $post = $this->request->data;
                    $keyword = $post['k'];
                    $nusers = array();
                    $this->loadModel('Role');
                    $this->loadModel('Tool');
                    $this->loadModel('Timezone');
                    $cond=array('OR'=>array("User.username LIKE '$keyword%'","User.first_name LIKE '$keyword%'", "User.email LIKE '$keyword%'")  );
                    $users = $this->User->find('all',array('conditions'=>$cond));
//                    print_r($users); exit;
                    foreach($users as $userdata){
                        $nusers[] = array(
                            'un'    => $userdata['User']['username'],
                            'nm'    => $userdata['User']['first_name'] . ' ' .$userdata['User']['last_name'],
                            'in'    => substr($userdata['User']['first_name'], 0,1) . substr($userdata['User']['last_name'],0,1),
                            'em'    => $userdata['User']['email'],
//                            'rl'    => $userdata['Role']['title'],
                            'tz'    => $userdata['Timezone']['title'],
                            'im'    => ($userdata['User']['image'])?$this->Tool->crop($userdata['User']['image'],32,32):'',
                            'vr'    => $userdata['User']['verified'],
                            'el'    => $this->in_organisation($post['org'], $userdata['Organization'])
                        );
                    }
                    die(json_encode($nusers));
                    
                }
            }
            die();
         }
         
         public function in_organisation($id,$organisations){
             foreach ($organisations as $org){
                 if($org['id'] == $id)
                     return true;
             }
             return false;
         }
}
