<?php

class DetailController extends App_Controller_FrontController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
        $config = Zend_Registry::get(APPLICATION_CONFIG);
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        if(isset($_SESSION['idpage']) && $_SESSION['idpage'] != "")
		{
			$idpage = $_SESSION['idpage'];
			$this->view->idpage = $idpage;
		}
        //$idpage = '356730004423499';
        $idsp = @$_GET['id'];
        $this->view->idsp = $idsp;
        $this->view->detailProduct = $store->getProductById($idpage, $idsp);
        $this->view->array_hinhphu = $store->getPhotoProduct($idsp);
        $this->view->sanPhamLienQuan = $store->getSanPhamLienQuan($idpage,$idsp);

    }
    

}
