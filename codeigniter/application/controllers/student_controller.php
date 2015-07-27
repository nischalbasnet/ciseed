<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Student_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('student_model');
    }
    
    public function index(){
        $this->load->view('student_page');
    }
    
    public function getStudents(){
        $id = $this->input->get('id');
        if($id){
            $student = $this->student_model->getStudents($id);
        }
        else{
            $student = $this->student_model->getStudents('all');
        }
        echo json_encode($student);
    }
    
    public function updateUsername(){
        $id = $this->input->post('id');
        if($id){
            $randomUn = $this->randomUnGenerator(mt_rand(5,7));
            $data = array(
               'user_name' => $randomUn
            );
            $this->student_model->updateStudents(array($id), $data);
        }
    }
    
    public function updatePassword(){
        $id = $this->input->post('id');
        if($id){
            $randomPw = $this->randomPwGenerator(mt_rand(3,4));
            $data = array(
               'password' => $randomPw
            );
            $this->student_model->updateStudents(array($id), $data);
        }
    }
  
    private function randomPwGenerator($length){
        $bytes = openssl_random_pseudo_bytes($length);
        $password = bin2hex($bytes);
        return $password;
    }
    
    private function randomUnGenerator($length){
        $un = '';
        $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
        $charListLength = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $index = mt_rand(0, $charListLength - 1);
            $un .= $characters[$index];
        }
        return $un;
    }
    
}
