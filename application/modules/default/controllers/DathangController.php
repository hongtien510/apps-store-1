<?php

class DathangController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        if(isset($_SESSION['idpage']) && $_SESSION['idpage'] != "")
		{
			$idpage = $_SESSION['idpage'];
			$this->view->idpage = $idpage;
		}
        /*
        $facebook = new Ishali_Facebook();
        echo $facebook->getuserfbid();
        if($facebook->getuserfbid() == 0)
        {
            $facebook->userlogin('https://localhost/appfb/apps-store/dathang?idpage=356730004423499');
        }
        else
        {
            print_r($facebook->getUserInfo());
        }
        */
    }
    

}
