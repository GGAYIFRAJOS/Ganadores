<?php

class Member_model extends CI_Model {
	
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

	public function get_info($id){

		$this->db->from('ranges');
		$this->db->where('member_id',$id);
		
		$info = $this->db->get();

        if($info->num_rows > 0){
            return $info->result();
        }
        else
            return FALSE;

    }

    public function get_names($id){

		$this->db->from('members');
		$this->db->where('member_id',$id);
		
		$info = $this->db->get();

        if($info->num_rows > 0){
            return $info->row()->names;
        }
        else
            return FALSE;

    }

    





	public function create_member(){
        

		$nxt_id = $this->get_last_id();

		if($nxt_id > 0){
			$range_mem_id = $nxt_id + 1 ;
			$new_member_insert = array(
	            'member_id' => $range_mem_id,
	            'names'         => $this->input->post('names'),
	            'adress'         => $this->input->post('adress'),
	            'phone_cell'         => $this->input->post('phone_cell'),                    
	            'email'         => ($this->input->post('email'))

        	);

			$total_balances = array(
				'member_id' => $range_mem_id,
            	'member' => $this->input->post('names'),
            	'amount_paid' => 0,
            	'total_balances'=>0

			);

			$total_fines = array(
				'member_id' => $range_mem_id,
            	'member' => $this->input->post('names'),
            	'amount_paid' => 0,
            	'total_fines'=>0

			);
		}
		else{
			$range_mem_id = 1;
			$new_member_insert = array(
	            'member_id' => $range_mem_id,
	            'names'         => $this->input->post('names'),
	            'adress'         => $this->input->post('adress'),
	            'phone_cell'         => $this->input->post('phone_cell'),                    
	            'email'         => ($this->input->post('email'))

        	);

        	$total_balances = array(
				'member_id' => $range_mem_id,
            	'member' => $this->input->post('names'),
            	'amount_paid' => 0,
            	'total_balances'=>0

			);

			$total_fines = array(
				'member_id' => $range_mem_id,
            	'member' => $this->input->post('names'),
            	'amount_paid' => 0,
            	'total_fines'=>0

			);
		}

		for($i = 1;$i<61;$i++){

			$original_date = '2019-06-06';

			$savings_sched = strtotime("+$i months", strtotime($original_date));

			$savings_sched = date('Y-m-d',$savings_sched);

			$range_dates = $this->Dates_model->get_range_dates($i);

			$range_info = array(

				'member_id' => $range_mem_id,
	            'range_id'			=>$i,
	            'names'         => $this->input->post('names'),
	            'saving_range'  => $i,
	            'saving_sched'  => $savings_sched,
	            'range_dates' => $range_dates
	        );

			$this->db->insert('ranges',$range_info);
		}
        
        $insert = $this->db->insert('members', $new_member_insert);

        $insert = $this->db->insert('total_fines', $total_fines);

        $insert = $this->db->insert('total_balances', $total_balances);

        return $insert;
    }

   
     
    public function edit_member($id){

    	$update = $this->db->update('members',array(
            'names'         => $this->input->post('names'),
            'adress'         => $this->input->post('adress'),
            'phone_cell'         => $this->input->post('phone_cell'),                    
            'email'         => $this->input->post('email')), array('member_id' => $id));

    	$update2 = $this->db->update('member_loan_info',array('names'=> $this->input->post('names')),array('member_id' => $id));

    	$update2 = $this->db->update('member_payments',array('member'=> $this->input->post('names')),array('member_id' => $id));

    	$update2 = $this->db->update('ranges',array('names'=> $this->input->post('names')),array('member_id' => $id));

    	$update2 = $this->db->update('savings',array('member'=> $this->input->post('names')),array('member_id' => $id));

    	$update2 = $this->db->update('total_savings',array('member'=> $this->input->post('names')),array('member_id' => $id));

    	$update2 = $this->db->update('transactions',array('names'=> $this->input->post('names')),array('member_id' => $id));

        if($update){
        	return TRUE;
        }
        else
        	return FALSE;
    }


    public function delete_member($id){

    	$delete = $this->db->delete('members', array('member_id' => $id));

    	$delete2 = $this->db->delete('member_loan_info',array('member_id' => $id));

    	$delete2 = $this->db->delete('member_payments',array('member_id' => $id));

    	$delete2 = $this->db->delete('ranges',array('member_id' => $id));

    	$delete2 = $this->db->delete('savings',array('member_id' => $id));

    	$delete2 = $this->db->delete('total_savings',array('member_id' => $id));

    	$delete2 = $this->db->delete('transactions',array('member_id' => $id));

        if($delete){
        	return TRUE;
        }
        else
        	return FALSE;

    }
    
    
    public function login_user($username,$passowrd){
        //Secure password
        $enc_password = md5($passowrd);
        
        //Validate
        $this->db->where('username',$username);
        $this->db->where('password',$enc_password);
        
        $result = $this->db->get('users');
        if($result->num_rows() == 1){
            return $result->row(0)->id;
        } else {
            return false;
        }
    }

