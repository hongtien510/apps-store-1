<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArticleModel
 *
 * @author root
 */
class App_Models_PagesModel {

    private $_db;
    private static $_instance;

    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new App_Models_PagesModel();
            self::$_instance->_db = App_Storage_Mysql_Connector::getInstance();
        }
        return self::$_instance;
    }

    public function put(App_Entities_Pages $page, $isUpdate = 0) {

        $page->an_hien = $this->_db->safeParams($page->an_hien, 1);
        $page->background_color = $this->_db->safeParams($page->background_color);
        $page->background_images = $this->_db->safeParams($page->background_images);
        $page->banner = $this->_db->safeParams($page->banner);
        $page->banner_link = $this->_db->safeParams($page->banner_link);
        $page->cam_on_binh_chon = $this->_db->safeParams($page->cam_on_binh_chon);
        $page->cam_on_tham_gia = $this->_db->safeParams($page->cam_on_tham_gia);
        $page->color = $this->_db->safeParams($page->color);
        $page->date_create = $this->_db->safeParams($page->date_create, 1);
        $page->font_size = $this->_db->safeParams($page->font_size);
        $page->footer = $this->_db->safeParams($page->footer);
        $page->id_fb = $this->_db->safeParams($page->id_fb, 1);
        $page->id_fb_page = $this->_db->safeParams($page->id_fb_page, 1);
        $page->id_pages = $this->_db->safeParams($page->id_pages, 1);
        $page->like_binh_chon = $this->_db->safeParams($page->like_binh_chon, 1);
        $page->like_comment = $this->_db->safeParams($page->like_comment, 1);
        $page->like_tham_gia = $this->_db->safeParams($page->like_tham_gia, 1);
        $page->page_name = $this->_db->safeParams($page->page_name);
        $page->show_gioi_thieu = $this->_db->safeParams($page->show_gioi_thieu, 1);
        $page->show_gioi_tinh = $this->_db->safeParams($page->show_gioi_tinh, 1);
        $page->show_luot_xem = $this->_db->safeParams($page->show_luot_xem, 1);
        $page->show_ma = $this->_db->safeParams($page->show_ma, 1);
        $page->show_so_binh_chon = $this->_db->safeParams($page->show_so_binh_chon, 1);
        $page->show_ten = $this->_db->safeParams($page->show_ten, 1);
        $page->so_lan_binh_chon = $this->_db->safeParams($page->so_lan_binh_chon, 1);
        $page->templates = $this->_db->safeParams($page->templates);

        if ($isUpdate) {

            $value = "an_hien='" . $page->an_hien . "'"
                    . ",background_color='" . $page->background_color . "'"
                    . ",background_images='" . $page->background_images . "'"
                    . ",banner='" . $page->banner . "'"
                    . ",banner_link='" . $page->banner_link . "'"
                    . ",cam_on_binh_chon='" . $page->cam_on_binh_chon . "'"
                    . ",cam_on_tham_gia='" . $page->cam_on_tham_gia . "'"
                    . ",color='" . $page->color . "'"
//                    . ",'" . $page->date_create . "'"
                    . ",font_size='" . $page->font_size . "'"
                    . ",footer='" . $page->footer . "'"
//                    . ",'" . $page->id_fb . "'"
//                    . ",'" . $page->id_fb_page . "'"
                    . ",like_binh_chon='" . $page->like_binh_chon . "'"
                    . ",like_comment='" . $page->like_comment . "'"
                    . ",like_tham_gia='" . $page->like_tham_gia . "'"
                    . ",page_name='" . $page->page_name . "'"
                    . ",show_gioi_thieu='" . $page->show_gioi_thieu . "'"
                    . ",show_gioi_tinh='" . $page->show_gioi_tinh . "'"
                    . ",show_luot_xem='" . $page->show_luot_xem . "'"
                    . ",show_ma='" . $page->show_ma . "'"
                    . ",show_so_binh_chon='" . $page->show_so_binh_chon . "'"
                    . ",show_ten='" . $page->show_ten . "'"
                    . ",so_lan_binh_chon='" . $page->so_lan_binh_chon . "'"
                    . ",templates='" . $page->templates . "'";


            $question = "update " . App_Entities_Pages::$TABLE . " set " . $value . " where id_pages=" . $page->id_pages;
            $result = $this->_db->executeNonQuery($question);
            if ($result != NULL) {                
                return $page->id_pages;
            }
        } else {
            $input = 'an_hien
            ,background_color
            ,background_images
            ,banner
            ,banner_link
            ,cam_on_binh_chon
            ,cam_on_tham_gia
            ,color
            ,date_create
            ,font_size
            ,footer
            ,id_fb
            ,id_fb_page
            ,like_binh_chon
            ,like_comment
            ,like_tham_gia
            ,page_name
            ,show_gioi_thieu
            ,show_gioi_tinh
            ,show_luot_xem
            ,show_ma
            ,show_so_binh_chon
            ,show_ten
            ,so_lan_binh_chon
            ,templates';

            $value = "'" . $page->an_hien . "'"
                    . ",'" . $page->background_color . "'"
                    . ",'" . $page->background_images . "'"
                    . ",'" . $page->banner . "'"
                    . ",'" . $page->banner_link . "'"
                    . ",'" . $page->cam_on_binh_chon . "'"
                    . ",'" . $page->cam_on_tham_gia . "'"
                    . ",'" . $page->color . "'"
                    . ",'" . $page->date_create . "'"
                    . ",'" . $page->font_size . "'"
                    . ",'" . $page->footer . "'"
                    . ",'" . $page->id_fb . "'"
                    . ",'" . $page->id_fb_page . "'"
                    . ",'" . $page->like_binh_chon . "'"
                    . ",'" . $page->like_comment . "'"
                    . ",'" . $page->like_tham_gia . "'"
                    . ",'" . $page->page_name . "'"
                    . ",'" . $page->show_gioi_thieu . "'"
                    . ",'" . $page->show_gioi_tinh . "'"
                    . ",'" . $page->show_luot_xem . "'"
                    . ",'" . $page->show_ma . "'"
                    . ",'" . $page->show_so_binh_chon . "'"
                    . ",'" . $page->show_ten . "'"
                    . ",'" . $page->so_lan_binh_chon . "'"
                    . ",'" . $page->templates . "'";


            $question = "insert into " . App_Entities_Pages::$TABLE . " ($input) value ($value)";
            $result = $this->_db->executeNonQuery($question);

            if ($result != NULL) {
                $page->id_pages = $this->_db->getNearIndex();
                return $page->id_pages;
            }
        }

        return 0;
    }

    public function remove($id) {
        $id = $this->_db->safeParams($id, 1);
        $question = "delete from " . App_Entities_Pages::$TABLE . " where id_pages=$id";
        $result = $this->_db->executeNonQuery($question);
        return $result;
    }

    public function getDetail($id_fb_page) {
        $item = new App_Entities_Pages();

        $id_fb_page = $this->_db->safeParams($id_fb_page, 1);

        $output = 'id_pages
            ,an_hien
            ,background_color
            ,background_images
            ,banner
            ,banner_link
            ,cam_on_binh_chon
            ,cam_on_tham_gia
            ,color
            ,date_create
            ,font_size
            ,footer
            ,id_fb
            ,id_fb_page
            ,like_binh_chon
            ,like_comment
            ,like_tham_gia
            ,page_name
            ,show_gioi_thieu
            ,show_gioi_tinh
            ,show_luot_xem
            ,show_ma
            ,show_so_binh_chon
            ,show_ten
            ,so_lan_binh_chon
            ,templates';

        $question1 = "select " . $output . " from " . App_Entities_Pages::$TABLE . " where id_fb_page='$id_fb_page'";
//exit;
        $result = $this->_db->executeReader($question1);
        if (!empty($result)) {
            $item = App_Entities_Pages::buildData($result[0]);
        }

        return $item;
    }

    public function getList($offset, $count = 10, $enable = -1, $id_fb) {
        $result = array();
        $output = 'id_pages,
						id_fb_page,
						page_name,
						date_create';

        //TODO: cái này có công dụng gì
//        $fbPageId = $this->_db->safeParams($fbPageId, 1);

        $condition = " id_fb=" . $id_fb;

        if ($enable > -1) {
            $condition.= " and an_hien=1";
        }

        $order = "";

        $query = "select " . $output . " from " . App_Entities_Pages::$TABLE . " where " . $condition . $order;
//      		$query = "select " . $output . " from " . App_Entities_Pages::$TABLE . " where " . $condition . $order;

        $data = $this->_db->executeReader($query);
        if (!empty($data)) {
            return $data;
//            foreach ($data as $it) {
//                $item = App_Entities_Pages::buildData($it);
//                $result[] = $item;
//            }
        }
        return $result;
    }

    public function checkHasAddedApp() {

    	$pageid=$_REQUEST['pageid'];
 		$userid=$_REQUEST['userid'];
 		$pagename=$_REQUEST['pagename'];
 		
//		$pageid ='163439097120561';
// 		$userid= '100003941320525';
 		$date = time();
 		 		$facebook = new Ishali_Facebook();  
 		$fb = $facebook->getFB();
 		
  			  /*Insert user*/
		 		$str_user = "SELECT id_fb FROM ishali_users WHERE id_fb='$userid'";
		 		
		 		$stmt_user = $this->_db->executeReader($str_user);
				if(empty($stmt_user))
				{
					$kquser = $fb->api("/".$userid);
					$name = $kquser['name'];
					$first_name = $kquser['first_name'];
					$middle_name = $kquser['middle_name'];
					$last_name = $kquser['last_name'];
					$gender = $kquser['gender'];
					
					$sql_user_insert ="INSERT INTO `ishali_users` (`id_fb`, `name`, `first_name`, `middle_name`, `last_name`,`gender`,`time_created`)";
					$sql_user_insert.=" VALUES	('$userid', '$name', '$first_name',	'$middle_name','$last_name','$gender','$date') ";	
					$this->_db->executeReader($sql_user_insert);
				}
		 		/*End Insert user*/
		 		
		 		$str = "SELECT id_pages FROM ishali_pages WHERE id_fb_page='$pageid'";
		 		$stmt = $this->_db->executeReader($str);
				if(empty($stmt))
				{
					$sql_page_insert ="INSERT INTO `ishali_pages`(`id_fb_page`, `id_fb`, `page_name` ) ";
					$sql_page_insert.=" VALUES ('$pageid','$userid','$pagename') ";	
//					echo $sql_page_insert;
					$this->_db->executeReader($sql_page_insert);
				}
 		
 		
 		

 		
		$fql="SELECT has_added_app FROM page WHERE page_id =$pageid";
		$kq=$fb->api( array(
							 'method' => 'fql.query',
							 'query' => $fql,
						 ));
		 	$hadadd =  $kq[0]['has_added_app'];		
    		if($hadadd ==1)
			{
				echo 1;
			}
    }
    
  public function updatepage(){
    	$id_fb_page=$_POST['id_fb_page'];
 	
 		$banner_link=$_POST['banner_link'];
 		$templates=$_POST['templates'];
 		$show_gioi_tinh=$_POST['show_gioi_tinh'];
 		$show_ma=$_POST['show_ma'];
 		$show_ten=$_POST['show_ten'];
 		$show_luot_xem=$_POST['show_luot_xem'];
 		$show_so_binh_chon=$_POST['show_so_binh_chon'];
 		$show_gioi_thieu=$_POST['show_gioi_thieu'];
 		$so_lan_binh_chon=$_POST['so_lan_binh_chon'];
 		$like_binh_chon=$_POST['like_binh_chon'];
 		$like_tham_gia=$_POST['like_tham_gia'];
 		$like_comment=$_POST['like_comment'];
 		$cam_on_binh_chon=$_POST['cam_on_binh_chon'];
 		$cam_on_tham_gia=$_POST['cam_on_tham_gia'];
 		$footer=$_POST['footer'];
 		$font_size=$_POST['font_size'];
 		$background_color=$_POST['background_color'];
 		$background_images=$_POST['background_images'];
 		$color=$_POST['color'];
		
		
		if($_FILES['banner']['name'] !="")
		{
			$urlhinh=time().'_'.$_FILES["banner"]['name'];
			move_uploaded_file($_FILES["banner"]['tmp_name'],"public/images/banner/".$urlhinh);
			$banner= "`banner` = '$urlhinh' , ";
		}else
		{
		$banner = ' ';
		}
			
		if($_FILES['background_images']['name'] !="")
		{
			$urlhinh=time().'_'.$_FILES["background_images"]['name'];
			move_uploaded_file($_FILES["background_images"]['tmp_name'],"public/images/background_images/".$urlhinh);
			$background_images= "`background_images` = '$urlhinh' , ";
		}else
		{
		$background_images = ' ';
		}
			
		
		$str_update = "UPDATE `ishali_pages` 
						SET			
						$banner
						`banner_link` = '$banner_link' , 
						`templates` = '$templates' , 
						
						`show_gioi_tinh` = '$show_gioi_tinh' , 
						`show_ma` = '$show_ma' , 
						`show_ten` = '$show_ten' , 
						`show_luot_xem` = '$show_luot_xem' , 
						`show_so_binh_chon` = '$show_so_binh_chon' , 
						`show_gioi_thieu` = '$show_gioi_thieu' , 
						`so_lan_binh_chon` = '$so_lan_binh_chon' , 
						`like_binh_chon` = '$like_binh_chon' , 
						`like_tham_gia` = '$like_tham_gia' , 
						`like_comment` = '$like_comment' , 
					
						`cam_on_binh_chon` = '$cam_on_binh_chon' , 
						`cam_on_tham_gia` = '$cam_on_tham_gia' , 
						`footer` = '$footer' , 
						`font_size` = '$font_size' , 
						`background_color` = '$background_color' , 
						$background_images 
						`color` = '$color'						
						WHERE	`id_fb_page` = '$id_fb_page' ;
					";
			$this->_db->executeReader($str_update);
//			$config = Zend_Registry::get(APPLICATION_CONFIG);

		$url = 	Ishali_Facebook::directadminlink();
//		$url = 'http://apps.facebook.com/tochuccuocthihinh/admin';
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
		exit("Nội dung đang được luu.....<script>window.top.location.replace('$url');</script>");

    }
    
