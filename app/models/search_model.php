<?php

class Search_model extends CI_Model {
	
	// --------------------------------------------------------------------
	
	/**
	 * Constructor. Instantiate CI to load database class.
	 * 
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Search record from lend_borrower_loans table based on given parameters
	 * @param array $param
	 * @return boolean
	 */
	function search($param = array()) {
		$this->db->select('*, lend_borrower_loans.id as borrower_loan_id, lend_borrower_loan_settings.interest as loan_name, lend_borrower.id as fborrower_id');
		$this->db->from('lend_borrower_loans');
		$this->db->join('lend_borrower_loan_settings', 'lend_borrower_loans.id = lend_borrower_loan_settings.borrower_loan_id');
		$this->db->join('lend_borrower', 'lend_borrower.id = lend_borrower_loans.borrower_id', 'RIGHT');
		
		//if there's a filter specify, consider it
		count($param) > 0 ? $this->db->where($param) : NULL;
		
		$exist = $this->db->get();
		
		if ($exist->num_rows() > 0) {
			return $exist;
		} else {
			return FALSE;
		}
	}
	
}