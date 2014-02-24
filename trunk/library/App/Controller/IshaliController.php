<?php

class App_Controller_IshaliController extends Zend_Controller_Action {

    public function init() {
        $layoutPath = APPLICATION_PATH . '/templates/giaodien_ishali';
        $option = array('layout' => 'index', 'layoutPath' => $layoutPath);
        Zend_Layout::startMvc($option);
    }	
	 
    public function preDispatch() {
    	  $facebook = new Ishali_Facebook();
    	  // $id_user   = $facebook->getuserfbid();
	    // $userid_array =  array('100002280840454','1758627882');
		// if(!in_array($id_user, $userid_array ))
		// {	
				// $this->_redirect('/thongbao/khongduocphep');
		// }
    }



}
