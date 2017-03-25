<?php
class quiz_model extends CI_Model {

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
     * Insert new quiz
     *
     * @access public
     * @param $data (array)
     * @return quiz_id (int)
     */
    public function insert_quiz($data)
    {


        $data=array(
            'name'=> $data["name"],
            'question_fr' => $data["question_fr"],
            'question_de' => $data["question_de"],
            'answer_fr' => $data["answer_fr"],
            'answer_de' => $data["answer_de"] ,
            'indice_1_fr'=> $data["indice_1_fr"],
            'indice_2_fr' => $data["indice_2_fr"],
            'indice_3_fr' => $data["indice_3_fr"],
            'indice_1_de' => $data["indice_1_de"],
            'indice_2_de' => $data["indice_2_de"] ,
            'indice_3_de'=> $data["indice_3_de"],
            'type' => $data["media_type"] ,
            /*'media_question' => $data["media_question"] ,
            'image_answer' => $data["media_answer"] ,
            'cover_answer' => $data["cover_answer"] ,*/
            'date_quiz' => $data["date_quiz"] ,
            'date_result' => $data["date_result"]
        );

        $query=$this->db->insert('quiz',$data);
       
        return $this->db->insert_id();
        
    }

    /*
     * update quiz media
     *
     * @access public
     * @param $data (array),quiz_id (int)
     * @return Boolean
     */
    public function update_quiz_media($quizId,$data)
    {

        $data=array(
            'media_question'=> $data["media_question"]["file_name"],
            'image_answer' => $data["media_answer"]["file_name"],
            'cover_answer' => $data["cover_answer"]["file_name"],
        );

        $this->db->where('quiz_id',$quizId);
        $query=$this->db->update('quiz',$data);

        return $query;

    }

    /*
     * get quiz open
     *
     * @access public
     * @param  none
     * @return array
     */
    public function get_quiz_open()
    {

        $this->db->select('*')
                ->from('quiz')
                ->where('statut', 1);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    /*
     * get quiz by id
     *
     * @access public
     * @param  int $quizId
     * @return boolean
     */
    public function get_quiz_by_id($quizId)
    {

        $this->db->select('*')
                ->from('quiz')
                ->where('quiz_id', $quizId);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    /*
     * get quiz by date
     *
     * @access public
     * @param  date $dateQuiz
     * @return array
     */
    public function get_quiz_by_date($dateQuiz)
    {

        $this->db->select('*')
                ->from('quiz')
                ->where('date_quiz',$dateQuiz);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function get_quiz_by_date_result($dateQuiz)
    {

        $this->db->select('*')
                ->from('quiz')
                ->where('date_result',$dateQuiz);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function get_response_by_quiz($quizId)
    {

        $this->db->select('*')
                ->from('user_quiz')
                ->join("user","user.user_id=user_quiz.user_id")
                ->where('quiz_id', $quizId)
                ->order_by("date_answer","ASC");

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function get_quiz()
    {

        $this->db->select('*')
                ->from('quiz')
                ->where('date_quiz', date("Y-m-d"));

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function get_all_quiz()
    {

        $this->db->select('*')
                ->from('quiz')
                ->order_by('date_quiz','DESC');

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function update_quiz_statut($quizId,$statut,$active)
    {

        $data=array(
            'statut'=> $statut,
            'active'=> $active
        );

        $this->db->where('quiz_id',$quizId);
        $query=$this->db->update('quiz',$data);

        return $query;

    }

    public function update_quiz_active($quizId,$active)
    {

        $data=array(
            'active'=> $active
        );

        $this->db->where('quiz_id',$quizId);
        $query=$this->db->update('quiz',$data);

        return $query;

    }

    public function update_quiz($files,$data)
    {

        $queryString='Update quiz SET ';

        if(!empty($files["media_question"]["file_name"]))
            $queryString.='media_question="'.$files["media_question"]["file_name"].'" ,';

        if(!empty($files["media_answer"]["file_name"]))
            $queryString.='image_answer="'.$files["media_answer"]["file_name"].'" ,';

        if(!empty($files["cover_answer"]["file_name"]))
            $queryString.='cover_answer="'.$files["cover_answer"]["file_name"].'" ,';

        $queryString.='name="'.addslashes($data["name"]).'" ,';

        $queryString.='question_fr="'.addslashes($data["question_fr"]).'" ,';

        $queryString.='question_de="'.addslashes($data["question_de"]).'" ,';

        $queryString.='answer_fr="'.addslashes($data["answer_fr"]).'" ,';

        $queryString.='answer_de="'.addslashes($data["answer_de"]).'" ,';

        $queryString.='indice_1_fr="'.addslashes($data["indice_1_fr"]).'" ,';

        $queryString.='indice_2_fr="'.addslashes($data["indice_2_fr"]).'" ,';

        $queryString.='indice_3_fr="'.addslashes($data["indice_3_fr"]).'", ';

        $queryString.='indice_1_de="'.addslashes($data["indice_1_de"]).'" ,';

        $queryString.='indice_2_de="'.addslashes($data["indice_2_de"]).'" ,';

        $queryString.='indice_3_de="'.addslashes($data["indice_3_de"]).'" ,';

        $queryString.='type='.$data["media_type"].' ,';

        $queryString.='date_quiz="'.addslashes($data["date_quiz"]).'" ,';

        $queryString.='date_result="'.addslashes($data["date_result"]).'" ';

        $queryString.='WHERE quiz_id='.$data["quiz_id"];

        $this->db->query($queryString);

    }

    public function get_result()
    {

        $this->db->select('*')
                ->from('quiz')
                ->where('date_result', date("Y-m-d"));

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

    public function check_response_exists($quizId,$userId)
    {
        $this->db->select('*')
                ->from('user_quiz')
                ->where('user_id', $userId)
                ->where('quiz_id', $quizId);

        $query = $this->db->get();

        if ($query->num_rows() > 0)
            return TRUE;

        return FALSE;
    }

    public function check_active_quiz($quizId)
    {
        $this->db->select('*')
                ->from('quiz')
                ->where('active', 1);

        $query = $this->db->get();

        if ($query->num_rows() > 0)
            return TRUE;

        return FALSE;
    }

    public function insert_response($dataForm)
    {
        $data=array(
            'quiz_id'=> $dataForm["quiz_id"],
            'user_id'=> $dataForm["user_id"],
            'user_answer'=> $dataForm["user_answer"],
            'date_answer'=> date("Y-m-d H:i:s"),
        );

        $query=$this->db->insert('user_quiz',$data);

    }

    public function delete_quiz($quizId)
    {
        $this->db->where('quiz_id', $quizId);
        $query=$this->db->delete('quiz');

    }

    public function delete_user_quiz($quizId)
    {
        $this->db->where('quiz_id', $quizId);
        $query=$this->db->delete('user_quiz');

    }
}

?>
