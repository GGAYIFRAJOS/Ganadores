<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions extends CI_Controller {

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



  function index(){
  	//$data['lists'] = "WHY HAST THOW FORSAKEN ME";
    $data['member_transactions'] = $this->Transactions_model->get_members_transactions();

    $data['non_member_transactions'] = $this->Transactions_model->get_non_members_transactions();
     //Load view and layout
    $data['main_content'] = 'transactions/index';
    $this->load->view('layouts/main',$data);
  }

    function view_transactions_member(){

    $name = $this->session->userdata('user_name');

    $id = $this->session->userdata('user_id');

    $data['name'] = $name;

    $data['id'] = $id;

    $data['member_transactions'] = $this->Transactions_model->get_member_transactions2();

    $data['main_content'] = 'transactions/members2';
    $this->load->view('layouts/main',$data);
  }


  function view_transactions_time($year,$id,$name){

  	$data['name'] = $name;

  	$data['year'] = $year;

    $data['id'] = $id;

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

    $data['id'] = $id;

  	$data['non_member_transactions'] = $this->Transactions_model->get_non_member_transactions($year,$id);

  	$data['main_content'] = 'transactions/non_members';
    $this->load->view('layouts/main',$data);
  }

  function view_report($year)
  {

      $transactions = $this->Transactions_model->get_member_transact($year);

      if($transactions) {
        $html = $this->load->view('transactions/print', array('year' => $year, 'member_transactions' => $transactions), true);

        require_once("./public/dompdf/dompdf_config.inc.php");
        
        $pdf =  new DOMPDF();
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream($name . "-" . $loan->borrower_loan_id . ".pdf");
      }
    
  }

  function view_report_member($year,$id,$name)
  {

      $transactions = $this->Transactions_model->get_member_transactions($year,$id);

      if($transactions) {
        $html = $this->load->view('transactions/member_print', array('name' =>$name,'year' => $year, 'member_transactions' => $transactions), true);

        require_once("./public/dompdf/dompdf_config.inc.php");
        
        $pdf =  new DOMPDF();
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream($name . "-" . $name . ".pdf");
      }
    
  }

  public function view_info_report($id){

        $fines = $this->Savings_model->get_fines($id);

        $balances = $this->Savings_model->get_balances($id);

        $names = $this->Member_model->get_names($id);

        $loans = $this->Loan_model->get_member_loan($id);

        $years = $this->Dates_model->get_member_years($id);

        $total_savings = $this->Savings_model->get_member_savings_total($id);

        $savings = $this->Savings_model->get_annual_savings($id);

        $ranges = $this->Dates_model->calculate_range_today();

        if($names) {
        $html = $this->load->view('members/inform', array('id' => $id,'names' =>$names,'fines'=>$fines,'balances'=>$balances,'years' => $years,'loans'=>$loans,'total_savings'=>$total_savings, 'savings' => $savings, 'ranges' => $ranges), true);

        require_once("./public/dompdf/dompdf_config.inc.php");
        
        $pdf =  new DOMPDF();
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream($name . "-" . $names . ".pdf");
        }

        
  }

  function view_report_non_member($year,$id,$name)
  {

      $transactions = $this->Transactions_model->get_non_member_transactions($year,$id);

      if($transactions) {
        $html = $this->load->view('transactions/non_member_print', array('name' =>$name,'year' => $year, 'member_transactions' => $transactions), true);

        require_once("./public/dompdf/dompdf_config.inc.php");
        
        $pdf =  new DOMPDF();
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream($name . "-" . $loan->borrower_loan_id . ".pdf");
      }
    
  }

  function view_non_report($year)
  {

      $transactions = $this->Transactions_model->get_non_member_transact($year);

      if($transactions) {
        $html = $this->load->view('transactions/non_print', array('year' => $year, 'member_transactions' => $transactions), true);

        require_once("./public/dompdf/dompdf_config.inc.php");
        
        $pdf =  new DOMPDF();
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream($name . "-" . $loan->borrower_loan_id . ".pdf");
      }
    
  }

}