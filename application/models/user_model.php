<?php
class user_model extends CI_Model {

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
     * Insert new user
     *
     * @access public
     * @param $userInfos (array)
     * @return BOOLEAN
     */
    public function insert_user($userInfos)
    {
        $tab=explode("_",$userInfos["locale"]);
        $locale=$tab[0];

        $data=array(
            'user_id'=> $userInfos["id"],
            'first_name' => $userInfos["first_name"] ,
            'last_name' => $userInfos["last_name"] ,
            'locale' => $locale ,
            'gender' => $userInfos["gender"] ,
            'email' => $userInfos["email"]
        );

        $query=$this->db->insert('user',$data);
        return $query;
        
    }

    /*
     * Check user exists
     *
     * @access public
     * @param $userId (bigint)
     * @return BOOLEAN
     */
    public function check_user_exists($userId)
    {

        $query=$this->db->select('user_id')
                ->where('user_id',$userId)
                ->get('user');

        if ($query->num_rows() > 0)
            return TRUE;

        return FALSE;

    }

    /*
     * check sponsor exists
     *
     * @access public
     * @param int $userId, int $sponsorId
     * @return BOOLEAN
     */
    public function check_sponsor_exists($userId,$sponsorId)
    {

        $query=$this->db->select('sponsor')
                ->where('sponsor',$sponsorId)
                ->where('user_id',$userId)
                ->get('user');

        if ($query->num_rows() > 0)
            return TRUE;

        return FALSE;

    }

    /*
     * get champion
     *
     * @access public
     * @param int $month
     * @return array
     */
    public function get_champion($month)
    {

        $this->db->select('*')
                ->from('user')
                ->where('champion_month',$month);

          $query = $this->db->get();

            $result=$query->result_array($query);

            return $result;

    }

    /*
     * update champion
     *
     * @access public
     * @param int $userId, int $month
     * @return BOOLEAN
     */
    public function update_champion($userId,$month)
    {

        $data=array(
            'champion_month'=> $month
        );

        $this->db->where('user_id',$userId);
        $query=$this->db->update('user',$data);

        return $query;

    }

    /*
     * delete champion
     *
     * @access public
     * @param int $userId
     * @return BOOLEAN
     */
    public function delete_champion($userId)
    {

        $data=array(
            'champion_month'=> 0
        );

        $this->db->where('user_id',$userId);
        $query=$this->db->update('user',$data);

        return $query;

    }

    /*
     * check champion exists
     *
     * @access public
     * @param int $month
     * @return BOOLEAN
     */
    public function check_champion_exists($month)
    {

        $query=$this->db->select('*')
                ->where('champion_month',$month)
                ->get('user');

        if ($query->num_rows() > 0)
            return TRUE;

        return FALSE;

    }

