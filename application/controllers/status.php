<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 *   http://example.com/index.php/welcome
	 * - or -
	 *   http://example.com/index.php/welcome/index
	 * - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	/*$dom = new DomDocument();

		$dom->loadHTML();
		$nodes = $dom->getElementsByTagName("title");
		echo $nodes->item(0)->nodeValue;
		foreach($nodes as $node){
			if(strtolower($node->getAttribut("name")) == "description"){
			$description = $node->getAttribut("content");
			}
		}
		*/

	public function index()
	{

		
		$this->load->helper('form');
		$this->load->model('M_Status');
		
		$dataList['list'] = $this->M_Status->lister();
		
		if($this->session->userdata('logged')){
			for ($i = 0; $i < count($dataList['list']) ; $i++)
			{
				$the_id = $dataList['list'][$i]->id;
			    $bool = $this->verifArticle($the_id);
			    $dataList['list'][$i]->bool = $bool;
			    
			}
		}
		
		$dataLayout['titre'] = "PostYourLink";	

		$dataLayout['vue'] = $this->load->view('home.php',$dataList,true);

		$this->load->view('layout',$dataLayout);

	}
	public function verifArticle($id){
			$this->load->model('M_Status');
			$this->load->helper('form');
			$data['idArticle'] = $id;
			$data['idCompte'] = $this->session->userdata('id');
			
			if($this->M_Status->ModelverifArticle($data)>0){
				$check = true;
			}else{
				$check = false;
			}
			return $check;
	}
	public function login(){
		
			$this->load->model('M_Status');
			$this->load->helper('form');

			$data['email'] = $this->input->post('email');
			$data['mdp'] = $this->input->post('mdp');
			
			$dataList['verification'] = $this->M_Status->login($data);
			
			if($dataList['verification']){
				$name = $this->M_Status->recupNameAndId($data['email']);
				$data = array('email'=> $this->input->post('email'), 'logged' => true , 'name' => $name[0]->nom, 'id' => $name[0]->id );
				
				$this->session->set_userdata($data);
				
				redirect("status");
			}else{
				
				$dataList['erreur'] = 'Mauvais identifiants';
				
				$dataList['list'] = $this->M_Status->lister();
		
				$dataLayout['titre'] = "PostYourLink";	
		
				$dataLayout['vue'] = $this->load->view('home.php',$dataList,true);
		
				$this->load->view('layout',$dataLayout);
			}
	}

	public function logout(){
		$this->session->unset_userdata('logged');
		$this->session->sess_destroy();
		redirect(site_url());
	}
	
	public function inscription(){
		
		$this->load->helper('form');
		$this->load->model('M_Status');

		$dataList['messageTop'] = "Bienvenue cher visiteur";
		
		$dataLayout['titre'] = "PostYourLink";	

		$dataLayout['vue'] = $this->load->view('sign.php',$dataList,true);

		$this->load->view('layout',$dataLayout);
		
		
	}
	public function inscrire(){
		
		$this->load->helper('form');
		$this->load->model('M_Status');
		$this->load->helper('email');
		
		if($this->input->is_ajax_request()){
			
			$data['nom'] = $_POST['nom'];
			$data['email'] = $_POST['emailIns'];
			$data['mdp'] = $_POST['mdpIns'];
			
			if($this->M_Status->checkEmail($_POST['emailIns'])>0){
				$check['check'] = false;
			}else{
				$check['check'] = true;
				$this->M_Status->sign($data);
				$name = $this->M_Status->recupName($data['email']);
				$data = array('email'=> $data['email'], 'logged' => true , 'name' => $name[0]->nom);
				$this->session->set_userdata($data);
				$check['redirect'] = 'status';
			}
			
			
			
			
			echo json_encode($check);
			
		}else{
			
			if(!empty($_POST['nom'])){
				$data['nom'] = $_POST['nom'];
			}else{
				$data['nError'] = 'Ce champ est obligatoire';
			}
			if($this->M_Status->checkEmail($_POST['emailIns'])>0){
				$check = false;
			}else{
				$check = true;
			}
			if(valid_email($_POST['emailIns']) && $check){
				$data['email'] = $_POST['emailIns'];
			}else if(!$check){
				$data['eError'] = 'Cette email est deja enregistrer';
			}else{
				$data['eError'] = 'Ce champ est obligatoire';
			}
			
			if(!empty($_POST['mdpIns'])){
				$data['mdp'] = $_POST['mdpIns'];
			}else{
				$data['mError'] = 'Ce champ est obligatoire';
			}
			
			if($_POST['mdpIns'] != $_POST['mdpReco']){
				$data['remError'] = 'Veuillez correctement recopiez votre mot de passe';
			}
			
			if(valid_email($_POST['emailIns']) && !empty($data['nom']) && !empty($_POST['emailIns']) && $check && $_POST['mdpIns'] === $_POST['mdpReco']){
				
				$this->M_Status->sign($data);
				$name = $this->M_Status->recupName($data['email']);
				$data = array('email'=> $this->input->post('email'), 'logged' => true , 'name' => $name[0]->nom);
				$this->session->set_userdata($data);
				
				$dataReq['list'] = $this->M_Status->lister();
				$dataLayout['titre'] = "PostYourLink";
				$dataLayout['vue'] = $this->load->view('home.php',$dataReq,true);
				$this->load->view('layout',$dataLayout);
				
			}else{
				
				
				$dataLayout['vue'] = $this->load->view('sign.php',$data,true);
				
				$dataLayout['titre'] = "PostYourLink";	
				
				$this->load->view('layout',$dataLayout);
			}

		}
				
		
	}
	public function choisir(){
		
		$this->load->helper('form');
		$this->load->model('M_Status');
		
		
		
		if (isset($_POST['champ']))
		{
			$champ = $this->input->post('champ');
		}else{
			$champ = false;
		}
		
		if($this->curl($champ)){
			
			$html = $this->curl($champ);
			
			preg_match_all('#<title>(.+)<\/title>#', $html , $titles);
			preg_match_all('#<meta(?=[^>]*name="description")\s[^>]*content="(.+)"#', $html, $description);
			preg_match_all('#<img[^\']*?src=\"([^\']*?)\"[^\']*?>#i', $html, $img);
			

			$dataReq['url'] = $champ;
			if(isset($description)){
					
					if(isset($description[1][0])){
						$dataReq['description'] = $description[1][0];
					}else{
						$dataReq['description'] = 'Ajoutez-y une description';
					}
			}
			if(isset($img)){
				$chaine = '';
				foreach($img[1] as $image => $value){
					$lien =  $this->rel2abs($champ,$value);
					$size = @getimagesize($lien);
	
					$sizeImg = (int)$size[0];
					if(isset($sizeImg) && $sizeImg > 50 && $size != false){
						$chaine = $chaine . $lien . ',';
					}
				}
				$test = explode(',',$chaine);
				if(!empty($test[0])){
					$dataReq['lienImg'] = $test;
				}
				if(!isset($dataReq['lienImg'])){
					$dataReq['lienImg'] = array( base_url() .  "web/images/erreur.png" );
					
				}
			}

			if(isset($titles)){
				$dataReq['titles'] = $titles[1][0];
			}

			if($this->input->is_ajax_request()){
				$dataReq['urlpage'] = site_url();
				$dataReq['state'] = 'ok';
				echo json_encode($dataReq);
			
			}else{
				$dataLayout['titre'] = "PostYourLink";
	
				$dataLayout['vue'] = $this->load->view('choisir.php',$dataReq,true);
	
				$this->load->view('layout',$dataLayout);
			}
		}
		else{
			if($this->input->is_ajax_request()){
				$dataReq['error'] = $this->curl(trim($champ));
				$dataReq['urlpage'] = site_url();
				
				echo json_encode($dataReq);
				
			
			}else{
				$dataReq['list'] = $this->M_Status->lister();
				$dataLayout['titre'] = "PostYourLink";
				$dataReq['erreur'] = "Url incorrecte";
				$dataLayout['vue'] = $this->load->view('home.php',$dataReq,true);
				$this->load->view('layout',$dataLayout);
			}
			
			
			
			
		}		
		
	}

	public function ajouter(){
		
		$this->load->helper('form');
		$this->load->model('M_Status');
		$this->load->helper('time_helper');
		
		$data['img'] = $this->input->post('SelectImg');
		$data['titre'] = $this->input->post('titre');
		$data['url'] = $this->input->post('url');
		
		if(!preg_match('#^(http|https):\/\/#i', $data['url'])){
			$data['url'] = 'http://' . $data['url'];
		}else{
			$data['url'] = $data['url'] ;
		}
		$data['description'] = $this->input->post('description');
		$data['id'] = $this->session->userdata('id');
		if(empty($data['description'])){
						$data['description'] = 'il n y a pas de description mais vous pouvez en ajouter une ';
		}
		
		$data['date'] = time();
		
		if($this->input->is_ajax_request()){
			$data['idPost'] = $this->M_Status->ajouterAjax($data);
			$data['urlpage'] = site_url();
			$data['date'] = relative_time($data['date']);
			echo json_encode($data);
			
		}else{
			
			$this->M_Status->ajouter($data);
		
			redirect("status");
		}
		
		
	}
	public function supprimer(){
		
		if($this->input->is_ajax_request()){
			
			$this->load->model('M_Status');
			
			$id = $this->input->post('id');
			
			$this->M_Status->supprimer($id);
			
			echo json_encode('ok');
			
		}else{
			
			$this->load->model('M_Status');
		
			$id = $this->uri->segment(3);
			
			$this->M_Status->supprimer($id);
			
			redirect("status");
		}
	}
	public function voir(){

		$this->load->helper('form');
		$this->load->model('M_Status');
		
		$id = $this->uri->segment(3);
		
		$dataLayout['titre'] = "PostYourLink";
		$dataStatus['status'] = $this->M_Status->voir($id);
		
		$dataLayout['vue'] = $this->load->view('voir.php',$dataStatus,true);
		
		$this->load->view('layout',$dataLayout);
	}
	public function modifier(){
		
		$this->load->model('M_Status');
		
		if($this->input->is_ajax_request()){
			$data['titre'] = $this->input->post('titre');
			$data['description'] = $this->input->post('des');
			$data['date'] = time();
			$data['id'] = $this->input->post('id');
			
			$this->M_Status->modifier($data);
			
			echo json_encode($data);
		}else{
			$data['titre'] = $this->input->post('champtitre');
			$data['description'] = $this->input->post('champtext');
			$data['date'] = time();
			$data['id'] = $this->input->post('id');
			
			$this->M_Status->modifier($data);
			
			redirect("status");
		}
	}
	
	public function isValidURL($url)
	{
		return preg_match('/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/', $url);
		
		
	}
	
	private function rel2abs($pageURL, $link)
	{
		if ( strstr($link, 'http://') !== false ){
	    	return $link;
	    }
	       	   
	    if ( $pageURL[strlen($pageURL) - 1] !== '/' ){
	    	$pageURL .= '/';
	    }

	    /*if ( $link[0] == '/' ){
	    	$link = substr($link, 1);
	    }*/
	        
	    return $pageURL.$link;
	}
	
	private function curl($champ){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $champ);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$html = curl_exec($ch);
		return $html;
		curl_close($ch);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */