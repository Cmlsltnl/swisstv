<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class date {

    public static function explode_date($date){

        return explode("-",$date);
    }

    public static function day_after($date){

        $tab=explode("-",$date);
        $timestamp=mktime(0,0,0,date($tab[1]), date($tab[2])+1, date($tab[0]));

        return date('Y-m-d',$timestamp);
    }

    public static function day_before($date){

        $tab=explode("-",$date);
        $timestamp=mktime(0,0,0,date($tab[1]), date($tab[2])-1, date($tab[0]));

        return date('Y-m-d',$timestamp);
    }

    public static function month_after($date){

        $tab=explode("-",$date);
        $timestamp=mktime(0,0,0,date($tab[1])+1, date($tab[2]), date($tab[0]));

        return date('Y-m-d',$timestamp);
    }

    public static function month_before($date){

        $tab=explode("-",$date);
        $timestamp=mktime(0,0,0,date($tab[1])-1, date($tab[2]), date($tab[0]));

        return date('Y-m-d',$timestamp);
    }

    public static function get_week($date){

          list($year, $month, $day) = explode('-', $date);
          $weekNum = (date('W', mktime(0, 0, 0, $month, $day, $year)) * 1);
          return $weekNum;
    }

    public static function month($date,$locale){

        $tab=explode("-",$date);

        if($locale=="fr"){

            switch($tab[1]){

                case "01":
                    return "Janvier";
                break;
                case "02":
                   return "Février";
                break;
                case "03":
                    return "Mars";
                break;
                case "04":
                    return "Avril";
                break;
                case "05":
                    return "Mai";
                break;
                case "06":
                    return "Juin";
                break;
                case "07":
                    return "Juillet";
                break;
                case "08":
                    return "Aout";
                break;
                case "09":
                    return "Septembre";
                break;
                case "10":
                    return "Octobre";
                break;
                case "11":
                    return "Novembre";
                break;
                case "12":
                    return "Décembre";
                break;

            }

        }else{
switch($tab[1]){

                case "01":
                    return "Januar";
                break;
                case "02":
                   return "Februar";
                break;
                case "03":
                    return "März";
                break;
                case "04":
                    return "April";
                break;
                case "05":
                    return "Mai";
                break;
                case "06":
                    return "Juni";
                break;
                case "07":
                    return "Juli";
                break;
                case "08":
                    return "August";
                break;
                case "09":
                    return "September";
                break;
                case "10":
                    return "Oktober";
                break;
                case "11":
                    return "November";
                break;
                case "12":
                    return "December";
                break;

            }

    }
}
}