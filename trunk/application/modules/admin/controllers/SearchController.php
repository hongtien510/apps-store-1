<?php
	class Admin_SearchController extends App_Controller_AdminController {
	
	public function init() {
        parent::init();
        $this->_SESSION=new Zend_Session_Namespace();
        
        $facebook = new Ishali_Facebook();
		$idpage = $facebook->getpageid();
        
        if(isset($idpage))
            $_SESSION['idpage'] = $idpage;
    }
	
	public function indexAction() {
		$_SESSION['list_page'] = "1";
		
		$store = $this->view->info = App_Models_StoreModel::getInstance();

		
		if($this->_request->getParam("idpage") != "")
        {
			$idpagee = $this->_request->getParam("idpage");
			$_SESSION['idpage'] = $idpagee;
		}
		@$idpage = $_SESSION['idpage'];
		
		$checkSessionIdpage = $store->KiemTraSessionIdPage($idpage);
		if($checkSessionIdpage == 0)
		{
			$this->view->checkSessionIdpage = $checkSessionIdpage;
		}
		else
		{
            $config = $this->view->config = $store->getConfig($idpage);
			if($this->_request->getParam("key") != "")
			{	
				$keyword = $this->_request->getParam("key");
				$arr_keyword = explode('_', $keyword);
				$where = "";
				$i = 0;
				foreach($arr_keyword as $value)
				{
					if($i == 0)
						$where .= " tensp like '%$value%' ";
					else
						$where .= " or tensp like '%$value%' ";
					$i++;
				}
				//$this->view->product = $store->getListProductByIdCate($idpage, 0, 0, 1, $where, "");
				
				$sql = "select a.idsp, a.idloaisp, b.tenloaisp, b.parent_id, 
							   c.tenloaisp as tenloaisp_parent, a.masp, a.tensp, 
							   a.gia, a.giagiam, a.sale_off, a.spmoi, a.hinhchinh, a.anhien, a.showindex 
						from ishali_sanpham a, ishali_loaisp b LEFT JOIN (select idloaisp, tenloaisp 
																		  from ishali_loaisp 
																		  where parent_id = 0 and idpage = '$idpage') c on b.parent_id = c.idloaisp
						where a.idloaisp = b.idloaisp and a.idpage = '$idpage' and ($where)";
				$data = $store->SelectQuery($sql);
				$this->view->product = $data;
			}
			
			$category = $store->getAllParentCategoryByIdPage($idpage, 0);
            $this->view->category = $category;

			
			$sql = "select donvitien, thongtinsp from ishali_config where idpage = '". $idpage ."'";
			$data = $store->SelectQuery($sql);
			if(count($data) == 0)
			{
				$donvitien = "VNĐ";
				$thongtinsp = 0;
			}
			else
			{
				if($data[0]['donvitien'] == "")
					$donvitien = "VNĐ";
				else
					$donvitien = $data[0]['donvitien'];
			}
			$this->view->donvitien = $donvitien;
		
			$this->view->checkSessionIdpage = $checkSessionIdpage;
			$this->view->idpage = $idpage;
		}
	}
}
?>