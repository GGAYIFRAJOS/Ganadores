<?php
class Members extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('user_logged_in')){
            //Set error
            $this->session->set_flashdata('need_login', 'Sorry, you need to be logged in to view that area');
            redirect('home/index');
        }
    }
    
    public function index(){
        //Get the logged in users id
        $user_id = $this->session->userdata('user_id');
        //Get all lists from the model
        $data['lists'] = $this->List_model->get_all_lists($user_id);
        
        //Load view and layout
        $data['main_content'] = 'lists/index';
        $this->load->view('layouts/main',$data);
    }


    // public function refresh_info($id){

    //     $loan_member = $this->Loan_model->get_loan_member($id);

    //     $today = date('Y-m-d');

    //     //$today = new DateTime($today);


    //    if($loan_member){

    //         $loan = $loan_member;

    //         $due_date = $loan->due_date;

    //         //$due_date = new DateTime($due_date);

    //         if( $today > $due_date){
                    

    //                 $member_id = $loan->member_id;

    //                 $new_due_date = strtotime('+1 month',strtotime($due_date));

    //                 $new_due_date = date('Y-m-d',$new_due_date);

    //                 $fine_amount = $loan->balance * 0.05;

    //                 $total_amount = $loan->balance + $fine_amount;

    //                 $loan_date = $loan->loan_date;

    //                 $loan_days = date('d',strtotime($loan_date));

    //                 $loan_month = date('m',strtotime($loan_date));

    //                 $fine_days = date('d',strtotime($today));

    //                 $fine_month = date('m',strtotime($today));

                    

    //                 if($fine_month - $loan_month){
    //                     $range = ($fine_month - $loan_month) + 1;
    //                 }
    //                 else{
    //                     $range = ($loan_month - $fine_month) + 1;
    //                 }

    //                 $last_sched_date = strtotime("+$range months",strtotime($loan_date));

    //                 $last_sched_date = date('Y/m/d',$last_sched_date);

    //                 $prev_range = $range - 1;

    //                 $prev_sched_date = strtotime("+$prev_range months",strtotime($loan_date));

    //                 $prev_sched_date = date('Y/m/d',$prev_sched_date);

    //                 $range_dates = "$prev_sched_date - $last_sched_date";


    //                 $data = array(
    //                     'names' => $loan->names,
    //                     'identification_id' => $loan->member_id,
    //                     'fine' => $fine_amount,
    //                     'membership' => 'member',
    //                     'loan_id' => $loan->id,
    //                     'loan_range' => $range,
    //                     'balance' => $total_amount,
    //                     'loan_range_dates' => $range_dates,
    //                     'prev_amount' => $loan->balance,
    //                     'total_amount' => $total_amount
    //                 );

    //                 $this->db->insert('loan_progress',$data);
                

    //                 $this->db->update('member_loan_info',array('balance' => $total_amount,'due_date' =>  $new_due_date),array('member_id' => $member_id ));
    //         }
            
    //     }


        


    //     $balances = $this->Savings_model->calculate_balances_member($id);

    //     $fines = $this->Savings_model->fine_savings_member($id);

    //     $this->session->set_flashdata('refreshed', 'The member information has been refreshed succesfully!');
    //         redirect('members/get_member_info/'.$id);

    // }


    public function refresh_info($id){

        $loan_payment = $this->Loan_model->get_member_payments($id);

        $today = date('Y-m-d');

        $loan_info = $this->Loan_model->get_member_loan($id);

        //$today = new DateTime($today);

        //$balance = $loan_info->balance;

        $loan_date = $loan_info->loan_date;

        $loan_id = $loan_info->id;

        $name = $loan_info->names;

        $balance_from_range = $this->Loan_model->get_first_range_balance($loan_id,$id);

        $balance = $balance_from_range->range_balance;


        // $next_loan_date = strtotime("+1 month", strtotime($loan_date));

        // $next_loan_date = date('Y-m-d',$next_loan_date);

        $range_var = 1;

        $prev_amount = 0;

        $prev_amount_total = 0;


       foreach($loan_payment as $payment){

        //$new_balance = $balance - $payment->payment_amount;

            $payment_date = $payment->payment_date;

            $amount = $payment->payment_amount;

            //$prev_balance = 0;

            $payment_id = $payment->id;

            $range = $this->Loan_model->get_payment_range($id,$payment_date);

            $range_info = $this->Loan_model->get_range_info($loan_id,$range);

            if($range != $range_var){

                $range_diff = $range - $range_var;

                if($range_diff > 1){

                    for($i = 0; $i < ($range_diff - 1); $i++){

                        $balance_prev = $balance;

                        $fine = $balance * 0.05;

                        $balance = $fine + $balance;

                        ++$range_var;

                        $range_dates = $this->Dates_model->get_loan_range_dates($range_var,$loan_date);

                        $total_owed = $balance_prev + $fine;

                        $data = array(
                            'identification_id' => $id,
                            'membership' => 'member',
                            'loan_id' => $loan_id,
                            'type' => 'fine',
                            'range_dates' => $range_dates,
                            'amount_forward' => $balance_prev,
                            'fine' => $fine,
                            'amount_paid' => 0,
                            'total_owed' => $total_owed,
                            'total_paid' => $prev_amount_total,
                            'balance' => $balance
                        );

                        $this->db->insert('loan_progress_update',$data);
                    }

                    $balance_prev = $balance;

                    $prev_range = $range - 1;

                    $range_info_curr = $this->Loan_model->get_range_info($loan_id,$range);

                    $max_date_curr = $range_info_curr->max_date;

                    $range_info_prev = $this->Loan_model->get_range_info($loan_id,$prev_range);

                    $max_date_prev = $range_info_prev->max_date;



                    $days_max_prev = date('z',strtotime($max_date_prev));

                    $days_pay = date('z',strtotime($payment_date));

                    $days = $days_pay - $days_max_prev;


                    $days_curr = date('z',strtotime($max_date_curr));

                    $days_div = $days_curr - $days_max_prev;


                    $month_balance = $balance * 0.05;

                    $daily_balance = $month_balance / $days_div;

                    $added_balance =  $days * $daily_balance;

                    $balance = $balance + $added_balance;

                    $balance = $balance - $amount;

                    //$total_paid = $balance_prev + $balance;

                    $amount_total = $prev_amount + $amount;

                    $range_dates = $this->Dates_model->get_loan_range_dates($range,$loan_date);

                    $total_owed = $balance_prev + $added_balance;

                    $data = array(
                        'identification_id' => $id,
                        'membership' => 'member',
                        'loan_id' => $loan_id,
                        'type' => 'loan_payment',
                        'range_dates' => $range_dates,
                        'amount_forward' => $balance_prev,
                        'interest' => $added_balance,
                        'amount_paid' => $amount,
                        'total_owed' => $total_owed,
                        'total_paid' => $amount_total,
                        'balance' => $balance
                    );

                    $data_transact = array(
                            'member_id' =>$id,
                            'names' => $name,
                            'type' => 'loan_payment',
                            'amount' => $amount,
                            'payment_id' => $payment_id,
                            'date' => $payment_date
                    );

                    $insert = $this->db->insert('transactions', $data_transact);

                    if($balance <= 0){
                         $this->db->update('member_loan_info',array('balance' => $balance,'status'=>'PAID'),array('id' => $id));
                    }
                    else
                         $this->db->update('member_loan_info',array('balance' => $balance),array('id' => $id));
           
         

                    $this->db->insert('loan_progress_update',$data);

                    $this->db->update('payments',array('balance' => $balance, 'status' => 'fined'),array('id' => $payment_id));

                    $this->db->update('loan_ranges',array('range_balance' => $balance),array('loan_id' => $loan_id , 'loan_range' => $range));

                    $prev_amount = $amount_total;

                }
                else{

                    //$balance = $balance + ($balance * 0.05);

                    $balance_prev = $balance;

                    $range_info = $this->Loan_model->get_range_info($loan_id,$range);

                    $max_date = $range_info->max_date;

                    if($payment_date != $max_date){

                        $range_info_curr = $this->Loan_model->get_range_info($loan_id,$range);

                        $max_date_curr = $range_info_curr->max_date;

                        $days_curr = date('z',strtotime($max_date_curr));


                        $prev_range = $range - 1;

                        $prev_range_info = $this->Loan_model->get_range_info($loan_id,$prev_range);

                        $prev_max_date = $prev_range_info->max_date;

                        $days_prev = date('z',strtotime($prev_max_date));


                        $days_pay = date('z',strtotime($payment_date));

                        $days = $days_pay - $days_prev;

                        $days_div = $days_curr - $days_prev;


                        $month_balance = $balance * 0.05;

                        $daily_balance = $month_balance / $days_div;

                        $added_balance = $days * $daily_balance;

                        $balance = $balance + $added_balance;

                        $balance = $balance - $amount;

                        

                        $range_dates = $this->Dates_model->get_loan_range_dates($range,$loan_date);

                        //$total_paid = $balance_prev + $amount;

                        $amount_total = $prev_amount + $amount;

                        $total_owed = $balance_prev + $added_balance;

                        $data = array(
                            'identification_id' => $id,
                            'membership' => 'member',
                            'loan_id' => $loan_id,
                            'type' => 'loan_payment',
                            'range_dates' => $range_dates,
                            'amount_forward' => $balance_prev,
                            'interest' => $added_balance,
                            'amount_paid' => $amount,
                            'total_owed' => $total_owed,
                            'total_paid' => $amount_total,
                            'balance' => $balance
                        );

                        $data_transact = array(
                            'member_id' =>$id,
                            'names' => $name,
                            'type' => 'loan_payment',
                            'amount' => $amount,
                            'payment_id' => $payment_id,
                            'date' => $payment_date
                        );

                        $insert = $this->db->insert('transactions', $data_transact);

                        $this->db->insert('loan_progress_update',$data);

                        $prev_amount = $amount_total;

                    }
                    else{

                        $balance_prev = $balance;

                        $interest = ($balance * 0.05);

                        $balance = $balance + $interest;

                        $balance = $balance - $amount;

                        $range_dates = $this->Dates_model->get_loan_range_dates($range,$loan_date);

                        //$total_paid = $balance_prev + $amount;

                        $amount_total = $prev_amount + $amount;

                        $total_owed = $balance_prev + $added_balance;

                        $data = array(
                            'identification_id' => $id,
                            'membership' => 'member',
                            'loan_id' => $loan_id,
                            'type' => 'loan_payment',
                            'range_dates' => $range_dates,
                            'amount_forward' => $balance_prev,
                            'interest' => $interest,
                            'amount_paid' => $amount,
                            'total_owed' => $total_owed,
                            'total_paid' => $amount_total,
                            'balance' => $balance
                        );

                         $data_transact = array(
                            'member_id' =>$id,
                            'names' => $name,
                            'type' => 'loan_payment',
                            'amount' => $amount,
                            'payment_id' => $payment_id,
                            'date' => $payment_date
                        );

                        $insert = $this->db->insert('transactions', $data_transact);

                        $this->db->insert('loan_progress_update',$data);

                        $prev_amount = $amount_total;

                    }

                     if($balance <= 0){
                         $this->db->update('member_loan_info',array('balance' => $balance,'status'=>'PAID'),array('id' => $id));
                    }
                    else
                         $this->db->update('member_loan_info',array('balance' => $balance),array('id' => $id));

                    
                    $this->db->update('payments',array('balance' => $balance, 'status' => 'fined'),array('id' => $payment_id));


                    $this->db->update('loan_ranges',array('range_balance' => $balance),array('loan_id' => $loan_id , 'loan_range' => $range));

                }
            

                $range_var = $range;
            }

            else{

                    $range_info = $this->Loan_model->get_range_info($loan_id,$range);

                    $max_date = $range_info->max_date;


                    $range_dates = $this->Dates_model->get_loan_range_dates($range,$loan_date);

                    if($payment_date != $max_date){
                        
                        if($range == 1){

                            $balance_prev = $balance;

                            $days_max = date('z',strtotime($max_date));

                            $days_loan = date('z',strtotime($loan_date));

                            $days_div = $days_max - $days_loan;

                           

                            $days_1 = date('z',strtotime($loan_date));

                            $days_2 = date('z',strtotime($payment_date));

                            $days = $days_2 - $days_1;




                            $month_balance = $balance * 0.05;

                            $daily_balance = $month_balance / $days_div;

                            $added_balance = $days * $daily_balance;

                            $balance = $balance + $added_balance;

                            $balance = $balance - $amount;

                            //$total_paid = $balance_prev + $amount;

                            $amount_total = $prev_amount + $amount;

                            $total_owed = $balance_prev + $added_balance;

                            $data = array(
                                'identification_id' => $id,
                                'membership' => 'member',
                                'loan_id' => $loan_id,
                                'type' => 'loan_payment',
                                'range_dates' => $range_dates,
                                'amount_forward' => $balance_prev,
                                'interest' => $added_balance,
                                'amount_paid' => $amount,
                                'total_owed' => $total_owed,
                                'total_paid' => $amount_total,
                                'balance' => $balance
                            );

                            $data_transact = array(
                                'member_id' =>$id,
                                'names' => $name,
                                'type' => 'loan_payment',
                                'amount' => $amount,
                                'payment_id' => $payment_id,
                                'date' => $payment_date
                            );

                            $insert = $this->db->insert('transactions', $data_transact);

                            $this->db->insert('loan_progress_update',$data);

                            $prev_amount = $amount_total;
                        }
                        else{

                            $balance_prev = $balance;

                            $prev_range = $range - 1;

                            $prev_range_info = $this->Loan_model->get_range_info($loan_id,$prev_range);

                            $prev_max_date = $prev_range_info->max_date;

                            $days_prev = date('z',strtotime($prev_max_date));

                            $days_max = date('z',strtotime($max_date));

                            $days_div = $days_max -  $days_prev;



                            $days_max_2 = date('z',strtotime($prev_max_date));

                            $days_pay = date('z',strtotime($payment_date));

                            $days = $days_pay - $days_max_2;



                            $month_balance = $balance * 0.05;

                            $daily_balance = $month_balance / $days_div;

                            $added_balance = $days * $daily_balance;

                            $balance = $balance + $added_balance;

                            $balance = $balance - $amount;


                            //$total_paid = $balance_prev + $amount;

                            $amount_total = $prev_amount + $amount;

                             $total_owed = $balance_prev + $added_balance;

                            $data = array(
                                'identification_id' => $id,
                                'membership' => 'member',
                                'loan_id' => $loan_id,
                                'range_dates' => $range_dates,
                                'type' => 'loan_payment',
                                'amount_forward' => $balance_prev,
                                'interest' => $added_balance,
                                'total_owed' => $total_owed,
                                'amount_paid' => $amount,
                                'total_paid' =>  $amount_total,
                                'balance' => $balance
                            );

                             $data_transact = array(
                                'member_id' =>$id,
                                'names' => $name,
                                'type' => 'loan_payment',
                                'amount' => $amount,
                                'payment_id' => $payment_id,
                                'date' => $payment_date
                            );

                            $insert = $this->db->insert('transactions', $data_transact);

                            $this->db->insert('loan_progress_update',$data);

                            $prev_amount = $amount_total;

                        }

                    }
                    else{

                        $balance_prev = $balance;

                        $fine = ($balance * 0.05);

                        $balance = $balance +  $fine;

                        $balance = $balance - $amount;

                        //$total_paid = $balance_prev + $amount;

                        $amount_total = $prev_amount + $amount;

                         $total_owed = $balance_prev + $fine;

                        $data = array(
                            'identification_id' => $id,
                            'membership' => 'member',
                            'loan_id' => $loan_id,
                            'range_dates' => $range_dates,
                            'type' => 'loan_payment',
                            'amount_forward' => $balance_prev,
                            'interest' => $fine,
                            'amount_paid' => $amount,
                            'total_owed' => $total_owed,
                            'total_paid' => $amount_total,
                            'balance' => $balance
                        );


                        $data_transact = array(
                            'member_id' =>$id,
                            'names' => $name,
                            'type' => 'loan_payment',
                            'amount' => $amount,
                            'payment_id' => $payment_id,
                            'date' => $payment_date
                        );

                        $insert = $this->db->insert('transactions', $data_transact);

                        $this->db->insert('loan_progress_update',$data);

                        $prev_amount = $amount_total;

                    }

                     if($balance <= 0){
                         $this->db->update('member_loan_info',array('balance' => $balance,'status'=>'PAID'),array('id' => $id));
                    }
                    else
                         $this->db->update('member_loan_info',array('balance' => $balance),array('id' => $id));


                    $this->db->update('payments',array('balance' => $balance, 'status' => 'fined'),array('id' => $payment_id));

                    $this->db->update('loan_ranges',array('range_balance' => $balance),array('loan_id' => $loan_id , 'loan_range' => $range));


                }

                
                //$prev_amount = $amount;

                $prev_amount_total = $amount_total;
            
        }

       
        $this->session->set_flashdata('refreshed', 'The member loan  information has been refreshed succesfully!');
            redirect('members/get_member_info/'.$id);

    }


    public function refresh_member_savings($id){

        $balances = $this->Savings_model->calculate_balances_member($id);

        $fines = $this->Savings_model->fine_savings_member($id);

        if(($balances > 0) || ($fines > 0)){
            $this->session->set_flashdata('refreshed', 'The member savings information has been refreshed succesfully!');
            redirect('members/get_member_info/'.$id);
        }
        else{
            $this->session->set_flashdata('refreshed', 'The member savings information has already been refreshed!');
            redirect('members/get_member_info/'.$id);
        }


    }



    public function refresh_non_member_info($id){

        $loan_payment = $this->Loan_model->get_non_member_payments($id);

        $today = date('Y-m-d');

        $loan_info = $this->Loan_model->get_non_member_loan($id);

        //$today = new DateTime($today);

        //$balance = $loan_info->balance;

        $loan_date = $loan_info->loan_date;

        $name = $loan_info->non_member;

        $loan_id = $loan_info->id;

        $balance_from_range = $this->Loan_model->get_first_range_balance($loan_id,$id);

        $balance = $balance_from_range->range_balance;


        // $next_loan_date = strtotime("+1 month", strtotime($loan_date));

        // $next_loan_date = date('Y-m-d',$next_loan_date);

        $range_var = 1;

        $prev_amount = 0;

        $prev_amount_total = 0;


       foreach($loan_payment as $payment){

        //$new_balance = $balance - $payment->payment_amount;

            $payment_date = $payment->payment_date;

            $amount = $payment->payment_amount;

            //$prev_balance = 0;

            $payment_id = $payment->id;

            $range = $this->Loan_model->get_payment_range($id,$payment_date);

            $range_info = $this->Loan_model->get_range_info($loan_id,$range);

            if($range != $range_var){

                $range_diff = $range - $range_var;

                if($range_diff > 1){

                    $balance_prev = $balance;

                    for($i = 0; $i < ($range_diff - 1); $i++){

                        $balance_prev = $balance;

                        $fine = $balance * 0.05;

                        $balance = $fine + $balance;

                        ++$range_var;

                        $range_dates = $this->Dates_model->get_loan_range_dates($range_var,$loan_date);

                         $total_owed = $balance_prev + $fine;

                        $data = array(
                            'identification_id' => $id,
                            'membership' => 'non_member',
                            'loan_id' => $loan_id,
                            'type' => 'fine',
                            'range_dates' => $range_dates,
                            'amount_forward' => $balance_prev,
                            'fine' => $fine,
                            'amount_paid' => 0,
                            'total_owed' => $total_owed,
                            'total_paid' => $prev_amount_total,
                            'balance' => $balance
                        );

                        $this->db->insert('loan_progress_update',$data);
                    }

                    $balance_prev = $balance;

                    $prev_range = $range - 1;

                    $range_info_curr = $this->Loan_model->get_range_info($loan_id,$range);

                    $max_date_curr = $range_info_curr->max_date;

                    $range_info_prev = $this->Loan_model->get_range_info($loan_id,$prev_range);

                    $max_date_prev = $range_info_prev->max_date;



                    $days_max_prev = date('z',strtotime($max_date_prev));

                    $days_pay = date('z',strtotime($payment_date));

                    $days = $days_pay - $days_max_prev;


                    $days_curr = date('z',strtotime($max_date_curr));

                    $days_div = $days_curr - $days_max_prev;


                    $month_balance = $balance * 0.05;

                    $daily_balance = $month_balance / $days_div;

                    $added_balance =  $days * $daily_balance;

                    $balance = $balance + $added_balance;

                    $balance = $balance - $amount;

                    //$total_paid = $balance_prev + $balance;

                    $amount_total = $prev_amount + $amount;

                    $range_dates = $this->Dates_model->get_loan_range_dates($range,$loan_date);

                     $total_owed = $balance_prev + $added_balance;

                    $data = array(
                        'identification_id' => $id,
                        'membership' => 'non_member',
                        'loan_id' => $loan_id,
                        'type' => 'loan_payment',
                        'range_dates' => $range_dates,
                        'amount_forward' => $balance_prev,
                        'interest' => $added_balance,
                        'amount_paid' => $amount,
                        'total_owed' => $total_owed,
                        'total_paid' => $amount_total,
                        'balance' => $balance
                    );

                    $data_transact = array(
                        'non_member_id' =>$borrower_id,
                        'names' => $name,
                        'type' => 'loans_payment',
                        'amount' => $amount,
                        'date' => $payment_date
                    );

                    $insert = $this->db->insert('non_member_transactions', $data_transact);

                     if($balance <= 0){
                         $this->db->update('non_member_loan_info',array('balance' => $balance,'status'=>'PAID'),array('id' => $id));
                    }
                    else
                         $this->db->update('non_member_loan_info',array('balance' => $balance),array('id' => $id));

                    $this->db->insert('loan_progress_update',$data);

                    $this->db->update('payments',array('balance' => $balance, 'status' => 'fined'),array('id' => $payment_id));

                    $this->db->update('loan_ranges',array('range_balance' => $balance),array('loan_id' => $loan_id , 'loan_range' => $range));

                }
                else{

                    //$balance = $balance + ($balance * 0.05);

                    $balance_prev = $balance;

                    $range_info = $this->Loan_model->get_range_info($loan_id,$range);

                    $max_date = $range_info->max_date;

                    if($payment_date != $max_date){

                        $range_info_curr = $this->Loan_model->get_range_info($loan_id,$range);

                        $max_date_curr = $range_info_curr->max_date;

                        $days_curr = date('z',strtotime($max_date_curr));


                        $prev_range = $range - 1;

                        $prev_range_info = $this->Loan_model->get_range_info($loan_id,$prev_range);

                        $prev_max_date = $prev_range_info->max_date;

                        $days_prev = date('z',strtotime($prev_max_date));


                        $days_pay = date('z',strtotime($payment_date));

                        $days = $days_pay - $days_prev;

                        $days_div = $days_curr - $days_prev;


                        $month_balance = $balance * 0.05;

                        $daily_balance = $month_balance / $days_div;

                        $added_balance = $days * $daily_balance;

                        $balance = $balance + $added_balance;

                        $balance = $balance - $amount;

                        $balance_prev = $balance;


                        $range_dates = $this->Dates_model->get_loan_range_dates($range,$loan_date);

                        //$total_paid = $balance_prev + $amount;

                        $amount_total = $prev_amount + $amount;

                         $total_owed = $balance_prev + $added_balance;

                        $data = array(
                            'identification_id' => $id,
                            'membership' => 'non_member',
                            'loan_id' => $loan_id,
                            'type' => 'loan_payment',
                            'range_dates' => $range_dates,
                            'amount_forward' => $balance_prev,
                            'interest' => $added_balance,
                            'amount_paid' => $amount,
                            'total_owed' => $total_owed,
                            'total_paid' => $amount_total,
                            'balance' => $balance
                        );

                        $data_transact = array(
                            'non_member_id' =>$borrower_id,
                            'names' => $name,
                            'type' => 'loans_payment',
                            'amount' => $amount,
                            'date' => $payment_date
                        );

                        $insert = $this->db->insert('non_member_transactions', $data_transact);

                        $this->db->insert('loan_progress_update',$data);

                    }
                    else{

                        $balance_prev = $balance;

                        $interest = ($balance * 0.05);

                        $balance = $balance + $interest;

                        $balance = $balance - $amount;

                        $range_dates = $this->Dates_model->get_loan_range_dates($range,$loan_date);

                        //$total_paid = $balance_prev + $amount;

                        $amount_total = $prev_amount + $amount;

                         $total_owed = $balance_prev + $added_balance;

                        $data = array(
                            'identification_id' => $id,
                            'membership' => 'non_member',
                            'loan_id' => $loan_id,
                            'type' => 'loan_payment',
                            'range_dates' => $range_dates,
                            'amount_forward' => $balance_prev,
                            'interest' => $interest,
                            'amount_paid' => $amount,
                            'total_owed' => $total_owed,
                            'total_paid' => $amount_total,
                            'balance' => $balance
                        );

                        $data_transact = array(
                            'non_member_id' =>$borrower_id,
                            'names' => $name,
                            'type' => 'loans_payment',
                            'amount' => $amount,
                            'date' => $payment_date
                        );

                        $insert = $this->db->insert('non_member_transactions', $data_transact);

                        $this->db->insert('loan_progress_update',$data);

                    }

                     if($balance <= 0){
                         $this->db->update('non_member_loan_info',array('balance' => $balance,'status'=>'PAID'),array('id' => $id));
                    }
                    else
                         $this->db->update('non_member_loan_info',array('balance' => $balance),array('id' => $id));

                    
                    $this->db->update('payments',array('balance' => $balance, 'status' => 'fined'),array('id' => $payment_id));

                    $this->db->update('loan_ranges',array('range_balance' => $balance),array('loan_id' => $loan_id , 'loan_range' => $range));

                }
            

                $range_var = $range;
            }

            else{

                    $range_info = $this->Loan_model->get_range_info($loan_id,$range);

                    $max_date = $range_info->max_date;


                    $range_dates = $this->Dates_model->get_loan_range_dates($range,$loan_date);

                    if($payment_date != $max_date){
                        
                        if($range == 1){

                            $balance_prev = $balance;

                            $days_max = date('z',strtotime($max_date));

                            $days_loan = date('z',strtotime($loan_date));

                            $days_div = $days_max - $days_loan;

                           

                            $days_1 = date('z',strtotime($loan_date));

                            $days_2 = date('z',strtotime($payment_date));

                            $days = $days_2 - $days_1;




                            $month_balance = $balance * 0.05;

                            $daily_balance = $month_balance / $days_div;

                            $added_balance = $days * $daily_balance;

                            $balance = $balance + $added_balance;

                            $balance = $balance - $amount;

                            //$total_paid = $balance_prev + $amount;

                            $amount_total = $prev_amount + $amount;

                             $total_owed = $balance_prev + $added_balance;

                            $data = array(
                                'identification_id' => $id,
                                'membership' => 'non_member',
                                'loan_id' => $loan_id,
                                'type' => 'loan_payment',
                                'range_dates' => $range_dates,
                                'amount_forward' => $balance_prev,
                                'interest' => $added_balance,
                                'amount_paid' => $amount,
                                'total_owed' => $total_owed,
                                'total_paid' => $amount_total,
                                'balance' => $balance
                            );


                            $data_transact = array(
                                'non_member_id' =>$borrower_id,
                                'names' => $name,
                                'type' => 'loans_payment',
                                'amount' => $amount,
                                'date' => $payment_date
                            );

                            $insert = $this->db->insert('non_member_transactions', $data_transact);

                            $this->db->insert('loan_progress_update',$data);
                        }
                        else{

                            $balance_prev = $balance;

                            $prev_range = $range - 1;

                            $prev_range_info = $this->Loan_model->get_range_info($loan_id,$prev_range);

                            $prev_max_date = $prev_range_info->max_date;

                            $days_prev = date('z',strtotime($prev_max_date));

                            $days_max = date('z',strtotime($max_date));

                            $days_div = $days_max -  $days_prev;



                            $days_max_2 = date('z',strtotime($prev_max_date));

                            $days_pay = date('z',strtotime($payment_date));

                            $days = $days_pay - $days_max_2;



                            $month_balance = $balance * 0.05;

                            $daily_balance = $month_balance / $days_div;

                            $added_balance = $days * $daily_balance;

                            $balance = $balance + $added_balance;

                            $balance = $balance - $amount;


                            //$total_paid = $balance_prev + $amount;

                            $amount_total = $prev_amount + $amount;

                             $total_owed = $balance_prev + $added_balance;

                            $data = array(
                                'identification_id' => $id,
                                'membership' => 'non_member',
                                'loan_id' => $loan_id,
                                'range_dates' => $range_dates,
                                'type' => 'loan_payment',
                                'amount_forward' => $balance_prev,
                                'interest' => $added_balance,
                                'amount_paid' => $amount,
                                'total_owed' => $total_owed,
                                'total_paid' =>  $amount_total,
                                'balance' => $balance
                            );

                            $data_transact = array(
                                'non_member_id' =>$borrower_id,
                                'names' => $name,
                                'type' => 'loans_payment',
                                'amount' => $amount,
                                'date' => $payment_date
                            );

                            $insert = $this->db->insert('non_member_transactions', $data_transact);

                            $this->db->insert('loan_progress_update',$data);

                        }

                    }
                    else{

                        $balance_prev = $balance;

                        $fine = ($balance * 0.05);

                        $balance = $balance +  $fine;

                        $balance = $balance - $amount;

                        //$total_paid = $balance_prev + $amount;

                        $amount_total = $prev_amount + $amount;

                         $total_owed = $balance_prev + $added_balance;

                        $data = array(
                            'identification_id' => $id,
                            'membership' => 'non_member',
                            'loan_id' => $loan_id,
                            'range_dates' => $range_dates,
                            'type' => 'loan_payment',
                            'amount_forward' => $balance_prev,
                            'interest' => $fine,
                            'amount_paid' => $amount,
                            'total_owed' => $total_owed,
                            'total_paid' => $amount_total,
                            'balance' => $balance
                        );

                        $data_transact = array(
                            'non_member_id' =>$borrower_id,
                            'names' => $name,
                            'type' => 'loans_payment',
                            'amount' => $amount,
                            'date' => $payment_date
                        );

                        $insert = $this->db->insert('non_member_transactions', $data_transact);

                        $this->db->insert('loan_progress_update',$data);

                    }

                     if($balance <= 0){
                         $this->db->update('non_member_loan_info',array('balance' => $balance,'status'=>'PAID'),array('id' => $id));
                    }
                    else
                         $this->db->update('non_member_loan_info',array('balance' => $balance),array('id' => $id));


                    $this->db->update('payments',array('balance' => $balance, 'status' => 'fined'),array('id' => $payment_id));


                    $this->db->update('loan_ranges',array('range_balance' => $balance),array('loan_id' => $loan_id , 'loan_range' => $range));


                }

                
                $prev_amount = $amount;

                $prev_amount_total = $amount_total;
            
        }

        $this->session->set_flashdata('refreshed', 'The member information has been refreshed succesfully!');

        redirect('members/get_non_member_inform/'.$id);

    }

    public function get_member_info($id){
        
        $data['id'] = $id;

        $data['fines'] = $this->Savings_model->get_fines($id);

        $data['balances'] = $this->Savings_model->get_balances($id);

        $data['total_fines'] = $this->Savings_model->get_total_fines_member($id);

        $data['total_balances'] = $this->Savings_model->get_total_balances_member($id);

        $data['names'] = $this->Member_model->get_names($id);

        $data['loans'] = $this->Loan_model->get_member_loans($id);

        $data['years'] = $this->Dates_model->get_member_years($id);

        $data['total_savings'] = $this->Savings_model->get_member_savings_total($id);

        $data['savings'] = $this->Savings_model->get_annual_savings($id);

        $data['ranges'] = $this->Dates_model->calculate_range_today();

        $data['main_content'] = 'members/info';
        $this->load->view('layouts/main',$data);
    }


    public function get_non_member_inform($id){

        $data['id'] = $id;

         $data['names'] = $this->Member_model->get_non_member_names($id);
        
        $data['inform'] = $this->Member_model->get_general_non_member_information($id);

        $data['transactions'] = $this->Savings_model->non_member_transactions($id);

        $data['years'] = $this->Dates_model->get_non_member_years($id);

        $data['main_content'] = 'members/non_member_info';
        $this->load->view('layouts/main',$data);
    }
    
    public function show_members(){
        //Get all lists from the model
        $data['members'] = $this->Member_model->get_members();

        $data['non_members'] = $this->Member_model->get_general_non_member_info();
        
        //Load view and layout
        $data['main_content'] = 'members/show';
        $this->load->view('layouts/main',$data);
    }
    
    
    public function add_member(){
        
        $this->form_validation->set_rules('names', 'Names', 'trim|required|xss_clean|callback_names_not_exist');
        $this->form_validation->set_rules('adress', 'Adress', 'trim|xss_clean');
        $this->form_validation->set_rules('phone_cell', 'Phone / Cellphone', 'trim|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|valid_email');


        if($this->form_validation->run() == FALSE){
            //Load view and layout
            $data['main_content'] = 'members/add_member';
            $this->load->view('layouts/main',$data);
        //Validation has ran and passed    
        } else {

            $names = $this->input->post('names');

           $member_exist = $this->Member_model->get_member($names);

           if($member_exist){
                $this->session->set_flashdata('member_exists', 'The member already exists');

                redirect('members/show_members');
           }
           else{
                $this->Member_model->create_member();

                $this->session->set_flashdata('member_registered', 'The member has been succesfully registered');

                redirect('members/show_members');
           }
        }
    }


    public function attendance(){

        
        if(!$this->input->post('submit2')){

        $data['main_content'] = 'members/attendance';
        $this->load->view('layouts/main',$data);
        }
        else{


            $date = $this->input->post('date');

            $date = date('Y-m-d',strtotime($date));

            $att = $this->input->post('att');

            //$names = $this->input->post('names');

            $names = $this->get_member_names();

            

            $name_arr = array();

           $i = 1;

            foreach($att as $key ) {

                $id = $i;

                if($key == 1){

                    $insert = $this->db->insert('attendance',array('member_id'=>$id,'date'=> $date,'status'=>'present','fine'=>0));
                }
                else{

                    $fine_range = $this->Dates_model->calculate_range($date);

                    $fine = 30000;

                    $insert = $this->db->insert('attendance',array('member_id'=>$id,'date'=> $date,'status'=>'absent','fine'=>$fine));

                    $insert = $this->db->insert('fines',array('member_id'=>$id,'fine_range'=> $fine_range,'balance'=>$fine,'amount_paid'=>0,'fine'=>$fine));

                    $total_fines = $this->Savings_model->get_total_fines_table($id);

                    $total_fine = $total_fines + $fine;

                    $update = $this->db->update('total_fines',array('total_fines'=>$total_fine),array('member_id'=>$id));
                }

                ++$i;
            }

            $this->session->set_flashdata('member_updated', 'The member attendance has been updated');

                redirect('members/show_members');
            
        }

    }


    public function chairman(){

        if(!$this->input->post('submit2')){

        $data['main_content'] = 'chairman/add';
        $this->load->view('layouts/main',$data);
        }
        else{


            $date = $this->input->post('date');

            $date = date('Y-m-d',strtotime($date));

            $att = $this->input->post('att');

            //$names = $this->input->post('names');

            $names = $this->get_member_names();

            

            $name_arr = array();

            $i = 1;

            foreach($att as $key ) {

                $id = $i;

                if($key == 1){

                    $names = $this->get_member_name($id);

                    $date_range = $this->Dates_model->calculate_range($date);

                    $insert = $this->db->insert('chairman',array('member_id'=>$id,'member' => $names,'date'=> $date,'status'=>'payed','fine'=>0 ,'amount' => 5000,'date_range' => $date_range));
                }
                else{

                    $fine_range = $this->Dates_model->calculate_range($date);

                    $date_range = $fine_range;

                    $fine = 5000;

                    $insert = $this->db->insert('chairman',array('member_id'=>$id,'member' => $names,'date' => $date,'status' => 'not_payed','fine' => 5000 ,'amount' => 0,'date_range' => $date_range));

                    $insert = $this->db->insert('fines',array('member_id'=>$id,'fine_range'=> $fine_range,'balance'=>$fine,'amount_paid'=>0,'fine'=>$fine));

                    $total_fines = $this->Savings_model->get_total_fines_table($id);

                    $total_fine = $total_fines + $fine;

                    $update = $this->db->update('total_fines',array('total_fines'=>$total_fine),array('member_id'=>$id));
                }

                ++$i;
            }

            $this->session->set_flashdata('member_updated', 'The member attendance has been updated');

                redirect('members/chairman_list');
            
        }

    }


    public function chairman_list(){

        $data['chairman'] = $this->get_chairman_general();
        
        //Load view and layout
        $data['main_content'] = 'chairman/show';
        $this->load->view('layouts/main',$data);
    }

    public function member_chairman_list($id){

        $data['chairman'] = $this->get_chairman_member($id);

        $data['id'] = $id;
        
        //Load view and layout
        $data['main_content'] = 'member/show_chairman';
        $this->load->view('layouts/main',$data);
    }



    public function get_chairman_general(){
        $this->db->order_by('date', 'DESC');
        $chairman = $this->db->get_from('chairman');

        if($chairman->num_rows > 0){
            return $chairman->result();
        }
        else{
            return FALSE;
        }
    }

    public function get_chairman_member($id){
        $this->db->where('member_id', $id);
        $this->db->order_by('date', 'DESC');
        $chairman = $this->db->get_from('chairman');

        if($chairman->num_rows > 0){
            return $chairman->result();
        }
        else{
            return FALSE;
        }
    }

    public function add_expenses(){
        $this->form_validation->set_rules('expense_name','Expense Name','trim|required|xss_clean');
        $this->form_validation->set_rules('amount','Amount','trim|required|xss_clean');
       
        
        if($this->form_validation->run() == FALSE){
            //Load view and layout
            $data['main_content'] = 'expenses/add';
            $this->load->view('layouts/main',$data);  
        } else {

            $expense = $this->input->post('expense_name');
            $amount = $this->input->post('amount');
            

           
           $insert = $this->db->insert('expenses',array('description'=>$expense, 'amount'=>$amount));

           if($insert){
                redirect('members/show_expenses');
           }
        }
    }

    public function show_expenses(){


       $data['expenses'] = $this->get_expenses();
        //Load view and layout
        $data['main_content'] = 'expenses/show';
        $this->load->view('layouts/main',$data);
        
    
    }

    public function get_expenses(){
        $this->db->order_by('date', 'DESC');
        $expense = $this->db->get_from('expenses');

        if($expense->num_rows > 0){
            return $expense->result();
        }
        else{
            return FALSE;
        }
    }

    public function get_expenses_member($id){
        $this->db->where('member_id', $id);
        $expense = $this->db->get_from('expenses');

        if($expense->num_rows > 0){
            return $expense->result();
        }
        else{
            return FALSE;
        }
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

     public function get_member_names(){

        $this->db->order_by('id', 'ASC');
        

        $info = $this->db->get('members');

        if($info->num_rows > 0){

            return $info->result();
        }
        else
            return FALSE;
    }
    

     public function get_member_name($id){

        $this->db->where('member_id', $id);
        

        $info = $this->db->get('members');

        if($info->num_rows > 0){

            return $info->row()->names;
        }
        else
            return FALSE;
    }
    
    
     public function quickadd(){
        $this->form_validation->set_rules('list_name','List Name','trim|required|xss_clean');
        if($this->form_validation->run() == FALSE){
            //Load view and layout
            $data['main_content'] = 'home';
            $this->load->view('layouts/main',$data);  
        } else {
            $data['list_name'] = $this->input->post('list_name');
            //Load view and layout
            $data['main_content'] = 'lists/add_list';
            $this->load->view('layouts/main',$data);  
        }
    }
    
    
    public function edit_member($id,$names){
        $this->form_validation->set_rules('names', 'Names', 'trim|required|xss_clean|callback_names_not_exist');
        $this->form_validation->set_rules('adress', 'Adress', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone_cell', 'Phone / Cellphone', 'trim|xss_clean');
        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required|valid_email');

        if($this->form_validation->run() == FALSE){

            //Load view and layout
            $data['names'] = $names;
            $data['id'] = $id;
            $data['main_content'] = 'members/edit_member';
            $this->load->view('layouts/main',$data);
        //Validation has ran and passed    
        } else {

           if($this->Member_model->edit_member($id)){
                $this->session->set_flashdata('member_edit', 'The member has been succesfully editted');

                redirect('members/show_members');
           }
        }
        
    }
    
    
    public function delete_member($id){      
            //Delete list
          if($this->Member_model->delete_member($id)){
                $this->session->set_flashdata('member_deleted', 'The member has been succesfully deleted');

                redirect('members/show_members');
           } 

           else{
                redirect('members/show_members');
           } 
     }

}
