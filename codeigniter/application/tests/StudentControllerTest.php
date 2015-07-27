<?php

require BASEPATH.'../application/controllers/student_controller.php';
class StudentControllerTest extends CIUnit_Framework_TestCase
{
    private $student;
    protected function setUp()
    {
        $this->get_instance()->load->model('Student_Model', 'student');
        $this->student = $this->get_instance()->student;
    }
    
    /**
     * test the getStudents method of student_Controller
     */
    public function testOne()
    {
        $controller = new Student_Controller;
        
        //get the first student to test        
        $expectedResult[] = array ( 'id' => 1);
        $expectedResult = json_encode($expectedResult);
        $expectedResult = json_decode($expectedResult);
        $_GET['id'] = 1;    //set value of the GET to test the method
        ob_start();
        $controller->getStudents();
        $output1 = ob_get_contents();
        ob_end_clean();
        $output1 = json_decode($output1);
        
        $this->assertEquals($expectedResult[0]->id, $output1[0]->id);
        $_GET['id'] = null; //set value of the GET to test the method
        ob_start();
        $controller->getStudents();
        $outputall = ob_get_contents();
        ob_end_clean();
        $outputall = json_decode($outputall);
        
        $expectedNoOfRecords = 4;
        $noOfRecrods = count($outputall);
        $this->assertEquals($expectedNoOfRecords, $noOfRecrods);        
    }
    /**
     * test the updateUsername and updatePassword method of the student_Controller
     */
    public function testTwo()
    {
        $controller = new Student_Controller;
        $_POST['id'] = 1;//set post to test update methods
        
        $initialValue = $this->student->getStudents(1);
        $preservedVal = $initialValue[0];//preserve the value to update after testing is done
       
        $controller->updateUsername();
        //after updating username
        $newValue1 = $this->student->getStudents(1);
        $this->assertNotEquals($initialValue[0]->user_name, $newValue1[0]->user_name);//user name is updated
        $this->assertEquals($initialValue[0]->password, $newValue1[0]->password);//pasword should be same
        
        $controller->updatePassword();
        //after updating username
        $newValue = $this->student->getStudents(1);
        $this->assertNotEquals($initialValue[0]->password, $newValue[0]->password);//password is updated
        
        //now revert back to the previous value
        $this->student->updateStudents(array(1), $preservedVal);
    }
}
