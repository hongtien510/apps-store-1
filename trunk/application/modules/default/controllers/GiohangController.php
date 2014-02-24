<?php

class GiohangController extends App_Controller_FrontController {

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
        $cart = array();
        if(isset($_SESSION["cart_$idpage"]))
        {
            $cart = $_SESSION["cart_$idpage"];
        }
        $arraySanPham = array();
        foreach($cart as $idsp=>$value)
        {
            $detailSanPham = $store->getProductById($idpage, $idsp);
            $arraySanPham[$idsp]['detail'] = $detailSanPham;
            $arraySanPham[$idsp]['soluong'] = $value['soluong'];
            //$arraySanPham[$idsp]['size'] = $value['size'];
        }
        $this->view->arraySanPham = $arraySanPham;
    }
    

}
