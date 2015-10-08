<?php
App::uses('AppController', 'Controller');
/**
 * Timezones Controller
 *
 */
class TimezonesController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;

        public function index(){
            if($this->request->is('ajax')){
                die(json_encode($this->Timezone->find('list')));
            }
        }
}
