<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {


        public function __construct(){

            //load librairies etc...
            parent::__construct();
            date_default_timezone_set('Europe/Paris');

        }

        /*
         * login page
         *
         * @access public
         * @param none
         * @return none
         */
	public function index()
	{

		$this->load->view('admin/login');
	}

        /*
         * home page
         *
         * @access public
         * @param none
         * @return none
         */
	public function home()
	{

                $connected = $this->session->userdata('connected_admin');
                check::check_admin_connexion($connected);

		$this->load->view('admin/home');
	}

        /*
         * modify quiz page
         *
         * @access public
         * @param none
         * @return none
         */
        public function modify()
	{
                $connected = $this->session->userdata('connected_admin');
                check::check_admin_connexion($connected);
                $quizId=$this->uri->segment(3);
                $data["quizInfos"]=$this->quiz_model->get_quiz_by_id($quizId);
		$this->load->view('admin/modify',$data);
	}

        /*
         * quiz list page
         *
         * @access public
         * @param none
         * @return none
         */
	public function list_quiz()
	{
                $connected = $this->session->userdata('connected_admin');
                check::check_admin_connexion($connected);
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'delete_quiz_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'search_quiz_by_date_process'));
                //$this->xajax->configure('debug', true);
                $this->xajax->processRequest();

                $data["allQuiz"]=$this->quiz_model->get_all_quiz();
		$this->load->view('admin/list_quiz',$data);
	}

        /*
         * list user page
         *
         * @access public
         * @param none
         * @return none
         */
	public function list_user()
	{
                $connected = $this->session->userdata('connected_admin');
                check::check_admin_connexion($connected);
                $data["allUser"]=$this->user_model->get_all_user();
		$this->load->view('admin/list_user',$data);
	}

        /*
         * check user logged in
         *
         * @access public
         * @param none
         * @return none
         */
	public function check()
	{

            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                redirect("admin");
            }
            else
            {
                $email=$this->input->post('email', TRUE);
                $password=$this->input->post('password', TRUE);

                $adminInfo=$this->admin_model->get_admin_by_id($email,$password);

                if(empty($adminInfo))
                    redirect("admin");

                $password=md5($password);

                if($email==$adminInfo[0]["email"] && $password==$adminInfo[0]["password"]){

                    $identification = array(
                            'connected_admin'  => TRUE
                    );

                    $this->session->set_userdata($identification);

                    redirect("admin/home");

                }else{

                    redirect("admin");
                }

            }
	}

        /*
         * add quiz
         *
         * @access public
         * @param none
         * @return none
         */
	public function add_quiz()
	{
            $connected = $this->session->userdata('connected_admin');
            check::check_admin_connexion($connected);
            //form validation rules
            $this->form_validation->set_rules('name', 'Nom du quiz', 'required');
            /*$this->form_validation->set_rules('media_question', 'Media question', 'required');
            $this->form_validation->set_rules('media_answer', 'Media answer', 'required');
            $this->form_validation->set_rules('cover_answer', 'Jaquette', 'required');*/
            /*$this->form_validation->set_rules('question_fr', 'Question Fr', 'required');
            $this->form_validation->set_rules('question_de', 'Question De', 'required');
            $this->form_validation->set_rules('answer_fr', 'Réponse Fr', 'required');
            $this->form_validation->set_rules('answer_de', 'Réponse De', 'required');
            $this->form_validation->set_rules('indice_1_fr', 'Indice 1 Fr', 'required');
            $this->form_validation->set_rules('indice_2_fr', 'Indice 2 Fr', 'required');
            $this->form_validation->set_rules('indice_3_fr', 'Indice 3 Fr', 'required');
            $this->form_validation->set_rules('indice_1_de', 'Indice 1 De', 'required');
            $this->form_validation->set_rules('indice_2_de', 'Indice 2 De', 'required');
            $this->form_validation->set_rules('indice_3_de', 'Indice 3 De', 'required');

            
            $this->form_validation->set_rules('date_quiz', 'Date du quiz', 'required');
            $this->form_validation->set_rules('date_result', 'Date du résultat', 'required');*/

            //check required fields
            if ($this->form_validation->run() == FALSE)
            {
                $data["message"]="Création impossible";
                $this->load->view('admin/home',$data);
            }
            else
            {

                $dataForm=$this->input->post();

                //insert quiz data
                $quizId=$this->quiz_model->insert_quiz($dataForm);

                //make dir and index.html to avoid item list
                mkdir("uploads/".$quizId, 0777);
                $handle = fopen("uploads/".$quizId."/index.html", "w+");

                $config['upload_path'] = './uploads/'.$quizId.'/';
                $config['allowed_types'] = 'gif|jpg|png|mp4|mp3|mov|flv';

                $this->load->library('upload', $config);

                $mediaQuestion=$this->upload->do_upload("media_question");
                $filesInfos["media_question"]=$this->upload->data();

                $mediaAnswer=$this->upload->do_upload("media_answer");
                $filesInfos["media_answer"]=$this->upload->data();

                $coverAnswer=$this->upload->do_upload("cover_answer");
                $filesInfos["cover_answer"]=$this->upload->data();

                $this->quiz_model->update_quiz_media($quizId,$filesInfos);

                $data["message"]="Quiz créée avec succès";
                $this->load->view('admin/home',$data);

            }
	}

        /*
         * update quiz
         *
         * @access public
         * @param none
         * @return none
         */
	public function update_quiz()
	{
            $connected = $this->session->userdata('connected_admin');
            check::check_admin_connexion($connected);
            $quizInfos=$this->quiz_model->get_quiz_by_id($_POST["quiz_id"]);

            $config['upload_path'] = './uploads/'.$_POST["quiz_id"].'/';
            $config['allowed_types'] = 'gif|jpg|png|mp4|mp3|mov|flv';

            $this->load->library('upload', $config);

            $mediaQuestion=$this->upload->do_upload("media_question");
            $filesInfos["media_question"]=$this->upload->data();
            if($mediaQuestion)
                $this->deleteFile($_POST["quiz_id"],$quizInfos[0]["media_question"]);

            $mediaAnswer=$this->upload->do_upload("media_answer");
            $filesInfos["media_answer"]=$this->upload->data();
            if($mediaAnswer)
                $this->deleteFile($_POST["quiz_id"],$quizInfos[0]["image_answer"]);

            $coverAnswer=$this->upload->do_upload("cover_answer");
            $filesInfos["cover_answer"]=$this->upload->data();
            if($coverAnswer)
                $this->deleteFile($_POST["quiz_id"],$quizInfos[0]["cover_answer"]);

            $this->quiz_model->update_quiz($filesInfos,$_POST);

            $data["messageInfos"]=$this->lang->line("custom_modified");
            $contestInfos=$this->quiz_model->get_quiz_by_id($_POST["quiz_id"]);
            $data["quizInfos"]=$contestInfos;
            $data["message"]="Quiz modifié avec succès";

            $result =$this->load->view('admin/modify',$data);

	}

        /*
         * export csv list
         *
         * @access public
         * @param none
         * @return csv file
         */
        public function export_csv(){

            $connected = $this->session->userdata('connected_admin');
            check::check_admin_connexion($connected);
            $this->user_model->export_csv();

        }

        /*
         * xajax delete quiz process
         *
         * @access public
         * @param int $quizId
         * @return none
         */
        public function delete_quiz_process($quizId){

            $objResponse = new xajaxResponse();

            $this->deleteFiles($quizId);
            $this->deleteDirectory($quizId);

            $this->quiz_model->delete_user_quiz($quizId);
            $this->quiz_model->delete_quiz($quizId);
            $data["allQuiz"]=$this->quiz_model->get_all_quiz();

            $result =$this->load->view('admin/includes/list_quiz',$data,true);
            $objResponse->assign("content","innerHTML",$result);

            return $objResponse;

        }

        /*
         * delete files contained in dir
         *
         * @access public
         * @param string $dir
         * @return none
         */
        public function deleteFiles($dir){

            $pathDir="uploads/".$dir."/";

            $handle=opendir($pathDir);
            while (false !== ($fichier = readdir($handle)))
            {
                if (($fichier != ".") && ($fichier != ".."))
                {
                    unlink($pathDir.$fichier);
                }

            }

        }

        /*
         * delete one file
         *
         * @access public
         * @param string $dir,string $file
         * @return none
         */
        public function deleteFile($dir,$file){

            $this->load->helper("file");
            $pathDir="uploads/".$dir."/";
            $filesArr=get_filenames($pathDir);
            if(in_array($file, $filesArr)){
                unlink($pathDir.$file);
            }
       }

        /*
         * delete directory
         *
         * @access public
         * @param string $dir
         * @return none
         */
        public function deleteDirectory($dir){

            $pathDir="uploads/".$dir."/";
            $r=rmdir($pathDir);

            if (!$r)
                return false;

            return true;

        }

        /*
         * preview video and pictures
         *
         * @access public
         * @param none
         * @return none
         */
        public function preview(){

            $connected = $this->session->userdata('connected_admin');
            check::check_admin_connexion($connected);
            
            $quizId=$this->uri->segment(3);
            $data["quizInfos"]=$this->quiz_model->get_quiz_by_id($quizId);
            $this->load->view('admin/preview',$data);

        }

        /*
         * results list
         *
         * @access public
         * @param none
         * @return none
         */
        public function results(){

            $connected = $this->session->userdata('connected_admin');
            check::check_admin_connexion($connected);
            
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'add_point_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'delete_point_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'attribute_zero_point_process'));

            //$this->xajax->configure('debug', true);
            $this->xajax->processRequest();

            $quizId=$this->uri->segment(3);

            $allPoint=$this->point_model->get_point_by_quiz($quizId);
            $pointArr=array();
            foreach($allPoint as $row){
                
                $pointArr[]=$row["user_id"];
                
            }

            $data["quizId"]=$quizId;
            $data["allPoint"]=$pointArr;
            $data["allResponse"]=$this->quiz_model->get_response_by_quiz($quizId);
            $this->load->view('admin/results',$data);
        }

        /*
         * ajax attribute zero process
         *
         * @access public
         * @param int $quizId
         * @return none
         */
	public function attribute_zero_point_process($quizId)
	{
                $objResponse = new xajaxResponse();

                $connected = $this->session->userdata('connected_admin');
                check::check_admin_connexion($connected);

                $quizInfos=$this->quiz_model->get_quiz_by_id($quizId);
              
                $allUser=$this->quiz_model->get_response_by_quiz($quizId);

                foreach($allUser as $row){

                    $check=$this->point_model->check_point_quiz($row["user_id"],$quizId);

                    if(!$check)
                       $this->point_model->insert_zero_point($row["user_id"],$quizInfos);

                }

                $objResponse->redirect(base_url()."/index.php/admin/results/".$quizId);

                return $objResponse;
	}

        /*
         * add point process
         *
         * @access public
         * @param array $dataForm
         * @return none
         */
        public function add_point_process($dataForm){

            $objResponse = new xajaxResponse();

            $this->point_model->insert_point($dataForm);

            $result =$this->load->view('admin/includes/link_delete',$dataForm,true);
            $objResponse->assign("button_response_".$dataForm["nb"],"innerHTML",$result);

            return $objResponse;

        }

        /*
         * ajax delete point process
         *
         * @access public
         * @param array $dataForm
         * @return none
         */
        public function delete_point_process($dataForm){

            $objResponse = new xajaxResponse();

            $this->point_model->delete_point($dataForm);

            $result =$this->load->view('admin/includes/link_add',$dataForm,true);
            $objResponse->assign("button_response_".$dataForm["nb"],"innerHTML",$result);

            return $objResponse;

        }

        /*
         * Search quiz
         *  process
         *
         * @access public
         * @param array $dataForm
         * @return none
         */
        public function search_quiz_by_date_process($dataForm){

            $objResponse = new xajaxResponse();

            $data["allQuiz"]=$this->quiz_model->get_quiz_by_date($dataForm["date_quiz"]);

            $objResponse->includeScript(base_url()."js/jquery-1.5.1.min.js");
            $objResponse->includeScript(base_url()."js/jquery-ui-1.8.11.custom.min.js");
            $objResponse->includeScript(base_url()."js/quiz.js");
            $result =$this->load->view('admin/includes/quiz_date',$data,true);
            $objResponse->assign("content","innerHTML",$result);

            return $objResponse;
        }

        /*
         * deconnexion
         *
         * @access public
         * @param none
         * @return none
         */
        public function deconnexion(){

            $connected = $this->session->userdata('connected_admin');
            check::check_admin_connexion($connected);

            $this->session->unset_userdata(array('connected_admin' => ''));

            redirect('admin/');

        }

        /*
         * admin page
         *
         * @access public
         * @param none
         * @return none
         */
	public function administrator()
	{
                $connected = $this->session->userdata('connected_admin');
                check::check_admin_connexion($connected);

		$this->load->view('admin/admin');
	}

        /*
         * add admin process
         *
         * @access public
         * @param none
         * @return none
         */
	public function add_admin()
	{
                $connected = $this->session->userdata('connected_admin');
                check::check_admin_connexion($connected);

                $this->admin_model->insert_admin($_POST);

                $data["message"]="Admin ajouté avec succès";
		$this->load->view('admin/admin',$data);
	}

        /*
         * annonce page
         *
         * @access public
         * @param none
         * @return none
         */
	public function annonce()
	{
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'delete_annonce_process'));

                //$this->xajax->configure('debug', true);
                $this->xajax->processRequest();

                $connected = $this->session->userdata('connected_admin');
                check::check_admin_connexion($connected);

                if(isset($_POST)&& !empty($_POST))
                    $this->admin_model->insert_annonce($_POST);

                $data["allAnnonce"]=$this->admin_model->get_annonces();

		$this->load->view('admin/annonce',$data);
	}

        /*
         * add annonce process
         *
         * @access public
         * @param none
         * @return none
         */
	public function add_annonce()
	{
                $connected = $this->session->userdata('connected_admin');
                check::check_admin_connexion($connected);

		$this->load->view('admin/add_annonce');
	}

        /*
         * delete annonce process
         *
         * @access public
         * @param none
         * @return none
         */
	public function delete_annonce_process($dataForm)
	{
                $objResponse = new xajaxResponse();
                
                $connected = $this->session->userdata('connected_admin');
                check::check_admin_connexion($connected);

                $this->admin_model->delete_annonce($dataForm);

                $objResponse->redirect(base_url().'index.php/admin/annonce');

                return $objResponse;
	}

        /*
         * classment page
         *
         * @access public
         * @param none
         * @return none
         */
	public function classement()
	{
               $this->xajax->register(XAJAX_FUNCTION ,array($this, 'champion_process'));

                $this->xajax->configure('debug', true);
                $this->xajax->processRequest();

                $connected = $this->session->userdata('connected_admin');
                check::check_admin_connexion($connected);

                $date=date("Y-m-d");
                $year=date("Y");

                if(isset($_POST["month"]))
                    $month=$_POST["month"];
                else
                    $month=date("m");

                $week=date("W");

                
                $data["month"]=$month;
                $data["year"]=$year;
                $data["week"]=$week;
                $data["classementMonth"]=$this->point_model->get_point_by_month($month,$year);

                $champion=$this->user_model->get_champion($month);
                if(!empty($champion))
                    $data["champion"]=$champion[0]["user_id"];
                else
                    $data["champion"]="";

		$this->load->view('admin/classement',$data);
	}

        /*
         * add champion process
         *
         * @access public
         * @param array $dataForm
         * @return none
         */
	public function champion_process($dataForm)
	{
                $objResponse = new xajaxResponse();

                $connected = $this->session->userdata('connected_admin');
                check::check_admin_connexion($connected);

                $tab=explode("-",$dataForm["date_point"]);

                $check=$this->user_model->check_champion_exists($tab[1]);

                if(!$check){
                    $this->user_model->update_champion($dataForm["user_id"],$tab[1]);
                    $result =$this->load->view('admin/includes/link_champion',$dataForm,true);
                    $objResponse->assign("button_response_".$dataForm["nb"],"innerHTML",$result);
                }
                //$objResponse->redirect(base_url().'index.php/admin/classement');
                


                return $objResponse;
	}

	/*public function delete_champion_process($dataForm)
	{
                $objResponse = new xajaxResponse();

                $connected = $this->session->userdata('connected_admin');
                check::check_admin_connexion($connected);

                $tab=explode("-",$dataForm["date_point"]);

                $check=$this->user_model->check_champion_exists($tab[1]);

                if(!$check){
                    $this->user_model->update_champion($dataForm["user_id"],$tab[1]);
                    $result =$this->load->view('admin/includes/link_champion',$dataForm,true);
                    $objResponse->assign("button_response_".$dataForm["nb"],"innerHTML",$result);
                }
                //$objResponse->redirect(base_url().'index.php/admin/classement');



                return $objResponse;
	}*/

        /*
         * parainnage page
         *
         * @access public
         * @param none
         * @return none
         */
        public function parrainage(){

               $this->xajax->register(XAJAX_FUNCTION ,array($this, 'parrainage_process'));

                //$this->xajax->configure('debug', true);
                $this->xajax->processRequest();

                $connected = $this->session->userdata('connected_admin');
                check::check_admin_connexion($connected);

                $data["pts"]=$this->user_model->get_pts_parrainage();

		$this->load->view('admin/parrainage',$data);

        }

        /*
         * parrainage  process
         *
         * @access public
         * @param array $dataForm
         * @return none
         */
	public function parrainage_process($dataForm)
	{
                $objResponse = new xajaxResponse();

                $connected = $this->session->userdata('connected_admin');
                check::check_admin_connexion($connected);

                $this->user_model->update_parrainage($dataForm["pts"]);

                return $objResponse;
	}


}
