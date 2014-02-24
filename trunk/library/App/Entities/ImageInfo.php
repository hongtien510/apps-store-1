<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageInfo
 *
 * @author root
 */
class App_Entities_ImageInfo {

    public static $TABLE = 'ishali_thi_sinh';
    public $id_thi_sinh;
    public $id_fb_thi_sinh;
    public $ten_thi_sinh;
    public $ngay_sinh;
    public $gioi_tinh;
    public $cmnd;
    public $gioi_thieu;
    public $hinh_du_thi;
    public $mo_ta_bai_thi;
    public $ngay_tham_gia;
    public $an_hien;
    public $luot_xem;
    public $luot_binh_chon;
    public $id_fb_page;
    public $email;
    public $so_dien_thoai;
    public function __construct() {
        $this->an_hien = 0;
        $this->cmnd = '';
        $this->gioi_thieu = '';
        $this->gioi_tinh = 0;
        $this->hinh_du_thi = '';
        $this->id_fb_page = 0;
        $this->id_fb_thi_sinh = 0;
        $this->id_thi_sinh = 0;
        $this->luot_xem = 0;
        $this->luot_binh_chon = 0;
        $this->mo_ta_bai_thi = '';
        $this->ngay_sinh = 0;
        $this->ngay_tham_gia = 0;
        $this->ten_thi_sinh = '';
        $this->email = '';
        $this->so_dien_thoai = '';
    }

    public static function buildData($value = array()) {
        $item = new App_Entities_ImageInfo();

        if (array_key_exists('id_thi_sinh', $value)) {
            $item->id_thi_sinh = $value['id_thi_sinh'];
        }

        if (array_key_exists('an_hien', $value)) {
            $item->an_hien = $value['an_hien'];
        }

        if (array_key_exists('cmnd', $value)) {
            $item->cmnd = $value['cmnd'];
        }

        if (array_key_exists('gioi_thieu', $value)) {
            $item->gioi_thieu = $value['gioi_thieu'];
        }

        if (array_key_exists('gioi_tinh', $value)) {
            $item->gioi_tinh = $value['gioi_tinh'];
        }

        if (array_key_exists('hinh_du_thi', $value)) {
            $item->hinh_du_thi = $value['hinh_du_thi'];
        }

        if (array_key_exists('id_fb_page', $value)) {
            $item->id_fb_page = $value['id_fb_page'];
        }

        if (array_key_exists('id_fb_thi_sinh', $value)) {
            $item->id_fb_thi_sinh = $value['id_fb_thi_sinh'];
        }

        if (array_key_exists('luot_xem', $value)) {
            $item->luot_xem = $value['luot_xem'];
        }
        
        if (array_key_exists('luot_binh_chon', $value)) {
            $item->luot_binh_chon = $value['luot_binh_chon'];
        }

        if (array_key_exists('mo_ta_bai_thi', $value)) {
            $item->mo_ta_bai_thi = $value['mo_ta_bai_thi'];
        }

        if (array_key_exists('ngay_sinh', $value)) {
            $item->ngay_sinh = $value['ngay_sinh'];
        }

        if (array_key_exists('ngay_tham_gia', $value)) {
            $item->ngay_tham_gia = $value['ngay_tham_gia'];
        }

        if (array_key_exists('ten_thi_sinh', $value)) {
            $item->ten_thi_sinh = $value['ten_thi_sinh'];
        }
        
   		 if (array_key_exists('email', $value)) {
            $item->email = $value['email'];
        }

        if (array_key_exists('so_dien_thoai', $value)) {
            $item->so_dien_thoai = $value['so_dien_thoai'];
        }

        return $item;
    }

}

