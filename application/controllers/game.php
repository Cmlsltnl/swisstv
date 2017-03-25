<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game extends CI_Controller {

        const NEXT_MONTH=2;
        const PREVIOUS_MONTH=1;
        const NEXT_WEEK=2;
        const PREVIOUS_WEEK=1;

        const CATEGORY_ALL=1;
        const CATEGORY_FRIENDS=2;
        const CATEGORY_ME=3;

        public $facebook;

        public function __construct(){

            //load librairies etc...
            parent::__construct();

            date_default_timezone_set('Europe/Paris');
            $this->load->database();
            $this->load->file(APPPATH.'/third_party/facebook.php');

            //tip to avoid infinite loop
            header('P3P: CP="CAO PSA OUR"');

            //facebook configuration
            $this->facebook = new Facebook(array(
                  'appId'  => APP_ID,
                  'secret' => SECRET_KEY,
                  'cookie' => FALSE,
                  'domain'=>FACEBOOK_DOMAIN,
            ));

            //check user locale
            if($this->uri->segment(3)!="fr" && $this->uri->segment(3)!="de"){

                $langageFile=$this->session->userdata("userLocale");

                if($langageFile!="fr" && $langageFile!="de"){
                    $identification = array(
                            'userLocale'  => 'fr'
                    );

                    $this->session->set_userdata($identification);
                    $langageFile=$this->session->userdata("userLocale");
                }

            }else{

                $langageFile=$this->uri->segment(3);
                //put user infos in secure session
                $identification = array(
                        'userLocale'  => $langageFile
                );

                $this->session->set_userdata($identification);
            }

            //load langage file
            if($langageFile=="fr" || $langageFile=="de")
            {
                 $this->lang->load('menu', $langageFile);
                 $this->lang->load('home', $langageFile);
                 $this->lang->load('cadeaux', $langageFile);
                 $this->lang->load('filleul', $langageFile);
                 $this->lang->load('resultat', $langageFile);
                 $this->lang->load('classement', $langageFile);
                 $this->lang->load('mission', $langageFile);
                 $this->lang->load('mon_compte', $langageFile);
                 $this->lang->load('footer', $langageFile);
            }
            else
            {
                 $this->lang->load('menu', 'fr');
                 $this->lang->load('home', 'fr');
                 $this->lang->load('cadeaux', 'fr');
                 $this->lang->load('filleul', 'fr');
                 $this->lang->load('resultat', 'fr');
                 $this->lang->load('classement', 'fr');
                 $this->lang->load('mon_compte', 'fr');
                 $this->lang->load('mission', 'fr');
                 $this->lang->load('footer', 'fr');

            }
        }

        /*
         * home page
         *
         * @access public
         * @param none
         * @return none
         */
	public function index()
	{
                
                $connected = $this->session->userdata('connected_ok');
                check::check_connexion($connected);

                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'update_indice1_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'update_indice2_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'update_indice3_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'submit_response_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'reload_process'));
                
                //$this->xajax->configure('debug', true);
                $this->xajax->processRequest();

                $quizInfos=$this->quiz_model->get_quiz_open();
                $data["quizInfos"]=$quizInfos;

                if(!empty($quizInfos)){

                    $active=$this->quiz_model->check_active_quiz($quizInfos[0]["quiz_id"]);
                    $check=$this->quiz_model->check_response_exists($quizInfos[0]["quiz_id"],$this->session->userdata("userId"));

                    if(!$check && $active)
                    {

                        $this->load->view('app/home',$data);

                    }else{

                        /*$dateNextQuiz=date::day_after($quizInfos[0]["date_quiz"]);
                        $data["dateNextQuiz"]=date::explode_date($dateNextQuiz);*/
                        $data["dateNextQuiz"]=date::explode_date($quizInfos[0]["date_result"]);
                        $data["dateResult"]=date::explode_date($quizInfos[0]["date_result"]);
                        $this->load->view('app/home_locked',$data);

                    }

                }else{
                    $data["message_info"]=$this->lang->line('home_none');
                    $this->load->view('app/home',$data);
                }
                
		
	}

        /*
         * cadeaux page
         *
         * @access public
         * @param none
         * @return none
         */
	public function cadeaux()
	{
                $connected = $this->session->userdata('connected_ok');
                check::check_connexion($connected);
		$this->load->view('app/cadeaux');
	}

        /*
         * filleul page
         *
         * @access public
         * @param none
         * @return none
         */
	public function filleul()
	{
                $connected = $this->session->userdata('connected_ok');
                check::check_connexion($connected);
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'filleul_process'));

                //$this->xajax->configure('debug', true);
                $this->xajax->processRequest();

                //$data["nbFilleul"]=$this->user_model->count_filleul($this->session->userdata('userId'));

                $data["totalPts"]=$this->user_model->count_parrainage_pts($this->session->userdata('userId'));
                $data["nbParrainage"]=$this->user_model->count_parrainage($this->session->userdata('userId'));
                $data["nbFilleul"]=$this->user_model->count_filleul_monthly($this->session->userdata('userId'));
                $data["nbUser"]=$this->user_model->count_user();

                //Pagination
                $nbFilleuls=$this->user_model->count_filleul_monthly($this->session->userdata('userId'));
                $total=$nbFilleuls;
                $perPage=18;
                $data["pagination"]=$this->pagination($this->uri->segment(4),$total,$perPage,'xajax_filleul_process');
                
                $filleuls=$this->user_model->get_filleul_monthly($this->session->userdata('userId'),$this->session->userdata('firstPage'),$perPage);
                $data["filleuls"]=$filleuls;
		$this->load->view('app/filleul',$data);
	}

        /*
         * filleul ajax process
         *
         * @access public
         * @param array
         * @return none
         */
	public function filleul_process($arg)
	{

                $objResponse = new xajaxResponse();

                //$data["nbFilleul"]=$this->user_model->count_filleul($this->session->userdata('userId'));
                $data["totalPts"]=$this->user_model->count_parrainage_pts($this->session->userdata('userId'));
                $data["nbFilleul"]=$this->user_model->count_filleul_monthly($this->session->userdata('userId'));
                $data["nbUser"]=$this->user_model->count_user();
                //Pagination
                $nbFilleuls=$this->user_model->count_filleul_monthly($this->session->userdata('userId'));
                $total=$nbFilleuls;
                $perPage=18;
                $data["pagination"]=$this->pagination($arg,$total,$perPage,'xajax_filleul_process');

                $filleuls=$this->user_model->get_filleul_monthly($this->session->userdata('userId'),$this->session->userdata('firstPage'),$perPage);
                $data["filleuls"]=$filleuls;

                //load view and js
                $result = $this->load->view('app/includes/filleul',$data,true);
                $objResponse->assign("filleul","innerHTML",$result);

                return $objResponse;

	}



        /*
         * data picker process
         *
         * @access public
         * @param date
         * @return none
         */
	public function date_picker_process($date=NULL)
	{

                $objResponse = new xajaxResponse();

                if($date===NULL){

                    $dateQuiz=date("Y-m-d");

                }else{

                    $dateQuiz=$date;

                }

                $locale=$this->session->userdata('userLocale');

                $data["userPoints"]=$this->point_model->get_point_by_day($this->session->userdata('userId'),$dateQuiz);
                $quizInfos=$this->quiz_model->get_quiz_by_date($dateQuiz);

                $data["quizInfos"]=$quizInfos;

                //Pagination
                $nbResultat=$this->user_model->count_players_day($this->session->userdata('userId'),$dateQuiz);
                
                $total=$nbResultat;
                $perPage=10;
                $data["pagination"]=$this->pagination_resultat($this->uri->segment(4),$dateQuiz,$total,$perPage,'xajax_resultat_process');

                $resultats=$this->user_model->get_players_day($this->session->userdata('firstPage'),$perPage,$dateQuiz);
                $data["resultats"]=$resultats;

                //load view and js
                $result = $this->load->view('app/includes/resultat',$data,true);

                if($locale=="fr"){

                    $objResponse->assign("acces_frame","innerHTML",$result);
                            $objResponse->script('    $("#calendar").datepicker({dateFormat: "yy-mm-dd",dayNamesMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],monthNames: ["Janvier","Fevrier","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre"],onSelect: function(date) {
                                        xajax_date_picker_process(date);
                                    }
                                });
                                ');
                }else{
                    $objResponse->assign("acces_frame","innerHTML",$result);
                            $objResponse->script('    $("#calendar").datepicker({dateFormat: "yy-mm-dd",dayNamesMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],monthNames: ["Janvier","Fevrier","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre"],onSelect: function(date) {
                                        xajax_date_picker_process(date);
                                    }
                                });
                                ');
                }

                return $objResponse;

	}

        /*
         * resultat page
         *
         * @access public
         * @param none
         * @return none
         */
	public function resultat()
	{
                $connected = $this->session->userdata('connected_ok');
                check::check_connexion($connected);
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'resultat_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'date_picker_process'));

                //$this->xajax->configure('debug', true);
                $this->xajax->processRequest();

                $dateQuiz=date("Y-m-d");
                $quizInfos=$this->quiz_model->get_quiz_by_date_result($dateQuiz);

                if(!empty($quizInfos)){
                   $dateQuiz=$quizInfos[0]["date_quiz"];
                }else{
                   $dateQuiz=date("Y-m-d");
                }

                $data["userPoints"]=$this->point_model->get_point_by_day($this->session->userdata('userId'),$dateQuiz);

                $data["quizInfos"]=$quizInfos;

                //Pagination
                $nbResultat=$this->user_model->count_players_day($this->session->userdata('userId'),$dateQuiz);
                $total=$nbResultat;
                $perPage=10;
                $data["pagination"]=$this->pagination_resultat($this->uri->segment(4),$dateQuiz,$total,$perPage,'xajax_resultat_process');

                $resultats=$this->user_model->get_players_day($this->session->userdata('firstPage'),$perPage,$dateQuiz);
                $data["resultats"]=$resultats;

		$this->load->view('app/resultat',$data);
	}

        /*
         * resultat process
         *
         * @access public
         * @param array, date
         * @return none
         */
	public function resultat_process($arg,$date=NULL)
	{

                $objResponse = new xajaxResponse();

                if($date===NULL){

                    $dateQuiz=date("Y-m-d");

                }else{

                    $dateQuiz=$date;
                    
                }

                $quizInfos=$this->quiz_model->get_quiz_by_date($dateQuiz);

                $data["quizInfos"]=$quizInfos;

                //Pagination
                $nbResultat=$this->user_model->count_players_day($this->session->userdata('userId'),$dateQuiz);
                $total=$nbResultat;
                $perPage=10;
                $data["pagination"]=$this->pagination_resultat($arg,$dateQuiz,$total,$perPage,'xajax_resultat_process');

                $resultats=$this->user_model->get_players_day($this->session->userdata('firstPage'),$perPage,$dateQuiz);
                $data["resultats"]=$resultats;

                //load view and js
                $result = $this->load->view('app/includes/top_day',$data,true);
                $objResponse->assign("top_day","innerHTML",$result);

                return $objResponse;

	}


        /*
         * ajax pagination resultats
         *
         * @access public
         * @param array,date,int,int,function
         * @return none
         */
        public function pagination_resultat($arg,$date,$total,$perPage,$function){

            $nbPage=ceil($total/$perPage);

            if(empty($arg)){

                $page=1;

            }else{

                $page=$arg;

                if($page>$nbPage){
                    $page=$nbPage;
                }
            }

            $firstPage=($page-1)*$perPage;
            //put user infos in secure session
            $identification = array(
                    'firstPage'  => $firstPage
            );

            $this->session->set_userdata($identification);

            $pagination=array();
            $pagination[]=' <a href="#block_right" onclick="'.$function.'(\''.($page-1).'\',\''.$date.'\')"><div id="button_left"></div></a> ';


            if($page>5)
                $pagination[]=' <div id="indicator">'.$page.'/5</div> ';
            else
                $pagination[]=' <div id="indicator">'.$page.'/'.$nbPage.'</div> ';

            if($page<5)
                $pagination[]=' <a href="#block_right" onclick="'.$function.'(\''.($page+1).'\',\''.$date.'\')"><div id="button_right"></div></a>';


            return $pagination;
        }

        /*
         * classment page
         *
         * @access public
         * @param none
         * @return none
         */
        public function classement(){

                $connected = $this->session->userdata('connected_ok');
                check::check_connexion($connected);
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'next_month_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'next_week_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'friends_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'my_classement_process'));

                //$this->xajax->configure('debug', true);
                $this->xajax->processRequest();

                $date=date("Y-m-d");
                $year=date("Y");
                $month=date("m");
                $week=date("W");

                $data["month"]=$month;
                $data["year"]=$year;
                $data["week"]=$week;
                $data["classementMonth"]=$this->point_model->get_point_by_month($month,$year);
                $data["classementWeek"]=$this->point_model->get_point_by_week($week,$year);

		$this->load->view('app/classement',$data);
        }

        /*public function friends_process(){

                $objResponse = new xajaxResponse();

                $year=date("Y");
                $month=date("m");
                $week=date("W");
                $data["month"]=$month;
                $data["year"]=$year;
                $data["week"]=$week;

                $data["classementMonth"]=$this->point_model->get_friends_point_by_month($this->session->userdata("userId"),$month,$year);
                $result = $this->load->view('app/includes/next_friends_month',$data,true);

                $objResponse->assign("bloc_right","innerHTML",$result);

                $data["classementWeek"]=$this->point_model->get_friends_point_by_week($this->session->userdata("userId"),$week,$year);
                $result = $this->load->view('app/includes/next_friends_week',$data,true);      
                //load view and js
                $objResponse->assign("bloc_left","innerHTML",$result);

                return $objResponse;

        }*/

        /*
         * ajax friend process
         *
         * @access public
         * @param none
         * @return none
         */
        public function friends_process(){

                $objResponse = new xajaxResponse();

                $year=date("Y");
                $month=date("m");
                $week=date("W");
                $data["month"]=$month;
                $data["year"]=$year;
                $data["week"]=$week;

                $friendsList=$this->facebook->api('me/friends?oauth_token='.$this->session->userdata("access_token"));

                $friendsArr=array();
                foreach($friendsList as $friend){

                    foreach($friend as $row){

                        $friendsArr[]=$row["id"];

                    }
                }

                $data["classementMonth"]=$this->point_model->get_fb_friends_point_by_month($friendsArr,$month,$year);
                $result = $this->load->view('app/includes/next_friends_month',$data,true);

                $objResponse->assign("bloc_right","innerHTML",$result);

                $data["classementWeek"]=$this->point_model->get_fb_friends_point_by_week($friendsArr,$week,$year);
                $result = $this->load->view('app/includes/next_friends_week',$data,true);
                //load view and js
                $objResponse->assign("bloc_left","innerHTML",$result);

                return $objResponse;

        }

        /*
         * ajax classement process
         *
         * @access public
         * @param none
         * @return none
         */
        public function my_classement_process(){

                $objResponse = new xajaxResponse();

                $year=date("Y");
                $month=date("m");
                $week=date("W");
                $data["month"]=$month;
                $data["year"]=$year;
                $data["week"]=$week;

                $data["classementMonth"]=$this->point_model->get_my_point_by_month($this->session->userdata("userId"),$month,$year);
                $result1 = $this->load->view('app/includes/next_my_classement_month',$data,true);

                $data["classementWeek"]=$this->point_model->get_my_point_by_week($this->session->userdata("userId"),$week,$year);
                $result2 = $this->load->view('app/includes/next_my_classement_week',$data,true);
                //load view and js
                $objResponse->assign("bloc_right","innerHTML",$result1);
                $objResponse->assign("bloc_left","innerHTML",$result2);

                return $objResponse;

        }

        /*
         * ajax next month process
         *
         * @access public
         * @param int $month,int $year,int $type,int $category
         * @return none
         */
        public function next_month_process($month,$year,$type,$category){

                $objResponse = new xajaxResponse();

                if($type==2){

                    if($month<=11){

                        $nextMonth=$month+1;
                        if($nextMonth<10)
                           $nextMonth="0".$nextMonth;

                        $nextYear=$year;

                    }else{
                        $nextMonth="01";
                        $nextYear=$year+1;
                    }

                }else{

                    if($month>=2){

                        $nextMonth=$month-1;
                        if($nextMonth<10)
                           $nextMonth="0".$nextMonth;

                        $nextYear=$year;
                    }else{
                        $nextMonth="12";
                        $nextYear=$year-1;
                    }
                }

                $data["month"]=$nextMonth;
                $data["year"]=$nextYear;

                if($category==1){
                    $data["classementMonth"]=$this->point_model->get_point_by_month($nextMonth,$nextYear);
                    $result = $this->load->view('app/includes/next_month',$data,true);
                }

                if($category==2){

                    $friendsList=$this->facebook->api('me/friends?oauth_token='.$this->session->userdata("access_token"));

                    $friendsArr=array();
                    foreach($friendsList as $friend){

                        foreach($friend as $row){

                            $friendsArr[]=$row["id"];

                        }
                    }

                    $data["classementMonth"]=$this->point_model->get_fb_friends_point_by_month($friendsArr,$nextMonth,$nextYear);
                    $result = $this->load->view('app/includes/next_friends_month',$data,true);
                }

                if($category==3){
                    $data["classementMonth"]=$this->point_model->get_my_point_by_month($this->session->userdata("userId"),$nextMonth,$nextYear);
                    $result = $this->load->view('app/includes/next_my_classement_month',$data,true);
                }
                //load view and js

                $objResponse->assign("bloc_right","innerHTML",$result);

                return $objResponse;
                
        }

        /*
         * ajax next week process
         *
         * @access public
         * @param int $week,int $year,int $type,int $category
         * @return none
         */
        public function next_week_process($week,$year,$type,$category){

                $objResponse = new xajaxResponse();

                if($type==2){

                    if($week<=51){

                        $nextWeek=$week+1;
                        $nextYear=$year;

                    }else{
                        $nextWeek=1;
                        $nextYear=$year+1;
                    }

                }else{

                    if($week>=2){

                        $nextWeek=$week-1;
                        $nextYear=$year;
                    }else{
                        $nextWeek=52;
                        $nextYear=$year-1;
                    }
                }

                $data["week"]=$nextWeek;
                $data["year"]=$nextYear;

                if($category==1){
                    $data["classementWeek"]=$this->point_model->get_point_by_week($nextWeek,$nextYear);
                    $result = $this->load->view('app/includes/next_week',$data,true);
                }
                
                if($category==2){

                    $friendsList=$this->facebook->api('me/friends?oauth_token='.$this->session->userdata("access_token"));

                    $friendsArr=array();
                    foreach($friendsList as $friend){

                        foreach($friend as $row){

                            $friendsArr[]=$row["id"];

                        }
                    }
                    $data["classementWeek"]=$this->point_model->get_fb_friends_point_by_week($friendsArr,$nextWeek,$nextYear);
                    $result = $this->load->view('app/includes/next_friends_week',$data,true);                
                }

                if($category==3){
                    $data["classementWeek"]=$this->point_model->get_my_point_by_week($this->session->userdata("userId"),$nextWeek,$nextYear);
                    $result = $this->load->view('app/includes/next_my_classement_week',$data,true);
                }
                //load view and js
                $objResponse->assign("bloc_left","innerHTML",$result);

                return $objResponse;

        }


        /*
         * mission page
         *
         * @access public
         * @param none
         * @return none
         */
        public function mission(){
            $connected = $this->session->userdata('connected_ok');
            check::check_connexion($connected);
            $this->load->view('app/mission');
        }

        /*
         * mon compte page
         *
         * @access public
         * @param none
         * @return none
         */
	public function mon_compte()
	{
                $connected = $this->session->userdata('connected_ok');
                check::check_connexion($connected);
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'submit_account_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'submit_newsletter_process'));

                //$this->xajax->configure('debug', true);
                $this->xajax->processRequest();

                $data["userInfos"]=$this->user_model->get_user_infos($this->session->userdata("userId"));

		$this->load->view('app/mon_compte',$data);
	}

        /*
         * ajax submit account process
         *
         * @access public
         * @param array $dataForm
         * @return none
         */
        public function submit_account_process($dataForm){

            $objResponse = new xajaxResponse();

            $langageFile=$this->session->userdata('userLocale');

            $this->user_model->update_account($this->session->userdata("userId"),$dataForm);

            //$result =$this->load->view('app/includes/home_locked',$data,true);

            /*$objResponse->script('xajax_update_indice1_process();
                                xajax_update_indice2_process();
                                xajax_update_indice3_process();');*/

            $objResponse->assign("mon_compte_desc","innerHTML",$this->lang->line("validation_compte_message"));

            return $objResponse;

        }

       /*
         * ajax submit newsletter process
         *
         * @access public
         * @param array $dataForm
         * @return none
         */
        public function submit_newsletter_process($dataForm){

            $objResponse = new xajaxResponse();

            $langageFile=$this->session->userdata('userLocale');

            $this->user_model->update_newsletter($this->session->userdata("userId"),$dataForm);

            //$result =$this->load->view('app/includes/home_locked',$data,true);

            /*$objResponse->script('xajax_update_indice1_process();
                                xajax_update_indice2_process();
                                xajax_update_indice3_process();');*/

            $objResponse->assign("newsletter_desc","innerHTML",$this->lang->line("validation_newsletter_message"));

            return $objResponse;

        }

       /*
         * ajax update indice 1 process
         *
         * @access public
         * @param none
         * @return none
         */
        public function update_indice1_process(){

            $objResponse = new xajaxResponse();

            $langageFile=$this->session->userdata('userLocale');

            if($langageFile=="fr" || $langageFile=="de")
                 $this->lang->load('home', $langageFile);
            else
                 $this->lang->load('home', 'fr');


            if(date("Y-m-d H:i:s")>=date("Y-m-d 18:00:00"))
            {
                $quizInfos=$this->quiz_model->get_quiz_open();
                $data=substr($quizInfos[0]["indice_1_".$this->session->userdata('userLocale')], 0, 20);

            } else{

                $data=$this->lang->line('home_indice1');
                $objResponse->script('setTimeout("xajax_update_indice1_process();",60000)');

            }

            $objResponse->assign("indice_1","innerHTML",$data);

            return $objResponse;

        }

       /*
         * ajax update indice 2 process
         *
         * @access public
         * @param none
         * @return none
         */
        public function update_indice2_process(){

            $objResponse = new xajaxResponse();

            $langageFile=$this->session->userdata('userLocale');

            if($langageFile=="fr" || $langageFile=="de")
                 $this->lang->load('home', $langageFile);
            else
                 $this->lang->load('home', 'fr');


            if(date("Y-m-d H:i:s")>=date("Y-m-d 21:00:00"))
            {
                $quizInfos=$this->quiz_model->get_quiz_open();
                $data=substr($quizInfos[0]["indice_2_".$this->session->userdata('userLocale')], 0, 20);

            } else{

                $data=$this->lang->line('home_indice2');
                $objResponse->script('setTimeout("xajax_update_indice2_process();",60000)');

            }

            $objResponse->assign("indice_2","innerHTML",$data);

            return $objResponse;

        }

       /*
         * ajax update indice 3 process
         *
         * @access public
         * @param none
         * @return none
         */
        public function update_indice3_process(){

            $objResponse = new xajaxResponse();

            $langageFile=$this->session->userdata('userLocale');

            if($langageFile=="fr" || $langageFile=="de")
                 $this->lang->load('home', $langageFile);
            else
                 $this->lang->load('home', 'fr');


            if(date("Y-m-d H:i:s")>=date("Y-m-d 21:30:00"))
            {
                $quizInfos=$this->quiz_model->get_quiz_open();
                $data=substr($quizInfos[0]["indice_3_".$this->session->userdata('userLocale')], 0, 20);

            } else{

                $data=$this->lang->line('home_indice3');
                $objResponse->script('setTimeout("xajax_update_indice3_process();",60000)');

            }

            $objResponse->assign("indice_3","innerHTML",$data);

            return $objResponse;

        }

        /*public function update_quiz_off_process(){

            $objResponse = new xajaxResponse();

            $quizInfosOpen=$this->quiz_model->get_quiz_open();

            if(!empty($quizInfosOpen)){

                $active=$this->quiz_model->check_active_quiz($quizInfos[0]["quiz_id"]);

                if($active)
                {
                    if(date("Y-m-d H:i:s")>=date("Y-m-d 22:00:05"))
                    {
                        $objResponse->redirect(base_url().'index.php/game');
                    }else{
                        $objResponse->script('setTimeout("xajax_quiz_off_process();",60000)');
                    }
                }

            }

            return $objResponse;

        }*/

       /*
         * ajax submit respnse process
         *
         * @access public
         * @param array $dataForm
         * @return none
         */
        public function submit_response_process($dataForm){

            $objResponse = new xajaxResponse();

            $langageFile=$this->session->userdata('userLocale');

            if($langageFile=="fr" || $langageFile=="de")
                 $this->lang->load('home', $langageFile);
            else
                 $this->lang->load('home', 'fr');

            $check=$this->quiz_model->check_response_exists($dataForm["quiz_id"],$dataForm["user_id"]);

            if(!$check)
            {

                $this->quiz_model->insert_response($dataForm);

            }

            $quizInfos=$this->quiz_model->get_quiz_open();
            
            $data["quizInfos"]=$quizInfos;
            $dateNextQuiz=date::day_after($quizInfos[0]["date_quiz"]);
            $dateNextQuiz=date::explode_date($dateNextQuiz);
            $dateResult=date::explode_date($quizInfos[0]["date_result"]);
            $data["dateNextQuiz"]=$dateNextQuiz;
            $data["dateResult"]=$dateResult;

            $result =$this->load->view('app/includes/home_locked',$data,true);

            $objResponse->redirect(base_url().'index.php/game');

            return $objResponse;

        }

       /*
         * ajax reload process
         *
         * @access public
         * @param none
         * @return none
         */
        public function reload_process(){

            $objResponse = new xajaxResponse();
            $objResponse->redirect(base_url().'index.php/game');

            return $objResponse;
        }

       /*
         * ajax pagination process
         *
         * @access public
         * @param int $arg, int $total, int $perPage, function $function
         * @return none
         */
        public function pagination($arg,$total,$perPage,$function){

            $nbPage=ceil($total/$perPage);

            if(empty($arg)){

                $page=1;

            }else{

                $page=$arg;

                if($page>$nbPage){
                    $page=$nbPage;
                }
            }

            $firstPage=($page-1)*$perPage;
            //put user infos in secure session
            $identification = array(
                    'firstPage'  => $firstPage
            );

            $this->session->set_userdata($identification);

            $pagination=array();
            $pagination[]=' <a href="#block_right" onclick="'.$function.'(\'1\')"><</a> ';
            $pagination[]=' <a href="#block_right" onclick="'.$function.'(\''.($page-1).'\')">'.$this->lang->line("prev").'</a>';

            for($i=$page-2; $i<$page; $i++){

                if($i>=1)
                    $pagination[]=' <a href="#block_right" onclick="'.$function.'(\''.$i.'\')">'.$i.'</a> ';
                else
                    $pagination[]=" ";
            }

            $pagination[]=' ['.$page.'] ';

            for($i=$page+1; $i<=($page+2); $i++){

                if($i<=$nbPage)
                    $pagination[]=' <a href="#block_right" onclick="'.$function.'(\''.$i.'\')">'.$i.'</a> ';

            }

            $pagination[]=' <a href="#block_right" onclick="'.$function.'(\''.($page+1).'\')">></a>';
            $pagination[]=' <a href="#block_right" onclick="'.$function.'(\''.$nbPage.'\')">'.$this->lang->line("last").'</a> ';

            return $pagination;
        }

       /*
         * ajax alternative pagination process
         *
         * @access public
         * @param int $arg, int $total, int $perPage, function $function
         * @return none
         */
        public function pagination_alt($arg,$total,$perPage,$function){

            $nbPage=ceil($total/$perPage);

            if(empty($arg)){

                $page=1;

            }else{

                $page=$arg;

                if($page>$nbPage){
                    $page=$nbPage;
                }
            }

            $firstPage=($page-1)*$perPage;
            //put user infos in secure session
            $identification = array(
                    'firstPage'  => $firstPage
            );

            $this->session->set_userdata($identification);

            $pagination=array();
            $pagination[]=' <a href="#block_right" onclick="'.$function.'(\'1\')"><div id="button_left"></div></a> ';
            $pagination[]=' <a href="#block_right" onclick="'.$function.'(\''.($page-1).'\')">'.$this->lang->line("prev").'</a>';

            $pagination[]=' <div id="indicator">'.$page.'/'.$nbPage.'</div> ';

            $pagination[]=' <a href="#block_right" onclick="'.$function.'(\''.($page+1).'\')"><div id="button_right"></div></a>';
            $pagination[]=' <a href="#block_right" onclick="'.$function.'(\''.$nbPage.'\')">'.$this->lang->line("last").'</a> ';

            return $pagination;
        }

 
}
