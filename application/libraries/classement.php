<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class classement {


        public static function get_player_position_monthly($pts,$userId){

            $pointObject=new point_model();
            $lastPosition=$pointObject->count_player_position_monthly($pts);
            $lastPosition=count($lastPosition);

            //return $lastPosition;
            $samePosition=$pointObject->get_players_same_position_monthly($pts);
            $nbSamePos=count($samePosition)-1;

            foreach($samePosition as $row){

               if($row["user_id"]==$userId){

                  $position=$lastPosition-$nbSamePos;

               }
               $nbSamePos--;
            }

            return $position;

        }

        public static function get_player_position_next_month($month,$year,$pts,$userId){


            $pointObject=new point_model();
            $lastPosition=$pointObject->count_player_position_next_month($month,$year,$pts);
            $lastPosition=count($lastPosition);

            $samePosition=$pointObject->get_players_same_position_next_month($month,$year,$pts);
            $nbSamePos=count($samePosition)-1;

            foreach($samePosition as $row){

               if($row["user_id"]==$userId){

                  $position=$lastPosition-$nbSamePos;

               }
               $nbSamePos--;
            }

            return $position;

        }

        public static function get_player_position_next_week($week,$year,$pts,$userId){


            $pointObject=new point_model();
            $lastPosition=$pointObject->count_player_position_next_week($week,$year,$pts);
            $lastPosition=count($lastPosition);

            $samePosition=$pointObject->get_players_same_position_next_week($week,$year,$pts);
            $nbSamePos=count($samePosition)-1;

            foreach($samePosition as $row){

               if($row["user_id"]==$userId){

                  $position=$lastPosition-$nbSamePos;

               }
               $nbSamePos--;
            }

            return $position;

        }

        public static function get_player_position_daily($pts,$userId,$date){


            $pointObject=new point_model();
            $lastPosition=$pointObject->count_player_position_daily($pts,$date);
            $lastPosition=count($lastPosition);

            //return $lastPosition;
            $samePosition=$pointObject->get_players_same_position_daily($pts,$date);
            $nbSamePos=count($samePosition)-1;


            foreach($samePosition as $row){

               if($row["user_id"]==$userId){

                  $position=$lastPosition-$nbSamePos;

               }
               $nbSamePos--;
            }

            return $position;

        }

        public static function get_pt($userId,$date){


            $pointObject=new point_model();
            $point=$pointObject->get_point_by_day($userId,$date);

            return $point;

        }

        public static function get_parrainage_month($userId,$month,$year){


            $pointObject=new point_model();
            $point=$pointObject->get_point_parrainage_month($userId,$month,$year);

            return $point;

        }

        public static function get_parrainage_week($userId,$year,$week){


            $pointObject=new point_model();
            $point=$pointObject->get_point_parrainage_week($userId,$year,$week);

            return $point;

        }

        public static function progression_month($position,$userId){


            $userObject=new user_model();
            $UserInfos=$userObject->get_month_position($userId);

            if(!empty($UserInfos[0]["position_m"])){

                $lastPosition=$UserInfos[0]["position_m"];
                $userObject->update_month_last_position($lastPosition,$userId);
                $userObject->update_month_position($position,$userId);

                if($position>$lastPosition){

                    $result=$position-$lastPosition;
                    $progression="<div id='arrow_top'></div><div>+".$result."</div>";
                }

                if($position<$lastPosition){

                    $result=$position-$lastPosition;
                    $progression="<div id='arrow_down'></div><div>-".$result."</div>";
                }

                if($position==$lastPosition){

                    $progression="<div id='arrow_equal'></div><div></div>";
                }

            }else{

                $userObject->update_month_position($position,$userId);
                $progression="<div id='arrow_equal'></div><div></div>";

            }

            return $progression;

        }

        public static function progression_week($position,$userId){


            $userObject=new user_model();
            $UserInfos=$userObject->get_month_position($userId);

            if(!empty($UserInfos[0]["position_w"])){

                $lastPosition=$UserInfos[0]["position_w"];
                $userObject->update_week_last_position($lastPosition,$userId);
                $userObject->update_week_position($position,$userId);

                if($position>$lastPosition){

                    $result=$position-$lastPosition;
                    $progression="<div id='arrow_top'></div><div>+".$result."</div>";
                }

                if($position<$lastPosition){

                    $result=$position-$lastPosition;
                    $progression="<div id='arrow_down'></div><div>-".$result."</div>";
                }

                if($position==$lastPosition){

                    $progression="<div id='arrow_equal'></div><div></div>";
                }

            }else{

                $userObject->update_week_position($position,$userId);
                $progression="<div id='arrow_equal'></div><div></div>";

            }

            return $progression;

        }
}
