<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Start extends CI_Controller {

        private $facebook;

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
        }

        /*
         * Landing page fan function
         *
         * @access public
         * @param none
         * @return none
         */
	public function index()
	{
                //Get signed request to check if user is fan or not
                $signedRequest=$this->facebook->getSignedRequest();
                $data["liked"]=$signedRequest["page"]["liked"];
                $tab=explode("_",$signedRequest["user"]["locale"]);

                if($this->uri->segment(3)!="fr" && $this->uri->segment(3)!="de"){

                    if($tab[0]!="fr" && $tab[0]!="de")
                        $data["lang"]="fr";
                    else
                        $data["lang"]=$tab[0];
                    
                }else{
                    $data["lang"]=$this->uri->segment(3);
                }

		$this->load->view('page/landing',$data);
	}

         /*
         * Application access
         *
         * @access public
         * @param none
         * @return none
         */
        public function app_access()
        {
                
                ini_set('allow_url_fopen', 1);
                /*ini_set('display_errors', 1);
                error_reporting(E_ALL);*/
                //Authentification new players Oauth 2.0
                $app_id = APP_ID;
                $app_secret = SECRET_KEY;
                $my_url = APP_URL_CANVAS;



                    //check if check application code is given
                    if(isset($_REQUEST["code"])){
                        $code = $_REQUEST["code"];
                    }else{
                        $code="";
                    }

                if(empty($code)) {//first time in game



                        $dialog_url = "http://www.facebook.com/dialog/oauth?client_id="
                            . $app_id . "&redirect_uri=" . urlencode($my_url)."&cancel_url=" . urlencode($my_url)."&scope=publish_stream,email";

                        echo("<script> top.location.href='" . $dialog_url . "'</script>");

                }else {//else go in game directly


                    try{

                        $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
                            . $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret="
                            . $app_secret . "&code=" . $code;

                        $access_token = file_get_contents($token_url);

                        if($access_token==FALSE)
                            echo("<script> top.location.href='" .PAGE_FAN_APP_URL. "'</script>");

                        //load user infos
                        $userInfos = $this->facebook->api('me?'.$access_token);

                        //check if user already in database
                        $userExist=$this->user_model->check_user_exists($userInfos['id']);

                        if(!$userExist)
                            $this->user_model->insert_user($userInfos);

                        //locale facebook
                        $tab=explode("_",$userInfos["locale"]);
                        $locale=$tab[0];

                        //put user infos in secure session
                        $identification = array(
                                'userId'  => $userInfos['id'],
                                'userFirstName'  => $userInfos['first_name'],
                                'userLastName'  => $userInfos['last_name'],
                                'userEmail'  => $userInfos['email'],
                                'userLocale'  => $locale,
                                'connected_app'  => TRUE,
                                'access_token'  => $this->facebook->getAccessToken(),
                                'userGender'  => $userInfos['gender'],
                                'connected_ok'  => TRUE,
                        );

                        $this->session->set_userdata($identification);

                        if($locale=="fr" || $locale=="de")
                        {
                             $this->lang->load('menu', $locale);
                             $this->lang->load('home', $locale);
                             $this->lang->load('footer', $locale);
                        }
                        else
                        {
                             $this->lang->load('menu', 'fr');
                             $this->lang->load('home', 'fr');
                             $this->lang->load('footer', 'fr');

                            $identification = array(
                                    'userLocale'  => 'fr'
                            );

                            $this->session->set_userdata($identification);
                        }

                        //if invitation
                        //Get all app requests for user
                        $request_url ="https://graph.facebook.com/" .
                        $userInfos['id']. "/apprequests?" .$access_token;
                        $requests = file_get_contents($request_url);

                        //Process and delete app requests
                        $data = json_decode($requests);

                        $pts=$this->user_model->get_pts_parrainage();

                        foreach($data->data as $item){

                            $item->from->id;
                            $checkSponsor=$this->user_model->check_sponsor_exists($userInfos['id'],$item->from->id);

                            if(!$checkSponsor){
                                $this->user_model->update_sponsor($userInfos['id'],$item->from->id);

                                if(!empty($pts))
                                    $this->point_model->insert_parrainage_point($item->from->id,$pts);
                            }
                        }


                        foreach($data->data as $item) {
                                                        
                            $id = $item->id;
                            $delete_url = "https://graph.facebook.com/" .
                              $id . "?".$access_token. "&method=delete";

                            $result = file_get_contents($delete_url);
                        }
                        
                        $likeId = $this->facebook->api(
                        array( 'method' => 'fql.query', 'query' =>
                        'SELECT target_id FROM connection WHERE source_id ='.$userInfos['id'].' AND target_id =171336616212529' )
                        );

                        if ( empty($likeId) ) {

                            echo("<script> top.location.href='" .PAGE_FAN_APP_URL. "'</script>");

                        } else {

                            redirect('game');

                        }
                        
                    throw("Your session has expired");

                    }catch(Exception $e){
                        echo $e;
                    }

                }


   
        }

        public function info(){
            phpinfo();
        }
}
