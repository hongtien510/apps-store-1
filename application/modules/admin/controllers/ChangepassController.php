<?php

class Admin_ChangepassController extends App_Controller_AdminController {

    public function init() {
        parent::init();
        $this->_SESSION=new Zend_Session_Namespace();
        
    }

    public function indexAction() {
        $facebook = new Ishali_Facebook();
        $iduser_fb = $facebook->getuserfbid();
		$this->view->iduser_fb = $iduser_fb;
		
		$_SESSION['list_page'] = "0";
    }
    

	
	public function xulychangepassAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout->disableLayout();
		
		$iduserfb = $_POST['iduserfb'];
		$oldpass = sha1($_POST['oldpass']);
		$newpass = sha1($_POST['newpass']);
		$store = $this->view->info = App_Models_StoreModel::getInstance();
		
		$sql = "select 1 from ishali_admin ";
		$sql.= "where iduserfb = '".$iduserfb."' and pass = '".$oldpass."' ";
		$data = $store->SelectQuery($sql);
		if(count($data)==0)
		{
			echo '-1';
			return;
		}
		else
		{
			$sql = "update ishali_admin set pass = '".$newpass."' ";
			$sql.= "where iduserfb = ".$iduserfb;
		
			$data = $store->InsertDeleteUpdateQuery($sql);
			echo $data;
			unset ($this->_SESSION->iduseradmin);
			unset ($this->_SESSION->hotenadmin);
			unset ($_SESSION['iduseradmin']);
		}
		
	}
	
  
}






