    /*
     * get user infos
     *
     * @access public
     * @param int $userId
     * @return array
     */
    public function get_user_infos($userId)
    {

        $this->db->select('*')
                ->from('user')
                ->where('user_id',$userId);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    /*
     * get all users
     *
     * @access public
     * @param none
     * @return array
     */
    public function get_all_user()
    {

        $this->db->select('*')
                ->from('user');

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    /*
     * export users csv
     *
     * @access public
     * @param none
     * @return csv file
     */
    public function export_csv(){

        $this->db->select('*')
                ->from('user');

        $query = $this->db->get();
        $this->load->helper('csv');

        echo query_to_csv($query, TRUE, 'exportDatabase.csv');
   }

    /*
     * update sponsor
     *
     * @access public
     * @param int $userId, int $sponsorId
     * @return BOOLEAN
     */
    public function update_sponsor($userId,$sponsorId)
    {

        $data=array(
            'sponsor'=> $sponsorId
        );

        $this->db->where('user_id',$userId);
        $query=$this->db->update('user',$data);

        return $query;

    }

    /*
     * update newsletter
     *
     * @access public
     * @param int $userId, array $dataForm
     * @return BOOLEAN
     */
    public function update_newsletter($userId,$dataForm)
    {

        $data=array(
            'newsletter'=> $dataForm["newsletter"]
        );

        $this->db->where('user_id',$userId);
        $query=$this->db->update('user',$data);

        return $query;

    }

    /*
     * update account
     *
     * @access public
     * @param int $userId, array $dataForm
     * @return BOOLEAN
     */
    public function update_account($userId,$dataForm)
    {

        $data=array(
            'swisstv_account'=> $dataForm["account"]
        );

        $this->db->where('user_id',$userId);
        $query=$this->db->update('user',$data);

        return $query;

    }

    /*
     * get filleul monthly
     *
     * @access public
     * @param int $sponsorId, int $firstPage, int $perpage
     * @return array
     */
    public function get_filleul_monthly($sponsorId,$firstPage,$perPage)
    {

        $this->db->select('SUM(point)as pt,first_name,last_name,user.user_id')
                ->from('user')
                ->join("point","user.user_id=point.user_id")
                ->where('sponsor',$sponsorId)
                ->where('date_point >=',date("Y-m-01"))
                ->where('date_point <=',date::day_before(date::month_after(date("Y-m-01"))))
                ->group_by("user.user_id")
                ->order_by("pt","DESC")
                ->order_by("user.user_id","DESC")
                ->limit($perPage,$firstPage);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    /*
     * count filleul monthly
     *
     * @access public
     * @param  int $sponsorId
     * @return int
     */
    public function count_filleul_monthly($sponsorId)
    {

        $this->db->select('SUM(point)as pt,first_name,last_name,user.user_id')
                ->from('user')
                ->join("point","user.user_id=point.user_id")
                ->where('sponsor',$sponsorId)
                ->where('date_point >=',date("Y-m-01"))
                ->where('date_point <=',date::day_before(date::month_after(date("Y-m-01"))))
                ->group_by("user_id")
                ->order_by("pt","DESC")
                ->order_by("user.user_id","DESC");

        $query = $this->db->get();

        return $query->num_rows();

    }

    /*
     * count filleul
     *
     * @access public
     * @param  int $sponsorId
     * @return int
     */
    public function count_filleul($sponsorId)
    {

        $this->db->select('*')
                ->from('user')
                ->join("point","user.user_id=point.user_id")
                ->where('sponsor',$sponsorId);

        $query = $this->db->get();

        return $query->num_rows();

    }

    /*
     * count parrainnage points
     *
     * @access public
     * @param  int $sponsorId
     * @return array
     */
    public function count_parrainage_pts($sponsorId)
    {

        $this->db->select('SUM(point)as pt')
                ->from('point')
                ->where('user_id',$sponsorId)
                ->where('date_point >=',date("Y-m-01"))
                ->where('date_point <=',date::day_before(date::month_after(date("Y-m-01"))))
                ->where('parrainage',1);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    /*
     * count parainnage
     *
     * @access public
     * @param  int $sponsorId
     * @return int
     */
    public function count_parrainage($sponsorId)
    {

        $this->db->select('*')
                ->from('point')
                ->where('user_id',$sponsorId)
                ->where('date_point >=',date("Y-m-01"))
                ->where('date_point <=',date::day_before(date::month_after(date("Y-m-01"))))
                ->where('parrainage',1);

        $query = $this->db->get();

        return $query->num_rows();

    }

    /*
     * count user
     *
     * @access public
     * @param  none
     * @return int
     */
    public function count_user()
    {

        $this->db->select('*')
                ->from('user');

        $query = $this->db->get();

        return $query->num_rows();

    }

    /*
     * get players by day
     *
     * @access public
     * @param  int $sponsorId, int $perPage , date $date
     * @return array
     */
    public function get_players_day($firstPage,$perPage,$date=NULL)
    {

        $this->db->select('SUM(point)as pt,first_name,last_name,user.user_id')
                ->from('user')
                ->join("point","user.user_id=point.user_id");

        if($date===NULL){
                $this->db->where('date_point',date("Y-m-d"))
                ->where('parrainage',0);
        }else{
                $this->db->where('date_point',$date)
                ->where('parrainage',0);
        }

                $this->db->group_by("user.user_id")
                ->order_by("pt","DESC")
                ->order_by("user.user_id","DESC")
                ->limit($perPage,$firstPage);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    /*public function count_players_day($sponsorId,$date=NULL)
    {

        $this->db->select('SUM(point)as pt,first_name,last_name,user.user_id')
                ->from('user')
                ->join("point","user.user_id=point.user_id");

        if($date===NULL){
                $this->db->where('date_point',date("Y-m-d"));
        }else{
                $this->db->where('date_point',$date);
        }
        
                $this->db->group_by("user.user_id")
                ->order_by("pt","DESC")
                ->order_by("user.user_id","DESC");

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }*/

    /*
     * count player by day
     *
     * @access public
     * @param  int $sponsorId, date $date
     * @return array
     */
    public function count_players_day($sponsorId,$date=NULL)
    {

        $this->db->select('SUM(point)as pt,first_name,last_name,user.user_id')
                ->from('user')
                ->join("point","user.user_id=point.user_id");

        if($date==NULL){
                $this->db->where('date_point',date("Y-m-d"))
                ->where('parrainage',0);
        }else{
                $this->db->where('date_point',$date)
                ->where('parrainage',0);
        }

                $this->db->group_by("user.user_id")
                ->order_by("pt","DESC")
                ->order_by("user.user_id","DESC");

        $query = $this->db->get();

        $result=$query->num_rows();

        return $result;

    }

    /*
     * update month position
     *
     * @access public
     * @param  int $sponsorId, int $userId
     * @return boolean
     */
    public function update_month_position($position,$userId)
    {

        $data=array(
            'position_m'=> $position
        );

        $this->db->where('user_id',$userId);
        $query=$this->db->update('user',$data);

        return $query;

    }

    /*
     * update last position
     *
     * @access public
     * @param  int $position,int $userId
     * @return boolean
     */
    public function update_month_last_position($position,$userId)
    {

        $data=array(
            'last_position_m'=> $position
        );

        $this->db->where('user_id',$userId);
        $query=$this->db->update('user',$data);

        return $query;

    }

    /*
     * update week position
     *
     * @access public
     * @param  int $position, int $userId
     * @return boolean
     */
    public function update_week_position($position,$userId)
    {

        $data=array(
            'position_w'=> $position
        );

        $this->db->where('user_id',$userId);
        $query=$this->db->update('user',$data);

        return $query;

    }

    /*
     * update week last position
     *
     * @access public
     * @param  int $position, int $userId
     * @return boolean
     */
    public function update_week_last_position($position,$userId)
    {

        $data=array(
            'last_position_w'=> $position
        );

        $this->db->where('user_id',$userId);
        $query=$this->db->update('user',$data);

        return $query;

    }

    /*
     * get month position
     *
     * @access public
     * @param  int $userId
     * @return array
     */
    public function get_month_position($userId)
    {

        $this->db->select('*')
                ->from('user')
                ->where('user_id',$userId);

        $query = $this->db->get();
        $result=$query->result_array($query);

        return $result;

    }

    /*
     * get parrainage points
     *
     * @access public
     * @param  none
     * @return array
     */
    public function get_pts_parrainage()
    {

        $this->db->select('*')
                ->from('parrainage');

        $query = $this->db->get();
        $result=$query->result_array($query);

        return $result;

    }

    /*
     * update parrainage
     *
     * @access public
     * @param  int $pts
     * @return boolean
     */
    public function update_parrainage($pts)
    {

        $data=array(
            'pts'=> $pts
        );

        $query=$this->db->update('parrainage',$data);

        return $query;

    }
}

?>
