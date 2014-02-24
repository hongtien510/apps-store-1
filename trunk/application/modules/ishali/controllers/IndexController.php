<?php

class Ishali_IndexController extends App_Controller_IshaliController {

    public function init() {
        parent::init();
    }

  public function indexAction() {
  
        $facebookadmin = new Ishali_FacebookAdmin();  
        $facebook = new Ishali_Facebook();  
		$facebook->begins_works('1');
        
    	$manage_pages =  $facebookadmin->checkpermissions('manage_pages');
    	if ($manage_pages)
    	{
    	
		$this->view->appid = $facebook->getAppId();
	 	$this->view->fbuserid = $facebook->getuserfbid();
//		$this->view->list_pages = $facebookadmin->list_pages($this->view->fbuserid, 'page');
		
		$request = $this->getRequest();
        $this->view->curr_page = $request->getParam('search_page', 1);
        $this->view->count = 45;
        
		 $result =	App_Models_IshaliModel::getInstance()->getList($this->view->curr_page, $this->view->count);
		 $this->view->total = $result['total'];
	        $this->view->pageslist = $result['data'];
	        $paging = array();
	        $paging['totalRecord'] = $result['total'];
	        $paging['currentPage'] = $this->view->curr_page;
	        $paging['numDisplay'] = 5;
	        $paging['pageSize'] = $this->view->count;
	        $paging['action'] = APP_DOMAIN . '/ishali';
	
	        $this->view->paging = json_encode($paging);
        
    	}else {
    		$facebookadmin->install();
    	}
    }
    
    public function updatestatusAction() {

    	$info = new App_Entities_Pages();
    	$info->an_hien = $_GET['status'];
    	$info->idpage = $_GET['idpage'];
    	
    	App_Models_IshaliModel::getInstance()->update_status($info);
     	$layoutPath = APPLICATION_PATH . '/templates/giaodien_admin';
	  	$option = array('layout' => 'install', 'layoutPath' => $layoutPath);
	    Zend_Layout::startMvc($option);
	}
	
    public function delpageAction() {
    	$id_encode = $_GET['idpage'];
    	$id_decode = base64_decode($id_encode);
	  	$this->view->pageid = substr($id_decode, 2,strlen($id_decode));   		
    	
    	App_Models_IshaliModel::getInstance()->remove($this->view->pageid);
    	$url = FB_APP_DOMAIN.'/ishali';
    	$this->_redirect($url);
    	
    	
	}
	
   	 public function delpageuserAction() {
    	$id_encode = $_GET['idpage'];
    	$id_decode = base64_decode($id_encode);
	  	$this->view->pageid = substr($id_decode, 2,strlen($id_decode));   		
    	
    	App_Models_IshaliModel::getInstance()->remove($this->view->pageid);
    	$url = FB_APP_DOMAIN.'/admin';
    	$this->_redirect($url);
    	
    	
	}
	

  	public function listthisinhAction() {
		$id_encode = $_GET['idpage'];
    	$id_decode = base64_decode($id_encode);
	  	$this->view->pageid = substr($id_decode, 2,strlen($id_decode));   
//  	exit;
		 $result =	App_Models_IshaliModel::getInstance()->getListthisinh($this->view->pageid);
	     $this->view->listthisinh = $result;

        
    }

 
}

