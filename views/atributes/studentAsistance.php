<?php
     require_once "../../persistence/atributes/NoAttendance.php";
     require_once "../../persistence/Database/Database.php";
     $db = database::conectar();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="images/login.ico" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <meta charset="utf-8" />
  <title><?php session_start();?> Welcome</title>
</head>

<body>
  <section class="h-100 bg-dark">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
          <div class="col-xl-12">
            <h3 class="mb-5 text-uppercase text-center">Listado de Asistencias</h3>
            <?php if ($_SESSION['role_index'] === 'st'): ?>
            <h1>Student
              <?php echo $_SESSION["NAME"]. " " .$_SESSION["SNAME"]." ".$_SESSION["LASTNAME"]." ".$_SESSION["SLASTNAME"];?>
            </h1>
            <?php
              $sql = "
                SELECT * FROM no_attendance
                WHERE fk_student_tdoc = '".$_SESSION["TIPO_DOC"]."'
                AND fk_student_user_id='".$_SESSION["ID_PERSONA"]."'
              ";
              $query = $db->query($sql);
              echo "FALTASTE EL(los) DÍA(s):";
              while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
                echo "<input id='space' type='text' name='tdoc' value='".$row['fk_student_tdoc']."' disabled />";
                echo "<input id='space' type='text' name='tdoc' value='".$row['fk_student_user_id']."' disabled />";
                echo "<input id='space' type='text' name='tdoc' value='".$row['date']."' disabled />";
                echo "<input id='space' type='text' name='tdoc' value='".$row['fk_sub_has_course']."' disabled />";
              }
            ?>
            <?php endif; if ($_SESSION['role_index'] === 'att'): ?>
            <div class="row align-items-center">
              <div class="col-xl-4">
                <label>Mr.(Ms) Attendant Select One Student:</label>
              </div>
              <div class="col-xl-4">
                <select name="s" class="form-control form-control-lg">
                  <?php
                  foreach ($db->query("
                    SELECT * FROM student
                    JOIN user ON pk_fk_tdoc_user = pk_fk_cod_doc
                    AND pk_fk_user_id = id_user
                    WHERE fk_attendat_cod_doc ='".$_SESSION["TIPO_DOC"]."'
                    AND fk_attendant_id='".$_SESSION["ID_PERSONA"]."'
                  ") as $row1) {
                    echo "<option value='".$row1['pk_fk_user_id']."'>".$row1['first_name']." ".$row1['surname']."</option>";
                  }
                ?>
                </select>
              </div>
              <div class="col-xl-4">
                <button id="boton">Buscar</button>
              </div>
            </div>
            <?php endif; ?>
          </div>

          <div class="col-xl-12">
            <?php
               if (isset($_GET['s'])) {
               $_SESSION['estu_id'] = $_GET['s'];
               }

               $sql1= "
               SELECT * FROM student
               JOIN course
                    ON cod_course = fk_cod_course
               JOIN subject_has_course
                    ON cod_course = pk_fk_course_stu
               WHERE pk_fk_user_id
               LIKE '".@$_SESSION['estu_id']."'
               AND fk_attendat_cod_doc = '".$_SESSION['TIPO_DOC']."'
               AND fk_attendant_id ='".$_SESSION["ID_PERSONA"]."'
               ";

               $query = $db->query($sql1);
               if ($query->rowCount() > 0 || isset($_SESSION['b'])):
               $_SESSION['b'] = 1;
               ?>
            <form action="" method="">
              <div class="row align-items-center">
                <div class="col-xl-4">
                  <label>Select The Subject For The NO Asistence Query:</label>
                </div>
                <div class="col-xl-4">
                  <select name="sub" class="form-control">
                    <?php
                         foreach ($db->query("
                         SELECT * FROM student
                         JOIN course
                              ON cod_course = fk_cod_course
                         JOIN subject_has_course
                              ON cod_course = pk_fk_course_stu
                         WHERE pk_fk_user_id
                         LIKE '".$_SESSION['estu_id']."'
                         AND fk_attendat_cod_doc = '".$_SESSION['TIPO_DOC']."'
                         AND fk_attendant_id ='".$_SESSION["ID_PERSONA"]."'
                         ") as $row1) {
                         echo "<option value='".$row1['pk_fk_te_sub']."'>".$row1['pk_fk_te_sub']."</option>";
                         }
                    ?>
                  </select>
                </div>
                <div class="col-xl-4">
                  <button id="boton">Buscar</button>
                </div>
              </div>
            </form>
          </div>
          <?php endif; ?>
        </div>

      </div>
      <?php
     $sub=@$_GET['sub'];
     if (isset($sub)):
     ?>
      <?php
     $sql = "
          SELECT
          fk_student_tdoc,
          fk_student_user_id,
          DATE_FORMAT(date, '%Y - %b - %d, %H:%i') AS date
          FROM no_attendance
          JOIN student
          ON fk_student_tdoc = pk_fk_tdoc_user
          AND fk_student_user_id = pk_fk_user_id
          WHERE fk_attendat_cod_doc = '".$_SESSION["TIPO_DOC"]."'
          AND fk_attendant_id='".$_SESSION["ID_PERSONA"]."'
          AND fk_sub_has_course='$sub'
          AND fk_student_user_id='".$_SESSION['estu_id']."'
     ";

     $query2 = $db->query($sql);

     if ($query2->rowCount() > 0) {
          echo "FALTO EL(los) DÍA(s):";
          while ($row=$query2->fetch(PDO::FETCH_ASSOC)) {
          echo "<input id='space' type='text' name='tdoc' value='".$row['fk_student_tdoc']."' disabled />";
          echo "<input id='space' type='text' name='id' value='".$row['fk_student_user_id']."' disabled />";
          echo "<input id='space' type='text' name='date' value='".$row['date']."' disabled />";
          }
     } else {
          print "<script>alert(El Estudiante Seleccionado NO Ha Fallado En Esta Asignatura);</script>";
     }
     endif;
     ?>
    </div>
  </section>

  <div id="new">



</body>

</html>