<?php
App::uses('AppController', 'Controller');
/**
 * OrganizationsUsers Controller
 *
 */
class OrganizationsUsersController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;
        
        public function sfu(){
            if($this->request->is('ajax')){
                $post = $this->request->data;
                    if (!$this->OrganizationsUser->exists($post['id'])) {
			throw new NotFoundException(__('Invalid Organization'));
                    }
                    $this->OrganizationsUser->save(array('id'=>$post['id'],$post['f']=>$post['value']));
            }
            die($post['value']);
        }

}
