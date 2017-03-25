<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class check {

/*
|==========================================================
| Check user's session
| @param $connected :connect session var
|==========================================================
|
*/
    public static function check_connexion($connected){

        if(!$connected)
            redirect('start/app_access');
    }

    public static function check_admin_connexion($connected){

        if(!$connected)
            redirect('admin/');
    }
}