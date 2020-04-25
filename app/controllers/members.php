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





    public function refresh_info($id){

        //FETCHING MEMBER PAYMENT INFORMATION FROM THE PAYMENTS TABLE INTO THE LOAN_PAYMENT VARIABLE(ARRAY)
        $loan_payment = $this->Loan_model->get_member_payments($id);

        //GETTING HE CURRENT DATE
        $today = date('Y-m-d');

        //GETTING MEMBER LOAN INFO FROM MEMBER LOAN INFO TABLE AND INSTATIATING IT WITH THE LOAN_INFO VARIABLE(ARRAY)
        $loan_info = $this->Loan_model->get_member_loan($id);


        //EXTRACTING THE LOAN DATE FROM  LOAN_INFO ARRAY
        $loan_date = $loan_info->loan_date;

        //EXTRACTING THE LOAN ID FROM  LOAN_INFO ARRAY
        $loan_id = $loan_info->id;

        //EXTRACTING THE MEMBER NAMES FROM  LOAN_INFO ARRAY
        $name = $loan_info->names;

        //GETTING THE BALANCE OF THE FIRST RANGE USING THE GET_FIRST_RANGE_BALLANCE FROM THE LOAN_RANGES TABLE
        $balance_from_range = $this->Loan_model->get_first_range_balance($loan_id,$id);
        $balance = $balance_from_range->range_balance;

        //SETTING THE RANGE VARIABLE range_var TO 1
        $range_var = 1;

        //SETTING THE PREV_AMOUNT TO 0
        $prev_amount = 0;

        //SETTING THE PREV_AMOUNT VARIABLE TO 0
        $prev_amount_total = 0;


        //USING A FOREACH LOOP TO ITERATE THROUGH ALL THE PAYMENTS FETCHED FROM THE PAYMENTS TABLE ON LINE 30
        foreach($loan_payment as $payment){

            //GETTING THE PAYMENT DATE FOR THE PAYMENT
            $payment_date = $payment->payment_date;

            //GETTING THE PAYMENT AMOUNT
            $amount = $payment->payment_amount;

            //GETTING THE PAYMENT ID
            $payment_id = $payment->id;

            //DETERMINING THE RANGE IN WHICH THE PAYMENT WAS MADE USING THE GET_PAYMENT_RANGE FUNCTION IN THE LOAN_MODEL
            $range = $this->Loan_model->get_payment_range($id,$payment_date);

            //GETTING INFORMATION ABOUT THE RANGE USING THE GET_RANGE_INFO FUNCTION IN THE LOAN MODEL
            $range_info = $this->Loan_model->get_range_info($loan_id,$range);

            //IF THE RANGE IN WHICH THE PAYMENT HAS BEEN MADE IS NOT THE SAME AS THE PREVIOUS ONE OR THE SAME AS THE FIRST MONTH OF THE LOAN RECEPTION

            if($range != $range_var){

                //DETERMINING THE DIFFERENCE BETWEEN THE RANGES
                $range_diff = $range - $range_var;

                //IF THE RANGE DIFFERENCE IS GREATER THAN 1
                if($range_diff > 1){

                   

                    //WE ITERATE THROUGH THE COMPLETELY UNPAID MONTHS USING A FOREACH LOOP
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

                    if(date('n',strtotime($payment_date)) == 12){
                            if(date('L',strtotime($payment_date))){
                                $days_pay = $days_pay + 366;
                            }
                            else
                                $days_pay = $days_pay + 365;
                            
                    }

                    $days = $days_pay - $days_max_prev;

                    $neg = -1;

                    if($days < 1){
                        $days = $days * $neg;
                    }
                    else
                        $days = $days * 1;


                    $days_curr = date('z',strtotime($max_date_curr));

                    if(date('n',strtotime($max_date_curr)) == 12){
                            if(date('L',strtotime($max_date_curr))){
                                $days_curr = $days_curr + 366;
                            }
                            else
                                $days_curr = $days_curr + 365;
                            
                    }

                    $days_div = $days_curr - $days_max_prev;


                    if($days_div < 1){
                        $days_div = $days_div * $neg;
                    }
                    else
                        $days_div = $days_div * 1;



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

                        if(date('n',strtotime($max_date_curr)) == 12){
                            if(date('L',strtotime($max_date_curr))){
                                $days_curr = $days_curr + 366;
                            }
                            else
                                $days_curr = $days_curr + 365;
                            
                        }


                        $prev_range = $range - 1;

                        $prev_range_info = $this->Loan_model->get_range_info($loan_id,$prev_range);

                        $prev_max_date = $prev_range_info->max_date;

                        $days_prev = date('z',strtotime($prev_max_date));


                        $days_pay = date('z',strtotime($payment_date));

                        if(date('n',strtotime($payment_date)) == 12){
                            if(date('L',strtotime($payment_date))){
                                $days_pay = $days_pay + 366;
                            }
                            else
                                $days_pay = $days_pay + 365;
                            
                        }

                        $days = $days_pay - $days_prev;

                        $neg = -1;

                        if($days < 1){
                            $days = $days * $neg;
                        }
                        else
                            $days = $days * 1;

                        $days_div = $days_curr - $days_prev;

                        if($days_div < 1){
                            $days_div = $days_div * $neg;
                        }
                        else
                            $days_div = $days_div * 1;


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

                            if(date('n',strtotime($max_date))== 12){
                                    if(date('L',strtotime($max_date))){
                                        $days_max = $days_max + 366;
                                    }
                                    else
                                        $days_max = $days_max + 365;
                                    
                            }

                           

                            $days_div = $days_max - $days_loan;

                            $neg = -1;

                            if($days_div < 1){
                                $days_div = $days_div * $neg;
                            }
                            else
                                $days_div = $days_div * 1;

                           

                            $days_1 = date('z',strtotime($loan_date));

                            $days_2 = date('z',strtotime($payment_date));

                            if(date('n',strtotime($payment_date)) == 12){
                                    if(date('L',strtotime($payment_date))){
                                        $days_2 = $days_pay + 366;
                                    }
                                    else
                                        $days_2 = $days_pay + 365;
                                    
                            }

                            $days = $days_2 - $days_1;


                            if($days < 1){
                                $days = $days * $neg;
                            }
                            else
                                $days = $days * 1;




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

                            if(date('n',strtotime($days_max)) == 12){
                                    if(date('L',strtotime($days_max))){
                                        $days_max = $days_max + 366;
                                    }
                                    else
                                        $days_max = $days_max + 365;
                                    
                            }


                            $days_div = $days_max -  $days_prev;

                            $neg = -1;

                            if($days_div < 1){
                                $days_div = $days_div * $neg;
                            }
                            else
                                $days_div = $days_div * 1;



                            $days_max_2 = date('z',strtotime($prev_max_date));

                            $days_pay = date('z',strtotime($payment_date));

                            if(date('n',strtotime($prev_max_date)) == 12){
                                    if(date('L',strtotime($prev_max_date))){
                                        $days_max_2 = $days_max_2 + 366;
                                    }
                                    else
                                        $days_max_2 = $days_max_2 + 365;
                                    
                            }

                            $days = $days_pay - $days_max_2;


                            if($days < 1){
                                $days = $days * $neg;
                            }
                            else
                                $days = $days * 1;



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

            if($range != 1){

                $range_diff = $range - 1;

                if($range_diff > 1){

                    $balance_prev = $balance;

                    for($i = 0; $i <= ($range_diff - 1); $i++){

                        $balance_prev = $balance;

                        $fine = $balance * 0.05;

                        $balance = $fine + $balance;

                        ++$range_var;

                        $range_dates = $this->Dates_model->get_loan_range_dates($range,$loan_date);

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

       

        $data['years'] = $this->Dates_model->get_member_years($id);

        $data['total_savings'] = $this->Savings_model->get_member_savings_total($id);

        $data['savings'] = $this->Savings_model->get_annual_savings2($id);

        $data['ranges'] = $this->Dates_model->calculate_range_today();

        $data['main_content'] = 'members/info';
        $this->load->view('layouts/main',$data);
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


    public function get_member_info2(){

        $id = $this->get_user_id();
        
        $data['id'] = $id;

        $names = $this->session->userdata('user_name');

        $data['names'] = $names;

        $data['fines'] = $this->Savings_model->get_fines($id);

        $data['balances'] = $this->Savings_model->get_balances($id);

        $data['total_fines'] = $this->Savings_model->get_total_fines_member($id);

        $data['total_balances'] = $this->Savings_model->get_total_balances_member($id);

        $data['names'] = $this->Member_model->get_names($id);

       

        $data['years'] = $this->Dates_model->get_member_years($id);

        $data['total_savings'] = $this->Savings_model->get_member_savings_total($id);

        $data['savings'] = $this->Savings_model->get_annual_savings($id);

        $data['ranges'] = $this->Dates_model->calculate_range_today();

        $data['main_content'] = 'members/info2';
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

            $names = $this->input->post('names');

            

            $name_arr = array();

           $i = 1;
           $j = 0;

            foreach($names as $name ) {

                if(in_array("$name", $att)){

                    $insert = $this->db->insert('attendance',array('member_id'=>$i,'member'=>$name,'date'=> $date,'status'=>'present','fine'=>0));
                }
                else{

                    $fine_range = $this->Dates_model->calculate_range($date);

                    $fine = 30000;

                    $insert = $this->db->insert('attendance',array('member_id'=>$i,'member'=>$name,'date'=> $date,'status'=>'absent','fine'=>$fine));

                    $insert = $this->db->insert('fines',array('member_id'=>$i,'fine_range'=> $fine_range,'balance'=>$fine,'amount_paid'=>0,'fine'=>$fine));

                    $total_fines = $this->Savings_model->get_total_fines_table($i);

                    $total_fine = $total_fines + $fine;

                    $update = $this->db->update('total_fines',array('total_fines'=>$total_fine),array('member_id'=>$i));
                }

                ++$i;
                ++$j;
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

            $names = $this->input->post('names');

            

            $name_arr = array();

            $i = 1;

            $j = 0;



            foreach($names as $name ) {


                if(in_array("$name", $att)){

                    

                    $date_range = $this->Dates_model->calculate_range($date);

                    $insert = $this->db->insert('chairman',array('member_id'=>$i,'member' => $name,'date'=> $date,'status'=>'payed','fine'=>0 ,'amount' => 5000,'date_range' => $date_range));
                }
                else{

                    $fine_range = $this->Dates_model->calculate_range($date);

                    $date_range = $fine_range;

                    $fine = 5000;

                    $insert = $this->db->insert('chairman',array('member_id'=>$i,'member' => $name,'date' => $date,'status' => 'not_payed','fine' => 5000 ,'amount' => 0,'date_range' => $date_range));

                    $insert = $this->db->insert('fines',array('member_id'=>$i,'fine_range'=> $fine_range,'balance'=>$fine,'amount_paid'=>0,'fine'=>$fine));

                    $total_fines = $this->Savings_model->get_total_fines_table($id);

                    $total_fine = $total_fines + $fine;

                    $update = $this->db->update('total_fines',array('total_fines'=>$total_fine),array('member_id'=>$i));
                }

                ++$i;

                ++$j;
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

    public function attendance_list(){

        $data['attendance'] = $this->get_attendance_general();
        
        //Load view and layout
        $data['main_content'] = 'members/attendance_show';
        $this->load->view('layouts/main',$data);
    }

    public function attendance_list2(){

        $names = $this->session->userdata('user_name');
        $id = $this->get_member_id($names);

        $data['attendance'] = $this->get_attendance_member2($id);

        
        //Load view and layout
        $data['main_content'] = 'members/attendance2';
        $this->load->view('layouts/main',$data);
    }

    public function member_chairman_list($id){

        $data['chairman'] = $this->get_chairman_member($id);

        $data['id'] = $id;
        
        //Load view and layout
        $data['main_content'] = 'member/show_chairman';
        $this->load->view('layouts/main',$data);
    }

    public function chairman_list_member(){

        $names = $this->session->userdata('user_name');

        $id = $this->get_member_id($names);

        $data['chairman'] = $this->get_chairman_member($id);

        $data['id'] = $id;
        
        //Load view and layout
        $data['main_content'] = 'chairman/show';
        $this->load->view('layouts/main',$data);
    }


      public function member_attendance_list($id){

        $data['attendance'] = $this->get_attendance_member($id);

        $data['id'] = $id;
        
        //Load view and layout
        $data['main_content'] = 'member/attendance_show_member';
        $this->load->view('layouts/main',$data);
    }



    public function get_chairman_general(){
        $this->db->order_by('date', 'DESC');
        $this->db->from('chairman');
        $chairman = $this->db->get();

        if($chairman->num_rows > 0){
            return $chairman->result();
        }
        else{
            return FALSE;
        }
    }

    public function get_attendance_general(){
        $this->db->order_by('date', 'DESC');
        $this->db->from('attendance');
        $attendance = $this->db->get();

        if($attendance->num_rows > 0){
            return $attendance->result();
        }
        else{
            return FALSE;
        }
    }

    public function get_attendance_member2($id){

        $this->db->order_by('date', 'DESC');
        $this->db->from('attendance');
        $this->db->where('member_id', $id);
        $attendance = $this->db->get();

        if($attendance->num_rows > 0){
            return $attendance->result();
        }
        else{
            return FALSE;
        }
    }

    public function get_chairman_member($id){
        $this->db->where('member_id', $id);
        $this->db->order_by('date', 'DESC');
        $this->db->from('chairman');
        $chairman = $this->db->get();

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
        $this->db->from('expenses');
        $expense = $this->db->get();

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
        $this->db->from('members');

        $info = $this->db->get();

        if($info){

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
