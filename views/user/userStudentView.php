<?php
    require_once "../../persistence/database/Database.php";
    require_once "../../persistence/user/UserStudentDAO.php";

    $db = database::connect();

    if (isset($_REQUEST['action'])) {
        $action = $_REQUEST['action'];

        if ($action === 'update') {
            $update = new UserStudentDAO();
            $update->updateUserStudent(
                $_POST['tdoc'], $_POST['id_user'], $_POST['f_name'], $_POST['s_name'],
                $_POST['f_lname'], $_POST['s_lname'], $_POST['gender'], $_POST['adress'],
                $_POST['email'], $_POST['phone'], $_POST['u_name'], $_POST['pass'], $_POST['s_ans'],
                $_POST['s_ques'], $_POST['att_doc'], $_POST['att_id'], $_POST['course']
            );
        } elseif ($action === 'register') {
            $insert = new UserStudentDAO();
            $insert->registerUserAndStudent(
                $_POST['tdoc'], $_POST['id_user'], $_POST['f_name'], $_POST['s_name'], $_POST['f_lname'],
                $_POST['s_lname'], $_POST['gender'], $_POST['adress'], $_POST['email'], $_POST['phone'],
                $_POST['u_name'], $_POST['pass'], $_POST['s_ans'], $_POST['s_ques'], $_POST['att_doc'],
                $_POST['att_id'], $_POST['course']);
        } elseif ($action === 'delete') {
            $delete = new UserStudentDAO();
            $delete->deleteStudentUser($_GET['id_user'], $_GET['t_doc']);
        } elseif ($action === 'edit') {
            $id = $_GET['id_user'];
            $tdoc = $_GET['t_doc'];
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
                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="tdoc">
                                  <?php
                                        foreach ($db->query('SELECT * FROM type_of_document') as $row) {
                                            echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
                                        }
                                    ?>
                                </select>
                                <label class="form-label">Tipo de Documento:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input class="form-control" id=" space" type="number" name="id_user"
                                  placeholder="Número de Identificación" maxlength="15" minlength="5" required />
                                <label class="form-label">Número de Identificación:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" class="form-control" type="text" name="f_name"
                                  placeholder="Primer Nombre" maxlength="15" required />
                                <label class="form-label">Primer Nombre:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="s_name"
                                  placeholder="Segundo Nombre" maxlength="15" />
                                <label class="form-label">Segundo Nombre:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="f_lname"
                                  placeholder="Primer Apellido" maxlength="15" required />
                                <label class="form-label">Primer Apellido:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" class="form-control" type="text" name="s_lname"
                                  placeholder="Segundo Apellido" />
                                <label class="form-label">Segundo Apellido:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="gender">
                                  <?php
                                    foreach ($db->query('SELECT * FROM gender') as $row) {
                                        echo '<option value="'.$row['desc_gender'].'">'.$row["desc_gender"].'</option>';
                                    }
                                ?>
                                </select>
                                <label class="form-label">Género:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="adress" placeholder="Dirección"
                                  maxlength="40" />
                                <label class="form-label">Dirección:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" class="form-control" type="email" name="email"
                                  placeholder="Correo Electrónico" maxlength="35" required />
                                <label class="form-label">Correo:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="number" class="form-control" name="phone" placeholder="Teléfono"
                                  maxlength="15" />
                                <label class="form-label">Teléfono:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name=" u_name" placeholder="Usuario"
                                  required maxlength="45" />
                                <label class="form-label">Usuario:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" class="form-control" type="password" name="pass"
                                  placeholder="Contraseña" required maxlength="20" />
                                <label class="form-label">Contraseña:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-6">
                              <div class="form-outline">
                                <select class="form-control" name="s_ques">
                                  <?php
                                      foreach ($db->query('SELECT * FROM security_question') as $security)  {
                                        echo '<option value="'.$security['question'].'">'.$security["question"].'</option>';
                                      }
                                    ?>
                                </select>
                                <label class="form-label">Pregunta de Seguridad:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="ans" type="text" class="form-control" name="s_ans" placeholder="Respuesta"
                                  required />
                                <label class="form-label">Respuesta:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="att_doc">
                                  <?php
                                        foreach ($db->query('SELECT * FROM attendant') as $row1)  {
                                            echo '<option value="'.$row1['user_pk_fk_cod_doc'].'">'.$row1["user_pk_fk_cod_doc"].'</option>';
                                        }
                                    ?>
                                </select>
                                <label class="form-label">Tipo Documento Acudiente:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="att_id">
                                  <?php
                                        foreach ($db->query('SELECT * FROM attendant') as $attendant) {
                                            echo '<option value="'.$attendant['user_id_user'].'">'.$attendant["user_id_user"].'</option>';
                                        }
                                    ?>
                                </select>
                                <label class="form-label">Número de Identificación del Acudiente:</label>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="course">
                                  <?php
                                        foreach ($db->query('SELECT * FROM course WHERE state=1') as $course) {
                                            echo '<option value="'.$course['cod_course'].'">'.$course["cod_course"].'</option>';
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
                        <?php if (!empty($_GET['t_doc']) && !empty($_GET['id_user']) && !empty($_GET['action']) && !empty($id)) { ?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <?php
                            $sql = "SELECT * FROM user WHERE pk_fk_cod_doc = '$tdoc' and id_user = '$id'";
                            $query = $db->query($sql);
                        
                            while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                          <h4 class="mb-5 text-uppercase text-center text-success">Actualizar Estudiante</h4>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="tdoc"
                                  value="<?php echo $r['pk_fk_cod_doc'];?>" readonly required />
                                <label class="form-label">Tipo de Documento:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="number" class="form-control" name=" id_user"
                                  value="<?php echo $r['id_user'];?>" readonly required />
                                <label class="form-label">Número de Identificación:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" class="form-control" type="text" name="f_name"
                                  value="<?php echo $r['first_name'];?>" maxlength="15" placeholder="Primer Nombre"
                                  required />
                                <label class="form-label">Primer Nombre:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="s_name"
                                  value="<?php echo $r['second_name'];?>" maxlength="15" placeholder="Segundo Nombre" />
                                <label class="form-label">Segundo Nombre:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="f_lname"
                                  value="<?php echo $r['surname'];?>" maxlength="15" placeholder="Primer Apellido"
                                  required />
                                <label class="form-label">Primer Apellido:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="s_lname"
                                  value="<?php echo $r['second_surname'];?>" maxlength="15"
                                  placeholder="Segundo Apellido" />
                                <label class="form-label">Segundo Apellido:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="gender">
                                  <?php
                                    foreach ($db->query('SELECT * FROM gender') as $gender){
                                        echo '<option value="'.$gender['desc_gender'].'">'.$gender['desc_gender'].'</option>';
                                    }
                                ?>
                                </select>
                                <label class="form-label">Género:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="Dirección"
                                  value="<?php echo $r['adress'];?>" maxlength="40" placeholder="Adress" />
                                <label class="form-label">Dirección:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="email"
                                  value="<?php echo $r['email'];?>" maxlength="35" placeholder="Correo Electrónico"
                                  required />
                                <label class="form-label">Correo:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" class="form-control" type="text" name="phone"
                                  value="<?php echo $r['phone'];?>" placeholder="Teléfono" maxlength="15" />
                                <label class="form-label">Teléfono:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="u_name"
                                  value="<?php echo $r['user_name'];?>" maxlength="45" placeholder="Usuario" required />
                                <label class="form-label">Usuario:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="password" maxlength="20" class="form-control" name="pass"
                                  placeholder="Contraseña" required />
                                <label class="form-label">Contraseña:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-6">
                              <div class="form-outline">
                                <select class="form-control" name="s_ques">
                                  <?php
                                    foreach ($db->query('SELECT * FROM security_question') as $securityQuestion) {
                                        echo '<option value="'.$securityQuestion['question'].'">'.$r["fk_s_question"].'</option>';
                                    }
                                ?>
                                </select>
                                <label class="form-label">Pregunta de Seguridad:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" class="form-control" type="text" name="s_ans"
                                  value="<?php echo $r['security_answer'];?>" required />
                                <label class="form-label">Respuesta:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="att_doc">
                                  <?php
                                    foreach ($db->query('SELECT * FROM attendant') as $attendant) {
                                        echo '<option value="'.$attendant['user_pk_fk_cod_doc'].'">'.$attendant["user_pk_fk_cod_doc"].'</option>';
                                    }
                                ?>
                                </select>
                                <label class="form-label">Tipo Documento Acudiente:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="att_id">
                                  <?php
                                    foreach ($db->query('SELECT * FROM attendant') as $attendant){
                                        echo '<option value="'.$attendant['user_id_user'].'">'.$attendant["user_id_user"].'</option>';
                                    }
                                    ?>
                                </select>
                                <label class="form-label">Número de Identificación del Acudiente:</label>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="course">
                                  <?php
                                    foreach ($db->query('SELECT * FROM course WHERE state=1') as $course) {
                                        echo '<option value="'.$course['cod_course'].'">'.$course["cod_course"].'</option>';
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
                        $sql = "SELECT * FROM user
                        JOIN user_has_role ON tdoc_role = pk_fk_cod_doc
                            AND id_user = pk_fk_id_user WHERE pk_fk_role = 'STUDENT'";
                    
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
                            <?php echo "<td>".$row['pk_fk_cod_doc']."</td>";?>
                            <?php echo "<td>".$row['id_user'] . "</td>";?>
                            <?php echo "<td>".$row['first_name'] . "</td>";?>
                            <?php echo "<td>".$row['surname'] . "</td>";?>
                            <?php echo "<td>".$row['phone'] . "</td>";?>
                            <td>
                              <a class="btn btn-primary btn-block" id="boton"
                                href="?action=edit&id_user=<?php echo $row['id_user'];?>&t_doc=<?php echo $row['pk_fk_cod_doc'] ?>">
                                Update
                              </a>
                              <a class="btn btn-danger btn-block" id="boton"
                                href="?action=delete&id_user=<?php echo $row['id_user'];?>&t_doc=<?php echo $row['pk_fk_cod_doc'] ?>"
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