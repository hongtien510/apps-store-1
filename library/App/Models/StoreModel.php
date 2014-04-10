<?php
//$this->_SESSION=new Zend_Session_Namespace();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BangmauModel
 *
 * @author root
 */
class App_Models_StoreModel {

    private $_db;
    private static $_instance;

    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new App_Models_StoreModel();
            self::$_instance->_db = App_Storage_Mysql_Connector::getInstance();
        }
        return self::$_instance;
    }
	
	public function SelectQuery($sql)
	{
        $data = $this->_db->executeReader($sql);
  			return $data;
	}
    
    public function InsertDeleteUpdateQuery($sql)
	{
        $data = $this->_db->executeReader($sql); 
  			if(!isset($data))
                return 0;
            else
                return 1;
	}
    
    public function CatChuoi($str)
    {
        return explode(',', $str);
    }
    
    public function GetidCategory($idpage)
    {
        $sql = "Select idloaisp, tenloaisp ";
        $sql.= "From ishali_loaisp ";
        $sql.= "Where anhien = 1 and idpage = ". $idpage ." order by vitri";
        $data = $this->SelectQuery($sql);
        return $data;
    }
	
	public function GetPageFbByIdUserFB()
	{
		$facebook = new Ishali_Facebook();
        $iduser_fb = $facebook->getuserfbid();
		$sql = "select id_pages, id_fb_page, page_name ";
		$sql.= "from ishali_pages ";
		$sql.= "where id_fb = " . $iduser_fb;
			$lpage = $this->SelectQuery($sql);
			return $lpage;
	}

	public function GetBanner($idPage)
	{
		$sql = "select banner from ishali_config where idpage = '".$idPage."'";
		$data = $this->SelectQuery($sql);
        return $data;
	}
	
	public function GetColor($idPage)
	{
		$sql = "select bg_color_menu, color_text_menu, bg_color_menu_act, color_text_menu_act from ishali_config where idpage = '".$idPage."'";
		$data = $this->SelectQuery($sql);
		if(count($data)==0)
		{
			$color['bg_color_menu'] = "EFEFEF";
			$color['color_text_menu'] = "000000";
			$color['bg_color_menu_act'] = "3B5998";
			$color['color_text_menu_act'] = "FFFFFF";
		}
		else
		{
			if($data[0]['bg_color_menu']!="") {$color['bg_color_menu'] = $data[0]['bg_color_menu'];} else {$color['bg_color_menu'] = "EFEFEF";}
			if($data[0]['color_text_menu']!="") {$color['color_text_menu'] = $data[0]['color_text_menu'];} else {$color['color_text_menu'] = "000000";}
			if($data[0]['bg_color_menu_act']!="") {$color['bg_color_menu_act'] = $data[0]['bg_color_menu_act'];} else {$color['bg_color_menu_act'] = "3B5998";}
			if($data[0]['color_text_menu_act']!="") {$color['color_text_menu_act'] = $data[0]['color_text_menu_act'];} else {$color['color_text_menu_act'] = "FFFFFF";}
        }
		return $color;
	}
	
	public function KiemTraSessionIdPage($sessionIdPage)
	{
		$facebook = new Ishali_Facebook();
		$idUserFB = $facebook->getuserfbid();
		
		$sql = "select 1 from ishali_pages where id_fb_page = '". $sessionIdPage ."' and id_fb = '". $idUserFB ."'";
		$data = $this->SelectQuery($sql);
		return count($data);
	}
	
	//Chua su dung
	public function chuyenLinkThanhHttps($idpage)
	{
		if($_SERVER["HTTPS"] != "on")//Link ko phai la https
		{
			$facebook = new Ishali_Facebook(); 
			$fb = $facebook->getFB();
			$id_fb_page = '/'.$idpage;
			$pages_fb =  $fb->api($id_fb_page);
			$linkPage = $pages_fb['link'];//http://www.facebook.com/Phtpht
			
			$lPage = substr($linkPage,4);
			$linkHttps = 'https'.$lPage.'/app_'.APP_ID;
			return $linkHttps;
		}
		else
			return true;
	}
	
	public function getLinkPage($idpage)
	{
		$sql = "select link_page from ishali_pages where id_fb_page = '". $idpage ."'";
		$data = $this->SelectQuery($sql);
		return $data[0]['link_page'];
	}
    
    public function getListCategoryByIdPage($page_id = "", $parentID = '', $data = null, $space = "")
    {
        //$store = $this->view->info = App_Models_StoreModel::getInstance();
        $where = "";
        if ($parentID != '')
            $where .= " parent_id = $parentID ";
        else
            $where .= " parent_id = 0 ";

        $sql = "select * from ishali_loaisp where $where and idpage = '$page_id'";
        $rows = $this->SelectQuery($sql);
        
        if (isset($rows) == TRUE && is_array($rows) == TRUE) {
            foreach ($rows as $value) {
                $arr = array();
                $arr['idloaisp'] = $value['idloaisp'];
                if ($value['parent_id'] == 0) {
                    $arr['tenloaisp'] = $space . '<strong>' . $value['tenloaisp'] . '</strong>';
                } else {
                    $arr['tenloaisp'] = $space . $value['tenloaisp'];
                }
                $arr['vitri'] = $value['vitri'];
                $arr['anhien'] = $value['anhien'];
                $arr['parent_id'] = $value['parent_id'];
                $data[] = $arr;
                $data = $this->getListCategoryByIdPage($page_id ,$value['idloaisp'], $data, $space . '>> ');
            }
        }
        return $data;
    }
    
    public function getAllParentCategoryByIdPage($idpage, $show = "1")
    {
        $show = $show == 1 ? "and anhien = 1" : "";
        $sql = "SELECT * FROM ishali_loaisp where idpage = '$idpage' $show and parent_id = 0 ORDER BY vitri";
        $data = $this->SelectQuery($sql);
        return $data;
    }
    public function getAllChildCategoryByIdParentCategory($idpage, $idParent, $show = "1")
    {
        $show = $show == 1 ? "and anhien = 1" : "";
        $sql = "SELECT * FROM ishali_loaisp where idpage = '$idpage' $show and parent_id = $idParent ORDER BY vitri";
        $data = $this->SelectQuery($sql);
        return $data;
    }
    public function getAllCategoryByIdPage($idpage, $show = "1")
    {
        $show = $show == 1 ? "and anhien = 1" : "";
        //$sql = "SELECT * FROM ishali_loaisp where idpage = '$idpage' $show ORDER BY vitri";
        $sql = "SELECT il.*, if(parent_id = 0, idloaisp, '0') as 'idp' FROM ishali_loaisp il where idpage = '$idpage' $show ORDER BY vitri";
        $data = $this->SelectQuery($sql);
        return $data;
    } 


    public function addCategoryIntoMenuAdmin($list_category = null, $parentid = 0, $data = null, $sep = '')
    {
        foreach($list_category as $v){
        if($v['parent_id'] == $parentid){
            if($parentid == 0) $v['tenloaisp'] = '<strong>'.$v['tenloaisp'].'</strong>';
            else $v['tenloaisp'] = $sep.$v['tenloaisp'];
            $data[] = $v;
            $data = $this->addCategoryIntoMenuAdmin($list_category, $v['idloaisp'],$data, $sep.">> ");
            }
        }
        return $data;
    }
    
    public function getListProductByIdCate($id_page = 0, $id_cate = 0, $show_index = 0, $page = 1, $where = "", $order = "", $parent_id = 0)
    {
        if($order == "") $order = "order by idsp desc";
        $config = Zend_Registry::get(APPLICATION_CONFIG);
        $product_on_page = $config->config->product_on_page;
        $start = ($page - 1) * $product_on_page;
        $limit = "limit $start,$product_on_page";
        
        if($id_page == 0) return;

        if($parent_id != 0)
        {
            $sIndex = ($show_index == 0) ? "" : "and showindex = 1";
            /*
            $sql = "select a.*, b.parent_id
                from ishali_sanpham a, ishali_loaisp b
                where b.parent_id = '$parent_id' and a.idpage = '$id_page' and a.idloaisp = b.idloaisp and a.anhien = 1 $sIndex $where $order $limit";
            */
            $sql = "select A.* from 
                        (select isa.*, ilo.parent_id, ilo.tenloaisp, if(ilo.parent_id = 0, isa.idloaisp, ilo.parent_id) as idp
                        from ishali_sanpham isa, ishali_loaisp ilo 
                        where isa.idloaisp = ilo.idloaisp) A
                        where A.idp = '$parent_id' and A.idpage = '$id_page' and anhien = 1 $sIndex $where GROUP BY idsp $order $limit";
            $data = $this->SelectQuery($sql);
            return $data;
        }
        if($id_cate != 0)
        {
            $sIndex = ($show_index == 0) ? "" : "and showindex = 1";
            $sql = "select * 
                from ishali_sanpham
                where `idloaisp` = '$id_cate' and idpage = '$id_page' and anhien = 1 $sIndex $where GROUP BY idsp $order $limit";
        }
        else
        {
            $sIndex = ($show_index == 0) ? "" : "and showindex = 1";
            $sql = "select * 
                from ishali_sanpham
                where idpage = '$id_page' and anhien = 1 $sIndex $where GROUP BY idsp $order $limit";
        }

        $data = $this->SelectQuery($sql);
		return $data;
    }
    
    public function getProductById($id_page = 0, $idsp = 0)
    {
        if($id_page == 0) return;

        $sql = "select * from ishali_sanpham where idsp = '$idsp' and idpage = '$id_page' and anhien = 1";
        $data = $this->SelectQuery($sql);
		return $data[0];
    }
    
    public function getPhotoProduct($idsp = 0)
    {
        if($idsp == 0) return;
        
        $sql = "select * from ishali_sanpham_hinhanh where idsp = '$idsp' order by sapxep";
        $data = $this->SelectQuery($sql);
		return $data;
    }
    
    public function getSanPhamLienQuan($id_page = 0, $idsp = 0)
    {
        $id_cate = $this->getIdCateByIdProduct($id_page, $idsp);
        $sql = "select * 
                from ishali_sanpham
                where `idloaisp` = '$id_cate' and idpage = '$id_page' and anhien = 1 and idsp != $idsp order by rand() limit 0,6";
        $data = $this->SelectQuery($sql);
		return $data;
    }
    
    public function getIdCateByIdProduct($id_page = 0, $idsp=0)
    {
        if($id_page == 0) return;
        $sql = "SELECT idloaisp from ishali_sanpham where idsp = $idsp and idpage = '$id_page'";
        $data = $this->SelectQuery($sql);
		return $data[0]['idloaisp'];
    }
    
    
    public function getNumPage($id_page = 0, $id_cate = 0, $show_index = 0, $where = "", $parent_id = 0)
    {   
        if($id_page == 0) return;
        if($parent_id != 0)
        {
            $sIndex = ($show_index == 0) ? "" : "and showindex = 1";  
            $sql = "select count(*) as num_row 
                from ishali_sanpham a, ishali_loaisp b
                where b.parent_id = '$parent_id' and a.idpage = '$id_page' and a.idloaisp = b.idloaisp and a.anhien = 1 $sIndex $where";
        
            $data = $this->SelectQuery($sql);
    		$num_row = $data[0]['num_row'];
            $config = Zend_Registry::get(APPLICATION_CONFIG);
            $product_on_page = $config->config->product_on_page;
            $num_page = ceil($num_row / $product_on_page);$num_page = max(1,$num_page);
            return $num_page;
        }
        
        if($id_cate != 0)
        {
            $sIndex = ($show_index == 0) ? "" : "and showindex = 1";
            $sql = "select count(*) as num_row 
                from ishali_sanpham
                where `idloaisp` = '$id_cate' and idpage = '$id_page' and anhien = 1 $sIndex $where GROUP BY idsp";
        }
        else
        {
            $sIndex = ($show_index == 0) ? "" : "and showindex = 1";
            $sql = "select count(*) as num_row 
                from ishali_sanpham
                where idpage = '$id_page' and anhien = 1 $sIndex $where GROUP BY idsp";
        }
        //echo $sql;
        $data = $this->SelectQuery($sql);
		$num_row = $data[0]['num_row'];
        $config = Zend_Registry::get(APPLICATION_CONFIG);
        $product_on_page = $config->config->product_on_page;
        $num_page = ceil($num_row / $product_on_page);$num_page = max(1,$num_page);
        return $num_page;
    }
    
    public function getConfig($idpage = 0)
    {
        if($idpage == 0 || $idpage == null) return;
        $sql = "select * from ishali_config where idpage = '$idpage'";
        $data = $this->SelectQuery($sql);
		return @$data[0];
    }
    
    public function getInfoPage($idpage = 0)
    {
        if($idpage == 0 || $idpage == null) return;
        $sql = "select * from ishali_pages where id_fb_page = '$idpage' GROUP BY id_fb_page";
        $data = $this->SelectQuery($sql);
		return @$data[0];
    }
    
    function pagination($pageDisplay, $numPage, $link, $currentPage)
	{
        if($numPage == 1) return;
		$html_page = "";
		$html_page .= "<div class='pagination'><ul class='ul-pagination'>";
		if($numPage <= $pageDisplay)
		{
			for($i=1;$i<=$numPage;$i++)
			{
				$pageActive = ($currentPage == $i) ? "class='pageActive'" : "";
				$linkPage = str_replace('np',$i,$link);
				$html_page .= "<li $pageActive><a href='$linkPage'>$i</a></li>";
			}
		}
		else
		{
			if($currentPage <= ceil($pageDisplay/2))
			{
				$html_page .= "<li class='pageDisable'><a href=''>First</a></li>";
				$html_page .= "<li class='pageDisable'><a href=''>Previous</a></li>";
				for($i=1; $i<=$pageDisplay; $i++)
				{
					$pageActive = ($currentPage == $i) ? "class='pageActive'" : "";
					$linkPage = str_replace('np',$i,$link);
					$html_page .= "<li $pageActive><a href='$linkPage'>$i</a></li>";
				}
				if($pageDisplay < $numPage) $html_page .= "<li class='pageSeparator'><a href=''>...</a></li>";
				$linkPage = str_replace('np',($currentPage+1),$link);
				$html_page .= "<li><a href='$linkPage'>Next</a></li>";
				$linkPage = str_replace('np',$numPage,$link);
				$html_page .= "<li><a href='$linkPage'>Last</a></li>";
			}
			if($currentPage > ceil($pageDisplay/2) && $currentPage <= ($numPage - ceil($pageDisplay/2)))
			{
				$linkPage = str_replace('np',1,$link);
				$html_page .= "<li><a href='$linkPage'>First</a></li>";
				$linkPage = str_replace('np',($currentPage-1),$link);
				$html_page .= "<li><a href='$linkPage'>Previous</a></li>";
				$html_page .= "<li class='pageSeparator'><a href=''>...</a></li>";
				for($i=($currentPage-floor($pageDisplay/2)); $i<= min($numPage,($currentPage+floor($pageDisplay/2))); $i++)
				{
					$pageActive = ($currentPage == $i) ? "class='pageActive'" : "";
					$linkPage = str_replace('np',$i,$link);
					$html_page .= "<li $pageActive><a href='$linkPage'>$i</a></li>";
				}
				$html_page .= "<li class='pageSeparator'><a href=''>...</a></li>";
				
				$linkPage = str_replace('np',($currentPage+1),$link);
				$html_page .= "<li><a href='$linkPage'>Next</a></li>";
				$linkPage = str_replace('np',$numPage,$link);
				$html_page .= "<li><a href='$linkPage'>Last</a></li>";
			}
			if($currentPage > ($numPage - ceil($pageDisplay/2)))
			{
				$linkPage = str_replace('np',1,$link);
				$html_page .= "<li><a href='$linkPage'>First</a></li>";
				$linkPage = str_replace('np',($currentPage-1),$link);
				$html_page .= "<li><a href='$linkPage'>Previous</a></li>";
				$html_page .= "<li class='pageSeparator'><a href=''>...</a></li>";
				for($i=($currentPage-floor($pageDisplay/2)); $i<= min($numPage,($currentPage+floor($pageDisplay/2))); $i++)
				{
					$pageActive = ($currentPage == $i) ? "class='pageActive'" : "";
					$linkPage = str_replace('np',$i,$link);
					$html_page .= "<li $pageActive><a href='$linkPage'>$i</a></li>";
				}
				$html_page .= "<li class='pageDisable'><a href=''>Next</a></li>";
				$html_page .= "<li class='pageDisable'><a href=''>Last</a></li>";
			}
		}
		
		$html_page .= "<div class='meta-pagination'>Page ". $currentPage .' of '. $numPage ."</div>";
		$html_page .= "</ul></div>";
		return $html_page;
	}
    
    public function checkManagerPage($idpage = "", $iduser_fb = "")
    {
        $sql = "select 1 from ishali_pages where id_fb_page = '$idpage ' and id_fb = '$iduser_fb'";
        $data = $this->SelectQuery($sql);
		return count($data);
    }
    
    public function getGraphFacebook($id = "")
    {
        if($id == "") return null;
        $url = "http://graph.facebook.com/$id";  
        $graph = json_decode(file_get_contents($url));
        return $graph;
        //$data = $graph->link;  
        //echo "Link: ".$data;
    }
    
    public function getCart($idpage = "", $status = "")
    {
        if($idpage == "") return;
        switch ($status) {
            case "0":
                $where_status = "and status = 0";
                break;
            case "1":
                $where_status = "and status = 1";
                break;
            case "2":
                $where_status = "and status = 2";
                break;
            default:
                $where_status = "";
                break;
        }
        
        $sql = "select * from cart where idpage = '$idpage' $where_status order by id_cart desc";
        $data = $this->SelectQuery($sql);
		return $data;
    }
    
    public function getListCart($idpage = "", $act = "", $key = "")
    {
        if($idpage == "") return;
        if($act == "other") return;
        
        $sql = "select * from cart where `idpage` = '$idpage' ";
        
        switch ($act) {
            case "email":
                $sql .= "and `email` = '$key'";
                break;
            case "phone":
                $sql .= "and `phone` = '$key'";
                break;
            case "dh":
                $sql .= "and `id_cart` = '$key'";
                break;
        }
        $sql .= " order by date_create desc";
        
        $data = $this->SelectQuery($sql);
		return $data;
    }

	public function getOrder($idpage = "", $keyword = "")
    {
        if($idpage == "") 
		{	
			return;
		}
		
		/*$arr_keyword = explode('_', $keyword);
		$where = "";
		$i = 0;
		foreach($arr_keyword as $value)
		{
			if($i == 0)
				$where .= " id_cart like '%$value%' ";
			else
				$where .= " or id_cart like '%$value%' ";
			$i++;
		}*/
		$arr_keyword = explode('-', $keyword);
		
		$where = "";
		$i = 0;
		foreach($arr_keyword as $value)
		{
			if($i == 0)
				$where .= " id_cart like '%$value%' or name like '%$value%' or email like '%$value%' or phone like '%$value%' ";
			else
				$where .= " or id_cart like '%$value%' or name like '%$value%' or email like '%$value%' or phone like '%$value%' ";
			$i++;
		}
		
        $sql = "select * from cart where idpage = '$idpage' and ($where) order by id_cart desc";
        $data = $this->SelectQuery($sql);
		return $data;
    }
    
    public function checkUserManagerPage($iduser_fb = "", $idpage = "")
    {
        if($iduser_fb == "" || $iduser_fb == "0")
        {
            return 0;
        }
        else
        {
            $sql = "select 1 from ishali_pages where id_fb_page = '$idpage' and id_fb = '$iduser_fb' limit 0,1";
            $data = $this->SelectQuery($sql);
    		if(!empty($data))
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
    }
	
	public function getCustomer($idpage = "")
	{
		if($idpage == "") 
		{	
			return;
		}
		
		$sql = "select * from customer where idpage = '".$idpage."'";
		$data = $this->SelectQuery($sql);
		
		return $data;
	}
	
	public function getCustomerOrders($idpage = "", $email = "")
	{
		if($idpage == "" || $email == "") 
		{	
			return;
		}
		
		$sql = "select * from cart where email = '".$email."' and idpage = '".$idpage."'";
		$data = $this->SelectQuery($sql);
		
		return $data;
	}
	
	public function checkFbUserInDb ($idpage = "", $idfb = "") 
	{
		if($idpage == "" || $idfb == "") 
		{	
			return;
		}
		
		$sql = "select * from customer where idpage = '$idpage' and fb_id = '$idfb'";
		$data = $this->SelectQuery($sql);
			
		return $data;
	}
}





























