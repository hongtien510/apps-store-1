<?php

class Admin_CategoryController extends App_Controller_AdminController {

    public function init() {
        parent::init();
        $this->_SESSION=new Zend_Session_Namespace();
        
        $facebook = new Ishali_Facebook();
		$idpage = $facebook->getpageid();
        
        if(isset($idpage))
            $_SESSION['idpage'] = $idpage;
            
    }

    public function indexAction() {
		$store = $this->view->info = App_Models_StoreModel::getInstance();
        /*
        if(!isset($this->_SESSION->iduseradmin))
		{
			$link_login = APP_DOMAIN."/admin/login";
			header("Location:$link_login");
		}
        */
		$_SESSION['list_page'] = "1";
		
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
            $list_loaisp = $store->getAllCategoryByIdPage($idpage, 0);
            $category = $store->addCategoryIntoMenuAdmin($list_loaisp);
            $this->view->category = $category;
			
			$this->view->checkSessionIdpage = $checkSessionIdpage;
		}	
    }
	
	public function addAction() {
	   /*
        if(!isset($this->_SESSION->iduseradmin))
			header("Location:../login");
        */
		$_SESSION['list_page'] = "0";
		
		if($this->_request->getParam("idpage") != "")
        {
			$idpagee = $this->_request->getParam("idpage");
			$_SESSION['idpage'] = $idpagee;
		}
        $idpage = $_SESSION['idpage'];
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        
        //Truong hop hien thi menu nhieu cap
        //$list_loaisp = $store->getAllCategoryByIdPage($idpage, 0);
        //$category = $store->addCategoryIntoMenuAdmin($list_loaisp);
        
        //Chi hien thi menu cha
        $category = $store->getAllParentCategoryByIdPage($idpage, 0);
        $this->view->list_loaisp = $category;
        
        $sql = "select max(vitri) as 'maxvitri' from ishali_loaisp where idpage = '". $idpage ."' and parent_id = 0";
		$data = $store->SelectQuery($sql);
        $this->view->maxvitri = $data[0]['maxvitri'];
    }
    

    
    public function detailAction() {
        /*
        if(!isset($this->_SESSION->iduseradmin))
			header("Location:../login");
        */
        
		$_SESSION['list_page'] = "0";
		
        $idpage = $_SESSION['idpage'];
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        
        $category = $store->getAllParentCategoryByIdPage($idpage, 0);
        $this->view->list_loaisp = $category;
        
        $idcat = base64_decode($this->_request->getParam("idcat"));
        $sql = "Select * from ishali_loaisp where idloaisp = " . $idcat . " and idpage = ". $idpage;
        $data = $store->SelectQuery($sql);
        $this->view->category = $data;

    }
	
	public function xulyaddAction() {    
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        $facebook = new Ishali_Facebook(); 
        $iduser_fb = $facebook->getuserfbid();
        $idpage = $_SESSION['idpage'];
        
        
        if($store->checkUserManagerPage($iduser_fb, $idpage))
        {
            $Tenlsp = $_POST["tenlsp"];
            $Vitri = $_POST["vitri"];
            $Anhien = $_POST["anhien"];
            $parent_id = $_POST["parent_id"];
            
            $sql = "Insert into ishali_loaisp(tenloaisp, vitri, anhien, idpage, parent_id) ";
            $sql.= "Values ('" . $Tenlsp . "', '" . $Vitri . "', '" . $Anhien . "', '". $idpage ."', '". $parent_id ."')";
            $rs = mysql_query($sql);
            if ($rs) {
                echo 1;
                
                $id = mysql_insert_id();
                //Kiem tra xem neu dem bang 1 thi tiep tuc kiem tra co san pham nao thuoc danh muc nay ko, neu co thi chuyen san pham ve danh muc moi them
                $sql = "select count(*) as count_child_cat from ishali_loaisp where parent_id = $parent_id";
                $data = $store->SelectQuery($sql);
                $count = $data[0]['count_child_cat'];
                if($count == 1)
                {
                    $sql = "update ishali_sanpham set idloaisp = '$id' where idloaisp = '$parent_id' and idpage = '$idpage'";
                    $store->InsertDeleteUpdateQuery($sql);
                }
            }
            else
            {
                echo 0;
            }	
        }
        else
        {
            echo -1;
        }
        
        	
    }
    
    public function xulyupdateAction() {    
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
        
        $idCategory = $_POST['idcategory'];
        $parent_id = $_POST['parent_id'];
        $Tenlsp = $_POST["tenlsp"];
        $Vitri = $_POST["vitri"];
        $Anhien = $_POST["anhien"];
        
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        
        $sql = "Update ishali_loaisp Set ";
        $sql.= "tenloaisp = N'" . $Tenlsp . "', ";
        $sql.= "vitri = '" . $Vitri . "', ";
        $sql.= "anhien = '" . $Anhien . "', ";
        $sql.= "parent_id = '" . $parent_id . "' ";
        $sql.= "where idloaisp = ". $idCategory;

        
        //echo $sql;
		echo $data = $store->InsertDeleteUpdateQuery($sql);
		
    }
    
   	public function deleteAction() { 
   	    $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        $idcat = base64_decode($_POST['idCat']);
        //Kiem tra danh muc nay co chua san ppham hay ko
        $sql = "select count(*) as count_sanpham from ishali_sanpham where idloaisp = '$idcat'";
        $data = $store->SelectQuery($sql);
        if($data[0]['count_sanpham'] > 0)
        {
            echo 'ko';
        }
        else
        {
            $sql = "select count(*) as count_child_cat from ishali_loaisp where parent_id = '$idcat'";
            $data = $store->SelectQuery($sql);
            if($data[0]['count_child_cat'] > 0)
            {
                echo 'koo';
            }
            else
            {
                $sql = "Delete from ishali_loaisp where idloaisp = " . $idcat;
                echo $data = $store->InsertDeleteUpdateQuery($sql);
            }
            
        }
    }
    
    public function getorderAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $store = $this->view->info = App_Models_StoreModel::getInstance();
        $idpage = $_SESSION['idpage'];
        
        $parent_id = $_POST['parent_id'];
        $idloaisp = isset($_POST['idloaisp']) ? $_POST['idloaisp'] : "";
        
        if($parent_id != 0 && $idloaisp != "")
        {
            $sql = "select idloaisp from ishali_loaisp where idpage = '$idpage' and parent_id = $idloaisp";
            $rs = mysql_query($sql);
            if(mysql_num_rows($rs) > 0)
            {
                echo 'ko';
                exit;
            }
        }

        $sql = "select max(vitri) as 'maxvitri' from ishali_loaisp where idpage = '$idpage' and parent_id = '$parent_id'";
        $data = $store->SelectQuery($sql);
        $order = $data[0]['maxvitri'];
        echo $order = max(0,$order);
 
    }

}

