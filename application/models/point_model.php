<?php
class point_model extends CI_Model {

/*
|==========================================================
| Constructor
|==========================================================
|
*/
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    /*
     * insert points
     *
     * @access public
     * @param  array $dataForm
     * @return booelan
     */
    public function insert_point($dataForm)
    {

        $data=array(
            'user_id' => $dataForm["user_id"] ,
            'quiz_id' => $dataForm["quiz_id"] ,
            'point' => $dataForm["point"] ,
            'date_point' => $dataForm["date_answer"],
            'week_point' => date::get_week($dataForm["date_answer"]),
            'year_point' => date("Y")
        );

        $query=$this->db->insert('point',$data);
        return $query;
        
    }

    /*
     * insert parrainage points
     *
     * @access public
     * @param  int $parrain,int $pts
     * @return boolean
     */
    public function insert_parrainage_point($parrain,$pts)
    {

        $data=array(
            'user_id' => $parrain ,
            'point' => $pts[0]["pts"] ,
            'date_point' => date("Y-m-d"),
            'week_point' => date::get_week(date("Y-m-d")),
            'year_point' => date("Y"),
            'parrainage' => 1,
        );

        $query=$this->db->insert('point',$data);
        return $query;

    }

    /*
     * insert zero point
     *
     * @access public
     * @param  int $userId, int $quizInfos
     * @return boolean
     */
    public function insert_zero_point($userId,$quizInfos)
    {
        
        $data=array(
            'user_id' => $userId,
            'quiz_id' => $quizInfos[0]["quiz_id"] ,
            'point' => 0 ,
            'date_point' => $quizInfos[0]["date_quiz"],
            'week_point' => date::get_week($quizInfos[0]["date_quiz"]),
            'year_point' => date("Y")
        );

        $query=$this->db->insert('point',$data);
        return $query;

    }

    /*
     * delete points
     *
     * @access public
     * @param  array $dataForm
     * @return boolean
     */
    public function delete_point($dataForm)
    {

        $this->db->where('quiz_id',$dataForm["quiz_id"]);
        $this->db->where('user_id',$dataForm["user_id"]);
        $query=$this->db->delete('point');
        return $query;

    }

    /*
     * get point by quiz
     *
     * @access public
     * @param  int $quizId
     * @return array
     */
    public function get_point_by_quiz($quizId)
    {

        $this->db->select('*')
                ->from('point')
                ->where('quiz_id', $quizId);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }


