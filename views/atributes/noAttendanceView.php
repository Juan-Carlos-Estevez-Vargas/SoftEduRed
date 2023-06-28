<?php
  require_once "../../persistence/database/Database.php";
  require_once "../../persistence/atributes/NoAttendanceDAO.php";

  session_start();

  $db = database::connect();

  if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];

    if ($action === 'update') {
      $update = new NoAttendance();
      $update->updateGender($_POST["tdoc"], $_POST["id"], $_POST["subject"], $_POST["course"]);
    } elseif ($action === 'register') {
      $insert = new NoAttendance();
      $insert->registerAbsence($_POST["tdoc"], $_POST["id"], $_POST["subject"], $_POST["course"]);
    } elseif ($action === 'delete') {
      $eliminar = new NoAttendance();
      $eliminar->deleteGender($_GET['cod_attendance']);
    } elseif ($action === 'edit') {
      $id = $_GET['id_gender'];
    }
  }
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Asistencias</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <section class="h-100 bg-white">
    <div class="container py-4 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
          <div class="card card-registration my-4">
            <div class="row g-0">
              <div class="col-xl-12">
                <div class="card-body p-md-5 text-black" style="background-color: hsl(0, 0%, 96%)">
                  <h3 class="mb-5 text-uppercase text-center text-primary">Asistencias</h3>

                  <div class="row">
                    <div class="col-md-12 mb-4">
                      <form action="" method="">
                        <div class="row align-items-center">
                          <label class="col-auto me-2">Seleccione un Curso: </label>
                          <div class="col-md-6">
                            <select name="s" class="form-control">
                              <?php foreach ($db->query('SELECT * FROM course WHERE state = 1') as $row1) { ?>
                              <option value="<?php echo $row1['id_course']; ?>"> <?php echo $row1['course']; ?>
                              </option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="col-auto">
                            <button class="btn btn-primary me-2" id="boton">Buscar</button>
                            <input class="btn btn-success" id="buton" type="button" value="reset"
                              onclick="window.location.href='noAttendanceView.php?s '" />
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12 mb-4">
                      <?php
                        $x = @$_GET['s'];

                        $sql1= "
                          SELECT
                            pk_fk_tdoc_user,
                            pk_fk_user_id,
                            surname,
                            second_surname,
                            first_name,
                            second_name,
                            fk_cod_course
                          FROM student
                          JOIN user ON pk_fk_user_id = id_user AND pk_fk_tdoc_user = pk_fk_cod_doc
                          WHERE fk_cod_course LIKE '$x'
                        ";

                        $query = $db->query($sql1);

                        if($query->rowCount() > 0):
                      ?>
                      <form action="" method="POST">
                        <div class="row align-items-center justify-content-center">
                          <label class="col-auto me-2">¿Que Materia desea ver?: </label>
                          <div class="col-md-4">
                            <select name="subject" class="form-control">
                              <?php foreach ($db->query("
                                  SELECT * FROM subject_has_course
                                  WHERE state_sub_course = 1 AND pk_fk_course_stu ='$x'
                                ") as $row2) {
                              ?>
                              <option value="<?php echo $row2['pk_fk_te_sub']; ?>"><?php echo $row2['pk_fk_te_sub']; ?>
                              </option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="col-md-12 text-center mt-5">
                            <h3 class="mb-5 text-uppercase text-primary">Inasistencias</h3>
                            <div class="table-responsive">
                              <table class="table table-bordered">
                                <caption class="text-center">Listado de Resultados</caption>
                                <thead>
                                  <tr>
                                    <th>Documento</th>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Curso</th>
                                    <th>Seleccionar</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>
                                  <tr>
                                    <td><input class="form-control" id="space" type="text" name="tdoc"
                                        value="<?php echo $row['pk_fk_tdoc_user']; ?>" readonly></td>
                                    <td><input class="form-control" id="space" type="text" name="id"
                                        value="<?php echo $row['pk_fk_user_id']; ?>" readonly></td>
                                    <td><input class="form-control" id="space" type="text"
                                        value="<?php echo $row["first_name"], " ", $row["surname"]; ?>" disabled></td>
                                    <td><input class="form-control" id="space" type="text" name="course"
                                        value="<?php echo $row['fk_cod_course']; ?>" readonly></td>
                                    <td><input class="form-control" id="space" type="checkbox"
                                        name="<?php echo $row['pk_fk_user_id']; ?>">
                                    </td>
                                  </tr>
                                  <?php } ?>
                                </tbody>
                              </table>
                            </div>
                            <p>
                              <input id="reg" class="btn btn-primary col-md-4" type="submit" value="Guardar"
                                onclick="this.form.action='?action=register';">
                            </p>
                          </div>
                        </div>
                      </form>
                      <?php else: ?>
                      <h4>No se encontraron registros</h4>
                      <?php endif; ?>
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

</html>