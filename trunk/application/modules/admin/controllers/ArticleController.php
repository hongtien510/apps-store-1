<?php

class Admin_ArticleController extends App_Controller_AdminController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
    	$facebook = new Ishali_Facebook();  
	 	$this->view->fbuserid = $facebook->getuserfbid();
		if(isset($_GET['pageid']) && $_GET['pageid']>0)
		{
			$this->view->pageid = $_GET['pageid'];
			$this->view->page_name = $_GET['pagename'];
			$this->view->listArticle =App_Models_ArticleModel::getInstance()->getListByFbPage_admin($this->view->pageid);
			$this->view->list_pages = App_Models_ArticleModel::getInstance()->listArticlePages($this->view->fbuserid);

			$layoutPath = APPLICATION_PATH . '/templates/giaodien_admin';
	        $option = array('layout' => 'article_ajax', 'layoutPath' => $layoutPath);
	        Zend_Layout::startMvc($option);
		}
		else 
		{
			$PagesList = App_Models_PagesModel::getInstance()->getList('','','',$this->view->fbuserid);
			$this->view->page_name =$PagesList[0]['page_name'];
			$this->view->pageid = $PagesList[0]['id_fb_page'];
			$this->view->listArticle =App_Models_ArticleModel::getInstance()->getListByFbPage_admin($this->view->pageid);
			$this->view->list_pages = App_Models_ArticleModel::getInstance()->listArticlePages($this->view->fbuserid);
//		    $layoutPath = APPLICATION_PATH . '/templates/giaodien_admin';
//	        $option = array('layout' => 'index', 'layoutPath' => $layoutPath);
//	        Zend_Layout::startMvc($option);
		}
			
	}
	
    public function addAction() {
    	if(isset($_GET['articleid']) && $_GET['articleid'] > 0)
    	{
    		$id = $_GET['articleid'];
   			$articledetail = App_Models_ArticleModel::getInstance()->getDetail($id);
   			$this->view->id_bai_viet = $articledetail->id_bai_viet;
   			$this->view->ten_menu = $articledetail->ten_menu;
   			$this->view->tieu_de  = $articledetail->ten_menu;
   			$this->view->noi_dung = $articledetail->noi_dung;
   			$this->view->thu_tu = $articledetail->thu_tu;
   			$this->view->an_hien = $articledetail->an_hien;
   			$this->view->ngay_tao = $articledetail->ngay_tao;
   		
    	}
    	$layoutPath = APPLICATION_PATH . '/templates/giaodien_admin';
	  	$option = array('layout' => 'article_ajax', 'layoutPath' => $layoutPath);
	    Zend_Layout::startMvc($option);
    	
	}

    public function saveAction() {
	App_Models_ArticleModel::getInstance()->save();
	}
	
    public function deleteAction() {
    	$id = $_GET['articleid'];
		App_Models_ArticleModel::getInstance()->remove($id);

	}

}

