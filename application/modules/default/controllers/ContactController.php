<?php

class ContactController extends App_Controller_FrontController {

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
        
    }
    

}
