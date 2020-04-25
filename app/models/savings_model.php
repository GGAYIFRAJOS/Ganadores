<?php

class Savings_model extends CI_Model {
	
	// --------------------------------------------------------------------
	
	/**
	 * Constructor. Instantiate CI to load database class.
	 * 
	 */
	function __construct()
	{
		parent::__construct();

	}

	

	
	
	// --------------------------------------------------------------------------------------------------------------------------------------------

	public function add_savings($member,$amount,$date,$id){

		$append = $amount;

	 	$original_date = '2019-06-06';

	 	$after_range = 0;
        
        $newDate = date("Y-m-d", strtotime($date));

        $this->load->model('Dates_model');

		$date_range = $this->Dates_model->calculate_range($newDate);

		$date_forward_range =  $date_range ; 

		$double_forward =  $date_range + 1;   

		$total_amt = $this->calculate_savings_amount($id,$date_range);

		$total_amount = $total_amt->total_paid;

		$savings_sched = strtotime("+$date_forward_range months", strtotime($original_date));

		$next_savings_sched = strtotime("+$double_forward months", strtotime($original_date));

		$saving_sched = date('Y-m-d',$savings_sched);

		$next_savings_sched = date('Y-m-d',$next_savings_sched);

		$newer_range = 0;

		

		$pay_id = $this->get_max_payment_id();

		if($pay_id){
			$payment_id = $pay_id + 1;
		}
		else
			$payment_id = 1;

		$date = date('Y-m-d',strtotime($date));

		$payment_data = array(
			'names' => $member,
			'member_id' => $id,
			'payment_amount'=> $amount,
			'payment_date' => $date,
			'membership' => 'member',
			'type' => 'savings'
		);

		$this->db->insert('payments',$payment_data);

		

			$general = array(
	        	'member_id'      => $id,
	        	'member'         => $member,
	        	'amount_total'   => $amount
	        );
	       
	        $data = array(
	        	'member_id'      => $id,
	        	'member'         => $member,
	        	'amount'         => $amount,
	        	'date'           => $newDate,
	        	'payment_id' => $payment_id,
	        	'date_range'     => $date_range
	        );

	        

	        $this->db->where('member_id', $id);
 			$query = $this->db->get('total_savings');


			    if($query->num_rows <= 0){

		        	$insert = $this->db->insert('total_savings', $general);

			        $insert = $this->db->insert('savings', $data);

			        
			        $new_total = $total_amount + $amount;

			        $balance = 200000 -  $new_total;

			        if($new_total == 200000){
			        	$this->db->update('ranges', array('amount' => $amount,'total_paid' => $new_total,'balance' => 0,'status'=>'CLEARED'),array('saving_range'=> $date_range,'member_id'=>$id));

			        	$data_transact = array(
				        	'member_id' =>$id,
				        	'names' => $member,
				        	'type' => 'savings_payment',
				        	'amount' => $amount,
				        	'payment_id' => $payment_id,
				        	'date' => $newDate
				        ); 

			        	 $insert = $this->db->insert('transactions', $data_transact);
			        }
			        elseif($new_total > 200000){

			        	$num = $new_total / 200000;

			        	for($i = 0;$i<$num;$i++){

			        	$newer_range = $date_range + $i;

			        	$this->db->update('ranges', array('amount' => 200000,'total_paid' => 200000,'balance' => 0,'status'=>'CLEARED'),array('saving_range'=> $newer_range,'member_id'=>$id));

			        	$newDate = strtotime("+$newer_range months",strtotime($original_date));

			        	$newDate = date("Y-m-d",$newDate);

		        		$data_transact = array(
				        	'member_id' =>$id,
				        	'names' => $member,
				        	'type' => 'savings_payment',
				        	'amount' => 200000,
				        	'payment_id' => $payment_id,
				        	'date' => $newDate
			       		 ); 

			        	 $insert = $this->db->insert('transactions', $data_transact);

			        	 $new_total = $new_total - 200000;
			        	}

			        	$num_left = $new_total % 200000;

			        	$new_range = $newer_range + 1;
			        	
			        	$bal = 200000 - $num_left ;

			        	if($num_left > 0){
			        		$this->db->update('ranges', array('amount' => $num_left,'total_paid' => $num_left,'balance' => $bal),array('saving_range'=> $new_range,'member_id'=>$id));

			        	$newDate = strtotime("+$new_range months",strtotime($original_date));

			        	$newDate = date("Y-m-d",$newDate);

			        	$data_transact = array(
						        	'member_id' =>$id,
						        	'names' => $member,
						        	'type' => 'savings_payment',
						        	'amount' => $num_left,
						        	'payment_id' => $payment_id,
						        	'date' => $newDate
			       		 ); 

			        	 $insert = $this->db->insert('transactions', $data_transact);

			        	}
			        	
			        	
			        }
			        else{
			        	$this->db->update('ranges', array('amount' => $amount,'total_paid' => $amount,'balance' => $balance),array('saving_range'=> $date_range,'member_id'=>$id));

			        	$data_transact = array(
						        	'member_id' =>$id,
						        	'names' => $member,
						        	'type' => 'savings_payment',
						        	'amount' => $amount,
						        	'payment_id' => $payment_id,
						        	'date' => $newDate
			       		 	); 

			        	 $insert = $this->db->insert('transactions', $data_transact);
			        	
		        	}
		        }
		        else{

		        		

				        $insert = $this->db->insert('savings', $data);

				        $new_total = $total_amount + $amount;

				        $Saving = $this->get_total_saving($id);

				        $Total = $amount + $Saving->amount_total;

				        $insert = $this->db->update('total_savings', array('amount_total' =>  $Total),array('member_id' => $id));

				        $balance = 200000 -  $new_total;

				        if($new_total == 200000){
				        	$this->db->update('ranges', array('amount' => $amount,'total_paid' => $new_total,'balance' => 0,'status'=>'CLEARED'),array('saving_range'=> $date_range,'member_id'=>$id));

				        	$data_transact = array(
				        	'member_id' =>$id,
				        	'names' => $member,
				        	'type' => 'savings_payment',
				        	'amount' => $amount,
				        	'payment_id' => $payment_id,
				        	'date' => $newDate
				        	);

				        	$insert = $this->db->insert('transactions', $data_transact);
				        	
				        }

				        else if($new_total > 200000){

					        	$num = floor($new_total / 200000);

					        	for($i = 0;$i<$num;$i++){

					        		$new_range = $date_range + $i;
					        		$this->db->update('ranges', array('amount' => 200000,'total_paid' => 200000,'balance' => 0,'status'=>'CLEARED'),array('saving_range'=> $new_range,'member_id'=>$id));


					        	$newDate = strtotime("+$new_range months",strtotime($original_date));

					        	$newDate = date("Y-m-d",$newDate);

							    $data_transact = array(
						        	'member_id' =>$id,
						        	'names' => $member,
						        	'type' => 'savings_payment',
						        	'amount' => 200000,
						        	'payment_id' => $payment_id,
						        	'date' => $newDate
						        	);
						        	
						        	$insert = $this->db->insert('transactions', $data_transact);

					        		//$new_total = $new_total - 200000;
					        	}

					        	$num_left = $new_total % 200000;

					        	$new_range = $new_range + 1;
					        	
					        	$bal = 200000 - $num_left ;
					        	if($num_left > 0){
					       		$this->db->update('ranges', array('amount' => $num_left,'total_paid' => $num_left,'balance' => $bal),array('saving_range'=> $new_range,'member_id'=>$id));

					       		$newDate = strtotime("+$new_range months",strtotime($original_date));

					        	$newDate = date("Y-m-d",$newDate);

					       		$data_transact = array(
						        	'member_id' =>$id,
						        	'names' => $member,
						        	'type' => 'savings_payment',
						        	'amount' => $num_left,
						        	'payment_id' => $payment_id,
						        	'date' => $newDate
						        	);
						        	
						        	$insert = $this->db->insert('transactions', $data_transact);

								}
					        	
			        	}
				        else{
				        	$this->db->update('ranges', array('amount' => $amount,'total_paid' => $new_total,'balance' =>$balance),array('saving_range'=> $date_range,'member_id'=>$id));

				        	$data_transact = array(
						        	'member_id' =>$id,
						        	'names' => $member,
						        	'type' => 'savings_payment',
						        	'amount' => $amount,
						        	'payment_id' => $payment_id,
						        	'date' => $newDate
						        	);
						        	
						        	$insert = $this->db->insert('transactions', $data_transact);

				        	
				        }
		    	}
		

		

        if ($insert > 0){
        	return TRUE;
        }
        
        else
        	return FALSE;
    }


