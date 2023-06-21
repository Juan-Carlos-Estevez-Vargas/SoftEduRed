<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style/cruds_style.css">
</head>

<body>
  <div class="select">
    <select name="select_crud" onchange="window.location.href=this.value">

      <option selected disabled>Acción:</option>
      <option value='../views/atributes/documentTypeView.php'>Tipo de Documento</option>
      <option value='../views/atributes/genderView.php'>Género</option>
      <option value='../views/relationship/relationshipView.php'>Relación</option>
      <option value='../views/atributes/questionView.php'>Pregunta se Seguridad</option>
      <option value='../views/relationship/roleView.php'>Rol</option>
      <option value='../views/relationship/roleHasUser.php'>Rol de Usuario</option>
      <option value='../views/user/userStudentView.php'>Estudiante</option>
      <option value='../views/user/userTeacherView.php'>Profesor</option>
      <option value='../views/use/uaserAttendantView.php'>Acudiente</option>
      <option value='../views/atributes/subjectView.php'>Asunto</option>
      <option value='../views/atributes/courseView.php'>Curso</option>
      <option value='../views/relationship/subjectHasCourseView.php'>Asunto del Curso</option>
      <option value='../views/atributes/noAttendanceView.php'>Asistencia</option>
    </select>
  </div>
</body>

</html>