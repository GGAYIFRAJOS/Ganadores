<?php 



class Payments_model extends CI_Model {



	public function get_payments_general($year){

		$query = $this->db->query("SELECT * FROM payments WHERE `payment_date` BETWEEN '$year-01-01' AND '$year-12-31' ORDER BY payment_date DESC");

		if($query){
			return $query->result();
		}
		return FALSE;
	}


}

?>