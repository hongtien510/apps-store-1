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
class App_Entities_Pages {

    public static $TABLE = 'ishali_pages';
    public $id_pages;
    public $id_fb_page;
    public $page_name;
    public $id_fb;
    public $banner;
    public $banner_link;
    public $templates;
    public $date_create;
    public $show_gioi_tinh;
    public $show_ma;
    public $show_ten;
    public $show_luot_xem;
    public $show_so_binh_chon;
    public $show_gioi_thieu;
    public $so_lan_binh_chon;
    public $like_binh_chon;
    public $like_tham_gia;
    public $like_comment;
    public $an_hien;
    public $cam_on_binh_chon;
    public $cam_on_tham_gia;
    public $footer;
    public $font_size;
    public $background_color;
    public $background_images;
    public $color;

    public function __construct() {
        $this->id_pages = 0;
        $this->an_hien = 0;
        $this->background_color = '';
        $this->background_images = '';
        $this->banner = '';
        $this->banner_link = '';
        $this->cam_on_binh_chon = '';
        $this->cam_on_tham_gia = '';
        $this->color = '';
        $this->date_create = 0;
        $this->font_size = '';
        $this->footer = '';
        $this->id_fb = 0;
        $this->id_fb_page = 0;
        $this->like_binh_chon = 0;
        $this->like_comment = 0;
        $this->like_tham_gia = 0;
        $this->page_name = '';
        $this->show_gioi_thieu = 0;
        $this->show_gioi_tinh = 0;
        $this->show_luot_xem = 0;
        $this->show_ma = 0;
        $this->show_so_binh_chon = 0;
        $this->show_ten = 0;
        $this->so_lan_binh_chon = 0;
        $this->templates = '';
    }

    public static function buildData($value = array()) {
        $item = new App_Entities_Pages();

        if (array_key_exists('id_pages', $value)) {
            $item->id_pages = $value['id_pages'];
        }

        if (array_key_exists('an_hien', $value)) {
            $item->an_hien = $value['an_hien'];
        }

        if (array_key_exists('background_color', $value)) {
            $item->background_color = $value['background_color'];
        }

        if (array_key_exists('background_images', $value)) {
            $item->background_images = $value['background_images'];
        }

        if (array_key_exists('banner', $value)) {
            $item->banner = $value['banner'];
        }

        if (array_key_exists('banner_link', $value)) {
            $item->banner_link = $value['banner_link'];
        }

        if (array_key_exists('cam_on_binh_chon', $value)) {
            $item->cam_on_binh_chon = $value['cam_on_binh_chon'];
        }

        if (array_key_exists('cam_on_tham_gia', $value)) {
            $item->cam_on_tham_gia = $value['cam_on_tham_gia'];
        }

        if (array_key_exists('color', $value)) {
            $item->color = $value['color'];
        }

        if (array_key_exists('date_create', $value)) {
            $item->date_create = $value['date_create'];
        }

        if (array_key_exists('font_size', $value)) {
            $item->font_size = $value['font_size'];
        }

        if (array_key_exists('footer', $value)) {
            $item->footer = $value['footer'];
        }

        if (array_key_exists('id_fb', $value)) {
            $item->id_fb = $value['id_fb'];
        }

        if (array_key_exists('id_fb_page', $value)) {
            $item->id_fb_page = $value['id_fb_page'];
        }

        if (array_key_exists('like_binh_chon', $value)) {
            $item->like_binh_chon = $value['like_binh_chon'];
        }

        if (array_key_exists('like_comment', $value)) {
            $item->like_comment = $value['like_comment'];
        }

        if (array_key_exists('like_tham_gia', $value)) {
            $item->like_tham_gia = $value['like_tham_gia'];
        }

        if (array_key_exists('page_name', $value)) {
            $item->page_name = $value['page_name'];
        }

        if (array_key_exists('show_gioi_thieu', $value)) {
            $item->show_gioi_thieu = $value['show_gioi_thieu'];
        }

        if (array_key_exists('show_gioi_tinh', $value)) {
            $item->show_gioi_tinh = $value['show_gioi_tinh'];
        }

        if (array_key_exists('show_luot_xem', $value)) {
            $item->show_luot_xem = $value['show_luot_xem'];
        }

        if (array_key_exists('show_ma', $value)) {
            $item->show_ma = $value['show_ma'];
        }

        if (array_key_exists('show_so_binh_chon', $value)) {
            $item->show_so_binh_chon = $value['show_so_binh_chon'];
        }

        if (array_key_exists('show_ten', $value)) {
            $item->show_ten = $value['show_ten'];
        }

        if (array_key_exists('so_lan_binh_chon', $value)) {
            $item->so_lan_binh_chon = $value['so_lan_binh_chon'];
        }

        if (array_key_exists('templates', $value)) {
            $item->templates = $value['templates'];
        }

        return $item;
    }

}

?>
