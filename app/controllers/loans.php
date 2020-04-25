<?php
class Loans extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('user_logged_in')){
            //Set error
            $this->session->set_flashdata('need_login', 'Sorry, you need to be logged in to view that area');
            redirect('home/index');
        }
    }
    
    

    public function loan_list(){
        $data['title']= 'Member List';
        $data['members'] = $this->Member_model->get_members();
        $this->load->view('loans/add',$data);
    }
    
     public function show_loans(){

        // $loans_members = $this->Loan_model->get_loans_members();

        // $today = date('Y-m-d');

        // //$today = new DateTime($today);


        // foreach($loans_members as $loan){
        //     $due_date = $loan->due_date;

        //     //$due_date = new DateTime($due_date);

        //     if( $today > $due_date){
                    

        //             $member_id = $loan->member_id;

        //             $new_due_date = strtotime('+1 month',strtotime($due_date));

        //             $new_due_date = date('Y-m-d',$new_due_date);

        //             $fine_amount = $loan->balance * 0.05;

        //             $total_amount = $loan->balance + $fine_amount;

        //             $loan_date = $loan->loan_date;

        //             $loan_days = date('d',strtotime($loan_date));

        //             $loan_month = date('m',strtotime($loan_date));

        //             $fine_days = date('d',strtotime($today));

        //             $fine_month = date('m',strtotime($today));

                    

        //             if($fine_month - $loan_month){
        //                 $range = ($fine_month - $loan_month) + 1;
        //             }
        //             else{
        //                 $range = ($loan_month - $fine_month) + 1;
        //             }

        //             $last_sched_date = strtotime("+$range months",strtotime($loan_date));

        //             $last_sched_date = date('Y/m/d',$last_sched_date);

        //             $prev_range = $range - 1;

        //             $prev_sched_date = strtotime("+$prev_range months",strtotime($loan_date));

        //             $prev_sched_date = date('Y/m/d',$prev_sched_date);

        //             $range_dates = "$prev_sched_date - $last_sched_date";


        //             $data = array(
        //                 'names' => $loan->names,
        //                 'identification_id' => $loan->member_id,
        //                 'fine' => $fine_amount,
        //                 'membership' => 'member',
        //                 'loan_id' => $loan->id,
        //                 'loan_range' => $range,
        //                 'balance' => $total_amount,
        //                 'loan_range_dates' => $range_dates,
        //                 'prev_amount' => $loan->balance,
        //                 'total_amount' => $total_amount
        //             );

        //             $this->db->insert('loan_progress',$data);
                

        //             $this->db->update('member_loan_info',array('balance' => $total_amount,'due_date' =>  $new_due_date),array('member_id' => $member_id ));
        //     }
            
        // }


        // $loans_non_members = $this->Loan_model->get_loans_non_members();

        
        // foreach($loans_non_members as $loan){
        //     $non_due_date = $loan->due_date;

        //     if( $today > $non_due_date){

        //             $non_member_id = $loan->non_member_id;

        //             $new_due_date = strtotime('+1 month',strtotime($non_due_date));

        //             $new_due_date = date('Y-m-d',$new_due_date);

        //             $total_amount = $loan->balance + ($loan->balance * 0.1);

        //             $info = $this->Loan_model->get_non_member_loan($non_member_id);

        //             $loan_date = $info->loan_date;

        //             $loan_days = date('d',strtotime($loan_date));

        //             $loan_month = date('m',strtotime($loan_date));

        //             $fine_days = date('d',strtotime($today));

        //             $fine_month = date('m',strtotime($today));


        //             if($fine_month - $loan_month){
        //                 $range = ($fine_month - $loan_month) + 1;
        //             }
        //             else{
        //                 $range = ($loan_month - $fine_month) + 1;
        //             }

        //             $last_sched_date = strtotime("+$range months",strtotime($loan_date));

        //            $last_sched_date = date('Y/m/d',$last_sched_date);

        //             $prev_range = $range - 1;

        //             $prev_sched_date = strtotime("+$prev_range months",strtotime($loan_date));

        //             $prev_sched_date = date('Y/m/d',$prev_sched_date);

        //             $range_dates = "$prev_sched_date - $last_sched_date";


        //             $data = array(
        //                 'names' => $info->names,
        //                 'identification_id' => $non_member_id,
        //                 'fine' => $fine_amount,
        //                 'membership' => 'non_member',
        //                 'loan_id' => $info->id,
        //                 'loan_range' => $range,
        //                 'balance' => $total_amount,
        //                 'loan_range_dates' => $range_dates,
        //                 'prev_amount' => $info->total_amount,
        //                 'total_amount' => $total_amount
        //             );

        //             $this->db->insert('loan_progress',$data);

        //             $this->db->update('non_member_loan_info',array('balance' => $total_amount,'due_date' =>  $new_due_date),array('non_member_id' => $non_member_id ));
        //     }
        // }

        $data['mem_loans'] = $this->Loan_model->get_loans_members();

        $data['non_loans'] = $this->Loan_model->get_loans_non_members();
        
        $data['main_content'] = 'loans/show';
        $this->load->view('layouts/main',$data);
    }

    public function show_loans_general(){

         $data['mem_loans'] = $this->Loan_model->get_loans_gen_members();

        $data['non_loans'] = $this->Loan_model->get_loans_gen_non_members();
        
        $data['main_content'] = 'loans/show_general';
        $this->load->view('layouts/main',$data);
    }

    public function show_loan_member(){
        
        $id= $this->session->userdata('user_id');

        $data['names'] = $this->session->userdata('user_name');

        $data['mem_loans'] = $this->Loan_model->get_loan_member($id);
        
        $data['main_content'] = 'loans/show_general';
        $this->load->view('layouts/main',$data);
    }
    
    
    public function add_loan_member(){
        $this->form_validation->set_rules('member','Member','trim|required|xss_clean');
        $this->form_validation->set_rules('amount','Amount','trim|required|xss_clean');
        $this->form_validation->set_rules('date','Date','trim|required|xss_clean');
        
        if($this->form_validation->run() == FALSE){
            //Load view and layout
            $data['main_content'] = 'loans/add_member';
            $this->load->view('layouts/main',$data);
        } else {

            $member = $this->input->post('member');
            $amount = $this->input->post('amount');
            $date = $this->input->post('date');
            $interest = 5;
           
           $get_member = $this->Member_model->get_member($member); 
           $id = $get_member->id;

           $check_balance = $this->Loan_model->check_system_balance($amount);

           $check_loan_exist = $this->Loan_model->check_loan_exist_member($id);

           // if(!$check_balance){
           //      $data['error'] = 'There is insufficient money in the system to cover loan. Try again later';
           //      $data['main_content'] = 'loans/add_member';
           //      $this->load->view('layouts/main',$data);

           // }
           // else if($check_loan_exist){
           //      $data['error'] = 'The Member already has a loan.';
           //      $data['main_content'] = 'loans/add_member';
           //      $this->load->view('layouts/main',$data);
           // }
           // else{
           //      $this->Loan_model->add_loan($member,$amount,$date,$id,$interest);
           //      $this->session->set_flashdata('Loan_added', 'The loan has been added');
           //      //Redirect to index page with error above
           //      redirect('loans/show_loans');
           // }
           //$this->form_validation->set_message('validate_member','Member already has a loan!');
           if($this->Loan_model->add_loan($member,$amount,$date,$id,$interest)){
                $this->session->set_flashdata('Loan_added', 'The loan has been added');
                //Redirect to index page with error above
                redirect('loans/show_loans');
           }
          

           //$this->form_validation->set_message('validate_amount','Amount exceeds the amount in the system, try again later!');
         
        }
    }

    


    public function add_loan_non_member(){
        $this->form_validation->set_rules('names','Names','trim|required|xss_clean');
        $this->form_validation->set_rules('amount','Amount','trim|required|xss_clean');
        $this->form_validation->set_rules('adress','Adress','trim|xss_clean');
        $this->form_validation->set_rules('email','Email','trim|xss_clean');
        $this->form_validation->set_rules('contact','Contact','trim|xss_clean');
        $this->form_validation->set_rules('date','Date','trim|required|xss_clean');
        
        if($this->form_validation->run() == FALSE){
            //Load view and layout
            $data['main_content'] = 'loans/add_non_member';
            $this->load->view('layouts/main',$data);  
        } else {

            $name = $this->input->post('names');
            $amount = $this->input->post('amount');
            $date = $this->input->post('date');
            $adress = $this->input->post('adress');
            $email = $this->input->post('email');
            $contact = $this->input->post('contact');
            
            $interest = 10;


           $check_balance = $this->Loan_model->check_system_balance($amount);

           $check_loan_exist = $this->Loan_model->check_loan_exist_non_member($name);

           if($check_balance){
                $data['error'] = 'There is insufficient money in the system to cover loan. Try again later';
                $data['main_content'] = 'loans/add_loan_member';
                $this->load->view('layouts/main',$data);

           }
           else if($check_loan_exist){
                $data['error'] = 'This person already has a loan.';
                $data['main_content'] = 'loans/add_loan_member';
                $this->load->view('layouts/main',$data);
           }
           else{
                $this->Loan_model->add_non_member($name,$amount,$adress,$email,$contact,$date,$interest);
                $this->session->set_flashdata('Loan_added', 'The loan has been added');
                //Redirect to index page with error above
                redirect('loans/show_loans');
           }
        }
    }

    public function member_loan_freeze($id,$names){

        if($this->Loan_model->freeze_member_loan($id)){

            $this->session->set_flashdata('Loan_freeze', "The loan for $names has been frozen");
                //Redirect to index page with error above
                redirect('loans/show_loans');
        }
        else{
            $this->session->set_flashdata('Loan_not_freeze', "The loan for $names could not be frozen, please check loan details for more information");
                //Redirect to index page with error above
                redirect('loans/show_loans');
        }
    }

    public function validate_non_member($names)
    {
    
       if($this->Loan_model->check_loan_exist_non_member($names))
       {
         $this->form_validation->set_message('validate_non_member','Non_Member already has a loan!');
         return FALSE;
       }
       else
       {
         
         return TRUE;
       }
    }

    public function validate_non_amount($amount)
    {
    
       if($this->Loan_model->check_system_balance($amount))
       {
        $this->form_validation->set_message('validate_non_amount','Amount currently not available in the system!');
         return FALSE;
       }
       else
       {
         return TRUE;
       }
    }

    public function member_loan_payment($id){

       
        $this->form_validation->set_rules('amount','Amount','trim|required|xss_clean');
        $this->form_validation->set_rules('date','Date','trim|required|xss_clean');

        

        if($this->form_validation->run() == FALSE){
            $data['names'] = $this->Member_model->get_member_names($id);
            $data['member_id'] = $id;
            $data['members'] = $this->Member_model->get_members();
            $data['main_content'] = 'loans/member_payment';
            $this->load->view('layouts/main',$data); 
        }
        else{
            $member = $this->Member_model->get_member_names($id);
            $amount = $this->input->post('amount');
            $date = $this->input->post('date');

            $date = date('Y-m-d',strtotime($date));

            $payment = $this->Loan_model->member_payment($member,$amount,$date,$id); 
        
           if($payment > 0){
                $this->session->set_flashdata('Payment registered', 'The Payment has been registered');
                //Redirect to index page with error above
                redirect('loans/show_loans');
           }


        }

        
        
    }

    public function non_member_loan_payment($id){

        
        $this->form_validation->set_rules('amount','Amount','trim|required|xss_clean');
        $this->form_validation->set_rules('date','Date','trim|required|xss_clean');

        

        if($this->form_validation->run() == FALSE){
            $data['names'] = $this->Member_model->get_non_member_names($id);
            $data['member_id'] = $id;
            $data['members'] = $this->Member_model->get_non_members();
            $data['main_content'] = 'loans/non_member_payment';
            $this->load->view('layouts/main',$data); 
        }
        else{
            $member = $this->Member_model->get_non_member_names($id);
            $amount = $this->input->post('amount');
            $date = $this->input->post('date');

            $date = date('Y-m-d',strtotime($date));

            $payment = $this->Loan_model->non_member_payment($member,$amount,$date,$id); 
        
           if($payment > 0){
                $this->session->set_flashdata('Payment registered', 'The Payment has been registered');
                //Redirect to index page with error above
                redirect('loans/show_loans');
           }


        }

    }
    
    
    
    
    public function edit_loan($list_id){
        $this->form_validation->set_rules('list_name','List Name','trim|required|xss_clean');
        $this->form_validation->set_rules('list_body','List Body','trim|xss_clean');
        
        if($this->form_validation->run() == FALSE){
            //Get the current list info
            $data['this_list'] = $this->List_model->get_list_data($list_id);
            //Load view and layout
            $data['main_content'] = 'lists/edit_list';
            $this->load->view('layouts/main',$data);  
        } else {
            //Validation has ran and passed  
             //Post values to array
            $data = array(             
                'list_name'    => $this->input->post('list_name'),
                'list_body'    => $this->input->post('list_body'),
                'list_user_id' => $this->session->userdata('user_id')
            );
           if($this->List_model->edit_list($list_id,$data)){      
                $this->session->set_flashdata('list_updated', 'Your task list has been updated');
                //Redirect to index page with error above
                redirect('lists/index');
           }
        }
    }
    
    
    public function delete_loan_member($member_id){      
            
            $deleted = $this->Loan_model->delete_loan_member($member_id);

            //Create Message
            if($deleted){
                $this->session->set_flashdata('loan_deleted', 'Your Loan has been succesfully deleted');        
            
                redirect('home/index');
            }
            else
                redirect('loans/show_loans');
     }

      public function delete_loan_non_member($non_member_id){      
            //Delete list
            $deleted = $this->Loan_model->delete_loan_non_member($non_member_id);

            //Create Message
            if($deleted){
                $this->session->set_flashdata('loan_deleted', 'Your Loan has been succesfully deleted');        
                redirect('home/index');
            }
            else
                redirect('loans/show_loans');
            
     }


     public function get_loan_progress_member($id,$names){

        $membership = 'member';

        $progress = $this->Loan_model->get_loan_prog($id,$membership);

        $loan_info = $this->Loan_model->get_member_loan($id);

        $loan_date = $loan_info->loan_date;

        $loan_amount = $loan_info->amount;

        $loan_interest = $loan_info->interest;

        $loan_total = $loan_amount + $loan_interest;

        if($progress) {
        $html = $this->load->view('loans/member_progress', array('id' => $id,'names' =>$names,'progress' => $progress,'loan_date'=> $loan_date, 'loan_amount'=>$loan_amount,'loan_interest'=>$loan_interest,'loan_total'=>$loan_total), true);

        require_once("./public/dompdf/dompdf_config.inc.php");
        
        $pdf =  new DOMPDF();
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream($name . "-" . $names . ".pdf");
        }
     }

     public function get_member_loan_info($id,$names){
        $membership= 'member';

        $data['progress'] = $this->Loan_model->get_loan_prog($id,$membership);

        $loan_info = $this->Loan_model->get_member_loan($id);

        $data['loan_date'] = $loan_info->loan_date;

        $loan_amount= $loan_info->amount;

        $data['loan_amount'] = $loan_amount;

        $data['loans'] = $this->Loan_model->get_member_loans($id);

        $loan_interest= $loan_info->interest;

        $data['loan_interest'] = $loan_interest;

        $data['loan_total'] = $loan_amount + $loan_interest;

        $data['names'] = $names;

        $data['id'] = $id;


        $data['main_content'] = 'loans/member_loan_progress';
        $this->load->view('layouts/main',$data);

        
        // $this->load->view('loans/member_loan_progress', array('id' => $id,'names' =>$names,'progress' => $progress,'loan_date'=> $loan_date, 'loan_amount'=>$loan_amount,'loan_interest'=>$loan_interest,'loan_total'=>$loan_total), true);
        
     }

     public function get_member_id($member){

        $this->db->where('names',$member);
        $this->db->from('members');

        $info = $this->db->get();

        if($info->num_rows > 0){

            return $info->row()->id;
        }
        else
            return FALSE;
    }

     public function get_member_loan_info2(){
        $membership= 'member';

        $names = $this->session->userdata('user_name');

        $id = $this->get_member_id($names);

        $data['progress'] = $this->Loan_model->get_loan_prog($id,$membership);

        $loan_info = $this->Loan_model->get_member_loan($id);

        $data['loan_date'] = $loan_info->loan_date;

        $loan_amount= $loan_info->amount;

        $data['loan_amount'] = $loan_amount;

        $data['loans'] = $this->Loan_model->get_member_loans($id);

        $loan_interest= $loan_info->interest;

        $data['loan_interest'] = $loan_interest;

        $data['loan_total'] = $loan_amount + $loan_interest;

        $data['names'] = $this->session->userdata('user_name');

        $data['id'] = $id;


        $data['main_content'] = 'loans/member_loan_progress2';
        $this->load->view('layouts/main',$data);

        
        // $this->load->view('loans/member_loan_progress', array('id' => $id,'names' =>$names,'progress' => $progress,'loan_date'=> $loan_date, 'loan_amount'=>$loan_amount,'loan_interest'=>$loan_interest,'loan_total'=>$loan_total), true);
        
     }

     public function get_loan_progress_non_member($id,$names){

        $membership = 'non_member';

        $progress = $this->Loan_model->get_non_loan_prog($id,$membership);

        $loan_info = $this->Loan_model->get_non_member_loan($id);

        $loan_date = $loan_info->loan_date;

        $loan_amount = $loan_info->amount;

        $loan_interest = $loan_info->interest;

        $loan_total = $loan_amount + $loan_interest;

        if($progress) {
        $html = $this->load->view('loans/non_member_progress', array('id' => $id,'names' =>$names,'progress' => $progress,'loan_date'=> $loan_date, 'loan_amount'=>$loan_amount,'loan_interest'=>$loan_interest,'loan_total'=>$loan_total), true);

        require_once("./public/dompdf/dompdf_config.inc.php");
        
        $pdf =  new DOMPDF();
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream($name . "-" . $names . ".pdf");
        }



     }


      public function get_loan_payment_member($id,$names){

        $membership = 'member';

        $payments = $this->Loan_model->get_member_payments_print($id);

        $loan_info = $this->Loan_model->get_member_loan($id);

        $loan_date = $loan_info->loan_date;

        $loan_amount = $loan_info->amount;

        $loan_interest = $loan_info->interest;

        $loan_total = $loan_amount + $loan_interest;

        if($payments ) {
        $html = $this->load->view('payments/print_member_loan', array('id' => $id,'names' =>$names,'payment' => $payments,'loan_date'=> $loan_date, 'loan_amount'=>$loan_amount,'loan_interest'=>$loan_interest,'loan_total'=>$loan_total), true);

        require_once("./public/dompdf/dompdf_config.inc.php");
        
        $pdf =  new DOMPDF();
        $pdf->load_html($html);
        $pdf->render();
        $pdf->stream($name . "-" . $names . ".pdf");
        }



     }

    

}