    public function get_point_parrainage_month($userId,$month,$year)
    {

        $this->db->select('sum(point) as point')
                ->from('point')
                ->where('user_id', $userId)
                ->where('date_point >=',date("".$year."-".$month."-01"))
                ->where('date_point <=',date::day_before(date::month_after(date("".$year."-".$month."-01"))))
                ->where('parrainage',1);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function get_point_parrainage_week($userId,$year,$week)
    {

        $this->db->select('sum(point) as point')
                ->from('point')
                ->where('user_id', $userId)
                ->where('year_point',$year)
                ->where('week_point',$week)
                ->where('parrainage',1);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function get_point_by_day($userId,$date){

        $this->db->select('sum(point) as point')
                ->from('point')
                ->where('user_id',$userId)
                ->where('date_point',$date)
                ->where('parrainage',0);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function get_point_by_month($month,$year){

        $this->db->select('user.user_id,first_name,last_name,email,date_point,sum(point) as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('date_point >=',date("".$year."-".$month."-01"))
                ->where('date_point <=',date::day_before(date::month_after(date("".$year."-".$month."-01"))))
                ->group_by('user.user_id')
                ->order_by('pt','DESC')
                ->order_by('user.user_id','DESC')
                ->limit(10,0);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function get_point_by_week($week,$year){

        $this->db->select('user.user_id,first_name,last_name,sum(point) as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('year_point',$year)
                ->where('week_point',$week)
                ->where('parrainage',0)
                ->group_by('user.user_id')
                ->order_by('pt','DESC')
                ->order_by('user.user_id','DESC')
                ->limit(10,0);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function get_friends_point_by_month($sponsorId,$month,$year){

        $this->db->select('user.user_id,first_name,last_name,sum(point) as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('sponsor',$sponsorId)
                ->where('date_point >=',date("".$year."-".$month."-01"))
                ->where('date_point <=',date::day_before(date::month_after(date("".$year."-".$month."-01"))))
                ->group_by('user.user_id')
                ->order_by('pt','DESC')
                ->order_by('user.user_id','DESC')
                ->limit(10,0);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function get_friends_point_by_week($sponsorId,$week,$year){

        $this->db->select('user.user_id,first_name,last_name,sum(point) as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('sponsor',$sponsorId)
                ->where('year_point',$year)
                ->where('week_point',$week)
                ->where('parrainage',0)
                ->group_by('user.user_id')
                ->order_by('pt','DESC')
                ->order_by('user.user_id','DESC')
                ->limit(10,0);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function get_fb_friends_point_by_month($friendsArr,$month,$year){

        $this->db->select('user.user_id,first_name,last_name,sum(point) as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('date_point >=',date("".$year."-".$month."-01"))
                ->where('date_point <=',date::day_before(date::month_after(date("".$year."-".$month."-01"))))
                ->where_in('user.user_id',$friendsArr)
                ->group_by('user.user_id')
                ->order_by('pt','DESC')
                ->order_by('user.user_id','DESC')
                ->limit(10,0);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function get_fb_friends_point_by_week($friendsArr,$week,$year){

        $this->db->select('user.user_id,first_name,last_name,sum(point) as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('year_point',$year)
                ->where('week_point',$week)
                ->where_in('user.user_id',$friendsArr)
                ->where('parrainage',0)
                ->group_by('user.user_id')
                ->order_by('pt','DESC')
                ->order_by('user.user_id','DESC')
                ->limit(10,0);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function get_my_point_by_month($sponsorId,$month,$year){

        $this->db->select('user.user_id,first_name,last_name,sum(point) as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('point.user_id',$sponsorId)
                ->where('date_point >=',date("".$year."-".$month."-01"))
                ->where('date_point <=',date::day_before(date::month_after(date("".$year."-".$month."-01"))))
                ->group_by('user.user_id')
                ->order_by('pt','DESC')
                ->order_by('user.user_id','DESC')
                ->limit(10,0);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function get_my_point_by_week($sponsorId,$week,$year){

        $this->db->select('user.user_id,first_name,last_name,sum(point) as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('point.user_id',$sponsorId)
                ->where('year_point',$year)
                ->where('week_point',$week)
                ->where('parrainage',0)
                ->group_by('user.user_id')
                ->order_by('pt','DESC')
                ->order_by('user.user_id','DESC')
                ->limit(10,0);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function count_player_position_monthly($pts){

        $this->db->select('user.user_id,sum(point) as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('date_point >=',date("Y-m-01"))
                ->where('date_point <=',date::day_before(date::month_after(date("Y-m-01"))))
                ->group_by('user.user_id')
                ->having('pt >='.$pts)
                ->order_by('pt','DESC')
                ->order_by('user.user_id','DESC');

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;
    }


    public function get_players_same_position_monthly($pts){

        $this->db->select('user.user_id,sum(point)as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('date_point >=',date("Y-m-01"))
                ->where('date_point <=',date::day_before(date::month_after(date("Y-m-01"))))
                ->group_by('user.user_id')
                ->having('pt ='.$pts)
                ->order_by('user.user_id','DESC');

        $query = $this->db->get();
        $result=$query->result_array($query);

        return $result;
    }


    public function count_player_position_next_month($month,$year,$pts){

        $this->db->select('user.user_id,sum(point) as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('date_point >=',date("".$year."-".$month."-01"))
                ->where('date_point <=',date::day_before(date::month_after(date("".$year."-".$month."-01"))))
                ->group_by('user.user_id')
                ->having('pt >='.$pts)
                ->order_by('pt','DESC')
                ->order_by('user.user_id','DESC');

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;
    }


    public function get_players_same_position_next_month($month,$year,$pts){

        $this->db->select('user.user_id,sum(point)as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('date_point >=',date("".$year."-".$month."-01"))
                ->where('date_point <=',date::day_before(date::month_after(date("".$year."-".$month."-01"))))
                ->group_by('user.user_id')
                ->having('pt ='.$pts)
                ->order_by('user.user_id','DESC');

        $query = $this->db->get();
        $result=$query->result_array($query);

        return $result;
    }

    public function count_player_position_daily($pts,$date){

        $this->db->select('user.user_id,sum(point) as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('date_point',$date)
                ->where('parrainage',0)
                ->group_by('user.user_id')
                ->having('pt >='.$pts)
                ->order_by('pt','DESC')
                ->order_by('user.user_id','DESC');

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;
    }


    public function get_players_same_position_daily($pts,$date){

        $this->db->select('user.user_id,sum(point)as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('date_point',$date)
                ->where('parrainage',0)
                ->group_by('user.user_id')
                ->having('pt ='.$pts)
                ->order_by('user.user_id','DESC');

        $query = $this->db->get();
        $result=$query->result_array($query);

        return $result;
    }

    public function count_player_position_next_week($week,$year,$pts){

        $this->db->select('user.user_id,sum(point) as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('week_point',$week)
                ->where('year_point',$year)
                ->where('parrainage',0)
                ->group_by('user.user_id')
                ->having('pt >='.$pts)
                ->order_by('pt','DESC')
                ->order_by('user.user_id','DESC');

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;
    }


    public function get_players_same_position_next_week($week,$year,$pts){

        $this->db->select('user.user_id,sum(point)as pt')
                ->from('point')
                ->join('user','user.user_id=point.user_id ')
                ->where('week_point',$week)
                ->where('year_point',$year)
                ->where('parrainage',0)
                ->group_by('user.user_id')
                ->having('pt ='.$pts)
                ->order_by('user.user_id','DESC');

        $query = $this->db->get();
        $result=$query->result_array($query);

        return $result;
    }

    public function check_point_quiz($userId,$quizId)
    {
        $this->db->select('*')
                ->from('point')
                ->where('user_id', $userId)
                ->where('quiz_id', $quizId);

        $query = $this->db->get();

        if ($query->num_rows() > 0)
            return TRUE;

        return FALSE;
    }



}


?>
