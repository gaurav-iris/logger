<?php
App::uses('AppController', 'Controller');
/**
 * Roles Controller
 *
 */
class RolesController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;
        
        public function index(){
            if($this->request->is('ajax')){
                die(json_encode($this->Role->find('list')));
            }
        }

}
