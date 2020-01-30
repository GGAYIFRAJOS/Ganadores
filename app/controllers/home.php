<?php
class Home extends CI_Controller {
    public function index(){
        if($this->session->userdata('user_logged_in')){
            //Get the logged in users id
            $user_id = $this->session->userdata('user_id');
            //Get all lists from the model
            //$data['lists'] = $this->List_model->get_all_lists($user_id);
            //$data['tasks'] = $this->Task_model->get_users_tasks($user_id);

            $this->load->model('savings_model');

            $fines = $this->Savings_model->get_all_total_fines();

            if($fines){
                 $data['members'] = $this->Member_model->get_general_member_info();
            }
            else{
                $data['members'] = $this->Member_model->get_general_member_infos();
            }

            

            $this->load->model('loan_model');
            $data['non_members'] = $this->Member_model->get_general_non_member_info();

            $data['fines'] = $this->Savings_model->get_all_total_fines();

            $data['balances'] = $this->Savings_model->get_all_total_balances();


            

            $data['years_mem'] = $this->Dates_model->get_member_year();

            $data['years_non_mem'] = $this->Dates_model->get_member_year();

           
            $data['main_content'] = 'home';
             $this->load->view('layouts/main',$data);
        }
        else{
             

             $data['main_content'] = 'users/login';
            $this->load->view('layouts/landing',$data);
        }
        
    }
  
}
