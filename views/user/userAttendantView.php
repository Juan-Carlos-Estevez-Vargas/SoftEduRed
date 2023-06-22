<?php
    require_once "../../persistence/user/UserAttendantDAO.php";
    require_once "../../persistence/database/Database.php";
    // include "../indexs/cruds.php";
    $db = database::conectar();

    if (isset($_REQUEST['action'])) {
        $action = $_REQUEST['action'];

        if ($action === 'update') {

            $update = new UserAttendantDAO();
            $update->updateAttendantUser(
                $_POST['tdoc'], $_POST['id_user'], $_POST['f_name'], $_POST['s_name'],
                $_POST['f_lname'], $_POST['s_lname'], $_POST['gender'], $_POST['adress'],
                $_POST['email'], $_POST['phone'], $_POST['u_name'], $_POST['pass'],
                $_POST['s_ans'], $_POST['s_ques'], $_POST['relation']
            );
        
        } elseif ($action === 'register') {

            $insert = new UserAttendantDAO();
            $insert ->registerAttendantUser(
                $_POST['tdoc'], $_POST['id_user'], $_POST['f_name'], $_POST['s_name'],
                $_POST['f_lname'], $_POST['s_lname'], $_POST['gender'], $_POST['adress'],
                $_POST['email'], $_POST['phone'], $_POST['u_name'], $_POST['pass'],
                $_POST['s_ans'], $_POST['s_ques'], $_POST['relation']
            );
        
        } elseif ($action === 'delete') {

            $delete = new UserAttendantDAO();
            $delete->deleteAttendantUser($_GET['id_user'],$_GET['t_doc']);

        } elseif ($action === 'edit') {

            $id = $_GET['id_user'];
            $tdoc = $_GET['t_doc'];

        }
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Acudiente</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
                    <a class="btn btn-success" href="?action=ver&m=1">Agregar Registro</a>
                  </h3>

                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <h4 class="mb-5 text-uppercase text-center text-success">Nuevo Asistente</h4>

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
                                <input id="space" type="number" class="form-control" name="id_user"
                                  placeholder="Número de Identificación" required />
                                <label class="form-label">Número de Identificación:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="f_name"
                                  placeholder="Primer Nombre" required />
                                <label class="form-label">Primer Nombre:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="s_name"
                                  placeholder="Segundo Nombre" />
                                <label class="form-label">Segundo Nombre:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="f_lname"
                                  placeholder="Primer Apellido" required />
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
                                <input id="space" type="text" class="form-control" name="adress"
                                  placeholder="Dirección" />
                                <label class="form-label">Dirección:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="email"
                                  placeholder="Correo Electrónico" required />
                                <label class="form-label">Correo electrónico:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="phone" placeholder="Teléfono"
                                  required />
                                <label class="form-label">Teléfono:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="u_name" placeholder="Usuario"
                                  required />
                                <label class="form-label">Usuario:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="password" class="form-control" name="pass"
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
                                    foreach ($db->query('SELECT * FROM security_question') as $row2) {
                                        echo '<option value="'.$row2['question'].'">'.$row2["question"].'</option>';
                                    }
                                ?>
                                </select>
                                <label class="form-label">Pregunta de Seguridad:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="s_ans" placeholder="Respuesta"
                                  required />
                                <label class="form-label">Respuesta:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="relation">
                                  <?php
                                    foreach ($db->query('SELECT * FROM relationship WHERE state=1') as $relationship) {
                                        echo '<option value="'.$relationship['desc_relationship'].'">'.$relationship["desc_relationship"].'</option>';
                                    }
                                ?>
                                </select>
                                <label class="form-label">Relación:</label>
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
                        <?php if (!empty($_GET['t_doc']) && !empty($_GET['id_user']) && !empty($_GET['action'])) { ?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <?php $sql = "SELECT * FROM user WHERE pk_fk_cod_doc = '$tdoc' and id_user = '$id'";
                            $query = $db->query($sql);
                            while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                          <h4 class="mb-5 text-uppercase text-center text-success">Actualizar Acudiente</h4>

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
                                <input id="space" type="number" class="form-control" name="id_user"
                                  value="<?php echo $r['id_user'];?>" readonly required />
                                <label class="form-label">Número de Identificación:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="f_name"
                                  value="<?php echo $r['first_name'];?>" placeholder="Primer Nombre" required />
                                <label class="form-label">Primer Nombre:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="s_name"
                                  value="<?php echo $r['second_name'];?>" placeholder="Segundo Nombre" />
                                <label class="form-label">Segundo Nombre:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="f_lname"
                                  value="<?php echo $r['surname'];?>" placeholder="Primer Apellido" required />
                                <label class="form-label">Primer Apellido:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="s_lname"
                                  value="<?php echo $r['second_surname'];?>" placeholder="Segundo Apellido" />
                                <label class="form-label">Segundo Apellido:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="gender">
                                  <?php
                                    foreach ($db->query('SELECT * FROM gender') as $row1) {
                                        $selected = $r['fk_gender'] == $row1['desc_gender'] ? 'selected' : '';
                                        echo '<option value="'.$row1['desc_gender'].'" '.$selected.'>'.$row1['desc_gender'].'</option>';
                                    }
                                ?>
                                </select>
                                <label class="form-label">Género:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="adress"
                                  value="<?php echo $r['adress'];?>" placeholder="Dirección" />
                                <label class="form-label">Dirección:</label>
                              </div>
                            </div>
                          </div>

                          <div class="row mb-4">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="email"
                                  value="<?php echo $r['email'];?>" placeholder="Correo Electrónico" required />
                                <label class="form-label">Correo:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="phone"
                                  value="<?php echo $r['phone'];?>" placeholder="Teléfono" required />
                                <label class="form-label">Teléfono:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="text" class="form-control" name="u_name"
                                  value="<?php echo $r['user_name'];?>" placeholder="Usuario" required />
                                <label class="form-label">Usuario:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="space" type="password" class="form-control" name="pass"
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
                                    foreach ($db->query('SELECT * FROM security_question') as $row2) {
                                        $selected = $r['fk_s_question'] == $row2['question'] ? 'selected' : '';
                                        echo '<option value="'.$row2['question'].'" '.$selected.'>'.$row2["question"].'</option>';
                                    }
                                ?>
                                </select>
                                <label class="form-label">Pregunta de Seguridad:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input id="ans" type="text" class="form-control" name="s_ans"
                                  value="<?php echo $r['security_answer'];?>" required />
                                <label class="form-label">Respuesta:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="relation">
                                  <?php
                                    foreach ($db->query('SELECT * FROM relationship WHERE state=1') as $relationship)
                                    {
                                        echo '<option value="'.$relationship['desc_relationship'].'">'.$relationship["desc_relationship"].'</option>';
                                    }
                                ?>
                                </select>
                                <label class="form-label">Relación:</label>
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
                        $sql = "SELECT * FROM user JOIN user_has_role ON tdoc_role = pk_fk_cod_doc
                        AND id_user = pk_fk_id_user WHERE pk_fk_role = 'ATTENDANT'";
                        $query = $db ->query($sql);
                        
                        if ($query->rowCount()>0):
                    ?>
                    <h4 class="mb-5 text-uppercase text-primary">Registros</h4>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <caption class="text-center">Listado de Resultados</caption>
                        <thead>
                          <tr>
                            <th>Número de Documento</th>
                            <th>Número de Identificación</th>
                            <th>Primer Nombre</th>
                            <th>Segundo Nombre</th>
                            <th>Primer Apellido</th>
                            <th>Segundo Apellido</th>
                            <th>Género</th>
                            <th>Dirección</th>
                            <th>Correo Electrónico</th>
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
                            <?php echo "<td>".$row['second_name'] . "</td>";?>
                            <?php echo "<td>".$row['surname'] . "</td>";?>
                            <?php echo "<td>".$row['second_surname'] . "</td>";?>
                            <?php echo "<td>".$row['fk_gender'] . "</td>";?>
                            <?php echo "<td>".$row['adress'] . "</td>";?>
                            <?php echo "<td>".$row['email'] . "</td>";?>
                            <?php echo "<td>".$row['phone'] . "</td>";?>
                            <td>
                              <a class="btn btn-primary btn-block"
                                href="?action=edit&id_user=<?php echo $row['id_user'];?>&t_doc=<?php echo $row['pk_fk_cod_doc'] ?>">
                                Update
                              </a>
                              <a class="btn btn-danger btn-block"
                                href="?action=delete&id_user=<?php echo $row['id_user'];?>&t_doc=<?php echo $row['pk_fk_cod_doc'] ?>"
                                onclick="return confirm('¿Esta seguro de eliminar este usuario?')">
                                Delete
                              </a>
                            </td>
                          </tr>
                          <?php endwhile ?>
                        </tbody>
                      </table>
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