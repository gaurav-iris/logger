<?php
App::uses('AppController', 'Controller');
/**
 * Projects Controller
 *
 */
class ProjectsController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;
        
        public function beforeFilter() {
            parent::beforeFilter();
            $this->uid = CakeSession::read("Auth.User.id");
            $this->set('user_id',$this->uid);
        }
        
        public function create(){
            $aProj = array();
            if($this->request->is('ajax')){
                $projects = $this->request->data['Project'];
                foreach($projects as $key=>$project){
                    if($project['title'] && isset($this->request->data['o_id']) && $this->request->data['o_id']){
                        $aProj['Project'] = array('title'=>$project['title'],'slug'=>'','user_id'=>$this->uid);
                        $aProj['Organization'] = array('organization_id'=>$this->request->data['o_id']);
                        $aProj['User'] = array('user_id'=>$this->uid);
                        $this->Project->create();
                        $this->Project->saveAssociated($aProj);
                        
                    }
                }
//                if($this->Project->saveMany($this->projects)){
                    die(json_encode(array('status'=>true,'msg'=>'Projects created')));
//                }
            }
        }
        
        public function sfu(){
            if($this->request->is('ajax')){
                $post = $this->request->data;
                    if (!$this->Project->exists($post['id'])) {
			throw new NotFoundException(__('Invalid Project'));
                    }
                    $this->Project->save(array('id'=>$post['id'],$post['f']=>$post['value']));
            }
            die($post['value']);
        }

}
