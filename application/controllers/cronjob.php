<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjob extends CI_Controller {

        const QUIZ_OPEN=1;
        const QUIZ_CLOSE=0;
        const QUIZ_ACTIVE=1;
        const QUIZ_OFF=0;


        public function __construct(){

            //load librairies etc...
            parent::__construct();
            date_default_timezone_set('Europe/Paris');
            $this->load->database();
            
        }

	public function start_quiz()
	{
                $quizInfos=$this->quiz_model->get_quiz();
                $quizInfosOpen=$this->quiz_model->get_quiz_open();

                
                if(!empty($quizInfos)&&!empty($quizInfosOpen)){
                    $this->quiz_model->update_quiz_statut($quizInfosOpen[0]["quiz_id"],  Cronjob::QUIZ_CLOSE,Cronjob::QUIZ_OFF);
                    $this->quiz_model->update_quiz_statut($quizInfos[0]["quiz_id"],  Cronjob::QUIZ_OPEN,Cronjob::QUIZ_ACTIVE);
                }else{
                    if(!empty($quizInfos))
                        $this->quiz_model->update_quiz_statut($quizInfos[0]["quiz_id"],  Cronjob::QUIZ_OPEN,Cronjob::QUIZ_ACTIVE);
                }

	}

	public function quiz_off()
	{
                $quizInfosOpen=$this->quiz_model->get_quiz_open();

                if(!empty($quizInfosOpen)){
                    $this->quiz_model->update_quiz_active($quizInfosOpen[0]["quiz_id"],Cronjob::QUIZ_OFF);
                }

	}



}
