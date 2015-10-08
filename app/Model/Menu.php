<?php
App::uses('AppModel', 'Model');
/**
 * Menu Model
 *
 * @property Menu $ParentMenu
 * @property Menu $ChildMenu
 */
class Menu extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

        
        
        var $actsAs = array(
                'Tree'
	);	

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ParentMenu' => array(
			'className' => 'Menu',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ChildMenu' => array(
			'className' => 'Menu',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
        
        public function generateHtml($type){
            $menus = $this->find('threaded',array('order'=>'Menu.sort_order','conditions'=>array('Menu.menu_type'=>$type)));
         
            $out = "<ul class='nav navbar-nav'>";
            foreach($menus as $menu){
                $url = Router::url($menu['Menu']['slug']);
                $current = $_SERVER['REQUEST_URI'];
                
                $class = ($current == $url)?'active':'';
                    
            $out .= "<li class='{$class}'><a href='" .Router::url($menu['Menu']['slug'],true)."'>" . $menu['Menu']['title'].'</a>';
                    if($menu['children']){
                        $out .= $this->getChildHtml($menu['children']);
                    }
                $out .= '</li>';
            }
            $out .= '</ul>';
            
            return $out;
        }
        
        public function getChildHtml($child){
            $out = '';
            if($child){
                $out = "<ul class='child'>";
                foreach($child as $menu){
                    $url = Router::url($menu['Menu']['slug']);
                    $current = $_SERVER['REQUEST_URI'];
                    $class = ($current == $url)?'active':'';
                    
                    $out .= "<li class='{$class}'><a href='". Router::url($menu['Menu']['slug'],true)."'>" . $menu['Menu']['title'].'</a>';
                        if($menu['ChildMenu']){
                            $out .= $this->getChildHtml($menu['children']);
                        }
                     $out .= '</li>';
                }
                $out .= '</ul>';
            }
            return $out;
        }

}
