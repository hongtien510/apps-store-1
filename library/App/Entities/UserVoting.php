<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pages
 *
 * @author root
 */
class App_Entities_UserVoting {

    public static $TABLE = 'ishali_users_binh_chon';
    public $id_users_binh_chon;
    public $id_fb;
    public $id_thi_sinh;
    public $ngay_binh_chon;

    public function __construct() {
        $this->id_users_binh_chon = 0;
        $this->id_fb = 0;
        $this->id_thi_sinh = 0;
        $this->ngay_binh_chon = 0;
    }

    public static function buildData($value = array()) {
        $item = new App_Entities_UserVoting();

        if (array_key_exists('id_users_binh_chon', $value)) {
            $item->id_users_binh_chon = $value['id_users_binh_chon'];
        }

        if (array_key_exists('id_fb', $value)) {
            $item->id_fb = $value['id_fb'];
        }

        if (array_key_exists('id_thi_sinh', $value)) {
            $item->id_thi_sinh = $value['id_thi_sinh'];
        }

        if (array_key_exists('ngay_binh_chon', $value)) {
            $item->ngay_binh_chon = $value['ngay_binh_chon'];
        }

        return $item;
    }

}

?>
