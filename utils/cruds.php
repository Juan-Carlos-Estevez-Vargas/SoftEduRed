<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>

  <body>
    <section class="h-100 bg-white">
      <div class="container py-4 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col">
            <div class="card card-registration my-4">
              <div class="row g-0">
                <div class="col-xl-12">
                  <div class="card-body p-md-5 text-black" style="background-color: hsl(0, 0%, 96%)">
                    <h3 class="mb-5 text-uppercase text-center text-primary">Registros</h3>

                    <div class="row">
                      <div class="col-md-12 mb-4">
                        <form action="" method="">
                          <div class="row align-items-center justify-content-center">
                            <label class="col-auto me-2">Seleccione un Recurso: </label>
                            <div class="col-md-auto">
                              <select name="select_crud" class="form-control"
                                onchange="window.location.href=this.value">
                                <option selected disabled>Acción:</option>
                                <option value='../views/documentTypeView.php'>Tipo de Documento</option>
                                <option value='../views/genderView.php'>Género</option>
                                <option value='../views/relationshipView.php'>Parentesco</option>
                                <option value='../views/questionView.php'>Pregunta de Seguridad</option>
                                <option value='../views/roleView.php'>Rol</option>
                                <option value='../views/roleHasUserView.php'>Rol por Usuario</option>
                                <option value='../views/userStudentView.php'>Estudiante</option>
                                <option value='../views/userTeacherView.php'>Docente</option>
                                <option value='../views/userAttendantView.php'>Acudiente</option>
                                <option value='../views/subjectView.php'>Materia</option>
                                <option value='../views/courseView.php'>Curso</option>
                                <option value='../views/subjectHasCourseView.php'>Materia por Curso
                                </option>
                                <option value='../views/atributes/noAttendanceView.php'>Asistencia</option>
                              </select>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer class="bg-light text-center text-lg-start">
      <div class="text-center p-3" style="background-color: hsl(0, 0%, 96%)">
        © 2023 Copyright:
        <a class="text-blue" href="https://github.com/Juan-Carlos-Estevez-Vargas/SoftEduRed">SoftEduRed.com</a>
      </div>
    </footer>
  </body>
</body>

</html>