<?php

class Borrower_model extends CI_Model {
	
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
	 * Check for any record from lend_loan table based on given parameters
	 * @param array $param
	 * @return boolean
	 */
	function chk_borrower_exist($param = array()) {
		$exist = $this->db->get_where('lend_borrower', $param);
		
		if ($exist->num_rows() > 0) {
			return $exist->row();
		} else {
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Add entry in lend_loan table
	 * @param array $param
	 */
	function add($param = array()) {
		$this->db->set('rdate', 'NOW()', FALSE);
		
		$insert = $this->db->insert('lend_borrower', $param);
		
		if ($insert) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	function edit($param = array(), $id) {
		$update = $this->db->update('lend_borrower', $param, array('id' => $id));
		
		if ($update) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function delete($id) {
		$delete1 = $this->db->delete('lend_borrower', array('id' => $id));

		$delete2 = $this->db->delete('lend_borrower_loans', array('borrower_id' => $id));

		$delete3 = $this->db->delete('lend_borrower_loan_settings', array('borrower_id' => $id));

		$delete4 = $this->db->delete('lend_loan', array('borrower_id' => $id));

		$delete5 = $this->db->delete('lend_logs', array('borrower_id' => $id));

		$delete6 = $this->db->delete('lend_payments', array('borrower_id' => $id)); 

		$delete7 = $this->db->delete('lend_transactions', array('borrower_id' => $id));
		
		if ($delete1 && $delete2 && $delete3 && $delete6) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function delete_loan($id) {

		$delete2 = $this->db->delete('lend_borrower_loans', array('borrower_id' => $id));

		$delete3 = $this->db->delete('lend_borrower_loan_settings', array('borrower_id' => $id));

		$delete4 = $this->db->delete('lend_loan', array('borrower_id' => $id));

		$delete5 = $this->db->delete('lend_logs', array('borrower_id' => $id));

		$delete6 = $this->db->delete('lend_payments', array('borrower_id' => $id)); 

		$delete7 = $this->db->delete('lend_transactions', array('borrower_id' => $id));
		
		if ($delete2 && $delete3 && $delete6) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
		
	// --------------------------------------------------------------------
	
	/**
	 * View entries in lend_borrower table
	 */
	function view_all()
	{
		$this->db->order_by('lname, fname');
		$return = $this->db->get('lend_borrower');
		
		return $return;
	}
	
	// --------------------------------------------------------------------
	
	function get_borrower_loan($borrower_id)
	{
		$this->db->order_by('id');
		$result = $this->db->get_where('lend_borrower_loans', array('borrower_id' => $borrower_id));
		
		if ($result->num_rows() > 0)
		{
			return $result;
		} else {
			return FALSE;		
		}
	}

	// --------------------------------------------------------------------
	
	function get_datails($borrower_loan_id)
	{
		//$result = $this->db->get_where('lend_borrower_loans', array('id' => $borrower_loan_id));

		$this->db->select('*, lend_borrower_loans.id as borrower_loan_id, lend_borrower_loan_settings.interest as loan_name');
		$this->db->from('lend_borrower_loans');
		$this->db->join('lend_borrower_loan_settings', 'lend_borrower_loans.id = lend_borrower_loan_settings.id');
		$this->db->join('lend_borrower', 'lend_borrower.id = lend_borrower_loans.borrower_id');
		$this->db->where('lend_borrower_loans.id', $borrower_loan_id);
		$result = $this->db->get();

		if ($result->num_rows() > 0)
		{
			return $result->row();
		} else {
			return FALSE;		
		}
	}

	function get_datails2($borrower_id)
	{
		//$result = $this->db->get_where('lend_borrower_loans', array('id' => $borrower_loan_id));

		$this->db->select('*, lend_borrower_loans.id as borrower_loan_id, lend_borrower_loan_settings.interest as loan_name,lend_borrower_loans.loan_type as ln_type');
		$this->db->from('lend_borrower_loans');
		$this->db->join('lend_borrower_loan_settings', 'lend_borrower_loans.borrower_id = lend_borrower_loan_settings.borrower_id');
		$this->db->join('lend_borrower', 'lend_borrower.id = lend_borrower_loans.borrower_id');
		$this->db->join('lend_payments', 'lend_borrower_loans.borrower_id = lend_payments.borrower_id');
		$this->db->where('lend_borrower_loans.borrower_id', $borrower_id);
		$result = $this->db->get();

		if ($result->num_rows() > 0)
		{
			return $result->row();
		} else {
			return FALSE;		
		}
	}

	// --------------------------------------------------------------------
	
	function get_name($borrower_id)
	{
		$result = $this->db->get_where('lend_borrower', array('id' => $borrower_id));
		
		if ($result->num_rows() > 0)
		{
			$borrower = $result->row();
			
			return $borrower->lname . ', ' . $borrower->fname . ' ' . $borrower->mi;
		} else {
			return FALSE;		
		}
	}
	
	// --------------------------------------------------------------------
	
	function add_loan($param = array())
	{
		//set Time Zone
		//date_default_timezone_set('East Africa Time');
		
		$amount = $param['loan_amount'];
		$days = $param['loan_days'];
		$interest = $param['loan_interest'];
		$type = $param['loan_type'];

		//get loan parameters
		$loan = $this->Loan_model->chk_loan_exist(array('id' => $param['borrower_id']));
		
		//divisor
		switch ($type) {
			case "Daily":
				$divisor = $days;
				break;
			case "Weekly":
				$divisor = ($days/7);
				break;
			case "Full":
				$divisor = 1;
				break;
		}
		
		//interest
		$amount_interest = $amount * $interest/100;
		
		//total payments applying interest
		$amount_total = $amount + $amount_interest;
		
		//payment per term
		$amount_term = ($amount_total/$divisor);
		
		
		
		//additional info to be insert
		$add_info = array(
						'loan_amount_interest' => $amount_interest,
						'loan_amount_term' => $amount_term,
						'loan_amount_total' => $amount_total,
						'loan_type'=>$type
						
					);
					
		$param = array_merge($param, $add_info);
		
		$insert = $this->db->insert('lend_borrower_loans', $param);
		
		//borrower_loan_id
		$id = $this->db->insert_id();
		
		//copy loan parameters to lend_borrower_loan_settings table
		
		
		//insert each payment records to lend_payments
		if($type =='Daily') {
			
			$today = date('Y-m-d'); 
			
			$loan_day = date('d', strtotime($today));

			$frequency = 0;
			
			$x = 1;

			$nom = 0;

			for ($i = 1; $i <= $divisor+$nom; $i++)
			{
				$frequency = $i;
				
				$newdate = strtotime ('+'.$frequency.' days', strtotime ($today)) ;

				//check if payment date landed on weekend
				//if Sunday, make it Monday. If Saturday, make it Friday
				if(date('D', $newdate) == 'Sun') {
					$newdate = strtotime('+1 day', $newdate) ;
					$i++;
					$nom++;
				} 

				$newdate = date('Y-m-d', $newdate );
				
				$this->db->insert(
					'lend_payments', array(
						'borrower_id' => $param['borrower_id'],
						'borrower_loan_id' => $id,
						'payment_sched' => $newdate,
						'payment_number' => $x++,
						'amount' => $amount_term,
						'Balance'=>$amount_term
					)
				);


				$this->db->insert(
				'lend_borrower_loan_settings', array(
				'borrower_id' =>$param['borrower_id'],
				'borrower_loan_id' => $id,
				'interest' => $param['loan_interest'],
				'borrower_days' => $days,
				
					)
				);

				
			//	$this->db->update('lend_loan', array('late_fee' =>( $amount_term*$interest)), array('borrower_loan_id' => $id));
			}
			
			$this->db->update('lend_borrower_loans',array('payment_date'=>$newdate),array('borrower_id' => $param['borrower_id']));
			//$this->db->update('lend_borrower_loans',array('borrower_loan_id'=>$id),array('id' => $param['borrower_id']));
			
		}
		else if($type == 'Weekly'){
			$today = date('Y-m-d'); 
			
			

			$frequency = 0;

			for ($i = 1; $i <= $divisor; $i++)
			{
				$frequency += 7;
				$newdate = strtotime ('+'.$frequency.' days', strtotime ($today)) ;



				$newdate = date('Y-m-d', $newdate );
				
				$this->db->insert(
					'lend_payments', array(
						'borrower_id' => $param['borrower_id'],
						'borrower_loan_id' => $id,
						'payment_sched' => $newdate,
						'payment_number' => $i,
						'amount' => $amount_term,
						'Balance'=>$amount_term
					)
				);
				//$table = $table . '<tr><td>'.$i.'</td><td>'.$amount_term.'</td><td>'.$newdate.'</td></tr>';

				$this->db->insert(
			'lend_borrower_loan_settings', array(
				'borrower_id' =>$param['borrower_id'],
				'borrower_loan_id' => $id,
				'interest' => $param['loan_interest'],
				'borrower_days' => $days
				
				
			)
		);	


				
			//$this->db->update('lend_loan', array('late_fee' => ($amount_term*$interest)), array('borrower_loan_id' => $id));
			}
		$this->db->update('lend_borrower_loans',array('payment_date'=>$newdate),array('borrower_id' => $param['borrower_id']));

		//$this->db->update('lend_borrower_loans',array('borrower_loan_id'=>$id),array('id' => $param['borrower_id']));

		}
		else{
			
			$today = date('Y-m-d'); 
			
			$i = 1;

			$newdate = strtotime ('+'.$days.' days', strtotime ($today)) ;

			$newdate = date('Y-m-d', $newdate );

			
			$this->db->insert(
					'lend_payments', array(
						'borrower_id' => $param['borrower_id'],
						'borrower_loan_id' => $id,
						'payment_sched' => $newdate,
						'payment_number' => $i,
						'amount' => $amount_total,
						'Balance'=>$amount_term
					)
				);


			$this->db->insert(
			'lend_borrower_loan_settings', array(
				'borrower_id' => $param['borrower_id'],
				'borrower_loan_id' => $id,
				'interest' => $param['loan_interest'],
				'borrower_days' => $days
				
			)
		);
		// $this->db->update('lend_loan', array('late_fee' =>( $amount_term*$interest)), array('borrower_loan_id' => $id));

		//$table = $table . '<tr><td>'.$i.'</td><td>'.$amount_term.'</td><td>'.$newdate.'</td></tr>';

			
		$this->db->update('lend_borrower_loans',array('payment_date'=>$newdate),array('id' => $param['borrower_id']));
		$this->db->update('lend_borrower_loans',array('borrower_loan_id'=>$id),array('id' => $param['borrower_id']));
			
		}
		
		//get next payment id and insert to lend_borrower_loans.next_payment_id
		$payment = $this->Loan_model->next_payment($id);
		$this->db->update('lend_borrower_loans', array('next_payment_id' => $payment->id), array('id' => $id));
		
		if ($insert) {
			return TRUE;
		} else {
			return FALSE;
		}
	}


	// --------------------------------------------------------------------
	
	function hasActiveLoan($borrower_id)
	{
		$result = $this->db->get_where('lend_borrower_loans', array('borrower_id' => $borrower_id, 'status' => 'ACTIVE'));
		
		if ($result->num_rows() > 0)
		{
			return TRUE;
		} else {
			return FALSE;		
		}
	}



	
}