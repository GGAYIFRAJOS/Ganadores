<?php

class Loan_model extends CI_Model {
	
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
	function chk_loan_exist($param = array()) {
		$exist = $this->db->get_where('lend_loan', $param);
		
		if ($exist->num_rows() > 0) {
			return $exist->row();
		} else {
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Check for any record from lend_borrower_loans table based on given parameters
	 * @param array $param
	 * @return boolean
	 */
	function chk_borrower_loan_exist($param = array()){
		$this->db->select('*, lend_borrower_loans.id as borrower_loan_id, lend_borrower_loan_settings.interest as interest');
		$this->db->from('lend_borrower_loans');
		$this->db->join('lend_borrower_loan_settings', 'lend_borrower_loans.id = lend_borrower_loan_settings.borrower_loan_id');
		$this->db->join('lend_borrower', 'lend_borrower.id = lend_borrower_loans.borrower_id');
		
		//if there's a filter specify, consider it
		count($param) > 0 ? $this->db->where($param) : NULL;
		
		$exist = $this->db->get();
		
		if ($exist->num_rows() > 0) {
			return $exist->row();
		} else {
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get record from lend_borrower_loans table based on given parameters
	 * @param array $param
	 * @return boolean
	 */
	function get_borrower_loans($param = array()) {
		$this->db->select('*, lend_borrower_loans.id as borrower_loan_id');
		$this->db->from('lend_borrower_loans');
		$this->db->join('lend_borrower', 'lend_borrower.id = lend_borrower_loans.borrower_id');
		
		//if there's a filter specify, consider it
		count($param) > 0 ? $this->db->where($param) : NULL;
		
		$exist = $this->db->get();
		
		if ($exist->num_rows() > 0) {
			return $exist;
		} else {
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Add entry in lend_loan table
	 * @param array $param
	 */
	

	function add_loan($member,$amount,$date,$member_id,$interest)
	{
		
		//$month_days = date('t',strtotime($date));
		
		$monthly_pay = $amount_interest;

		$total_amount = $amount;

		$due_date = strtotime('+1 month',strtotime($date));

		$due_date = date('Y-m-d',$due_date);
		
		$date = date('Y-m-d',strtotime($date));

		$max_id = $this->get_max_loan_id();


		if($max_id == 0){
			$loan_id = 1;
		}
		else{
			$loan_id = $max_id;
		}

		for($i = 1; $i < 25; $i++){

			$max_date = strtotime("+$i months",strtotime($date));

			$max_date = date('Y-m-d', $max_date);

			$range = $i;

			if($range == 1){

				$date_ranges = array(
					'member_id' => $member_id,
					'loan_id' => $loan_id,
					'max_date' => $max_date,
					'loan_range'=> $range,
					'range_balance' => $total_amount
				);

				$insert = $this->db->insert('loan_ranges', $date_ranges);
			}
			else{

				$date_ranges = array(
						'member_id' => $member_id,
						'loan_id' => $loan_id,
						'max_date' => $max_date,
						'loan_range'=> $range,

				);

				$insert = $this->db->insert('loan_ranges', $date_ranges);
			}

			
		}

		




		$data_transact = array(
		        	'member_id' =>$member_id,
		        	'names' => $member,
		        	'type' => 'loan_aquisition',
		        	'amount' => $amount,
		        	'date' => $date
		);

    	$insert = $this->db->insert('transactions', $data_transact);
		
		$insert = $this->db->insert('member_loan_info', array(
						'member_id' => $member_id,
						'amount' => $amount,
						'loan_date'=> $date,
						'names' => $member,
						'date' => $date,
						'interest' => $interest,
						'due_date' => $due_date,
						'balance'=> $total_amount
					));
		
		if ($insert) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function freeze_member_loan($id){

		$updates = $this->db->update('member_loan_info',array('status' => 'FROZEN'),array('member_id', $id));

		if($updates){
			return TRUE;
		}
		else
			return FALSE;
	}

	public function get_range_info($id,$range){

		$this->db->where('loan_id',$id);
		$this->db->where('loan_range', $range);
		$this->db->from('loan_ranges');

		$info = $this->db->get();

		if($info){
			return $info->row();
		}
		else{
			return FALSE;
		}
	}

	public function get_payment_range($id, $user_date){

		$info = $this->get_member_loan($id);

		$loan_date = $info->loan_date;

		//$original_date = $loan_date;

		
		//$date[0] = date('Y-m-d',strtotime($original_date));

		$end_date = strtotime("+24 months",strtotime($loan_date));

		$end_date = date('Y-m-d', $end_date);

		$ranges = $this->createDateRange($loan_date, $end_date);


		$date_range = 0;
	

		
		for($i = 1;$i<61;$i++){

			$date_range = $i;
		
			$start_date = $ranges[--$i];

			$end_date = $ranges[++$i];

			$date_range = $i;

			$start = strtotime($start_date);
			$end =   strtotime($end_date);
			$user =  strtotime($user_date);
			//$date_from_user = '2009-08-28';
			if(($user >= $start) && ($user <= $end)){
				break;
			}

			
		}

		if($date_range > 0)
			return $date_range;
		else
			return FALSE;
    }

    public function createDateRange($startDate, $endDate, $format = "Y-m-d"){

		    $begin = new DateTime($startDate);
		    $end = new DateTime($endDate);

		    $interval = new DateInterval('P1M'); // 1 Month
		    $dateRange = new DatePeriod($begin, $interval, $end);

		    $range = [];
		    foreach ($dateRange as $date) {
		        $range[] = $date->format($format);
		    }

		    return $range;
	}


	public function get_first_range_balance($loan_id,$id){

		$this->db->where('loan_id', $loan_id);
		$this->db->where('member_id', $id);
		$this->db->where('loan_range',1);
		$this->db->from('loan_ranges');

		$bal = $this->db->get();

		if($bal->num_rows > 0){
			return $bal->row();
		}
		else
			return FALSE;
	}

	function add_non_member($name,$amount,$adress,$email,$contact,$date,$interest)
	{
		
		//interest
		$amount_interest = $amount * $interest/100;
		
		
		$monthly_pay = $amount_interest;

		$total_amount = $amount + $monthly_pay;

		$due_date = strtotime('+1 month',strtotime($date));

		$due_date = date('Y-m-d',$due_date);
		
		$date = date('Y-m-d',strtotime($date));

		$nxt_id = $this->get_last_non_mem_id();

		if($nxt_id > 0){
			$range_mem_id = $nxt_id + 1 ;
		}
		else{
			$range_mem_id = 1;
		}

		$data_transact = array(
		        	'non_member_id' =>$range_mem_id,
		        	'names' => $name,
		        	'type' => 'loan_aquisition',
		        	'amount' => $amount,
		        	'date' => $date
		);

    	$insert = $this->db->insert('non_member_transactions', $data_transact);



		$insert = $this->db->insert('non_members', array(
						'id' => $range_mem_id,
						'non_member'=> $name,
						'adress' => $adress,
						'email' => $email,
						'contact' => $contact
					));
		
		$insert = $this->db->insert('non_member_loan_info', array(
						'non_member_id' => $range_mem_id,
						'non_member'=> $name,
						'amount' => $amount,
						'loan_date'=> $date,
						'date' => $date,
						'due_date' => $due_date,
						'interest' => $interest,
						'interest_amount'=>$amount_interest,
						'monthly_pay' => $monthly_pay,
						'balance'=> $total_amount
					));

		
		if ($insert) {
			return TRUE;
		} else {
			return FALSE;
		}
	}


	public function delete_loan_member($id){

		$delete = $this->db->delete('member_loan_info',array('member_id' => $id));

		$delete = $this->db->delete('payments',array('member_id' => $id));

		$delete = $this->db->delete('transactions',array('member_id' => $id,'type'=>'loan_aquisition'));

		$delete = $this->db->delete('transactions',array('member_id' => $id,'type'=>'loans_payment'));

		if($delete > 0){
			return TRUE;
		}
		else
			return FALSE;
	}

	public function delete_loan_non_member($id){

		$delete = $this->db->delete('non_members',array('id' => $id));

		$delete = $this->db->delete('non_member_loan_info',array('non_member_id' => $id));

		$delete = $this->db->delete('non_member_payments',array('non_member_id' => $id));

		$delete = $this->db->delete('non_member_transactions',array('non_member_id' => $id,'type'=>'loan_aquisition'));

		$delete = $this->db->delete('non_member_transactions',array('non_member_id' => $id,'type'=>'loans_payment'));

		if($delete > 0){
			return TRUE;
		}
		else
			return FALSE;
	}


	public function member_payment($name,$amount,$date,$borrower_id){


		$amounts= $this->get_member_loan($borrower_id);

		$amount_paid_prev = $amounts->total_amount;

		$amount_total = $amounts->balance;

		$amount_paid_total = $amount_paid_prev + $amount;

		$balance = $amount_total - $amount;

		$pay_id = $this->Savings_model->get_max_payment_id();

		if($pay_id){
			$payment_id = $pay_id + 1;
		}
		else
			$payment_id = 1;

		$info = $this->get_member_loan($borrower_id);

		$loan_date = $info->loan_date;
		$loan_month = date("m",strtotime($loan_date));
		$loan_days = date("d",strtotime($loan_date));

		$payment_month =  date("m",strtotime($date));
		$payment_days =  date("d",strtotime($date));

		$loan_date = $info->loan_date;

		if($payment_days > $loan_days){
			if($payment_month - $loan_month){
				$range = ($payment_month - $loan_month) + 1;
			}
			else{
				$range = ($loan_month - $payment_month) + 1;
			}
			

			$last_sched_date = strtotime("+$range months",strtotime($loan_date));

			$last_sched_date = date('Y/m/d',$last_sched_date);

			$prev_range = $range - 1;

			$prev_sched_date = strtotime("+$prev_range months",strtotime($loan_date));

			$prev_sched_date = date('Y/m/d',$prev_sched_date);

			$range_dates = "$prev_sched_date - $last_sched_date";

			$balance = $amounts->balance - $amount;


			$payment_data = array(
				'names' => $name,
				'member_id' => $borrower_id,
				'payment_amount'=> $amount,
				'payment_date' => $date,
				'membership' => 'member',
				'type' => 'loans_payment',
				'balance' => $balance
			);

			$insert = $this->db->insert('payments',$payment_data);

			$data = array(
			'amount_paid' => $amount,
			'total_amount' => $amount_paid_total,
			'balance' => $balance
			);

			$this->db->update('member_loan_info',$data,array('member_id'=>$borrower_id));
		}
		else{
			if($payment_month - $loan_month){
				$range = ($payment_month - $loan_month);
			}
			else{
				$range = ($loan_month - $payment_month);
			}

			$last_sched_date = strtotime("+$range months",strtotime($loan_date));

			$last_sched_date = date('Y/m/d',strtotime($last_sched_date));

			$prev_range = $range - 1;

			$prev_sched_date = strtotime("+$prev_range",strtotime($loan_date));

			$prev_sched_date = date('Y/m/d',strtotime( $prev_sched_date));

			$range_dates = "from $prev_sched_date to $last_sched_date";

			$balance = $amounts->balance - $amount;


			$payment_data = array(
				'names' => $name,
				'member_id' => $borrower_id,
				'payment_amount'=> $amount,
				'payment_date' => $date,
				'membership' => 'member',
				'type' => 'loans_payment',
				'balance' => $balance
			);

			$insert = $this->db->insert('payments',$payment_data);

			$data = array(
			'amount_paid' => $amount,
			'total_amount' => $amount_paid_total,
				'balance' => $balance
			);

			$this->db->update('member_loan_info',$data,array('member_id'=>$borrower_id));

		}

		if($insert){
			return TRUE;
		}
		else
			return FALSE;

	}

	public function non_member_payment($name,$amount,$date,$borrower_id){

		$amounts= $this->get_non_member_amount_paid($borrower_id);

		$amount_paid_prev = $amounts->total_amount;

		$amount_total = $amounts->balance;

		$amount_paid_total = $amount_paid_prev + $amount;

		$balance = $amount_total - $amount;

		


		if($pay_id){
			$payment_id = $pay_id + 1;
		}
		else
			$payment_id = 1;

		$payment_data = array(
			'names' => $name,
			'member_id' => $borrower_id,
			'payment_amount'=> $amount,
			'payment_date' => $date,
			'membership' => 'non_member',
			'type' => 'loans_payment'
		);

		$this->db->insert('payments',$payment_data);


		$info = $this->get_non_member_loan($id);

		$loan_date = $info->loan_date;

		$loan_days = date('d',strtotime($loan_date));

		$loan_month = date('m',strtotime($loan_date));

		$payment_days = date('d',strtotime($date));

		$payment_month = date('m',strtotime($date));

		if($payment_days > $loan_days){

			$range = ($payment_month - $loan_month) + 1;

			$last_sched_date = strtotime("+$range months",strtotime($loan_date));

			$last_sched_date = date('Y/m/d',$last_sched_date);

			$prev_range = $range - 1;

			$prev_sched_date = strtotime("+$prev_range",strtotime($loan_date));

			$prev_sched_date = date('Y/m/d',$prev_sched_date);

			$range_dates = "$prev_sched_date - $last_sched_date";

			$balance = $info->total_amount - $amount;


			
		}
		else{
			$range = ($payment_month - $loan_month);

			$last_sched_date = strtotime("+$range months",strtotime($loan_date));

			$last_sched_date = date('Y/m/d',$last_sched_date);

			$prev_range = $range - 1;

			$prev_sched_date = strtotime("+$prev_range",strtotime($loan_date));

			$prev_sched_date = date('Y/m/d',$prev_sched_date);

			$range_dates = "from $prev_sched_date to $last_sched_date";


			
		}




		if($amount_paid_total == $amount_total){

			$data = array(
				'amount_paid' => $amount,
				'total_amount' => $amount_paid_total,
				'balance' => 0,
				'status' => 'PAID'
			);
			$this->db->where('non_member_id',$borrower_id);
			$this->db->update('non_member_loan_info',$data);

			
		}
		else{

			$data = array(
				'amount_paid' => $amount,
				'total_amount' => $amount_paid_total,
				'balance' => $balance
			);

			$this->db->where('non_member_id',$borrower_id);
			$this->db->update('non_member_loan_info',$data);

			
		}

		
		if($insert){
			return TRUE;
		}
		else
			return FALSE;

	}



	public function get_member_amount_paid($member_id){
		$this->db->from('member_loan_info');
		
		$this->db->where('member_id',$member_id);
		
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return  $result->row();
		}
	}



	public function check_system_balance($amount){

		$member_loans = $this->get_member_amount_owed();

		$non_member_loans = $this->get_non_member_amount_owed();

		$savings = $this->Savings_model->select_total_payments();

		$Total_loans = $member_loans + $non_member_loans;

		if(($amount + $Total_loans) < $savings){
			return TRUE;
		}
		else
			return FALSE;


	}

	public function check_loan_exist_member($id){
		$this->db->from('member_loan_info');
		$this->db->where('member_id',$id);
		$result = $this->db->get();


		if($result->num_rows > 0){
			return TRUE;
		}
		else
			return FALSE;
	}

	public function check_loan_exist_non_member($names){
		$this->db->from('non_member_loan_info');
		$this->db->where('non_member',$names);
		$result = $this->db->get();


		if($result->num_rows > 0){
			return TRUE;
		}
		else
			return FALSE;
	}



	public function get_non_member_amount_paid($member_id){
		$this->db->from('non_member_loan_info');
		
		$this->db->where('non_member_id',$member_id);
		
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return  $result->row();
		}
	}

	public function get_member_amount_owed(){

		$this->db->select_sum('balance');

		$this->db->from('member_loan_info');
		
		$result = $this->db->get();
		
		if ($result) {
			return  $result->row()->balance;
		}
	}

	public function get_non_member_amount_owed(){

		$this->db->select_sum('balance');

		$this->db->from('non_member_loan_info');
		
		$result = $this->db->get();
		
		if ($result) {
			return  $result->row()->balance;
		}
	}

	public function get_member_amount_total($member_id){
		$this->db->from('member_loan_info');
		
		$this->db->where('member_id',$member_id);
		
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return  $result->row()->amount_paid;
		}
	}

	public function get_non_member_amount_total($member_id){
		$this->db->from('non_member_loan_info');
		
		$this->db->where('non_member_id',$member_id);
		
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return  $result->row()->amount_paid;
		}
	}


	public function get_last_non_mem_id()
	{
		//get last payment info
		$this->db->from('non_members');
		
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return  $result->row()->id;
		}
		
		return FALSE;
	}


	// public function get_member_payment(){

	// 	$this->db->from('member_payments');
		
	// 	$result = $this->db->get();
		
	// 	if ($result->num_rows() > 0) {
	// 		return  $result->result();
	// 	}
		
	// 	return FALSE;
	// }


	public function get_member_payments($id){

		$this->db->where('member_id',$id);
		$this->db->where('status', 'not_fined');
		$this->db->where('membership', 'member');
		$this->db->order_by('payment_date', 'ASC');
		$this->db->from('payments');
		
		$result = $this->db->get();
		
		if($result->num_rows() > 0) {
			return  $result->result();
		}
		else
			return FALSE;
	}

	public function get_non_member_payments($id){

		$this->db->where('non_member_id',$id);
		$this->db->where('status', 'not_fined');
		$this->db->where('membership', 'non_member');
		$this->db->order_by('payment_date', 'ASC');
		$this->db->from('payments');
		
		$result = $this->db->get();
		
		if($result->num_rows() > 0) {
			return  $result->result();
		}
		else
			return FALSE;
	}

	public function get_member_payments_print($id){

		$this->db->where('member_id',$id);
		$this->db->from('payments');
		
		$result = $this->db->get();
		
		if($result->num_rows() > 0) {
			return  $result->result();
		}
		else
			return FALSE;
	}


	public function get_member_payment($id){

		$this->db->where('id',$id);
		$this->db->where('membership','member');
		$this->db->from('payments');
		
		$result = $this->db->get();
		
		if($result->num_rows() > 0) {
			return  $result->row();
		}
		else
			return FALSE;

	}

	// public function get_non_member_payments($id){

	// 	$this->db->where('id',$id);
	// 	$this->db->where('membership','non_member');
	// 	$this->db->from('payments');
		
	// 	$result = $this->db->get();
		
	// 	if($result->num_rows() > 0) {
	// 		return  $result->row();
	// 	}
	// 	else
	// 		return FALSE;

	// }


	public function get_non_member_payment(){

		$this->db->from('payments');
		$this->db->where('membership','non_member');
		
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return  $result->result();
		}
		
		return FALSE;
	}

	public function get_member_loan($id){

		$this->db->where('member_id',$id);
		$this->db->from('member_loan_info');

        $loans = $this->db->get();
        

 

        if($loans->num_rows > 0){
            return $loans->row();
        }
    }

    public function get_member_loans($id){

		$this->db->where('member_id',$id);
		$this->db->from('member_loan_info');

        $loans = $this->db->get();
        

 

        if($loans->num_rows > 0){
            return $loans->result();
        }
    }

    public function get_non_member_loan($id){
        $this->db->where('non_member_id',$id);
        $this->db->from('non_member_loan_info');

        $loans = $this->db->get();

        if($loans->num_rows > 0){
            return $loans->row();
        }
    }


    public function get_loan_prog($id){
    	$progress = $this->db->get_where('loan_progress_update',array('identification_id' => $id, 'membership' => 'member'));

    	if($progress->num_rows > 0){
    		return $progress->result();
    	}
    	else
    		return FALSE;
    }

    public function get_non_loan_prog($id){
    	$progress = $this->db->get_where('loan_progress_update',array('identification_id' => $id, 'membership' => 'non_member'));

    	if($progress->num_rows > 0){
    		return $progress->result();
    	}
    	else
    		return FALSE;
    }
	
	// --------------------------------------------------------------------
	
	function edit($param = array(), $id) {
		$update = $this->db->update('lend_loan', $param, array('id' => $id));
		
		if ($update) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function get_max_loan_id(){

		$this->db->from('member_loan_info');
		
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return  $result->row()->id;
		}
		
		return FALSE;
	}


	public function get_max_non_loan_id(){

		$this->db->from('non_member_loan_info');
		
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return  $result->row()->id;
		}
		
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	
	// --------------------------------------------------------------------
	
	/**
	 * View entries in lend_loan table
	 */
	function get_loans_members()
	{
		
		$this->db->where('status', 'NOT PAID');
		$this->db->order_by('member_id');
		$return = $this->db->get('member_loan_info');
			
		if($return->num_rows() > 0) {
			return $return->result();
		} else {
			return FALSE;
		}
	}

	function get_loans_gen_members()
	{
		
		$this->db->order_by('member_id');
		$return = $this->db->get('member_loan_info');
			
		if($return->num_rows() > 0) {
			return $return->result();
		} else {
			return FALSE;
		}
	}

	function get_loan_member($id)
	{
		$this->db->where('member_id',$id);
		$return = $this->db->get('member_loan_info');
			
		if($return > 0) {
			return $return->row();
		} else {
			return FALSE;
		}
	}

	// function get_loans_amount(){

	// 	$date_today = date('Y-m-d');


 //        $CI =& get_instance();

	// 	$nxt_id = $CI->Loan_model->get_loans_members();

	// }


	 
	function get_loans_non_members()
	{
		
		$this->db->where('status', 'NOT PAID');
		$this->db->order_by('id');
		$return = $this->db->get('non_member_loan_info');
			
		


		if ($return->num_rows() > 0) {
			return $return->result();
		} else {
			return FALSE;
		}
	}
	

	function get_loans_gen_non_members()
	{
		
		
		$this->db->order_by('id');
		$return = $this->db->get('non_member_loan_info');
			
		


		if ($return->num_rows() > 0) {
			return $return->result();
		} else {
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Calculate payments made
	 */
	function payments_made($loan_id)
	{
		$this->db->select('sum(amount_t) as total');
		$amount = $this->db->get_where('lend_payments', array('borrower_loan_id' => $loan_id));
		
		if ($amount->num_rows() > 0) {
			$amount = $amount->row();
			
			return $amount->total;
		} else {
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Calculate next paymentinfo
	 */
	function next_payment($borrower_loan_id)
	{
		$this->db->order_by('payment_sched');
		$loan = $this->db->get_where('lend_payments', array('borrower_loan_id' => $borrower_loan_id, 'status' => 'UNPAID'));


		
		if ($loan->num_rows() > 0) {
			$loan = $loan->row();
			
			return $loan;
		} else {
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * View entries in lend_loan table
	 */
	function view_transactions($loan_id)
	{
		$this->db->select('*, lend_transactions.id as transaction_id, lend_transactions.rdate as transaction_date,lend_payments.id  as payment_number');
		$this->db->from('lend_transactions');
		$this->db->join('lend_payments', 'lend_transactions.payment_id = lend_payments.id');
		$this->db->join('lend_admin', 'lend_admin.id = lend_transactions.admin_id');
		$this->db->where(array('lend_payments.borrower_loan_id' => $loan_id));
		$this->db->order_by('lend_transactions.rdate');
		
		return $this->db->get();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get all overdue payments
	 */
	
	 function get_due_payments()
	{
		$due = $this->db->query(
			'
			SELECT c.fname, c.lname, c.id as \'borrower_id\', a.id as \'borrower_loan_id\', b.amount, b.payment_number, b.payment_sched ,a.loan_amount_interest,a.loan_amount as principals,  b.rdate, b.Balance
			FROM lend_borrower_loans a 
			INNER JOIN lend_payments b
			  ON a.id = b.borrower_loan_id
			INNER JOIN lend_borrower c
			  ON a.borrower_id = c.id
			WHERE b.payment_sched < DATE(NOW())
			  AND a.status = \'ACTIVE\'
			  AND b.status = \'UNPAID\'
			
			'
		);

		
		if ($due->num_rows() > 0) {
			return $due;
		} else {
			return FALSE;
		}
	}



	
	function get_due_payments_now()
	{
		$due = $this->db->query(
			'
			SELECT c.fname, c.lname, c.id as \'borrower_id\', a.id as \'borrower_loan_id\', b.amount, b.Balance, b.payment_number, b.payment_sched 
			FROM lend_borrower_loans a 
			INNER JOIN lend_payments b
			  ON a.id = b.borrower_loan_id
			INNER JOIN lend_borrower c
			  ON a.borrower_id = c.id
			WHERE b.payment_sched = DATE(NOW())
			  AND a.status = \'ACTIVE\'
			  AND b.status = \'UNPAID\'
			'
		);
		
		if ($due->num_rows() > 0) {
			return $due;
		} else {
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get all due payments on current week
	 */
	function get_due_payments_week()
	{
		$due = $this->db->query(
			'
			SELECT c.fname, c.lname, c.id as \'borrower_id\', a.id as \'borrower_loan_id\', b.amount, b.payment_number, b.payment_sched 
			FROM lend_borrower_loans a 
			INNER JOIN lend_payments b
			  ON a.id = b.borrower_loan_id
			INNER JOIN lend_borrower c
			  ON a.borrower_id = c.id
			WHERE WEEK(b.payment_sched) + YEAR(b.payment_sched) = WEEK(NOW()) + YEAR(NOW())
			  AND a.status = \'ACTIVE\'
			  AND b.status = \'UNPAID\'
			'
		);
		
		if ($due->num_rows() > 0) {
			return $due;
		} else {
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * View payments overview
	 * 
	 */
	function payments_overview($loan_id)
	{
		
		$this->db->select("*, datediff(NOW(), lend_payments.payment_sched) as is_due", FALSE);
		$this->db->from('lend_payments');
		$this->db->join('lend_borrower', 'lend_payments.borrower_id = lend_borrower.id');
		$this->db->where(array('lend_payments.borrower_loan_id' => $loan_id));
		$this->db->order_by('lend_payments.payment_number');
		$info = $this->db->get();

		if ($info->num_rows() > 0) {
			return $info;
		} else {
			return FALSE;
		}
	}


	// --------------------------------------------------------------------
	
	/**
	 * Get unpaid payments
	 * 
	 */
	function unpaid_payments($loan_id)
	{
		$this->db->select("*, datediff(NOW(), lend_payments.payment_sched) as is_due, lend_payments.id as payment_id", FALSE);
		$this->db->from('lend_payments');
		$this->db->join('lend_borrower', 'lend_payments.borrower_id = lend_borrower.id');
		$this->db->where(array('lend_payments.borrower_loan_id' => $loan_id, 'lend_payments.status' => 'UNPAID'));
		$this->db->order_by('lend_payments.payment_number');
		$info = $this->db->get();

		if ($info->num_rows() > 0) {
			return $info;
		} else {
			return FALSE;
		}
	}
	
}