    public function add_chairman($date,$range,$amount){

    	$pay_id = $this->get_max_payment_id();

		if($pay_id){
			$payment_id = $pay_id + 1;
		}
		else
			$payment_id = 1;


		$payment_data = array(
			'names' => 'general',
			'payment_amount'=> $amount,
			'payment_date' => $date,
			'membership' => 'all',
			'type' => 'chairmans bag'
		);

		$this->db->insert('payments',$payment_data);

		$data_transact = array(
        	'names' => 'general',
        	'type' => 'chairmans bag',
        	'amount' => $amount,
        	'payment_id' => $payment_id,
        	'date' => $date
        );

        $insert = $this->db->insert('transactions', $data_transact);


		$bag_data = array(
			'date' => $date,
			'amount' => $amount,
			'date_range' => $range,
			'payment_id' => $payment_id
		);

		if($this->db->insert('chairman', $bag_data)){
			return TRUR;
		}
		else
			return FALSE;
    }


    public function show_fines(){

    	$this->db->from('total_fines');
    	$this->db->where('total_fines >' , 0);

    	$fines = $this->db->get();

    	if($fines->num_rows > 0){
    		return $fines->result();
    	}
    	else
    		return FALSE;
    }

    public function show_fines_member($id){


    	$this->db->from('fines');
    	$this->db->where('member_id', $id);

    	$fines = $this->db->get();

    	if($fines->num_rows > 0){
    		return $fines->result();
    	}
    	else
    		return FALSE;
    }


    public function show_balances(){

    	$this->db->from('total_balances');
    	$this->db->where('total_balances >' , 0);

    	$balances = $this->db->get();

    	if($balances->num_rows > 0){
    		return $balances->result();
    	}
    	else
    		return FALSE;
    }

    public function show_balances_member($id){
    	
    	$this->db->from('balances');
    	$this->db->where('member_id', $id);

    	$balances = $this->db->get();

    	if($balances->num_rows > 0){
    		return $balances->result();
    	}
    	else
    		return FALSE;
    }

    public function delete_chairman_bag($payment_id){

    	$delete = $this->db->delete('chairman' , array('payment_id'=> $payment_id));

    	$delete = $this->db->delete('transactions' , array('payment_id'=> $payment_id));

    	$delete = $this->db->delete('payments' , array('payment_id'=> $payment_id));

    	if($delete){
    		return TRUE;
    	}
    	else 
    		return FALSE;
    }

