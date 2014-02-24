<?php
class CategoryController extends App_Controller_FrontController {

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
        $sort = isset($_GET['sort']) ? $_GET['sort'] : "";
        $sortSP = "";
        switch ($sort) {
            case 'asc':
                $sortSP = "order by gia asc";
                break;
            case 'desc':
                $sortSP = "order by gia desc";
                break;
            case 'new':
                $sortSP = "order by idsp desc";
                break;
            case '':
                $sortSP = "";
                break;
        }
        
        $tab = isset($_GET['tab']) ? $_GET['tab'] : "1";
        $where = "";
        switch ($tab) {
            case '1':
                $where = "";
                break;
            case '2':
                $where = "and spmoi = 1";
                break;
            case '3':
                $where = "and sale_off != 0";
                break;
            case '':
                $where = "";
                break;
        }
        
        $page = @$_GET['page'];
        $cate = @$_GET['id'];
        $parent_cate = @$_GET['idp'];
        //$cate = round($cate); $cate = max(1,$cate);
        $num_page = $store->getNumPage($idpage, $cate, 0, $where, $parent_cate);
        $page = round($page); $page = max(1,$page); $page = min($num_page, $page);
        $this->view->listProduct = $store->getListProductByIdCate($idpage, $cate, 0, $page, $where, $sortSP, $parent_cate);
        $this->view->num_page = $num_page;
        $this->view->curent_page = $page;
        $sort = ($sort != "") ? "&sort=$sort" : "";
        $tab = ($tab != "1") ? "&tab=$tab" : "";
        $cate = ($cate != "") ? "&id=$cate" : "";
        $parent_cate = ($parent_cate != "") ? "&idp=$parent_cate" : "";
        
        $link = APP_DOMAIN . "/category?idpage=". $idpage . $tab . $sort . $cate . $parent_cate . "&page=np";
        $this->view->cate = $cate;
        $this->view->parent_cate = $parent_cate;
        $this->view->pagination = $store->pagination(5,$num_page,$link,$page);
        
        $this->view->pageConfig = $store->getConfig($idpage);
    }

}
