<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('log_lib');
        $this->load->model('User_model');
        if(!$this->session->userdata('user_logged_in')){
            //Set error
            $this->session->set_flashdata('need_login', 'Sorry, you need to be logged in to view that area');
            redirect('home/index');
        }
    }


    public function index(){

    	$date = date('Y-m-d');

    	$year = date('Y',strtotime($date));

    	$data['year'] = $year;

	    $data['payments'] = $this->Payments_model->get_payments_general($year);
	     //Load view and layout
	    $data['main_content'] = 'payments/index';
   		$this->load->view('layouts/main',$data);
    }

    function view_transactions_time($year,$id,$name){

  	$data['name'] = $name;

  	$data['year'] = $year;

  	$data['member_transactions'] = $this->Transactions_model->get_member_transactions($year,$id);

  	$data['main_content'] = 'transactions/members';
    $this->load->view('layouts/main',$data);
  }

  function view_transactions_times($year){

  	$data['year'] = $year;

  	$data['member_transactions'] = $this->Transactions_model->get_member_transact($year);

  	$data['main_content'] = 'transactions/general_members';
    $this->load->view('layouts/main',$data);
  }


  function view_non_transactions_times($year){

  	$data['year'] = $year;

  	$data['non_member_transactions'] = $this->Transactions_model->get_non_member_transact($year);

  	$data['main_content'] = 'transactions/general_non_members';
    $this->load->view('layouts/main',$data);
  }

  function view_non_mem_transactions_time($year,$id,$name){

  	$data['name'] = $name;

  	$data['year'] = $year;

  	$data['non_member_transactions'] = $this->Transactions_model->get_non_member_transactions($year,$id);

  	$data['main_content'] = 'transactions/non_members';
    $this->load->view('layouts/main',$data);
  }

  function delete_payment($payment_id,$amount,$member_id,$member,$type,$date){

  		if($type == 'savings'){
  			$delete = $this->Savings_model->delete_savings($member,$amount,$date,$member_id,$payment_id);


  		}
  		else if($type == 'chairmans bag'){
  			$delete = $this->Savings_model->delete_chairman_bag($payment_id);
  		}
  		else if($type == 'loans_payment'){
  			$delete = $this->Savings_model->delete_loan($amount,$member_id,$payment_id);
  		}
  		else if($type == 'fines'){
  			$delete = $this->Savings_model->delete_fines($amount,$member_id,$payment_id);
  		}
  		else
  			$delete = $this->Savings_model->delete_balances($amount,$member_id,$payment_id);


  		if($delete){
  			$this->session->set_flashdata('deleted', 'The payment has been deleted');
  			redirect('payments/index');
  		}

  }	


  function print_report(){

  	$today = date('Y-m-d');

  	$year = date('Y',strtotime($today));

  	$payments = $this->Payments_model->get_payments_general($year);

     if($payments) {
        $html = $this->load->view('payments/print_payments', array('payments' => $payments ,'year' => $year), true);

        require_once("./public/dompdf/dompdf_config.inc.php");
        
        $pdf =  new DOMPDF();
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream($name . "-" . urldecode($names) . ".pdf");
      }
  }


}
