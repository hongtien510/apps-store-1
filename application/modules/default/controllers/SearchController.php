<?php
class SearchController extends App_Controller_FrontController {

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
        $keyword = isset($_GET['key']) ? $_GET['key'] : "";
        //$keyword = "pham_hong_tien";
        if($keyword != "")
        {
            $arr_keyword = explode('_', $keyword);
            $where = "";
            $i = 0;
            foreach($arr_keyword as $value)
            {
                if($i == 0)
                    $where .= " and masp like '%$value%' or tensp like '%$value%' ";
                else
                    $where .= " or masp like '%$value%' or tensp like '%$value%' ";
                $i++;
            }
            $page = @$_GET['page'];
        
            $num_page = $store->getNumPage($idpage, 0, 0, $where);
            $page = round($page); $page = max(1,$page); $page = min($num_page, $page);

            $this->view->listProduct = $store->getListProductByIdCate($idpage, 0, 0, $page, $where, "");
            $this->view->num_page = $num_page;
            $this->view->curent_page = $page;
            $link = APP_DOMAIN . "/search?idpage=". $idpage ."&key=$keyword&page=np";
            $this->view->pagination = $store->pagination(5,$num_page,$link,$page);
            
        }
        else
        {
            $this->view->listProduct = array();
        }
    }

}
