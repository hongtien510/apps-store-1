<?php
class Ishali_FacebookAdmin extends Ishali_Facebook{
	
 	 public static function install()
	 {	
			$config = Zend_Registry::get(APPLICATION_CONFIG);
            
            
	    	$fb = Ishali_Facebook::getFB();
	    	$Ishali_Api = new Ishali_Api();
	    	$paramsp['scope'] = $config->facebook->login_admin->scope;
	    	$paramsp['response_type'] = $config->facebook->login_admin->response_type;
	    	$paramsp['redirect_uri'] =$config->facebook->appurl."admin";

			$loginUrl = $fb->getLoginUrl($paramsp);
			$Ishali_Api->parentRedirect($loginUrl);
	  }
	  
    public function list_pages($userid, $name='page', $class='', $id='', $onchange='', $style='' )
    {
    	$config = Zend_Registry::get(APPLICATION_CONFIG);
//    	$bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');		
//		$options = $bootstrap->getOptions();	
    	$appid = $config->facebook->appid;
//    	$appid = $options['facebook']['appid'];
//    	$html = "<SELECT onchange='test2()' NAME='".$name."'>";

    	$html = "<input type='button' onclick=\"window.open('http://www.facebook.com/pages/create.php?ref_type=sitefooter', 'mywindow');\" value='Tạo trang' name='createpages' />";
    	
//    	$html = "<SELECT onchange='has_added_app(this.value,this.options[this.selectedIndex].text,$userid, $appid)' NAME='".$name."'>";
		$html .= "<SELECT class='select' onchange='has_added_app(this.value,this.options[this.selectedIndex].text,$userid, $appid, 1)' NAME='".$name."' ID='".$name."'>";
    	
    	$userpages = Ishali_Facebook::getuserpages();
    	$html .= "<OPTION VALUE='-1'>Chọn Trang</OPTION>";
		    foreach($userpages AS $row)
			{
				if($row['category']!='Application')
				{
				$html .= "<OPTION VALUE=\"$row[id]\">$row[name]</OPTION>";
				}
			}
		$html .= "</SELECT>";
		//$html .= "<input type='button' onclick=\"inputpageonload('$name', $userid, $appid)\" value='load' name='loadpage' />";
		return $html;
    }

    public function checkpermissions($perimssionkey)
    {  
		$fb = Ishali_Facebook::getFB();
        
		$permissions = @$fb->api("/me/permissions");
	    if(array_key_exists($perimssionkey, $permissions['data'][0]) ) {
		  return 1;
		} else {
		   return 0;
		}
    }

/*
 	public static function addpagetab()
    {
    	$Ishali_Api = new Ishali_Api();
    	$convertUrl = "http://www.facebook.com/dialog/pagetab?app_id=254387861355717&redirect_uri=http://apps.facebook.com/tochuccuocthihinh&scope=manage_pages,publish_stream&response_type=code" ;
  		$Ishali_Api->parentRedirect($convertUrl);
    }
    
    public static function getCreatePageUrl()
    {
        return 'http://www.facebook.com/pages/create.php?ref_type=sitefooter';
    }
*/  
}

?>
