<?php

class Student_Model extends CI_Model{
    
    public function __construct ()
    {
        parent::__construct();
    }
    public function getStudents($id){
        if($id == 'all'){
            $query = $this->db->get('Student');
        }
        else{
            $query = $this->db->get_where('Student', array('id' => $id));
        }
        $data = [];
        if($query->num_rows() > 0){
            foreach ($query->result() as $row)
            {
                $data[] = $row;
            } 
            return $data;
        }
    }
        
    public function updateStudents($ids, $data){
        foreach($ids as $id){
            $this->db->where('id', $id);
            $this->db->update('Student', $data); 
        }
    }
}
