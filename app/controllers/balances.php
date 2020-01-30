<?php 



class Balances extends CI_Controller{

public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('user_logged_in')){
            //Set error
            $this->session->set_flashdata('need_login', 'Sorry, you need to be logged in to view that area');
            redirect('home/index');
        }
}

public function info($id){

        $data['id'] = $id;

		$data['balances'] = $this->Savings_model->get_list_balances($id);

		$data['names'] = $this->Member_model->get_member_names($id);

        
        //Load view and layout
        $data['main_content'] = 'balances/info';
        $this->load->view('layouts/main',$data);

}


public function pay_balance($id,$names){


	$this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
    $this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
   


    if($this->form_validation->run() == FALSE){
            //Load view and layout
    		$data['names'] = $names;
    		$data['id'] = $id;

            $data['main_content'] = 'balances/pay';
            $this->load->view('layouts/main',$data);
        //Validation has ran and passed    
     } else {
     		$amount = $this->input->post('amount');

            $date = $this->input->post('date');

            $date = date('Y-m-d',strtotime($date));

            $balance_amt = $this->Savings_model->get_balances($id);

            if($amount > $balance_amt){
                $this->session->set_flashdata('amount_excess', 'The amount payed exceeds the balance amount');
                redirect('balances/info/'.$id);
            }
           else{

                $this->Savings_model->pay_balance_direct($amount,$date,$names,$id);
                $this->session->set_flashdata('balance payment', 'The balance payment has been succesfully registered');

                redirect('members/get_member_info/'.$id);
           }
        }
}



public function show_balances(){

    $balances = $this->Savings_model->show_balances();

    if($balances){

            $data['balances'] = $balances;

            $data['main_content'] = 'balances/show';
            $this->load->view('layouts/main',$data);
    }

    else{

        $data['error'] = 'There are currently no balances in the system';

        $data['main_content'] = 'balances/show';
        $this->load->view('layouts/main',$data);
    }
}


public function get_balances($id,$names){
        $id = $id;

        $balances = $this->Savings_model->get_list_balances($id);

        $names = $this->Member_model->get_member_names($id);

        
        //Load view and layout
       

        if($id) {
        $html = $this->load->view('balances/infos', array('id' => $id,'balances' =>$balances,'names' => $names), true);

        require_once("./public/dompdf/dompdf_config.inc.php");
        
        $pdf =  new DOMPDF();
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream($name . "-" . $names . ".pdf");
        }



     }




}




?>