    public function delete_savings($member,$amount,$date,$id,$payment_id){

	 	$original_date = '2017-06-06';

	 	$Total = 0;

	 	$after_range = 0;
        
        $newDate = date("Y-m-d", strtotime($date));

        $this->load->model('Dates_model');

		$date_range = $this->Dates_model->calculate_range($newDate);

		$date_forward_range =  $date_range ; 

		$double_forward =  $date_range - 1;   

		$total_amount = $this->calculate_savings_amount($id,$date_range);

		$savings_sched = strtotime("+$date_forward_range months", strtotime($original_date));

		$next_savings_sched = strtotime("-$double_forward months", strtotime($original_date));

		$saving_sched = date('Y-m-d',$savings_sched);

		$next_savings_sched = date('Y-m-d',$next_savings_sched);

		

		

		$this->db->delete('payments',array('id' => $payment_id));

		


	        

		$Saving = $this->get_total_saving($id);

		$payed_amount = $Saving->amount_total;

	    $Total =  $payed_amount - $amount;

	    $insert = $this->db->update('total_savings', array('amount_total' =>  $Total),array('member_id' => $id));
   
        $delete = $this->db->delete('savings', array('payment_id' => $payment_id));

        $delete = $this->db->delete('transactions', array('payment_id' => $payment_id));
        
        $new_total = $total_amount - $amount;

        $balance = 200000 -  $new_total;

        if($new_total > 0){
        	$this->db->update('ranges', array('amount' => $new_total,'total_paid' => $new_total,'balance' => $balance,'status'=>'NOT CLEARED','saving_status' => 'passed'),array('saving_range'=> $date_range,'member_id'=>$id));        	
        }
        elseif($new_total == 0){

        	$this->db->update('ranges', array('amount' => 0,'total_paid' => 0,'balance' => 200000,'status'=>'NOT CLEARED','saving_status' => 'passed'),array('saving_range'=> $date_range,'member_id'=>$id));
    	}
    	
	    else{
		        	$num = $new_total / 200000;

		        	for($i = 0;$i<$num;$i++){
		        		$new_range = $date_range - $i;
		        		$this->db->update('ranges', array('amount' => 0,'total_paid' => 0,'balance' => 200000,'status'=>'NOT CLEARED','saving_status' => 'passed'),array('saving_range'=> $new_range,'member_id'=>$id));

		        		//$new_total = $new_total - 200000;
		        	}

		        	$num_left = $new_total % 200000;

		        	$new_range = $new_range - 1;
		        	
		        	$new_range = --$date_range;
		        	$bal = 200000 - $num_left ;
		        	$this->db->update('ranges', array('amount' => $num_left,'total_paid' => $num_left,'balance' => $bal,'saving_sched'   => $next_savings_sched),array('saving_range'=> $new_range,'member_id'=>$id));
		        	
	        	
	    }

        if ($delete > 0){
        	return TRUE;
        }
        
        else
        	return FALSE;
    }


    public function delete_loan($amount,$id,$payment_id){

    	$delete = $this->db->delete('transactions',array('payment_id' => $payment_id));

    	$delete = $this->db->delete('payments',array('id' => $payment_id));

    	$progress = $this->get_progress_info($payment_id);

    	$member_info = $this->get_member_loan($id);

    	$amount_total = $member_info->total_amount;

    	if($progress->membership == 'member'){

    		$reduction = $progress->total_amount - $progress->prev_amount;

    		$new_amount_total = $amount_total - $reduction;

    		$update = $this->db->update('member_loan_info',array('total_amount' => $new_amount_total,'amount_paid' => $reduction), array('member_id' => $id));

    		$delete = $this->db->delete('loan_progress',array('payment_id' => $payment_id));
    	}
    	else{
    		$reduction = $progress->total_amount - $progress->prev_amount;

    		$new_amount_total = $amount_total - $reduction;

    		$update = $this->db->update('non_member_loan_info',array('total_amount' => $new_amount_total,'amount_paid' => $reduction), array('non_member_id' => $id));

    		$delete = $this->db->delete('loan_progress',array('payment_id' => $payment_id));
    	}

    	
    }


    public function get_savings_info($id){

    	$today = date('Y-m-d');

    	$year = date('Y',strtotime($today));

    	$result = $this->db->query("SELECT * FROM ranges WHERE `payment_date` BETWEEN '$year-01-01' AND '$year-12-31' AND  total_paid > 0 ");

    	if($result->num_rows > 0){
    		return $result->result();
    	}
    	else
    		return FALSE;
    }

    public function get_progress_info($payment_id){

    	$this->db->where('payment_id', $payment_id);
    	$progress = $this->db->get('loan_progress');

    	if($progress->num_rows > 0){
    		return $progress->result();
    	}
    	else 
    		return FALSE;
    }

    public function get_total_balances_table($id){

    	$this->db->from('total_balances');
		$this->db->where('member_id',$id);
		$balance_total = $this->db->get();

		if($balance_total->num_rows > 0){
			return $balance_total->row()->total_balances;
		}
		else
			return FALSE;
    }

    public function get_total_balances_table2($id){

    	$this->db->from('total_balances');
		$this->db->where('member_id',$id);
		$balance_total = $this->db->get();

		if($balance_total->num_rows > 0){
			return $balance_total->row();
		}
		else
			return FALSE;
    }


    public function get_total_balances_paid($id){

    	$this->db->from('total_balances');
		$this->db->where('member_id',$id);
		$balance_total = $this->db->get();

		if($balance_total->num_rows > 0){
			return $balance_total->row()->amount_paid;
		}
		else
			return FALSE;
    }


    public function get_total_balances_member($id){

    	$this->db->from('total_balances');
		$this->db->where('member_id',$id);
		$balance_total = $this->db->get();

		if($balance_total->num_rows > 0){
			return $balance_total->row();
		}
		else
			return FALSE;
    }


    public function get_max_payment_id(){
    	
		$this->db->select_max('id');
		$result = $this->db->get('payments')->row();  
		
		
		if ($result) {
			return $result->id;
		}
		else
			return FALSE;
    }

    public function get_max_fines_id($member_id){
    	$this->db->from('fines');
		$this->db->where('member_id',$member_id);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return  $result->row()->id;
		}
		
