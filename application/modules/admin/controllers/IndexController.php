<?php

class Admin_IndexController extends App_Controller_AdminController {

    public function init() {
        parent::init();
        $this->_SESSION=new Zend_Session_Namespace();
    }

    public function indexAction() {
        $store = App_Models_StoreModel::getInstance();
        $id_page_add_tab = $this->_request->getParam("pg");
		$_SESSION['list_page'] = "0";

        $facebookadmin = new Ishali_FacebookAdmin();  
        $facebook = new Ishali_Facebook();  
		$facebook->begins_works('1', $id_page_add_tab);
		$manage_pages =  $facebookadmin->checkpermissions('manage_pages');
		/*
        if(!isset($this->_SESSION->iduseradmin))
		{
			$link_login = APP_DOMAIN."/admin/login";
			header("Location:$link_login");
		}
        */
        //Cai App Vao Page
        if($id_page_add_tab != "")
        {
            $iduser_fb = $facebook->getuserfbid();
            $user_page = $facebook->getuserpages();
            $status = 0;
            //echo '<pre>';print_r($user_page);exit;
            foreach($user_page as $key=>$value)
            {
                //echo $value['id'];exit;
                if($id_page_add_tab == $value['id'])
                {
                    $status = 1;
                } 
            }
            if($status == 1)
            {
                $linkGraphPage = "http://graph.facebook.com/$id_page_add_tab";
                $info_page = $facebook->getGraphFB($linkGraphPage);
                $page_name = $info_page -> name;
                $link_page = $info_page -> link;

                if(!$store->checkManagerPage($id_page_add_tab, $iduser_fb))
                {
                    $sql = "insert into ishali_pages(id_fb_page, page_name, id_fb, link_page) values('$id_page_add_tab', '$page_name', '$iduser_fb', '$link_page')";
                    $store->InsertDeleteUpdateQuery($sql);
                }
            }
        }
        

    	if ($manage_pages)
    	{
			$this->view->appid = $facebook->getAppId();
			$this->view->fbuserid = $facebook->getuserfbid();
			$this->view->list_pages = $facebookadmin->list_pages($this->view->fbuserid, 'page');
            $this->view->pageslist = App_Models_PagesModel::getInstance()->getList('a',10, 1, $this->view->fbuserid );
    	   
            
        
        }else {
    		$facebookadmin->install();
    	}
    }

    public function installpageAction() {
		$store = $this->view->info = App_Models_StoreModel::getInstance();
		
		$pageid = $_GET['pageid'];
		$pagename = $_GET['pagename'];
		$userid = $_GET['userid'];
		$appid = $_GET['appid'];
		$status = $_GET['status'];
		$facebook = new Ishali_Facebook();
		$linkpage = $facebook->getLinkPage($pageid);
		
		if($status == 1)
		{
			$sql = "Select 1 from ishali_pages where id_fb_page = '". $pageid ."' and id_fb = '". $userid ."'";
			$data = $store->SelectQuery($sql);
			if(count($data) > 0)
			{
				echo "<script>ThongBaoDongY('Fanpage <u>$pagename</u><br/>Đã được cài thành công vào ứng dụng.', '".ROOT_DOMAIN."/admin');</script>";	
			}
			else
			{
				$link = "http://www.facebook.com/add.php?api_key=$appid&pages=1&page=$pageid";
				echo "<script>customerLoadWindow('$link', '', '540', '400');</script>";
				
				$sql = "Insert into ishali_pages(id_fb_page, page_name, id_fb, link_page, templates) value(";
				$sql.= "'".$pageid."', ";
				$sql.= "'".$pagename."', ";
				$sql.= "'".$userid."', ";
				$sql.= "'".$linkpage."', ";
				$sql.= "'tmpstore') ";
				
				$data = $store->InsertDeleteUpdateQuery($sql);
				
				if($data == 1)
				{
					echo "<script>ThongBaoDongY('Sau khi cài ứng dụng lên FanPage thành công,<br/>Hãy nhấn nút Đóng', '".ROOT_DOMAIN."/admin');</script>";	
				}
				else
				{
					echo "<script>ThongBaoDongY('Cài ứng dụng không thành công<br/>Vui Lòng thực hiện lại thao tác.', '".ROOT_DOMAIN."/admin');</script>";
				}
			}
		}
		else
		{
			$link = "http://www.facebook.com/add.php?api_key=$appid&pages=1&page=$pageid";
			echo "<script>customerLoadWindow('$link', '', '540', '400');</script>";
			echo "<script>ThongBaoDongY('Sau khi cài ứng dụng lên FanPage thành công,<br/>Hãy nhấn nút Đóng', '".ROOT_DOMAIN."/admin');</script>";	

		}
    }
}

