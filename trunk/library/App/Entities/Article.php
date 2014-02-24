<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Article
 *
 * @author root
 */
class App_Entities_Article {

    public static $TABLE = 'ishali_bai_viet';
    public $id_bai_viet;
    public $ten_menu;
    public $tieu_de;
    public $noi_dung;
    public $thu_tu;
    public $an_hien;
    public $ngay_tao;
    public $id_fb_page;

    public function __construct() {
        $this->id_bai_viet = 0;
        $this->ten_menu = '';
        $this->tieu_de = '';
        $this->noi_dung = '';
        $this->thu_tu = 0;
        $this->an_hien = 0;
        $this->ngay_tao = 0;
        $this->id_fb_page = 0;
    }

    public static function buildData($value = array()) {
        $article = new App_Entities_Article();

        if (array_key_exists('id_bai_viet', $value)) {
            $article->id_bai_viet = $value['id_bai_viet'];
        }

        if (array_key_exists('ten_menu', $value)) {
            $article->ten_menu = $value['ten_menu'];
        }

        if (array_key_exists('tieu_de', $value)) {
            $article->tieu_de = $value['tieu_de'];
        }

        if (array_key_exists('noi_dung', $value)) {
            $article->noi_dung = $value['noi_dung'];
        }

        if (array_key_exists('thu_tu', $value)) {
            $article->thu_tu = $value['thu_tu'];
        }

        if (array_key_exists('an_hien', $value)) {
            $article->an_hien = $value['an_hien'];
        }

        if (array_key_exists('ngay_tao', $value)) {
            $article->ngay_tao = $value['ngay_tao'];
        }

        if (array_key_exists('id_fb_page', $value)) {
            $article->id_fb_page = $value['id_fb_page'];
        }

        return $article;
    }

}

?>
