<?php
  session_start();
  require_once "UserCrudDAO.php";
  require_once "../persistence/Database/Database.php";
  
  $db = database::connect();

  if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];

    if ($action == 'update') {
      $update = new UserCrudDAO();
      $update->updateUser(
        $_POST['tdoc'], $_POST['id_user'], $_POST['f_name'], $_POST['s_name'],
        $_POST['f_lname'], $_POST['s_lname'], $_POST['gender'], $_POST['adress'],
        $_POST['email'], $_POST['phone'], $_POST['u_name'], $_POST['pass'],
        $_POST['s_ans'], $_POST['s_ques']
      );
    }
  }
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
  <title>Información de Usuario</title>
</head>

<body>
  <section class="h-100 bg-white">
    <?php
    $tdoc = $_SESSION["TIPO_DOC"];
    $id = $_SESSION["ID_PERSONA"];
    ?>
    <div class="container py-4 h-100">
      <form action="#" method="post" enctype="multipart/form-data">
        <?php $sql = "
          SELECT * FROM user
          WHERE pk_fk_cod_doc = '$tdoc'
            AND id_user = '$id'
        ";

        $query = $db->query($sql);
        while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
          ?>
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col">
            <div class="card card-registration my-4">
              <div class="row g-0">
                <div class="col-xl-12">
                  <div class="card-body p-md-5 text-black" style="background-color: hsl(0, 0%, 96%)">
                    <h3 class="text-center d-flex justify-content-center mb-5 text-primary text-uppercase">Actualizar
                      Usuario
                    </h3>

                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <select id="select" class="form-control" name="tipo_doc">
                              <?php
                              foreach ($db->query('SELECT * FROM type_of_document') as $row) {
                                echo '
                                  <option
                                    value="' . $row['cod_document'] . '">
                                    ' . $row["Des_doc"] .
                                  '</option>
                                ';
                              }
                              ?>
                            </select>
                          </div>
                          <label class="form-label" id="titulo">Tipo de Documento</label>
                        </div>
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="number" id="space" class="form-control" name="n_id"
                              value="<?php echo $r['id_user']; ?>" readonly required />
                            <label class="form-label" for="n_id">No° de Identificación</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="text" name="name" id="space" value="<?php echo $r['first_name']; ?>"
                              placeholder="Primer Nombre" maxlength="15" class="form-control" required />
                            <label class="form-label" for="name" id="name">Primer Nombre</label>
                          </div>
                        </div>

                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="text" name="sname" id="space" value="<?php echo $r['second_name']; ?>"
                              placeholder="Segundo Nombre" class="form-control" maxlength="15" />
                            <label class="form-label" for="sname" id="sname">Segundo Nombre
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="text" name="lname" id="ape" value="<?php echo $r['surname']; ?>"
                              placeholder="Primer Apellido" class="form-control" maxlength="15" required />
                            <label class="form-label" for="lname" id="Apellido">Primer Apellido
                            </label>
                          </div>
                        </div>

                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="text" name="slname" id="sa" value="<?php echo $r['second_surname']; ?>"
                              placeholder="Segundo Apellido" class="form-control" maxlength="15" />
                            <label class="form-label" for="slname" id="sape">
                              Segundo Apellido
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <select id="slect" class="form-control" name="gender">
                              <?php
                              $result = $db->query('SELECT * FROM gender WHERE state = 1');
                              ?>
                              <?php foreach ($result as $row): ?>
                              <option value="<?php echo $row['desc_gender']; ?>">
                                <?php echo $row['desc_gender']; ?>
                              </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                          <label id="gender" class="form-label">Género</label>
                        </div>
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="number" name="phone" id="phone" value="<?php echo $r['phone']; ?>"
                              placeholder="Teléfono" class="form-control" maxlength="15" />
                            <label class="form-label" for="slname" id="tel">Teléfono</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="text" name="direc" id="dir" value="<?php echo $r['adress']; ?>"
                              placeholder="Dirección" class="form-control" maxlength="40" />
                            <label class="form-label" for="direc" id="direc">Dirección</label>
                          </div>
                        </div>

                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="email" name="email" id="mail" value="<?php echo $r['email']; ?>"
                              placeholder="Correo electrónico" class="form-control" maxlength="35" required />
                            <label class="form-label" for="email" id="email">Correo</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="text" name="usern" id="User" value="<?php echo $r['user_name']; ?>"
                              placeholder="Usuario" class="form-control" maxlength="30" required />
                            <label class="form-label" for="usern" id="nickname">Usuario</label>
                          </div>
                        </div>

                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="password" name="pass" id="pass" value="<?php echo $r['pass']; ?>"
                              placeholder="Contraseña" class="form-control" maxlength="20" minlength="10" required />
                            <label class="form-label" for="pass" id="pasw">Contraseña</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12 mb-4">
                          <div class="form-outline">
                            <input type="file" name="usern" id="photo" placeholder="Imagen de perfil"
                              class="form-control" accept="image/*" />
                            <label class="form-label" for="photo" id="photo">
                              Foto de perfil
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <select id="listp" class="form-control" name="p_seg">
                              <?php
                                $result = $db->query('
                                  SELECT * FROM security_question
                                  WHERE state = 1
                                ');
                              ?>
                              <?php foreach ($result as $row): ?>
                              <option value="<?php echo $row['question']; ?>">
                                <?php echo $row['question']; ?>
                              </option>
                              <?php endforeach; ?>
                            </select>
                            <label class="form-label" for="p_seg" id="ask">
                              Pregunta de seguridad
                            </label>
                          </div>
                        </div>
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="text" name="r_seg" id="ans" value="<?php echo $r['security_answer']; ?>"
                              placeholder="Respuesta de seguridad" class="form-control" style="text-transform:uppercase"
                              required />
                            <label class="form-label" for="p_seg" id="answer">
                              Ingrese Su Respuesta De Seguridad
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="d-flex justify-content-center pt-3">
                        <input id="boton" type="submit" class="btn btn-primary btn-lg" value="Actualizar"
                          onclick="this.form.action = '?action=update';" />
                        <a id="reg" href="../index.php" class="btn btn-ligth btn-lg ms-2">
                          Regresar
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </form>
    </div>
  </section>

  <footer class="bg-light text-center text-lg-start">
    <div class="text-center p-3" style="background-color: hsl(0, 0%, 96%)">
      © 2023 Copyright:
      <a class="text-blue" href="https://github.com/Juan-Carlos-Estevez-Vargas/SoftEduRed">SoftEduRed.com</a>
    </div>
  </footer>
  <section class="h-100 bg-dark">
</body>

</html>