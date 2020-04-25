<?php 



class Transactions_model extends CI_Model {

	public function get_members_transactions(){

		$this->db->from('transactions');
		$this->db->order_by('date','DESC');
		$transactions = $this->db->get();

		if($transactions->num_rows > 0){
			return $transactions->result();
		}
		return FALSE;
	}

	public function get_member_transactions2(){

		$names = $this->session->userdata('user_name');

		$this->db->from('transactions');
		$this->db->where('names',$names);
		$this->db->order_by('date','DESC');
		$transactions = $this->db->get();

		if($transactions->num_rows > 0){
			return $transactions->result();
		}
		return FALSE;
	}

	public function get_member_transactions($year,$id){
		$query = $this->db->query("SELECT * FROM transactions WHERE `member_id` = '$id' AND `date` BETWEEN '$year-01-01' AND '$year-12-31'");

		if($query){
			return $query->result();
		}
		return FALSE;
	}

	public function get_member_transact($year){
		$query = $this->db->query("SELECT * FROM transactions WHERE `date` BETWEEN '$year-01-01' AND '$year-12-31'");

		if($query){
			return $query->result();
		}
		return FALSE;
	}


	public function get_non_members_transactions(){

		$this->db->from('non_member_transactions');
		$this->db->order_by('date','DESC');
		$non_transactions = $this->db->get();

		if($non_transactions->num_rows > 0){
			return $non_transactions->result();
		}
		return FALSE;
	}


	public function get_non_member_transactions($year,$id){
		
		$query = $this->db->query("SELECT * FROM non_member_transactions WHERE `non_member_id` = '$id' AND `date` BETWEEN '$year-01-01' AND '$year-12-31'");

		if($query){
			return $query->result();
		}
		return FALSE;
	}


	public function get_non_member_transact($year){
		
		$query = $this->db->query("SELECT * FROM non_member_transactions WHERE `date` BETWEEN '$year-01-01' AND '$year-12-31'");

		if($query){
			return $query->result();
		}
		return FALSE;
	}


}



?>