<?php

class DathangController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $store = $this->view->info = App_Models_StoreModel::getInstance();
		
		$flag = 0;
		if (isset($_GET['flag'])) {
			$flag = $_GET['flag'];
		}
		
        if(isset($_SESSION['idpage']) && $_SESSION['idpage'] != "")
		{
			$idpage = $_SESSION['idpage'];
			$this->view->idpage = $idpage;
		}
        
        $facebook = new Ishali_Facebook();
        if($facebook->getuserfbid() == 0)
        {
			if ($flag == 1) {
				$this->view->isfbuser = 0;
			} else {
				$url = APP_DOMAIN."/dathang?idpage=".$idpage."&flag=1";
				$facebook->userlogin($url);
			}
        }
        else
        {
			$facebook->getuserfbid();
			$user_profile = $facebook->getUserInfo();
			$this->view->isfbuser = 1;
			$this->view->linkfb = $user_profile['link'];
			$this->view->idfb = $user_profile['id'];
			
			$checkFbUserInDb = $store->checkFbUserInDb($idpage, $user_profile['id']);
			
			if (!empty($checkFbUserInDb)) {
				$this->view->name = $checkFbUserInDb[0]['name'];
				$this->view->phone = $checkFbUserInDb[0]['phone'];
				$this->view->email = $checkFbUserInDb[0]['email'];
				$this->view->district = $checkFbUserInDb[0]['district'];
				$this->view->address = $checkFbUserInDb[0]['address'];
			} else {
				$this->view->name = $user_profile['name'];
				$this->view->phone = "";
				$this->view->email = $user_profile['email'];
				$this->view->district = "";
				$this->view->address = "";
			}
        }
        
    }
    

}
