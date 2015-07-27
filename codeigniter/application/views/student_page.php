<!DOCTYPE html>
<html lang="en">
	<head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">
            <title>Profile List</title>
		
            <script type="text/javascript" src="//code.jquery.com/jquery-2.1.0.js"></script>
            <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
            <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		
            <style type="text/css">
                    body {
                      padding-top: 20px;
                      padding-bottom: 20px;
                    }
                    .navbar {
                      margin-bottom: 20px;
                    }
                    .update-username, .update-password{
                        float:  right;
                    }
            </style>
            <script type="text/javascript">
                $(document).ready(function(){
                    loadStudentsList();//get student data and fill the list table
                });
                
                /**
                 * 
                 * this function is gets the student data through ajax get call
                 */
                function loadStudentsList(){
                    $.ajax({
                        method: "GET",
                        url: "student_controller/getStudents",
                        success: function(result){
                            var data = JSON.parse(result);
                            createStudentListHtml(data);//now create the html table using the returned data
                        }
                    });
                }
                
                /**
                 * 
                 * @param {type} studentData
                 * this function takes the student data array returned from db
                 * and cretes html table using it.
                 */
                function createStudentListHtml(studentData){
                    var profileTableHtml = '';
                    //now loop through the data and create html table
                    for(var profileKey in studentData){  
                        profileTableHtml += '<tr> ';//strat row tag
                        //student id column
                        profileTableHtml += '<td>'+studentData[profileKey].id+'</td>';
                        //student user name with updater button column
                        profileTableHtml += '<td><span class="un" data-id='+studentData[profileKey].id+'>'+studentData[profileKey].user_name+'</span>';
                        profileTableHtml += '<button type="button" class="btn btn-primary btn-sm update-username" data-id='+studentData[profileKey].id+'> <span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> Update </button> </td>';
                         //student password with updater button column
                        profileTableHtml += '<td><span class="pw" data-id='+studentData[profileKey].id+'>'+studentData[profileKey].password+'</span>';
                        profileTableHtml += '<button type="button" class="btn btn-primary btn-sm update-password" data-id='+studentData[profileKey].id+'> <span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> Update </button> </td>';
                        
                        profileTableHtml += '</tr>';//close the row now
                    }
                    $('#profile-table-body').html(profileTableHtml);//insert the created html string to the table 
                }
                
                /**
                * event handler for updating username 
                */
                $(document).on('click', '.update-username', function(){
                    var id = $(this).attr('data-id');
                    var idString = 'id='+id;
                    $.ajax({
                        method: "POST",
                        data: idString,
                        url: "student_controller/updateUsername",
                        success: function(){
                            updateStudentInfo(id, 'un');//after update is complete refresh the student list
                        }
                    });
                });
                
                /**
                * event handler for updating password 
                */
                $(document).on('click', '.update-password', function(){
                    var id = $(this).attr('data-id');
                    var idString = 'id='+id;
                    $.ajax({
                        method: "POST",
                        data: idString,
                        url: "student_controller/updatePassword",
                        success: function(){
                            updateStudentInfo(id, 'pw');//after update is complete refresh the student list
                        }
                    });
                });
                
                /**
                *  This function take record id and updates the username or password field
                *  according to the input supplied
                 * @param {string} id 
                 * @param {string} unpw -- values can be 'un' for user name and 
                 * 'pw' for password 
                 */
                function updateStudentInfo(id, unpw){
                    var idString = 'id='+id;
                    $.ajax({
                        method: "GET",
                        data: idString,
                        url: "student_controller/getStudents",
                        success: function(result){
                            var student = JSON.parse(result);
                            //now update the info for the student
                            if(unpw === 'un'){
                                $('.un[data-id='+id+']').html(student[0].user_name);
                            }
                            else if(unpw === 'pw'){
                               $('.pw[data-id='+id+']').html(student[0].password); 
                           }
                        }
                    });
                }
                
            </script>
	</head>
	<body>
		<div class="container">
                    <h1>Student Profile List</h1>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>User Name</th>
                                <th>Password</th>
                            </tr>
                        </thead>
                        <tbody id="profile-table-body">
                        </tbody>
                    </table>
		</div>
	</body>
</html>