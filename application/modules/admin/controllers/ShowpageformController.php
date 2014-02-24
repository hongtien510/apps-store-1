<?php

class Admin_ShowpageformController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
 	   //$this->view->mausac = App_Models_BangmauModel::getInstance()->getList();
    }
	    
    public function luuAction()
    {	    
    	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
    	echo "Nội dung đang được lưu";
    	App_Models_PagesModel::getInstance()->updatepage();
//    	$Admin = new Admin_Model_DbTable_Showpageform();
//		$Admin->updatepage();		
    }

}