		return FALSE;
    }

    public function get_max_balances_id($member_id){
    	$this->db->from('balances');
		$this->db->where('member_id',$member_id);
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return  $result->row()->id;
		}
		
		return FALSE;
    }

    public function get_total_fines_table($id){

    	$this->db->from('total_fines');
		$this->db->where('member_id',$id);
		$fines_total = $this->db->get();

		if($fines_total->num_rows > 0){
			return $fines_total->row()->total_fines;
		}
		else
			return FALSE;
    }

    public function get_total_fines_table2($id){

    	$this->db->from('total_fines');
		$this->db->where('member_id',$id);
		$fines_total = $this->db->get();

		if($fines_total->num_rows > 0){
			return $fines_total->row();
		}
		else
			return FALSE;
    }

    public function get_total_fines_member($id){

    	$this->db->from('total_fines');
		$this->db->where('member_id',$id);
		$fines_total = $this->db->get();

		if($fines_total->num_rows > 0){
			return $fines_total->row();
		}
		else
			return FALSE;
    }


    public function pay_balance_direct($rem_amount,$date,$names,$id){

    	$names = urldecode($names);

    	$balances = $this->get_all_balances($id);

    	$total_balances = $this->get_total_balances_table($id);

    	$total_paid = $this->get_total_balances_paid($id);

    	$pay_id = $this->get_max_payment_id();

		if($pay_id){
			$payment_id = $pay_id + 1;
		}
		else
			$payment_id = 1;

		

		$payment_data = array(
			'names' => $names,
			'member_id' => $id,
			'payment_amount'=> $rem_amount,
			'payment_date' => $date,
			'membership' => 'member',
			'type' => 'balances'
		);

		$this->db->insert('payments',$payment_data);

    	if($balances > 0){


    		foreach($balances as $balance){

    			$balance_id = $balance->id;

    			$range = $balance->balance_range;

    			$actual_balance = $balance->pay_balance;

    			$actual_amount_owed = $balance->Balance;

    			$actual_paid = $balance->amount_paid;

    			
    			$total_amount_paid = $actual_paid + $rem_amount;


    			if($total_amount_paid > $actual_amount_owed){

    				$data_transact = array(
			        	'member_id' =>$id,
			        	'names' => $names,
			        	'type' => 'balances_payment',
			        	'payment_id' => $payment_id,
			        	'amount' => $actual_balance,
			        	'date' => $date
		        	);

    				 $insert = $this->db->insert('transactions', $data_transact);

    				$this->db->update('balances',array('amount_paid' => $actual_amount_owed,'pay_balance' => 0,'status' => 'paid'),array('balance_range' => $range,'member_id'=>$id));

    				$total_balances = $total_balances - $actual_balance;

    				$total_paid = $total_paid + $actual_balance;

    				$this->db->update('total_balances',array('total_balances' => $total_balances , 'amount_paid'=> $total_paid),array('member_id' => $id));



    				$rem_amount = $rem_amount - $actual_amount_owed;
    			}
    			else if($total_amount_paid == $actual_amount_owed){

    				$data_transact = array(
			        	'member_id' =>$id,
			        	'names' => $names,
			        	'type' => 'balances_payment',
			        	'payment_id' => $payment_id,
			        	'amount' => $actual_balance,
			        	'date' => $date
		        	);

    				 $insert = $this->db->insert('transactions', $data_transact);

    				$this->db->update('balances',array('amount_paid' =>$actual_amount_owed,'pay_balance' => 0,'status' => 'paid'),array('balance_range' => $range,'member_id'=>$id));

    				$total_balances = $total_balances - $actual_balance;

    				$total_paid = $total_paid + $actual_balance;

    				$this->db->update('total_balances',array('total_balances' => $total_balances , 'amount_paid'=> $total_paid),array('member_id' => $id));

    				$rem_amount = 0;

    				break;
    			}
    			else{

    				$data_transact = array(
			        	'member_id' =>$id,
			        	'names' => $names,
			        	'type' => 'balances_payment',
			        	'payment_id' => $payment_id,
			        	'amount' =>  $rem_amount,
			        	'date' => $date
		        	);

    				 $insert = $this->db->insert('transactions', $data_transact);

    				$balance = $actual_balance - $rem_amount;

    				$this->db->update('balances',array('amount_paid' => $rem_amount,'pay_balance' => $balance),array('balance_range' => $range,'member_id'=>$id));

    				$total_balances = $total_balances - $rem_amount;

    				$total_paid = $total_paid + $rem_amount;

    				$this->db->update('total_balances',array('total_balances' => $total_balances , 'amount_paid'=> $total_paid),array('member_id' => $id));

    				$rem_amount = 0;

    				break;
				}
			}

			return TRUE;
		}	

		else
			return FALSE;
    }

    public function pay_fines_direct($rem_amount,$date,$names,$id){

    	$fines = $this->get_all_fines($id);

    	$names = urldecode($names); 

    	$pay_id = $this->get_max_payment_id();

		if($pay_id){
			$payment_id = $pay_id + 1;
		}
		else
			$payment_id = 1;

		

		$payment_data = array(
			'names' => $names,
			'member_id' => $id,
			'payment_amount'=> $rem_amount,
			'payment_date' => $date,
			'membership' => 'member',
			'type' => 'fines'
		);

		$this->db->insert('payments',$payment_data);

    	$total_fines = $this->get_total_fines_table($id);

    	$total_paid = $this->get_total_fines_paid($id);

    		if($fines > 0){

	    		foreach($fines as $fine){

		    			$fine_id = $fine->id;

		    			$range = $fine->fine_range;

		    			$actual_fine = $fine->fine;

		    			$fine_balance = $fine->Balance;

		    			$actual_paid = $fine->amount_paid;

		    			$total_amount_paid = $actual_paid + $rem_amount;

		    		if($total_amount_paid > $actual_fine){


	    				$data_transact = array(
				        	'member_id' =>$id,
				        	'names' => $names,
				        	'type' => 'fines_payment',
				        	'payment_id' => $payment_id,
				        	'amount' => $actual_fine,
				        	'date' => $date
			        	);

	    				$insert = $this->db->insert('transactions', $data_transact);


	    				$this->db->update('fines',array('amount_paid' => $actual_fine,'Balance' => 0 , 'status' => 'cleared'),array('fine_range' => $range,'member_id'=>$id));

	    				$total_fines = $total_fines - $fine_balance;

	    				$total_paid = $total_paid + $actual_fine;

    					$this->db->update('total_fines',array('total_fines' => $total_fines ,'amount_paid' => $total_paid),array('member_id' => $id));


		    				$rem_amount = $rem_amount - $fine_balance;
	    			}
	    			else if($total_amount_paid == $actual_fine){


	    				$data_transact = array(
				        	'member_id' =>$id,
				        	'names' => $names,
				        	'type' => 'fines_payment',
				        	'payment_id' => $payment_id,
				        	'amount' => $actual_fine,
				        	'date' => $date
			        	);

	    				$insert = $this->db->insert('transactions', $data_transact);


	    				$this->db->update('fines',array('amount_paid' => $actual_fine,'Balance' => 0 , 'status' => 'cleared'),array('fine_range' => $range,'member_id'=>$id));

	    				$total_fines = $total_fines - $fine_balance;

    					$total_paid = $total_paid + $actual_fine;

    					$this->db->update('total_fines',array('total_fines' => $total_fines ,'amount_paid' => $total_paid),array('member_id' => $id));


		    			$rem_amount = 0;

	    				break;
	    			}
	    			else{

		    			$data_transact = array(
				        	'member_id' =>$id,
				        	'names' => $names,
				        	'type' => 'fines_payment',
				        	'payment_id' => $payment_id,
				        	'amount' => $rem_amount,
				        	'date' => $date
			        	);

	    				$insert = $this->db->insert('transactions', $data_transact);

	    				$balance = $fine_balance - $rem_amount;

	    				$this->db->update('fines',array('amount_paid' => $rem_amount, 'Balance' => $balance),array('fine_range' => $range,'member_id'=>$id));

	    				$total_fines = $total_fines - $rem_amount;

    					$total_paid = $total_paid + $rem_amount;

    					$this->db->update('total_fines',array('total_fines' => $total_fines ,'amount_paid' => $total_paid),array('member_id' => $id));

	    				$rem_amount = 0;

	    				break;
	    			}	
	    		}
	    		return TRUE;
    		}

    		else
    			return FALSE;

    }


     public function delete_balances($rem_amount,$id,$payment_id){

    	$names = urldecode($names);

    	$balances = $this->get_all_balances_order($id);

    	$total_balances = $this->get_total_balances_table($id);

    	$max_id = $this->get_max_balances_id($id);

		$this->db->delete('payments',array('id'=> $payment_id));

    	if($balances > 0){

			

    		foreach($balances as $balance){

    			$balance_id = $balance->id;

    			$range = $balance->balance_range;

    			$actual_balance = $balance->pay_balance;

    			$actual_amount_owed = $balance->balance;

    			$actual_paid = $balance->amount_paid;

    			
    			$total_amount_paid = $actual_paid - $rem_amount;

    			$nbalance = $actual_amount_owed - $total_amount_paid;

    			if($total_amount_paid > 0){


    				 $delete = $this->db->delete('transactions', array('payment_id'=>$payment_id));

    				$update = $this->db->update('balances',array('amount_paid' => $total_amount_paid,'pay_balance' => $nbalance,'status' => 'not_paid'),array('balance_range' => $range,'member_id'=>$id));

    				$total_balances = $total_balances +  $rem_amount;

    				$update = $this->db->update('total_balances',array('total_balances' => $total_balances),array('member_id' => $id));

    				break;

    			}
    			else if($total_amount_paid == $actual_amount_owed){

    				

    				 $delete = $this->db->delete('transactions', array('payment_id'=>$payment_id));

    				$update = $this->db->update('balances',array('amount_paid' => 0,'pay_balance' => $actual_amount_owed,'status' => 'not_paid'),array('balance_range' => $range,'member_id'=>$id));

    				$total_balances = $total_balances +  $rem_amount;

    				$update = $this->db->update('total_balances',array('total_balances' => $total_balances),array('member_id' => $id));

    				break;
    			}
    			else{

    				 $delete = $this->db->delete('transactions', array('payment_id'=>$payment_id));

    				$rem_amount -= $actual_amount_owed;

    				$update = $this->db->update('balances',array('amount_paid' => 0,'pay_balance' => $actual_amount_owed,'status' => 'not_paid'),array('balance_range' => $range,'member_id'=>$id));

    				$total_balances = $total_balances + $actual_paid;

    				$update = $this->db->update('total_balances',array('total_balances' => $total_balances),array('member_id' => $id));
    				
				}
			}

			
		}	
		if($update){
			return TRUE;
		}
		else
			return FALSE;
    }


    

    public function delete_fines($rem_amount,$id,$payment_id){

    	$fines = $this->get_all_fines_order($id); 

    	$max_id = $this->get_max_fines_id($id);

		$this->db->delete('payments',array('id'=> $payment_id));

    	$total_fines = $this->get_total_fines_table($id);

    	if($fines > 0){

	    		foreach($fines as $fine){

		    			$fine_id = $fine->id;

		    			$range = $fine->fine_range;

		    			$actual_fine = $fine->fine;

		    			$fine_balance = $fine->Balance;

		    			$actual_paid = $fine->amount_paid;

		    			$total_amount_paid = $actual_paid - $rem_amount;

    					$nbalance = $actual_fine - $total_amount_paid;


		    			if($total_amount_paid > 0){


		    				 $delete = $this->db->delete('transactions', array('payment_id'=>$payment_id));

		    				$update = $this->db->update('fines',array('amount_paid' => $total_amount_paid,'Balance' => $nbalance,'status' => 'not_cleared'),array('fine_range' => $range,'member_id'=>$id));

		    				$total_fines = $total_fines +  $rem_amount;

		    				$update = $this->db->update('total_fines',array('total_fines' => $total_fines),array('member_id' => $id));

		    				break;

		    			}
		    			else if($total_amount_paid == $actual_fine){

		    				

		    				 $delete = $this->db->delete('transactions', array('payment_id'=>$payment_id));

		    				$update = $this->db->update('fines',array('amount_paid' => 0,'Balance' => $actual_fine,'status' => 'not_cleared'),array('fine_range' => $range,'member_id'=>$id));

		    				$total_fines = $total_fines +  $rem_amount;

		    				$update = $this->db->update('total_fines',array('total_fines' => $total_fines),array('member_id' => $id));

		    				break;
		    			}
		    			else{

		    				 $delete = $this->db->delete('transactions', array('payment_id'=>$payment_id));

		    				$rem_amount -= $actual_fine;

		    				$update = $this->db->update('fines',array('amount_paid' => 0,'Balance' => $actual_fine,'status' => 'not_cleared'),array('fine_range' => $range,'member_id'=>$id));

		    				$total_fines = $total_fines + $actual_paid;

		    				$update = $this->db->update('total_fines',array('total_fines' => $total_fines),array('member_id' => $id));
		    				
						}
				}		
		}

		if($update){
			return TRUE;
		}
		else
			return FALSE;
	}


	public function check_payment($date, $id){

		$range = $this->Dates_model->calculate_range($date);

		$this->db->from('ranges');
		$this->db->where('member_id',$id);
		$info = $this->db->get();

		$status = $info->row()->status;

		if($status = 'CLEARED'){
			return TRUE;
		}
		else
			return FALSE;
	}

	public function check_date_clearance($member,$date){

		$range = $this->Dates_model->calculate_range($date);

		$this->db->from('ranges');
		$this->db->where('names',$member);
		$this->db->where('saving_range',$range);
		$info = $this->db->get();

		if($info->num_rows() > 0){
			return $info->row();
		}
		else
			return FALSE;
	}




    public function get_balance($id,$range){

    	$this->db->from('ranges');
    	$this->db->where('member_id',$id);
    	$this->db->where('saving_range',$range);
    	$balance = $this->db->get();

    	if($balance){
    		return $balance->row();
    	}
    	else 
    		return FALSE;
    }

    public function get_all_balances($id){

    	$this->db->from('balances');
    	$this->db->where('member_id',$id);
    	$this->db->where('status','not_paid');
    	$this->db->order_by('balance_range','ASC');
    	$latest = $this->db->get();

    	if($latest->num_rows > 0){
    		return $latest->result();
    	}
    	else 
    		return FALSE;
    }


    public function get_all_balances_order($id){

    	$this->db->from('balances');
    	$this->db->where('member_id',$id);
    	$this->db->where('status','paid');
    	$this->db->order_by('balance_range','DESC');
    	$latest = $this->db->get();

    	if($latest->num_rows > 0){
    		return $latest->result();
    	}
    	else 
    		return FALSE;
    }

    public function get_earliest_savings($id,$range){
    	$this->db->from('ranges');
    	$this->db->where('member_id',$id);
    	$this->db->where('status','NOT CLEARED');
    	$this->db->where('saving_range <',$range);
    	$this->db->order_by('saving_range','ASC');
    	$latest = $this->db->get();

    	if($latest->num_rows > 0){
    		return $latest->row();
    	}
    	else 
    		return FALSE;
    }

    public function get_annual_savings($id){

    	$today = date('Y-m-d');

    	$year = date('Y',strtotime($today));
    	
		$query = $this->db->query("SELECT * FROM ranges WHERE member_id = $id AND ranges.saving_sched BETWEEN '$year-01-01' AND '$year-12-31'");

    	if($query->num_rows > 0){
    		return $query->result();
    	}
    	else 
    		return FALSE;
    }

    public function get_annual_savings2($id){

    	$today = date('Y-m-d');

    	$year = date('Y',strtotime($today));

    	$year2 = $year - 1;
    	
		$query = $this->db->query("SELECT * FROM ranges WHERE member_id = $id AND ranges.saving_sched BETWEEN '$year2-06-06' AND '$year-06-06'");

    	if($query->num_rows > 0){
    		return $query->result();
    	}
    	else 
    		return FALSE;
    }


    public function get_annual_savings_total($id){

    	$today = date('Y-m-d');

    	$year = date('Y',strtotime($today));
    	
		$query = $this->db->query("SELECT SUM(total_paid) FROM ranges WHERE member_id = $id AND ranges.saving_sched BETWEEN '$year-01-01' AND '$year-12-31'");

    	if($query->num_rows > 0){
    		return $query->row()->total_paid;
    	}
    	else 
    		return FALSE;
    }


    public function get_next_saving($id,$rg){
    	
    	$this->db->where('member_id',$id);
    	$this->db->where('saving_range',$rg);
    	$sat = $this->db->get('ranges');
    	


    	if($sat->num_rows > 0){
    		return $sat->row();
    	}
    	else
    		return FALSE;
    }

    public function get_next_savings($id,$rg){
    	
    	$this->db->where('member_id',$id);
    	$this->db->where('saving_range >=',$rg);
    	$sat = $this->db->get('ranges');
    	


    	if($sat->num_rows > 0){
    		return $sat->result();
    	}
    	else
    		return FALSE;
    }

    public function non_member_transactions($id){
    	
    	$this->db->where('non_member_id',$id);
    	$this->db->from('non_member_payments');
    	$payments = $this->db->get();
    	


    	if($payments->num_rows > 0){
    		return $payments->result();
    	}
    	else
    		return FALSE;
    }

    public function count_all_balances($id){
    	$this->db->where('member_id',$id);
    	$this->db->where('status','not_paid');
    	$num = $this->db->count_all('balances');


    	if($num > 0){
    		return $num;
    	}
    	else
    		return FALSE;
    }

    public function count_all_fines($id){
    	$this->db->where('member_id',$id);
    	$this->db->where('status','not_cleared');
    	$num = $this->db->count_all('fines');

    	if($num > 0){
    		return $num;
    	}
    	else
    		return FALSE;
    }


    public function get_all_fines($id){

    	$this->db->from('fines');
    	$this->db->where('member_id',$id);
    	$this->db->where('status','not_cleared');
    	$this->db->order_by('fine_range','ASC');
    	
    	$latest = $this->db->get();

    	if($latest->num_rows > 0){
    		return $latest->result();
    	}
    	else 
    		return FALSE;
    }

    public function get_all_fines_order($id){

    	$this->db->from('fines');
    	$this->db->where('member_id',$id);
    	$this->db->where('status','cleared');
    	$this->db->order_by('fine_range','DESC');
    	
    	$latest = $this->db->get();

    	if($latest->num_rows > 0){
    		return $latest->result();
    	}
    	else 
    		return FALSE;
    }

    

    public function get_total_fines_paid($id){

    	$this->db->from('total_fines');
    	$this->db->where('member_id',$id);
    	$latest = $this->db->get();

    	if($latest->num_rows > 0){
    		return $latest->row()->amount_paid;
    	}
    	else 
    		return FALSE;
    }

    public function calculate_savings_amount($member_id,$range){
    	$this->db->where('member_id',$member_id);
		$this->db->where('saving_range',$range);
		$result = $this->db->get('ranges');

    	if($result->num_rows>0)
    		return $result->row();
    	else
    		return FALSE;
    }

  //   public function fine_savings(){

  //   	$today = date('Y-m-d');

  //   	$this->load->model('Dates_model');

		// $date_range = $this->Dates_model->calculate_range($today);

		
		// $this->db->select('*');
		// $this->db->from('ranges');
		// $this->db->where('saving_status','not_passed');
		// $this->db->where('status','NOT CLEARED');
		// $this->db->where('saving_range <',$date_range);
  //       $past_payments =  $this->db->get();
			    

  //       $payments_passed = $past_payments->result();

  //       $test_id = 0;

  //       $fine_total = 0;

		// foreach($payments_passed as $passed){
		// 	$member_id = $passed->member_id;

		// 	$range = $passed->saving_range;

		// 	$this->db->update('ranges',array('saving_status'=> 'passed'),array('saving_range'=>$range));

		// 	$Balance = $passed->balance;

		// 	$range = $passed->saving_range;

		// 	$fine = 30000;

		// 	$member = $passed->names;


		// 	$data = array(
		// 		'member_id' => $member_id,
		// 		'fine' => $fine,
		// 		'fine_range' => $range,
		// 		'Balance' => $fine
		// 	);

			
		// 	$fine_data = array(
		// 		'member_id' => $member_id,
		// 		'member' => $member,
		// 		'total_fines' => $fine
		// 	);


		// 	$fine_added = $this->db->insert('fines',$data);


		// 	if($test_id != $member_id){
		// 		$this->db->insert('total_fines',$fine_data);
		// 		$test_id = $member_id;
		// 		$fine_total = $fine;
		// 	}
		// 	else{
		// 		$fine_total += $fine;
		// 		$this->db->update('total_fines',array('total_fines' => $fine_total) ,array('member_id'=>$test_id));
		// 	}

		// }
		

  //   }


    public function fine_savings_member($id){

    	$today = date('Y-m-d');

    	$this->load->model('Dates_model');

		$date_range = $this->Dates_model->calculate_range($today);

		
		$this->db->select('*');
		$this->db->from('ranges');
		$this->db->where('saving_status','not_passed');
		$this->db->where('status','NOT CLEARED');
		$this->db->where('member_id', $id);
		$this->db->where('saving_range <',$date_range);
        $past_payments =  $this->db->get();
			    

        $payments_passed = $past_payments->result();

        $test_id = 0;

        $fine_total = 0;

		foreach($payments_passed as $passed){
			$member_id = $passed->member_id;

			$range = $passed->saving_range;

			$this->db->update('ranges',array('saving_status'=> 'passed'),array('saving_range'=>$range));

			$Balance = $passed->balance;

			$range = $passed->saving_range;

			$fine = 30000;

			$member = $passed->names;


			$data = array(
				'member_id' => $id,
				'fine' => $fine,
				'fine_range' => $range,
				'Balance' => $fine
			);

			
			$fine_data = array(
				'member_id' => $id,
				'member' => $member,
				'total_fines' => $fine
			);


			$fine_added = $this->db->insert('fines',$data);

			$fine_total += $fine;
			

		}

		$this->db->update('total_fines',array('total_fines' => $fine_total) ,array('member_id'=>$id));
			

		if($payments_passed){
			return TRUE;
		}
		else
			return FALSE;
		

    }

  //   public function calculate_balances(){

  //   	$today = date('Y-m-d');

  //   	$this->load->model('Dates_model');

		// $date_range = $this->Dates_model->calculate_range($today);

		// $this->db->from('ranges');
		// $this->db->where('status','NOT CLEARED');
		// $this->db->where('saving_status','not_passed');
		// $this->db->where('saving_range <',$date_range);
  //       $past_payments =  $this->db->get();
			    

  //       $payments_passed = $past_payments->result();

  //       $test_id = 0;

  //       $balance_total = 0;

		// foreach($payments_passed as $passed){

		// 	$member_id = $passed->member_id;

		// 	$Balance = $passed->balance;

		// 	$range = $passed->saving_range;

		// 	$member = $passed->names;


		// 	$data = array(
		// 		'member_id' => $member_id,
		// 		'balance' => $Balance,
		// 		'balance_range' => $range,
		// 		'pay_balance' => $Balance
		// 	);

		// 	$total_data = array(
		// 		'member_id' => $member_id,
		// 		'member' => $member,
		// 		'total_balances' => $Balance
		// 	);

		// 	$balance_added = $this->db->insert('balances',$data);

		// 	if($test_id != $member_id){
		// 		$this->db->insert('total_balances',$total_data);
		// 		$test_id = $member_id;
		// 		$balance_total = $Balance;
		// 	}
		// 	else{
		// 		$balance_total += $Balance;
		// 		$this->db->update('total_balances',array('total_balances' => $balance_total) ,array('member_id'=>$test_id));
		// 	}

		// }
		
  //   }


    public function calculate_balances_member($id){

    	$today = date('Y-m-d');

    	$this->load->model('Dates_model');

		$date_range = $this->Dates_model->calculate_range($today);

		$this->db->from('ranges');
		$this->db->where('status','NOT CLEARED');
		$this->db->where('saving_status','not_passed');
		$this->db->where('member_id', $id);
		$this->db->where('saving_range <',$date_range);
        $past_payments =  $this->db->get();
			    

        $payments_passed = $past_payments->result();

        $test_id = 0;

        $balance_total = 0;

		foreach($payments_passed as $passed){

			//$member_id = $passed->member_id;

			$Balance = $passed->balance;

			$range = $passed->saving_range;

			$member = $passed->names;


			$data = array(
				'member_id' => $id,
				'balance' => $Balance,
				'balance_range' => $range,
				'pay_balance' => $Balance
			);

			$total_data = array(
				'member_id' => $id,
				'member' => $member,
				'total_balances' => $Balance
			);

			$balance_added = $this->db->insert('balances',$data);

			$balance_total += $Balance;
			
			
		}

		$this->db->update('total_balances',array('total_balances' => $balance_total) ,array('member_id'=>$id));

		if($payments_passed){
			return TRUE;
		}
		else
			return FALSE;
		
    }


    public function select_total_savings(){
    	$due = $this->db->query(
			'
			

			SELECT
			   	amount_total as Total,member,member_id 
			FROM
			   total_savings 
			GROUP BY
				member_id 
			
			
			'
		);

		
		if ($due->num_rows() > 0) {
			return $due->result();
		} else {
			return FALSE;
		}
    }

    public function select_savings($id){

    	$this->db->from('savings');
    	$this->db->where('member_id',$id);
    	$saving = $this->db->get();

    	if($saving->num_rows > 0){
    		return $saving->result();
    	}
    	else 
    		return FALSE;
    }

     public function select_total_payments(){

    	$this->db->select_sum('payment_amount');
    	$this->db->from('payments');
    	$saving = $this->db->get();

    	if($saving){
    		return $saving->row()->payment_amount;
    	}
    	else 
    		return FALSE;
    }



    public function get_total_saving($id){

    	$this->db->from('total_savings');
    	$this->db->Where('member_id',$id);
    	$result = $this->db->get();

    	if($result->num_rows > 0){
    		return $result->row();
    	}
    	else
    		return FALSE;

    }

    public function get_fines($id)
	{
		//get first payment info
		
		$this->db->select_sum('Balance');
		$this->db->where('status','not_cleared');
		$this->db->where('member_id',$id);
		$result = $this->db->get('fines')->row();
		
		
		$fin = $result->Balance;
		
		
		if ($fin > 0) {
			return $fin;
		}
		
		return FALSE;
		
	}

	 public function get_all_total_fines()
	{
		//get first payment info
		
		$this->db->select_sum('fine');
		$this->db->where('status','not_cleared');
		$result = $this->db->get('fines')->row();
		
		
		$fin = $result->fine;
		
		
		if ($fin > 0) {
			return $fin;
		}
		
		return FALSE;
		
	}

	 public function get_list_fines($id)
	{
		//get first payment info
		
		$this->db->from('fines');
		$this->db->where('member_id',$id);
		$this->db->where('status','not_cleared');
		$this->db->order_by('fine_range','desc');
		$fin = $this->db->get();
		
		
		if ($fin->num_rows() > 0) {
			return $fin->result();
		}
		else
			return FALSE;
		
	}



	public function get_balances($id)
	{
		//get first payment info

		$this->db->select_sum('pay_balance');
		$this->db->where('status','not_paid');
		$this->db->where('member_id',$id);
		$result = $this->db->get('balances')->row();

		$bal = $result->pay_balance;
		
	
		if ($bal > 0) {
			return $bal;
		}
		else
			return FALSE;
		
	}

	public function get_all_total_balances()
	{
		//get first payment info

		$this->db->select_sum('balance','total_balances');
		$this->db->where('status','not_paid');
		$result = $this->db->get('balances')->row();

		$bal = $result->total_balances;
		
	
		if ($bal > 0) {
			return $bal;
		}
		else
			return FALSE;
	}


	public function get_list_balances($id)
	{
		//get first payment info
		
		$this->db->from('balances');
		$this->db->where('member_id',$id);
		$this->db->order_by('balance_range','desc');
		$bal = $this->db->get();
		
		
		if ($bal->num_rows() > 0) {
			return $bal->result();
		}
		else
			return FALSE;
		
	}


    public function select_total_member_savings($member_id){


    	$this->db->select('SUM(amount) as total');
    	$this->db->where('member_id' , $member_id);
    	$this->db->from('savings');
    	$due = $this->db->get();
			
		
		
		if ($due) {
			return $due->result();
		} else {
			return FALSE;
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

	
	function get_savings()
	{
		//get first payment info
		$this->db->from('savings');
		$this->db->order_by('id');
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		
		return FALSE;
		
	}

	function get_member_savings($id)
	{
		//get first payment info
		$this->db->from('savings');
		$this->db->where('member_id',$id);
		$this->db->order_by('id','DESC');
		$result = $this->db->get();
		
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		
		return FALSE;
		
	}

	function get_member_savings_total($id)
	{
		//get first payment info
		$this->db->from('total_savings');
		$this->db->where('member_id',$id);
		$result = $this->db->get();
		
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



	

}