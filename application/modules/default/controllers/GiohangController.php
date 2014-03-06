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
    
    public function findAction(){
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        if(isset($_SESSION['idpage']) && $_SESSION['idpage'] != "")
		{
			$idpage = $_SESSION['idpage'];
			$this->view->idpage = $idpage;
		}
    }
    
    public function detailAction(){
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        if(isset($_SESSION['idpage']) && $_SESSION['idpage'] != "")
		{
			$idpage = $_SESSION['idpage'];
			$this->view->idpage = $idpage;
		}
        
        if(isset($_GET['dh']))
        {
            $DH = $_GET['dh'];
            
            $sql = "select * from cart where id_cart = '$DH' and idpage = '$idpage'";
            $infoCart = $store->SelectQuery($sql);
            //$infoCart = $infoCart[0];
            $this->view->infoCart = $infoCart;
            
            $sql = "select * from detail_cart where id_cart = '$DH' and idpage = '$idpage'";
            $detailCart = $store->SelectQuery($sql);
            $this->view->detailCart = $detailCart;
        }
    }
    
    public function listAction(){
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        if(isset($_SESSION['idpage']) && $_SESSION['idpage'] != "")
		{
			$idpage = $_SESSION['idpage'];
			$this->view->idpage = $idpage;
		}
        
        if(isset($_GET['key']))
        {
            $act = trim($_GET['act']);
            $key = trim($_GET['key']);
            
            $list_cart = $store->getListCart($idpage, $act, $key);
            $this->view->list_cart = $list_cart;
        }
    }
    

}
