<?php

class IndexController extends App_Controller_FrontController {

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

        
        if(isset($_GET['tabs_added']))
        {
            $tabs_added = $_GET['tabs_added'];
            foreach($tabs_added as $idpage=>$status)
            $appid = $config->facebook->appid;
            
            //$linkPage = "http://facebook.com/$idpage?sk=app_$appid";
            $linkPage = FB_APP_DOMAIN . '/admin';
            echo "<p style=''>INSTALL APP SUCCESS. <a target='_top' href='$linkPage'>CLICK</a> TO CONFIG APP.</p>";
            exit;
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
        $num_page = $store->getNumPage($idpage, 0, 0, $where);
        $page = round($page); $page = max(1,$page); $page = min($num_page, $page);
        $this->view->listProduct = $store->getListProductByIdCate($idpage, 0, 0, $page, $where, $sortSP);
        $this->view->num_page = $num_page;
        $this->view->curent_page = $page;
        $sort = ($sort != "") ? "&sort=$sort" : "";
        $tab = ($tab != "1") ? "&tab=$tab" : "";
        $link = APP_DOMAIN . '?idpage=' . $idpage . $tab . $sort .'&page=np';
        $this->view->pagination = $store->pagination(5,$num_page,$link,$page);

        
  }
    
    

   

}
