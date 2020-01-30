<?php
class Savings extends CI_Controller {

 public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('user_logged_in')){
            //Set error
            $this->session->set_flashdata('need_login', 'Sorry, you need to be logged in to view that area');
            redirect('home/index');
        }
    }
    
    
    
     public function show_savings(){

        //$balances = $this->Savings_model->calculate_balances();

        //$fines = $this->Savings_model->fine_savings();

        $data['savings'] = $this->Savings_model->select_total_savings();

        
        //Load view and layout
        $data['main_content'] = 'savings/show';
        $this->load->view('layouts/main',$data);
    }


    public function add_chairman(){

        $this->form_validation->set_rules('amount','Amount','trim|required|xss_clean');
        $this->form_validation->set_rules('date','Date','trim|required|xss_clean');
        
        

            $amount = $this->input->post('amount');
            $date = $this->input->post('date');

            $date = date('Y-m-d',strtotime($date));

           $date_range = calculate_range($date);

           $range_dates = get_range_dates($date_range);

            //$added = $this->Dates_model->add_chairman($date,$range_dates,$amount);

            if($this->Savings_model->add_chairman($date,$range_dates,$amount)){
                return TRUE;
            }
            else
                return FALSE;
        
    }


    public function show_savings_member($id,$names){


        $data['savings'] = $this->Savings_model->select_savings($id);

        $data['names'] = $names;

        
        //Load view and layout
        $data['main_content'] = 'savings/show_member';
        $this->load->view('layouts/main',$data);
    }


    
    
    public function add_savings(){
        $this->form_validation->set_rules('member','Member','trim|required|xss_clean');
        $this->form_validation->set_rules('amount','Amount','trim|required|xss_clean');
        $this->form_validation->set_rules('date','Date','trim|required|xss_clean');
        
        if($this->form_validation->run() == FALSE){
            //Load view and layout
            $data['main_content'] = 'savings/add';
            $this->load->view('layouts/main',$data);  
        } else {

            $member = $this->input->post('member');
            $amount = $this->input->post('amount');
            $date = $this->input->post('date');

           
           $get_member = $this->Member_model->get_member($member);

           $date_clearance = $this->Savings_model->check_date_clearance($member,$date);

           $this->db->where('names',$member);
           $this->db->from('members');
           $mem = $this->db->get();

           $id = $mem->row()->member_id;

           $date_clearance = $this->Savings_model->check_date_clearance($member,$date);

            if($date_clearance->saving_status == 'passed'){
                $data['id'] = $id;
                 $data['error'] = 'Savings for this month have been payed, Please check for fines';
                 $data['main_content'] = 'savings/add';
                  $this->load->view('layouts/main',$data);
            }
           else{
                $this->Savings_model->add_savings($member,$amount,$date,$get_member->member_id);
                $this->session->set_flashdata('Savings_added', 'The saving has been added');
                //Redirect to index page with error above
                redirect('savings/show_savings');
           }
        }
    }

   
    

    public function add_savings_direct($id,$names){
        $this->form_validation->set_rules('amount','Amount','trim|required|xss_clean');
        $this->form_validation->set_rules('date','Date','trim|required|xss_clean');


        $names = urldecode($names);
        
        if($this->form_validation->run() == FALSE){
            //Load view and layout
            $data['id'] = $id;
            $data['names'] = $names;
            $data['main_content'] = 'savings/add_direct_savings';
            $this->load->view('layouts/main',$data);  
        } else {

            $amount = $this->input->post('amount');
            $date = $this->input->post('date');

            $date_clearance = $this->Savings_model->check_date_clearance($names,$date);
           
           
        if($date_clearance->saving_status == 'passed'){
            $data['id'] = $id;
                
                 $this->session->set_flashdata('Savings_pay', 'Savings for this month have been payed, Please check for fines ' .$error. "<a href ="."fines_info/$id".">here</a> or balances if any". "<a href = "."balances_info/$id".">here</a>");
                 redirect('savings/add_savings',$data);
        }
           else{
                $this->Savings_model->add_savings($names,$amount,$date,$id);
                $this->session->set_flashdata('Savings_added', 'The saving has been added');
                //Redirect to index page with error above
                redirect('savings/show_savings');
           }
        }
    }


    public function print_savings_info($id){

        $savings = $this->Savings_model->get_savings_info($id);

        $names = $this->Member_model->get_names($id);

        $total_savings = $this->Savings_model->get_member_savings_total($id);

      if($transactions) {
        $html = $this->load->view('savings/print_savings', array('savings' => $savings ,'names' => $names,'total_savings' => $total_savings, 'id' => $id), true);

        require_once("./public/dompdf/dompdf_config.inc.php");
        
        $pdf =  new DOMPDF();
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream($name . "-" . urldecode($names) . ".pdf");
      }
    }
 
    
    public function delete_saving($list_id){      
            //Delete list
            $this->List_model->delete_list($list_id);
            //Create Message
            $this->session->set_flashdata('list_deleted', 'Your list has been deleted');        
            //Redirect to list index
            redirect('lists/index');
     }

     public function fines_info($id){

        


        $data['fines'] = $this->Savings_model->get_list_fines($id);

        $data['names'] = $this->Member_model->get_member_names($id);
        
        //Load view and layout
        $data['main_content'] = 'fines/info';
        $this->load->view('layouts/main',$data);

    }

    public function balances_info($id){

        $data['balances'] = $this->Savings_model->get_list_balances($id);

        $data['names'] = $this->Member_model->get_member_names($id);

        
        //Load view and layout
        $data['main_content'] = 'balances/info';
        $this->load->view('layouts/main',$data);

}


}