	function add_non_member($param = array()) {
		
		$insert = $this->db->insert('non_members', $param);
		
		if ($insert) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	
	function get_members()
	{
		//get first payment info
		$this->db->from('members');
		$this->db->order_by('id');
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		
		return FALSE;
		
	}

	public function get_member_id($member){

        $this->db->where('names',$member);
        $this->db->from('members');

        $info = $this->db->get();

        if($info->num_rows > 0){

            return $info->row()->id;
        }
        else
            return FALSE;
    }

	function get_member_info($id)
	{
		//get first payment info
		$this->db->from('members');
		$this->db->where('id',$id);
		

		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		
		return FALSE;
		
	}

	function get_general_member_info()
	{
		//get first payment info
		$this->db->select('members.member_id, members.names, total_savings.amount_total, member_loan_info.balance, member_loan_info.total_amount,total_fines.total_fines,total_balances.total_balances');
		$this->db->from('members');
		$this->db->join('total_savings','members.member_id = total_savings.member_id','left');
		$this->db->join('member_loan_info','member_loan_info.member_id = members.member_id','left');
		$this->db->join('total_fines','total_fines.member_id = members.member_id','right');
		$this->db->join('total_balances','total_balances.member_id = members.member_id','right');
		$this->db->order_by('members.member_id');

		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else 
			return FALSE;
	}

	function get_general_member_infos()
	{
		//get first payment info
		$this->db->select('members.member_id, members.names, total_savings.amount_total, member_loan_info.balance, member_loan_info.total_amount,total_fines.total_fines,total_balances.total_balances');
		$this->db->from('members');
		$this->db->join('total_savings','members.member_id = total_savings.member_id','left');
		$this->db->join('member_loan_info','member_loan_info.member_id = members.member_id','left');
		$this->db->join('total_fines','total_fines.member_id = members.member_id','left');
		$this->db->join('total_balances','total_balances.member_id = members.member_id','left');
		$this->db->order_by('members.member_id');

		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else 
			return FALSE;
	}

	function get_general_non_member_info()
	{
		//get first payment info
		$this->db->select('non_member_loan_info.non_member_id, non_member_loan_info.non_member, non_member_loan_info.balance, non_member_loan_info.total_amount, non_members.contact');
		$this->db->from('non_member_loan_info');
		$this->db->join('non_members','non_members.id = non_member_loan_info.non_member_id','left');
		$this->db->order_by('non_member_loan_info.non_member_id');

		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else 
			return FALSE;
	}

	function get_general_non_member_information($id)
	{
		//get first payment info
		$this->db->select('non_member, non_member_id, amount, interest, interest_amount, total_amount, balance');
		$this->db->from('non_member_loan_info');
		$this->db->where('non_member_id',$id);
		$this->db->order_by('non_member_id');

		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return $result->row();
		}
		else 
			return FALSE;
	}

	function get_general_non_member_inform($id)
	{
		//get first payment info
		$this->db->select('non_member_loan_info.non_member, non_member_loan_info.balance, non_member_loan_info.total_amount');
		$this->db->from('non_member_loan_info');
		$this->db->where('non_member_id',$id);
		$this->db->order_by('non_member_loan_info.non_member_id');

		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else 
			return FALSE;
	}

	function get_non_members()
	{
		//get first payment info
		$this->db->from('non_members');
		$this->db->order_by('id');
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		
		return FALSE;
		
	}

	function get_member_names($id)
	{
		//get first payment info
		$result = $this->db->get_where('members', array('id' => $id));
		
		if ($result->num_rows() > 0) {
			return $result->row()->names;
		}
		
		return FALSE;
		
	}

	function get_non_member_names($id)
	{
		//get first payment info
		$result = $this->db->get_where('non_members', array('id' => $id));
		
		if ($result->num_rows() > 0) {
			return $result->row()->non_member;
		}
		
		return FALSE;
		
	}

	function get_member($member)
	{
		

		$result = $this->db->get_where('members', array('names' => $member));
		
		
		if ($result->num_rows() > 0) {
			return $result->row();
		}
		
		return FALSE;
		
	}

	function delete_user($user_id)
	{
		//get first payment info
		$delete = $this->db->delete('lend_admin', array('id' => $user_id));
		
		
		
		if ($delete) {
			return TRUE;
		}
		
		return FALSE;
	}


	function get_last_id()
	{
		//get last payment info
		$this->db->from('members');
		
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return  $result->row()->id;
		}
		
		return FALSE;
	}

}