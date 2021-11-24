<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <link rel="stylesheet" href="style/cruds_style.css" >
 </head>
	<body>
     <div class="select">
		<select name="select_crud" onchange="window.location.href=this.value">
		
			<option selected disabled>Action:</option>
			<option value='../Type_Document/formu_view.php'>Type Document</option>
			<option value='../gender/formu_view.php'>Gender</option>
                        <option value='../relationship/formu_view.php'>Relationship</option>
			<option value='../question/formu_view.php'>Question</option>
			<option value='../role/formu_view.php'>Role</option>
			<option value='../rol_has_user/formu_view.php'>Rol Of User</option>
			<option value='../user_student/formu_view.php'>Student</option>
			<option value='../user_teacher/formu_view.php'>Teacher</option>
			<option value='../user_attendant/formu_view.php'>Attendant</option>
			<option value='../subject/formu_view.php'>Subject</option>
			<option value='../course/formu_view.php'>Course</option>
			<option value='../subject_has_course/formu_view.php'>Subject of the Course</option>
            <option value='../no_attendance/formu_view.php'>Asistance</option>
		</select>
        </div>
	 </body>
</html>		