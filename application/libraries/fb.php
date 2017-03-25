<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class fb {



    public static function get_fb_pic($fbId,$accessToken,$facebook){


            //FQL FACEBOOK QUERY
            $fql = "SELECT pic_square FROM user WHERE uid=".$fbId." ";

            $params  =   array(
            'method'    => 'fql.query',
            'access_token' => $accessToken,
            'query'     => $fql,
            'callback'  => ''
            );

            $filleulPic = $this->facebook->api($params);
            return $filleulPic;
    }

}