<?php

class User_model extends CI_Model {
	
	// --------------------------------------------------------------------
	
	/**
	 * Constructor. Instantiate CI to load database class.
	 * 
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	// ------------

	 public function add_user(){

	 	$password = $this->input->post('password');

	 	$new_password = md5($password);

        $new_member_insert = array(
            
            'username'         => $this->input->post('username'),
            'role'         => $this->input->post('role'),                   
            'password'         => $new_password

        );
        
        $insert = $this->db->insert('users', $new_member_insert);
        return $insert;
    }


     public function edit_user($name,$role,$password,$user_id){
        $new_member_insert = array(
            
            'username'         => $name,
            'role'         => $role,                   
            'password'         => $password

        );
        
        $insert = $this->db->update('users', $new_member_insert,array('id'=> $user_id));
        return $insert;
    }
    
    
    public function login_user($username,$passowrd){
        //Secure password
        $enc_password = md5($passowrd);
        
        //Validate
        $this->db->where('username',$username);
        $this->db->where('password',$enc_password);
        
        $result = $this->db->get('users');
        if($result->num_rows() > 0){
            return $result->row();
        } else {
            return false;
        }
    }

	function add($param = array()) {
		
		$insert = $this->db->insert('users', $param);
		
		if ($insert) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	
	function get_users()
	{
		//get first payment info
		$this->db->from('users');
		$this->db->order_by('id');
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		
		return FALSE;
		
	}

	function delete_user($user_id)
	{
		//get first payment info
		$delete = $this->db->delete('users', array('id' => $user_id));
		
		
		
		if ($delete) {
			return TRUE;
		}
		
		return FALSE;
	}

}