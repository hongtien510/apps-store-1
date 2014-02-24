<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bangmau
 *
 * @author root
 */
class App_Entities_Bangmau {

    public static $TABLE = 'ishali_bangmau';
    public $id;
    public $ten;
    public $ma;
    public $order;

    public function __construct() {
        $this->id = 0;
        $this->ten = '';
        $this->ma = '';
        $this->order = 0;
        
    }

    public static function buildData($value = array()) {
        $Bangmau = new App_Entities_Bangmau();

        if (array_key_exists('id', $value)) {
            $Bangmau->id = $value['id'];
        }

        if (array_key_exists('ten', $value)) {
            $Bangmau->ten = $value['ten'];
        }

        if (array_key_exists('ma', $value)) {
            $Bangmau->ma = $value['ma'];
        }

        if (array_key_exists('order', $value)) {
            $Bangmau->order = $value['order'];
        }

        return $Bangmau;
    }

}

?>
