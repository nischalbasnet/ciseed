<?php

class StudentModelTest extends CIUnit_Framework_TestCase
{
    private $student;
    
    protected function setUp()
    {
        $this->get_instance()->load->model('Student_Model', 'student');
        $this->student = $this->get_instance()->student;
    }
    
    /**
     * this function tests for the getStudents method of Student_Model class
     */
    public function testOne()
    {
        //get the first student to test        
        $expectedResult[] = array ( 'id' => 1);
        $expectedResult = json_encode($expectedResult);
        $expectedResult = json_decode($expectedResult);
        $result = $this->student->getStudents(1);
        $this->assertEquals($expectedResult[0]->id, $result[0]->id);
        
        //now test for getting all records
        $result2 = $this->student->getStudents('all');
        $expectedNoOfRecords = 4;
        $noOfRecrods = count($result2);
        $this->assertEquals($expectedNoOfRecords, $noOfRecrods);
    }
    
    /**
     *  this function tests for the update methodof Student_Model class
     */
    public function testTwo(){
        //set up for testing 
        //get the values first
        $student = $this->student->getStudents(1);
        $preservedVal = $student[0];//preserve the value to update after testing is done
        //testing value
        $data = array(
                'user_name' => 'testingUn',
                'password' => 'testingPw'
            );
        
        $this->student->updateStudents(array(1), $data);
        
        $updatedStudent = $this->student->getStudents(1);
        //check if the values were updated
        $this->assertEquals($data['user_name'], $updatedStudent[0]->user_name);
        $this->assertEquals($data['password'], $updatedStudent[0]->password);
        //now revert back to the previous value
        $this->student->updateStudents(array(1), $preservedVal);
    }
}
