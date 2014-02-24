<?php

class Admin_RegisterController extends App_Controller_AdminController {

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
    
    public function xulyregisterAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        
		$iduserfb = $_POST['iduserfb'];
        $useradmin = $_POST['useradmin'];
        $passadmin = sha1($_POST['passadmin']);
		$hotenadmin = $_POST['hotenadmin'];
		$emailadmin = $_POST['emailadmin'];
		$dienthoaiadmin = $_POST['dienthoaiadmin'];


	
        $sql = "Insert into ishali_admin (hoten, email, sdt, user, pass, iduserfb) ";
		$sql.= "values ('$hotenadmin', '$emailadmin', '$dienthoaiadmin', '$useradmin', '$passadmin', '$iduserfb')";
        $data = $store->InsertDeleteUpdateQuery($sql);

        echo $data;
    }
    
    public function kiemtraiduserfbAction(){
		$this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $store = $this->view->info = App_Models_StoreModel::getInstance();
	
		$idUserFB = $_POST['IdUserFB'];
		
		$sql = "select 1 from ishali_admin ";
		$sql.= "where iduserfb = " . $idUserFB . " limit 0,1";
		
		$data = $store->SelectQuery($sql);
		
	
		if(count($data)>=1)
		{
			echo $idUserFB;
			return;
		}
		else
		{
			echo 1;
			return;
		}
	}
	
	public function kiemtratendangnhapAction(){
		$this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $store = $this->view->info = App_Models_StoreModel::getInstance();

		$UserName = $_POST['username'];
		$sql = "select 1 from ishali_admin ";
		$sql.= "where user = '" . $UserName . "' limit 0,1";
		
		$data = $store->SelectQuery($sql);
		
	
		if(count($data)>=1)
		{
			echo 0;
			return;
		}
		else
		{
			echo 1;
			return;
		}
	}
    
}








































