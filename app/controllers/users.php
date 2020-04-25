<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->library('log_lib');
    $this->load->model('User_model');
  }



  public function show_users(){
        //Get all lists from the model
        $data['users'] = $this->User_model->get_users();
        //Get all completed tasks for this list
        //$data['completed_tasks'] = $this->List_model->get_list_tasks($id,true);
        //Get all uncompleted tasks for this list
        //$data['uncompleted_tasks'] = $this->List_model->get_list_tasks($id,false);
        
        //Load view and layout
        $data['main_content'] = 'users/show';
        $this->load->view('layouts/main',$data);
  }


  public function add_user(){
        
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('role', 'User Role', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password','Password','trim|xss_clean|required');
        $this->form_validation->set_rules('password2','Confirm Password','trim||xss_clean|required|matches[password]');


        if($this->form_validation->run() == FALSE){
            //Load view and layout
            $data['main_content'] = 'users/register';
            $this->load->view('layouts/main',$data);
        //Validation has ran and passed    
        } else {
           if($this->User_model->add_user()){
                $this->session->set_flashdata('user_registered', 'The User has been registered');
                //Redirect to index page with error above
                redirect('users/show_users');
           }
        }
    }


    public function edit_user($id,$name){
        
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('role', 'User Role', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password','Password','trim|xss_clean|required');
        $this->form_validation->set_rules('password2','Confirm Password','trim||xss_clean|required|matches[password]');


        if($this->form_validation->run() == FALSE){
            //Load view and layout
            $data['names'] = $name;
            $data['id'] = $id;
            $data['main_content'] = 'users/edit';
            $this->load->view('layouts/main',$data);
        //Validation has ran and passed    
        } else {

          $name = $this->input->post('username');
          $role = $this->input->post('role');
          $password = $this->input->post('password');


           if($this->User_model->edit_user($name,$role,$password,$id)){
                $this->session->set_flashdata('user_editted', 'The User has been editted');
                //Redirect to index page with error above
                redirect('users/show_users');
           }
        }
    }



 

  public function login(){
        $this->form_validation->set_rules('username','Username','trim|required|min_length[4]|xss_clean');      
        $this->form_validation->set_rules('password','Password','trim|required|min_length[4]|max_length[50]|xss_clean');        
        
        if($this->form_validation->run() == FALSE){
            //Set error
            $this->session->set_flashdata('login_failed', 'Sorry, the login info that you entered is invalid');
            $data['main_content'] = 'users/login';
            $this->load->view('layouts/landing', $data);
        } else {
           //Get from post

           $username = $this->input->post('username');
           $password = $this->input->post('password');
               
           //Get user id from model
           $user_info = $this->User_model->login_user($username,$password);

           $user_id = $user_info->id;

           $user_role = $user_info->role;
               
           //Validate user
           if($user_id){
              
               //Create array of user data
               $user_data = array(
                       'user_id'   => $user_id,
                       'user_name'  => $username,
                       'user_role' => $user_role,
                       'user_logged_in' => true
                );
                //Set session userdata
               $this->session->set_userdata($user_data);
                                  
               redirect('home/index');
            } else {
                //Set error
                $this->session->set_flashdata('login_failed', 'Sorry, the login info that you entered is invalid');
                redirect('users/login');
            }
        }
    }
  
  function logout()
  {
    
    $this->session->unset_userdata('user_id');
    $this->session->unset_userdata('user_name');
    $this->session->unset_userdata('user_logged_in');

    redirect('users/login/', 'refresh');
  }

  public function register(){
        if($this->session->userdata('logged_in')){
            redirect('home/index');
        }
        
        
        $this->form_validation->set_rules('username','Username','trim|required|min_length[4]|xss_clean');  
        $this->form_validation->set_rules('role','User Role','trim|required|min_length[4]|xss_clean');    
        $this->form_validation->set_rules('password','Password','trim|required|min_length[4]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('password2','Confirm Password','trim|required|matches[password]|xss_clean');
        
        if($this->form_validation->run() == FALSE){
            //Load view and layout
            $data['main_content'] = 'users/register';
            $this->load->view('layouts/main',$data);
        //Validation has ran and passed    
        } else {
           if($this->User_model->create_member()){
                $this->session->set_flashdata('registered', 'You are now registered, please log in');
                //Redirect to index page with error above
                redirect('home/index');
           }
        }
    }
    


  function delete_user($user_id){

    //$this->load->model('user_model');
    $delete = $this->User_model->delete_user($user_id);
    
    if ($delete) {
      //insert log

      $this->session->set_flashdata('user_deleted', 'The user has been succesfully deleted'); 

      redirect('users/show_users', 'refresh');
    }
    else{
      //then redirect
      return FALSE;
    }
      
    
  }

  function change_password()
  {
    $this->load->library('form_validation');
     $this->form_validation->set_rules('password','Password','trim|xss_clean|required');
    $this->form_validation->set_rules('password2','Confirm Password','trim|xss_clean|required|matches[password]');

    if($this->form_validation->run() == FALSE)
    {
      $names = $this->session->userdata('user_name');
      $this->load->view('layouts/main',array('main_content'=>'users/password','names'=> $names));
    }else
    {
      $username = $this->session->userdata('user_name');
      $password = $this->input->post('password');
      if($this->log_lib->change_password($username,$password))
      {
        $this->session->set_flashdata('change_password', 'Password has been changed succesfully');
        redirect('users/login/', 'refresh');
      }else
      {
        return FALSE;
      }
    }
  }


  function username_not_exist($username)
  {
    $this->form_validation->set_message('username_not_exist','That username already exist choose another username');
    if($this->log_lib->check_exist_username($username))
    {
      return FALSE;
    }else
    {
      return TRUE;
    }
  }
}