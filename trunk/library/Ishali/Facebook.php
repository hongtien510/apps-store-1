<?php
class Ishali_Facebook extends Ishali_Api{
	
	private static $fb;

	function test() {   
    }
	
	public static function getFB()
	{
		if(self::$fb)
		{
			return self::$fb;
		}
		$config = Zend_Registry::get(APPLICATION_CONFIG);
		
		$fb = New Facebook_Facebook(array(
				'appId' => $config->facebook->appid,
				'secret' => $config->facebook->appsecret,
				'cookie' => true,
				));
				
				
		self::$fb = $fb;
		
		return self::$fb;
	}
	
 	function __construct() {   
//		Ishali_Facebook::begins_works();
    }
	
	public static function getuserfbid()
	{
		$fb = Ishali_Facebook::getFB();
		return  $fb->getUser();
	}
    
    public static function getAlbums()
    {
        $fb = Ishali_Facebook::getFB();
        $albums = $fb->api('/me/albums');
        return $albums;
    }
    public static function getAlbumsPage($idpage)
    {
        $fb = Ishali_Facebook::getFB();
        $albums = $fb->api("/$idpage/albums");
        return $albums;
    }
    
    public static function getAccessToken()
    {
        $fb = Ishali_Facebook::getFB();
        $access_token = $fb->getAccessToken();
        return $access_token;
    }
    
    public static function getPhotoInAlbums($album_id)
    {
        $fb = Ishali_Facebook::getFB();
        $access_token = Ishali_Facebook::getAccessToken();
        $photos = $fb->api("/$album_id/photos", array("access_token" => "$access_token"));
        return $photos;
    }
	
	public static function checkisadminpage()
	{
		$fb = Ishali_Facebook::getFB();
		$pageid =  Ishali_Facebook::getpageid();
    	if(empty($pageid) || $pageid == 0)
    	{	    		
	    	Ishali_Facebook::directadminlink();
    	}
	}
	
	public static function begins_works($isadmin=NULL, $id_page_add_tab = "")
	{
		$userid= Ishali_Facebook::getuserfbid();
		if($isadmin == 1)
		{
			if ($userid) {
				return true;
			}
			else
			{
				 try {
					@Ishali_Facebook::loginuserfb($isadmin, $id_page_add_tab);
				 } catch (FacebookApiException $e) {
				    echo 'loginuserfbException';exit;
					@Ishali_Facebook::loginuserfbException($isadmin);
				 }
			}
		}
		else
			return true;
	   
	}
    
	public  static function getpagearr()
	{
		if(empty($_REQUEST["signed_request"])) {		
//			Ishali_Facebook::directadminlink();
//				$Ishali_Api = new Ishali_Api();
// 				$Ishali_Api->parentRedirect2("http://localhost/tochuccuocthihinh/article?articleId=1");
//echo "ss";
//					exit;
		}
		else 
		{
			$config = Zend_Registry::get(APPLICATION_CONFIG);
			$app_secret = $config->facebook->appsecret;
			@$data =Ishali_Api::parse_signed_request($_REQUEST["signed_request"], $app_secret);
			return $data;
		}
	}
	/*Ket qua cua getpagearr()//chay tren facebook moi lay duoc
	Array
	(
    [algorithm] => HMAC-SHA256
    [expires] => 1369882800
    [issued_at] => 1369877438
    [oauth_token] => CAAIxaQjBHR4BABcqMfs0HO3SnTaiKznpc2CvZCXQGRz4T5x1IbHfgTG2cYiRQH1eI8SvpeoAY82kRpmLMxixF8k9XoHZCImGWS01gmHIITYr6PMfZB5uRnwiKNnq0uKviRUnY1Fpv2GW7ETk9es2ZATvsKDL7fRA9e2khApdxAZDZD
    [page] => Array
        (
            [id] => 356730004423499
            [liked] => 
            [admin] => 1
        )

    [user] => Array
        (
            [country] => vn
            [locale] => en_US
            [age] => Array
                (
                    [min] => 21
                )

        )

    [user_id] => 100002151254254
	)
	*/
	
	
    
    public  static function getpageid()
	{
		$pageid = Ishali_Facebook::getpagearr();
		return  @$pageid['page']['id'];
	}
	
	public  static function kiemTraLike()
	{
		$pageid = Ishali_Facebook::getpagearr();
		return  $pageid['page']['liked'];
	}
	
	public static function getLinkPage($idpage)
	{
		$fb = Ishali_Facebook::getFB();
		$pages_fb =  $fb->api('/'.$idpage);
		$linkpage = $pages_fb['link'];
		return $linkpage;
	}
		
	public  static function getParameterUrl()
	{
		$param = Ishali_Facebook::getpagearr();
		return  @$param["app_data"];
	}

    public function loginuserfb($isadmin, $id_page_add_tab = "")
	{   
		if(isset($isadmin) && $isadmin==1)
		{
			$config = Zend_Registry::get(APPLICATION_CONFIG);
            if($id_page_add_tab != "")
            {
                $pagelink =$config->facebook->appurl."admin?pg=".$id_page_add_tab;
            }
            else
            {
                $pagelink =$config->facebook->appurl."admin";
            }
			
			Ishali_Facebook::userlogin($pagelink);
		}
        else
        {
            if(isset($isadmin) && $isadmin!=0)
    		{
    		      echo '22222222';exit;
    			$pagelink = Ishali_Facebook::getpage_app_redirect();
    			Ishali_Facebook::userlogin($pagelink."?request_ids=".$isadmin);
    		}else
    		{
    		  echo '33333333333';exit;
    			$pagelink = Ishali_Facebook::getpage_app_redirect();
    			Ishali_Facebook::userlogin($pagelink);
    		}
        } 
        
	}
	    