//      public function getListByUser($id_fb) {
//        $result = array();
//        $output = 'id_pages,
//						id_fb_page';
//
//        $fbPageId = $this->_db->safeParams($fbPageId, 1);
//
//        $condition = " id_fb=" . $id_fb;
//
//            $condition.= " and an_hien=1";
//
//        $order = "";
//
//        $query = "select " . $output . " from " . App_Entities_Pages::$TABLE . " where " . $condition . $order;
//
//        $data = $this->_db->executeReader($query);
//        if (!empty($data)) {
//            return $data;
////            foreach ($data as $it) {
////                $item = App_Entities_Pages::buildData($it);
////                $result[] = $item;
////            }
//        }
//        return $result;
//    }
    
    
 	 public function listSelectPages($userid )
    {
    	$pageList = App_Models_PagesModel::getInstance()->getList('','','',$userid);
    	$name ="page";
		$html = "<SELECT  onchange='show_list_thisinh(this.value, this.options[this.selectedIndex].text)' NAME='".$name."' >";
    	
//    	$html .= "<OPTION VALUE='-1'>Chọn Trang</OPTION>";
		    foreach($pageList AS $row)
			{
				$html .= "<OPTION VALUE=\"$row[id_fb_page]\">$row[page_name]</OPTION>";
			}
		$html .= "</SELECT>";
		return $html;
    }

}

