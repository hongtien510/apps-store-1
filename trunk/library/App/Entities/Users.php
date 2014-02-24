<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author root
 */
class App_Entities_Users {

    public static $TABLE = 'ishali_users';
    public $id_users;
    public $id_fb;
    public $email;
    public $name;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $birthday;
    public $gender;
    public $time_created;

    public function __construct() {
        $this->id_users = 0;
        $this->id_fb = 0;
        $this->email = '';
        $this->name = '';
        $this->first_name = '';
        $this->middle_name = '';
        $this->last_name = '';
        $this->birthday = 0;
        $this->gender = 0;
        $this->time_created = 0;
    }

    public static function buildData($value = array()) {
        $item = new App_Entities_Users();

        if (array_key_exists('id_users', $value)) {
            $item->id_users = $value['id_users'];
        }

        if (array_key_exists('email', $value)) {
            $item->email = $value['email'];
        }

        if (array_key_exists('name', $value)) {
            $item->name = $value['name'];
        }

        if (array_key_exists('first_name', $value)) {
            $item->first_name = $value['first_name'];
        }

        if (array_key_exists('middle_name', $value)) {
            $item->middle_name = $value['middle_name'];
        }

        if (array_key_exists('last_name', $value)) {
            $item->last_name = $value['last_name'];
        }

        if (array_key_exists('birthday', $value)) {
            $item->birthday = $value['birthday'];
        }

        if (array_key_exists('gender', $value)) {
            $item->gender = $value['gender'];
        }

        if (array_key_exists('time_created', $value)) {
            $item->time_created = $value['time_created'];
        }

        return $item;
    }

}