    public function loginuserfbException($isadmin)
	{   
		if(isset($isadmin) && $isadmin==1)
		{
			$config = Zend_Registry::get(APPLICATION_CONFIG);
			$pagelink =$config->facebook->appurl."admin";
			Ishali_Facebook::userlogin($pagelink);
		}else if(isset($isadmin) && $isadmin!=0)
		{
			$config = Zend_Registry::get(APPLICATION_CONFIG);
			$pagelink = $config->facebook->appurl;
			Ishali_Facebook::userlogin($pagelink."?request_ids=".$isadmin);
		}else
		{
			$pagelink = Ishali_Facebook::getpage_app_redirect();
			Ishali_Facebook::userlogin($pagelink);
		}
			
	}
    
 	public static function converuserfb($app_url)
	{
		$Ishali_Api = new Ishali_Api();
		$convertUrl = "http://www.facebook.com/login/roadblock.php?target_url=$app_url" ;
		$Ishali_Api->parentRedirect($convertUrl);
	}
	    
	    
 	public static function userlogin($app_url)
	{
		$config = Zend_Registry::get(APPLICATION_CONFIG);
		$fb = Ishali_Facebook::getFB();
		$Ishali_Api = new Ishali_Api();
		$paramsp['scope'] = $config->facebook->login_admin->scope;
		$paramsp['response_type'] = $config->facebook->login_admin->response_type;
		$paramsp['redirect_uri'] = $app_url;
		$loginUrl = $fb->getLoginUrl($paramsp);
		$Ishali_Api->parentRedirect($loginUrl);
	}
	    
	    
	
	public static function isFacebookRequest()
	{
		$is_fb_request = false;

		if ($_SERVER['HTTP_USER_AGENT'] == "facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)")
		{
			$is_fb_request = true;
		}

		return $is_fb_request;
	}
	
	//Chua chay duoc
 	public function getpagenamearr()
    {    	
    	$fb = Ishali_Facebook::getFB();
    	$pageid = $fb->getFanPageId();
		$page_profile = $fb->api('/'.$pageid);
	
		return $page_profile;			
		
    }
    
	//Chua chay duoc
 	public function getpagelink()
    {    	
    	$pagearr = Ishali_Facebook::getpagenamearr();
		return $pagearr['link'];			
    }
    
 	public function getpage_app_redirect()
    {    	
    	$pagelink = Ishali_Facebook::getpagelink();
    	$appid = Ishali_Facebook::getFB()->getAppId();
    	return $pagelink."?sk=app_".$appid;
    	
    }
	
	public static function directadminlink()
	{
		$Ishali_Api = new Ishali_Api();
		$config = Zend_Registry::get(APPLICATION_CONFIG);
		
    	$Ishali_Api->parentRedirect($config->facebook->appurl."admin");
	}
	
	/*****************************************************************/
	
 	 public function haslikedpage() {
 	 	
      	 	$pageid = Ishali_Facebook::getpagearr();
			return  $pageid['page']['liked'];
    }
    /**chuc nang post len tuong*/
    public function posttowall($url, $message = '') {
    
    	$fb = Ishali_Facebook::getFB();
//	    $pageid = $fb->getFanPageId();
//	   echo	$page_access_token =Ishali_Facebook::getpageaccesstoken($pageid);
//       if (!empty($page_access_token)) {
      	 	$data['link'] = $url;
      	 	$data['message'] = $message;
			$fb->api('/me/feed','POST', $data);
//				echo "vao toi day";
//    	exit;
//         }
    }
       
    
    public function getpageaccesstoken($pageid) {
    	$pages = Ishali_Facebook::getuserpages();
        $pages = $this->getUserPages();
        foreach ($pages as $page) {
            if ($page['id'] == $pageid) {
                return $page['access_token'];
            }
        }
        return '';
    }
    
	public function getuserpages()
    {    	
    	$fb = Ishali_Facebook::getFB();
		$userpages = $fb->api('/me/accounts');

		return $userpages['data'];			
    }
	
    public function dangungdunglentuong()
    {    	
    		$Ishali_Api = new Ishali_Api();
    		$config = Zend_Registry::get(APPLICATION_CONFIG);
    		$app_id =$config->facebook->appid;
    		$redirect_url =Ishali_Facebook::getpage_app_redirect();
	    	$convertUrl = "http://www.facebook.com/dialog/feed?app_id=$app_id&redirect_uri=$redirect_url" ;
  			$Ishali_Api->parentRedirect($convertUrl);
    }
    
    public function laydanhsachbanbe()
    {    	
    	$fb = Ishali_Facebook::getFB();
		$userfriends = $fb->api('/me/friends');
		return $userfriends;
//		echo "<pre>";
//		print_r($userfriends);
//		echo "</pre>";
//		exit;	
    }
    
    
	public static function getAppId()
	{
		$config = Zend_Registry::get(APPLICATION_CONFIG);
		return $config->facebook->appid;
	}
    
    
    public function getGraphFB($url = "")
    {
        if($url == "") return;  
        $graph = json_decode(file_get_contents($url));  
        return $graph;
    }
    
    
}

?>
