<?php 
	class M_Status extends CI_Model{
		
		public function lister()
		{
			$this->db->select('*');
			$this->db->from('status');
			$this->db->order_by('date','desc');
			
			$query = $this->db->get();
			
			return $query->result();
		}
		public function ModelverifArticle($data){
	
			$this->db->select('id');
			$this->db->from('referenceId');
			$this->db->where('compte',$data['idCompte']);
			$this->db->where('status',$data['idArticle']);
			
			return $this->db->count_all_results();
		}
		public function ajouter($data)
		{	
			$value = array('titre' => $data['titre'],'description' => $data['description'],'img' => $data['img'],'url' => $data['url'],'date' => $data['date']); 

			$this->db->insert('status',$value);
			$idPost = $this->db->insert_id();
			
			$value2 = array('compte' => $data['id'], 'status' => $idPost);
			$this->db->insert('referenceId', $value2);
			
			if($data['id'] != 1){
				$value3 = array('compte' => 1 , 'status' => $idPost);
				$this->db->insert('referenceId', $value3);
			}
			
		}
		public function ajouterAjax($data)
		{	
			$value = array('titre' => $data['titre'],'description' => $data['description'],'img' => $data['img'],'url' => $data['url'],'date' => $data['date']); 

			$this->db->insert('status',$value);
			$idPost = $this->db->insert_id();
			
			$value2 = array('compte' => $data['id'], 'status' => $idPost);
			$this->db->insert('referenceId', $value2);
			
			if($data['id'] != 1){
				$value3 = array('compte' => 1 , 'status' => $idPost);
				$this->db->insert('referenceId', $value3);
			}
			
			return $idPost;
			
		}
		
		public function supprimer($id)
		{
			$array = array("id"=>$id);
			$this->db->delete('status',$array);
			
			$array2 = array("status"=>$id);
			$this->db->delete('referenceId',$array2);
			
		}
		public function voir($id)
		{
			$array = array("id"=>$id);
			$query = $this->db->get_where('status', $array);	
			
			return $query->result();
		}
		public function modifier($data){
			$array = array(
				'titre' => $data['titre'],
				'description' => $data['description'],
				'date' => $data['date']
			);
	
			$this->db->where("id", $data['id']);
			$this->db->update('status', $array);
		}
		public function login($data){
			
			$data = array('email' => $data['email'], 'mdp' => sha1($data['mdp']));
			$query = $this->db->get_where('compte', $data);
			
			if($query->num_rows()>0){
				return true;
			}
			
			
		}
		public function sign($data){
			
			$value = array('email' => $data['email'],'nom' => $data['nom'],'mdp' => sha1($data['mdp'])); 

			$this->db->insert('compte',$value);
			
		}
		public function recupNameAndId($email){
			
			$this->db->select('nom,id');
			$this->db->from('compte');
			$this->db->where("email", $email);
			
			$query = $this->db->get();
			
			return $query->result();
			
		}
		public function checkEmail($email){
			
			$this->db->select('id');
			$this->db->from('compte');
			$this->db->where('email',$email);
			
			return $this->db->count_all_results();
			
		}

		
	}