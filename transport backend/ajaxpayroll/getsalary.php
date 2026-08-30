<?php 
include("../adminsession.php");

   $id = $_REQUEST['id'];
   
   
 	 $sql = mysqli_query($connection, "Select * from  m_employee where employee_id=$id ");
									$row = mysqli_fetch_array($sql);  
									$salary=$row['salary'];
									echo $salary.'|'.$salary;
									?>
																	



