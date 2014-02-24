<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @author root
 */
class App_Controller_AdminController extends Zend_Controller_Action {

    public function init() {
        $layoutPath = APPLICATION_PATH . '/templates/giaodien_admin';
        $option = array('layout' => 'index', 'layoutPath' => $layoutPath);
        Zend_Layout::startMvc($option);
    }

}
