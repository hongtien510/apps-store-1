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
class App_Models_IshaliModel {

    private $_db;
    private static $_instance;

    public static function getInstance() {
        if (self::$_instance == NULL) {
            self::$_instance = new App_Models_IshaliModel();
            self::$_instance->_db = App_Storage_Mysql_Connector::getInstance();
        }
        return self::$_instance;
    }

    
 	public function getList( $page = 1, $count = 0) {
 		  if ($page < 1) {
            $page = 1;
        }
        $offset = ($page - 1) * $count;
        $result = array();
        $result['data'] = array();
        $result['total'] = 0;
        $result = array();
        $output = 'DISTINCT id_fb_page,					id_pages,
					page_name,					date_create,					an_hien				';
        $order = "";		
 		if ($count > 0) {
            $limit = ' limit ' . $offset . ',' . $count;
        } else {
            $limit = '';
        }
        $queryTotal = "select count(*) as total from " . App_Entities_Pages::$TABLE ;		
		$query = "select " . $output . " from " . App_Entities_Pages::$TABLE  . $order . $limit;

        $total = $this->_db->executeReader($queryTotal);
        if (!empty($total)) {
            $result['total'] = $total[0]['total'];
        }
        $data = $this->_db->executeReader($query);
        if (!empty($data)) {
//        	  return $data;
//  			$result['data'][]  = $data;
       	 foreach ($data as $item) {
//                $pageInfo = App_Entities_Pages::buildData($item);
              
                 $result['data'][]  = $item;
            }
         
        }
//        echo "<pre>";
//        print_r($result);
//        echo "</pre>";
//        exit;	
        return $result;
        
        
    }
    
 public function update_status(App_Entities_Pages $item) {

        $item->an_hien = $this->_db->safeParams($item->an_hien, 1);
        $item->id_page = $this->_db->safeParams($item->idpage);

        if ($item->an_hien == 0) {
            $anhien = 1;
        } else {
            $anhien = 0;
        }
        $value = "an_hien = '" . $anhien . "'";

        $question = "update " . App_Entities_Pages::$TABLE . " set " . $value . " where id_pages=" . $item->id_page;
        $result = $this->_db->executeNonQuery($question);

        if ($result != NULL) {
            return $item->id_page;
        }

        return 0;
    }
    
    public function remove($id) {
        $id = $this->_db->safeParams($id, 1);
        $question = "delete from " . App_Entities_Pages::$TABLE . " where id_fb_page=$id";
        $result0 = $this->_db->executeNonQuery($question);
        
        $question2 = "delete from " . App_Entities_ImageInfo::$TABLE . " where id_fb_page=$id";
        $result = $this->_db->executeNonQuery($question2);
        
        return $result;
    }
    
    public function sothisinh($id) {
//     echo $id;
		$id = trim($id);
    	$question = "select id_thi_sinh from " . App_Entities_ImageInfo::$TABLE . " where id_fb_page=$id";
//        $result = $this->_db->executeNonQuery($question);
         $result = $this->_db->executeReader($question);
//        echo "<pre>";
//        print_r($result);
//        echo "</pre>";
//        exit;	
        $soluong = count($result);
        return $soluong;
    }
    
	public function getListthisinh($id) {
		$id = trim($id);
        $query = "select * from " . App_Entities_ImageInfo::$TABLE . " where id_fb_page=$id";

        $data = $this->_db->executeReader($query);
        if (!empty($data)) {
        	  return $data;
        }
        
        return $data;
        
        
    }

}

