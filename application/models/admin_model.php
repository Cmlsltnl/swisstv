<?php
class admin_model extends CI_Model {

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
     * insert admin
     *
     * @access public
     * @param  array $adminInfos
     * @return boolean
     */
    public function insert_admin($adminInfos)
    {
        $password=md5($adminInfos["password"]);
        $data=array(
            'email' => $adminInfos["email"] ,
            'password' => $password
        );

        $query=$this->db->insert('admin',$data);
        return $query;
        
    }

        /*
     * get admin
     *
     * @access public
     * @param  none
     * @return array
     */
    public function get_admin()
    {

        $this->db->select('*')
                ->from('admin');

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    /*
     * get admin by id     *
     * @access public
     * @param  string email,string password
     * @return array
     */
    public function get_admin_by_id($email,$password)
    {

        $password=md5($password);
        $this->db->select('*')
                ->from('admin')
                ->where('email',$email)
                ->where('password',$password);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    /*
     * get annonces list
     *
     * @access public
     * @param  none
     * @return array
     */
    public function get_annonces()
    {

        $this->db->select('*')
                ->from('annonce')
                ->order_by("date_annonce","ASC");

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    /*
     * insert annonce
     *
     * @access public
     * @param  array $annonce
     * @return boolean
     */
    public function insert_annonce($annonce)
    {

        $data=array(
            'title' => $annonce["title"] ,
            'annonce_fr' => $annonce["annonce_fr"],
            'annonce_de' => $annonce["annonce_de"],
            'date_annonce'=>date('Y-m-d')
        );

        $query=$this->db->insert('annonce',$data);
        return $query;

    }

    /*
     * delete annonce
     *
     * @access public
     * @param  array $dataForm
     * @return boolean
     */
    public function delete_annonce($dataForm)
    {

        $this->db->where('annonce_id',$dataForm["annonce_id"]);
        $query=$this->db->delete('annonce');
        return $query;

    }

}

?>
