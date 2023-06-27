<?php
    require_once "../../persistence/database/Database.php";
    require_once "../../persistence/user/UserStudentDAO.php";

    $db = database::connect();

    if (isset($_REQUEST['action'])) {
        $action = $_REQUEST['action'];

        if ($action === 'update') {
            $update = new UserStudentDAO();
            $update->updateUserStudent(
                $_POST['id_user'], $_POST['document_type'], $_POST['identification'],
                $_POST['first_name'], $_POST['second_name'], $_POST['surname'],
                $_POST['second_surname'], $_POST['gender'], $_POST['address'], $_POST['email'],
                $_POST['phone'], $_POST['username'], $_POST['password'], $_POST['security_question'],
                $_POST['answer'], $_POST['attendant'], $_POST['course']
            );
        } elseif ($action === 'register') {
            $insert = new UserStudentDAO();
            $insert->registerUserAndStudent(
                $_POST['document_type'], $_POST['identification'], $_POST['first_name'],
                $_POST['second_name'], $_POST['surname'], $_POST['second_surname'],
                $_POST['gender'], $_POST['address'], $_POST['email'], $_POST['phone'],
                $_POST['username'], $_POST['password'], $_POST['security_question'],
                $_POST['answer'], $_POST['attendant'], $_POST['course']
            );
        } elseif ($action === 'delete') {
            $delete = new UserStudentDAO();
            $delete->deleteStudentUser($_GET['id_user']);
        } elseif ($action === 'edit') {
            $id = $_GET['id_user'];
        }
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Estudiante</title>
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
                  <h3 class="text-center d-flex justify-content-center justify-content-md-end">
                    <a class="btn btn-success" href="?action=ver&m=1">Agregar Estudiante</a>
                  </h3>

                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <h4 class="mb-5 text-uppercase text-center text-success">Nuevo Estudiante</h4>

                          <div class="row mb-4">
                            <div class=" col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="document_type">
                                  <?php
                                      foreach ($db->query('SELECT * FROM document_type') as $row) {
                                        echo '<option value="'.$row['id_document_type'].'">'.$row["description"].'</option>';
                                      }
                                    ?>
                                </select>
                                <label class="form-label" for="document_type">Tipo de Documento:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input class="form-control" type="number" name="identification"
                                  placeholder="Número de Identificación" maxlength="15" minlength="5" required />
                                <label class="form-label" for="identification">Número de Identificación:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input class="form-control" type="text" name="first_name" placeholder="Primer Nombre"
                                  maxlength="15" required />
                                <label class="form-label" for="first_name">Primer Nombre:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input type="text" class="form-control" name="second_name" placeholder="Segundo Nombre"
                                  maxlength="15" />
                                <label class="form-label" for="second_name">Segundo Nombre:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <input type="text" class="form-control" name="surname" placeholder="Primer Apellido"
                                  maxlength="15" required />
                                <label class="form-label" for="surname">Primer Apellido:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input class="form-control" type="text" name="second_surname"
                                  placeholder="Segundo Apellido" />
                                <label class="form-label" for="second_surname">Segundo Apellido:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="gender">
                                  <?php
                                      foreach ($db->query('SELECT * FROM gender') as $row) {
                                        echo '<option value="'.$row['id_gender'].'">'.$row["description"].'</option>';
                                      }
                                    ?>
                                </select>
                                <label class="form-label" for="gender">Género:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input type="text" class="form-control" name="address" placeholder="Dirección"
                                  maxlength="40" />
                                <label class="form-label" for="address">Dirección:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <input class="form-control" type="email" name="email" placeholder="Correo Electrónico"
                                  maxlength="35" required />
                                <label class="form-label" for="email">Correo:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input type="number" class="form-control" name="phone" placeholder="Teléfono"
                                  maxlength="15" />
                                <label class="form-label" for="phone">Teléfono:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input type="text" class="form-control" name="username" placeholder="Usuario" required
                                  maxlength="45" />
                                <label class="form-label" for="username">Usuario:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input class="form-control" type="password" name="password" placeholder="Contraseña"
                                  required maxlength="20" />
                                <label class="form-label" for="password">Contraseña:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-5">
                              <div class="form-outline">
                                <select class="form-control" name="security_question">
                                  <?php
                                        foreach ($db->query('SELECT * FROM security_question') as $security)  {
                                          echo '<option value="'.$security['id_security_question'].'">'.$security["description"].'</option>';
                                        }
                                      ?>
                                </select>
                                <label class="form-label" for="security_question">Pregunta de Seguridad:</label>
                              </div>
                            </div>

                            <div class=" col-md-3">
                              <div class="form-outline">
                                <input type="text" class="form-control" name="answer" placeholder="Respuesta"
                                  required />
                                <label class="form-label" for="answer">Respuesta:</label>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-outline">
                                <select class="form-control" name="attendant">
                                  <?php
                                      foreach ($db->query('
                                        SELECT u.first_name, u.surname, u.identification_number, a.id_attendant
                                        FROM `user` AS u
                                        INNER JOIN `attendant` AS a ON u.id_user = a.user_id
                                      ') as $row1)  {
                                          echo '<option value="'.$row1['id_attendant'].'">'.$row1["identification_number"].' - '.$row1["first_name"].' '.$row1["surname"].'</option>';
                                      }
                                    ?>
                                </select>
                                <label class="form-label">Acudiente:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="course">
                                  <?php
                                      foreach ($db->query('SELECT * FROM course WHERE state = 1') as $course) {
                                        echo '<option value="'.$course['id_course'].'">'.$course["course"].'</option>';
                                      }
                                    ?>
                                </select>
                                <label class="form-label">Curso del Estudiante:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="boton" type="submit" class="btn btn-primary btn-block" value="Guardar"
                                  onclick="this.form.action ='?action=register'" />
                              </div>
                            </div>
                          </div>
                        </form>
                        <?php } ?>
                      </div>
                    </div>
                  </div>

                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <?php if (!empty($_GET['id_user']) && !empty($_GET['action']) && !empty($id)) { ?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <?php
                            $sql = "SELECT * FROM user WHERE id_user = '$id'";
                            $query = $db->query($sql);
                        
                            while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                          <h4 class="mb-5 text-uppercase text-center text-success">Actualizar Estudiante</h4>

                          <div style="display: none;">
                            <input type="text" value="<?php echo $r['id_user']; ?>" name="id_user" />
                          </div>
                          <div class=" row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="document_type">
                                  <?php
                                    foreach ($db->query('SELECT * FROM document_type') as $row) {
                                      echo '<option value="'.$row['id_document_type'].'">'.$row["description"].'</option>';
                                    }
                                  ?>
                                </select>
                                <label class="form-label" for="document_type">Tipo de Documento:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input class="form-control" type="number" name="identification"
                                  placeholder="Número de Identificación"
                                  value="<?php echo $r['identification_number'];?>" readonly maxlength="15"
                                  minlength="5" required />
                                <label class="form-label" for="identification">Número de Identificación:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input class="form-control" type="text" name="first_name" placeholder="Primer Nombre"
                                  maxlength="15" required value="<?php echo $r['first_name'];?>" />
                                <label class="form-label" for="first_name">Primer Nombre:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input type="text" class="form-control" name="second_name" placeholder="Segundo Nombre"
                                  maxlength="15" value="<?php echo $r['second_name'];?>" />
                                <label class="form-label" for="second_name">Segundo Nombre:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <input type="text" class="form-control" name="surname" placeholder="Primer Apellido"
                                  maxlength="15" value="<?php echo $r['surname'];?>" required />
                                <label class="form-label" for="surname">Primer Apellido:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input class="form-control" type="text" name="second_surname"
                                  placeholder="Segundo Apellido" value="<?php echo $r['second_surname'];?>" />
                                <label class="form-label" for="second_surname">Segundo Apellido:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="gender">
                                  <?php
                                    foreach ($db->query('SELECT * FROM gender') as $row) {
                                      echo '<option value="'.$row['id_gender'].'">'.$row["description"].'</option>';
                                    }
                                  ?>
                                </select>
                                <label class="form-label" for="gender">Género:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input type="text" class="form-control" name="address" placeholder="Dirección"
                                  maxlength="40" value="<?php echo $r['address'];?>" />
                                <label class="form-label" for="address">Dirección:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <input class="form-control" type="email" name="email" placeholder="Correo Electrónico"
                                  maxlength="35" value="<?php echo $r['email'];?>" required />
                                <label class="form-label" for="email">Correo:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input type="number" class="form-control" name="phone" placeholder="Teléfono"
                                  maxlength="15" value="<?php echo $r['phone'];?>" />
                                <label class="form-label" for="phone">Teléfono:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input type="text" class="form-control" name="username" placeholder="Usuario" required
                                  maxlength="45" value="<?php echo $r['username'];?>" />
                                <label class="form-label" for="username">Usuario:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input class="form-control" type="password" name="password" placeholder="Contraseña"
                                  required maxlength="20" value="<?php echo $r['password'];?>" />
                                <label class="form-label" for="password">Contraseña:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-5">
                              <div class="form-outline">
                                <select class="form-control" name="security_question">
                                  <?php
                                    foreach ($db->query('SELECT * FROM security_question') as $security)  {
                                      echo '<option value="'.$security['id_security_question'].'">'.$security["description"].'</option>';
                                    }
                                  ?>
                                </select>
                                <label class="form-label" for="security_question">Pregunta de Seguridad:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input type="text" class="form-control" name="answer" placeholder="Respuesta"
                                  value="<?php echo $r['security_answer'];?>" required />
                                <label class="form-label" for="answer">Respuesta:</label>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-outline">
                                <select class="form-control" name="attendant">
                                  <?php
                                    foreach ($db->query('
                                      SELECT u.first_name, u.surname, u.identification_number, a.id_attendant
                                      FROM `user` AS u
                                      INNER JOIN `attendant` AS a ON u.id_user = a.user_id
                                    ') as $row1)  {
                                        echo '<option value="'.$row1['id_attendant'].'">'.$row1["identification_number"].' - '.$row1["first_name"].' '.$row1["surname"].'</option>';
                                    }
                                  ?>
                                </select>
                                <label class="form-label">Acudiente:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="course">
                                  <?php
                                    foreach ($db->query('SELECT * FROM course WHERE state = 1') as $course) {
                                      echo '<option value="'.$course['id_course'].'">'.$course["course"].'</option>';
                                    }
                                  ?>
                                </select>
                                <label class="form-label">Curso del Estudiante:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="reg" type="submit" class="btn btn-primary btn-block" value="Actualizar"
                                  onclick="this.form.action = '?action=update';">
                              </div>
                            </div>
                          </div>
                        </form>
                        <?php
                            }
                          }
                        ?>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 text-center mt-4">
                    <?php
                        $sql = "
                          SELECT u.*, dt.type AS document_type
                          FROM `user` AS u
                          INNER JOIN `user_has_role` AS uhr ON u.id_user = uhr.user_id
                          INNER JOIN `role` AS r ON uhr.role_id = r.id_role
                          INNER JOIN `document_type` AS dt ON u.document_type_id = dt.id_document_type
                          WHERE r.description = 'estudiante'
                        ";
                    
                        $query = $db ->query($sql);
                        if ($query->rowCount() > 0):
					          ?>
                    <h4 class="mb-5 text-uppercase text-primary">Estudiantes</h4>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <caption class="text-center">Listado de Resultados</caption>
                        <thead>
                          <tr>
                            <th>Tipo de Documento</th>
                            <th>Número de Identificación</th>
                            <th>Primer Nombre</th>
                            <th>Primer Apellido</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
                          <tr>
                            <?php echo "<td>".$row['document_type']."</td>";?>
                            <?php echo "<td>".$row['identification_number'] . "</td>";?>
                            <?php echo "<td>".$row['first_name'] . "</td>";?>
                            <?php echo "<td>".$row['surname'] . "</td>";?>
                            <?php echo "<td>".$row['phone'] . "</td>";?>
                            <td>
                              <a class="btn btn-primary btn-block" id="boton"
                                href="?action=edit&id_user=<?php echo $row['id_user'];?>">
                                Update
                              </a>
                              <a class="btn btn-danger btn-block" id="boton"
                                href="?action=delete&id_user=<?php echo $row['id_user'];?>"
                                onclick="confirmDelete(event)">
                                Delete
                              </a>
                            </td>
                          </tr>
                          <?php endwhile ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
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
  </section>

  <footer class="bg-light text-center text-lg-start">
    <div class="text-center p-3" style="background-color: hsl(0, 0%, 96%)">
      © 2023 Copyright:
      <a class="text-blue" href="https://github.com/Juan-Carlos-Estevez-Vargas/SoftEduRed">SoftEduRed.com</a>
    </div>
  </footer>

  <script>
  function confirmDelete(event) {
    event.preventDefault();

    Swal.fire({
      title: '¿Estás seguro de eliminar este registro?',
      text: "Esta acción no se puede deshacer.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = event.target.href;
      }
    });
  }
  </script>
</body>

</html>