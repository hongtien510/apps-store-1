<?php
class App_Controller_FrontController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function preDispatch() {
        $facebook = new Ishali_Facebook();
        $store = App_Models_StoreModel::getInstance();
        $this->_SESSION=new Zend_Session_Namespace();

		
        //$facebook->getuserfbid();
    	if($facebook->getpageid() != "")
		{
		  
			@$idpage = $facebook->getpageid();
			$_SESSION['idpage'] = $idpage;
            $this->_SESSION->idpage = $idpage;
			$this->view->idpage = $idpage;
		}
        else
        {
            $idpage = isset($_SESSION['idpage']) ? $_SESSION['idpage'] : "";
            $this->view->idpage = $idpage;
        }

        if($this->_request->getParam("idpage") != "")
        {
            $idpage = $this->_request->getParam("idpage");
            $_SESSION['idpage'] = $idpage;
            $this->_SESSION->idpage = $idpage;
            $this->view->idpage = $idpage;
        }
        
		/*
        $idpage = '356730004423499';
        $_SESSION['idpage'] = $idpage;
        $this->view->idpage = $idpage;
        */
		if(isset($_GET['tabs_added']))
		{	
			$tabs_added = $_GET['tabs_added'];
			foreach($tabs_added as $idpage=>$status)
			$link = ROOT_DOMAIN .'/admin?pg='. $idpage;
			echo "<script>top.location.href = '$link'</script>";
            exit;
		}
		
        if(!$idpage)
        {
            $link = ROOT_DOMAIN .'/admin';
            echo "<script>top.location.href = '$link'</script>";
            exit;
        }
        
        //Khi link có app_data
		if($facebook->getParameterUrl()!=null)
		{
			$idsp = $facebook->getParameterUrl();
			$idsp = base64_decode($idsp);
			$link = APP_DOMAIN . "/detail?idpage=$idpage&id=$idsp";
			//echo "<script>showMessageNotClose('Ðang chuyển trang, vui lòng đợi',5000);</script>";
			echo "<script>setTimeout(function(){window.location = '$link'},3000);</script>";
		}
        
        $config = $store->getConfig($idpage);
        $this->view->config = $config;
        $template = ($config['template'] != "") ? $config['template'] : 'bookshop';
        $option = array('layout' => 'layout', 'layoutPath' => LAYOUT_PATH .'/'. $template);
        Zend_Layout::startMvc($option);
    }

    public function postDispatch() {
        
    }

}

