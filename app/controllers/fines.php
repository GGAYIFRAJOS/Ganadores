<?php 



class Fines extends CI_Controller{


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

        $data['fines'] = $this->Savings_model->get_list_fines($id);

        $data['names'] = $this->Member_model->get_member_names($id);
        
        //Load view and layout
        $data['main_content'] = 'fines/info';
        $this->load->view('layouts/main',$data);

}

public function get_total_fines($id){

    $fines = $this->Member_model->get_member_total_fines($id);

}

public function pay_fines($id,$names){


	$this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
    $this->form_validation->set_rules('date', 'Date', 'trim|required|xss_clean');
   


    if($this->form_validation->run() == FALSE){
            //Load view and layout
    		$data['names'] = $names;
    		$data['id'] = $id;

            $data['main_content'] = 'fines/pay';
            $this->load->view('layouts/main',$data);
        //Validation has ran and passed    
     } else {
     		$amount = $this->input->post('amount');

     		$date = $this->input->post('date');

            $date = date('Y-m-d',strtotime($date));

            $fine_amt = $this->Savings_model->get_fines($id);

            if($amount > $fine_amt){
                $this->session->set_flashdata('amount_excess', 'The amount payed exceeds the fines amount');
                redirect('fines/info/'.$id);
            }
           else{

                $this->Savings_model->pay_fines_direct($amount,$date,$names,$id);
                $this->session->set_flashdata('balance payment', 'The balance payment has been succesfully registered');

                redirect('members/get_member_info/'.$id);
           }
        }
}



public function show_fines(){

    $fines = $this->Savings_model->show_fines();

    if($fines){
            $data['fines'] = $fines;

            $data['main_content'] = 'fines/show';
            $this->load->view('layouts/main',$data);
    }

    else{

        $data['error'] = 'There are currently no fines in the system';

        $data['main_content'] = 'fines/show';
        $this->load->view('layouts/main',$data);
    }
}

public function get_user_id(){

        $names = $this->session->userdata('user_name');

        $this->db->where('names', $names);
        $this->db->from('members');
        $info = $this->db->get();

        if($info->num_rows() > 0){
            return $info->row()->id;
        }
        else
            return false;
    }

public function show_fines_member(){

    $names = $this->session->userdata('user_name');

    $id = $this->get_user_id();

    $fines = $this->Savings_model->show_fines_member($id);

    if($fines){
            $data['fines'] = $fines;

            $data['total_fine'] = $this->Savings_model->get_total_fines_table2($id);

            $data['names'] = $names;

            $data['id'] = $id;

            $data['main_content'] = 'fines/show2';
            $this->load->view('layouts/main',$data);
    }

    else{

        $data['error'] = 'There are currently no fines in the system';

        $data['main_content'] = 'fines/show2';
        $this->load->view('layouts/main',$data);
    }
}


public function get_fines($id,$names){
        $id = $id;

        $fines = $this->Savings_model->get_list_fines($id);

        $names = $this->Member_model->get_member_names($id);

        
        //Load view and layout
        
        if($id) {
        $html = $this->load->view('fines/infos', array('id' => $id,'fines' =>$fines,'names' => $names), true);

        require_once("./public/dompdf/dompdf_config.inc.php");
        
        $pdf =  new DOMPDF();
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream($name . "-" . $names . ".pdf");
        }



     }




}




?>