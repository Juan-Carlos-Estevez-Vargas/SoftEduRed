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
        $_POST['id_user'], $_POST['document_type'], $_POST['identification_number'],
        $_POST['first_name'], $_POST['second_name'], $_POST['surname'], $_POST['second_surname'],
        $_POST['gender'], $_POST['phone'], $_POST['address'], $_POST['email'],
        $_POST['username'], $_POST['password'], $_POST['security_question'], $_POST['answer']
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
    $id = $_SESSION["ID_USER"];
    ?>
    <div class="container py-4 h-100">
      <form action="#" method="post" enctype="multipart/form-data">
        <?php $sql = "
          SELECT * FROM user
          WHERE id_user = '$id'
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
                        <div>
                          <input type="text" value="<?php echo $r['id_user']; ?>" name="id_user" style="display: none;">
                        </div>

                        <div class=" col-md-6 mb-4">
                          <div class="form-outline">
                            <select class="form-control" name="document_type">
                              <?php
                              foreach ($db->query('SELECT * FROM document_type') as $row) {
                                echo '
                                  <option
                                    value="' . $row['id_document_type'] . '">
                                    ' . $row["description"] .
                                  '</option>
                                ';
                              }
                              ?>
                            </select>
                          </div>
                          <label class="form-label" for="document_type">Tipo de Documento</label>
                        </div>

                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="number" class="form-control" name="identification_number"
                              value="<?php echo $r['identification_number']; ?>" readonly required />
                            <label class="form-label" for="identification_number">No° de Identificación</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="text" name="first_name" value="<?php echo $r['first_name']; ?>"
                              placeholder="Primer Nombre" maxlength="15" class="form-control" required />
                            <label class="form-label" for="first_name">Primer Nombre</label>
                          </div>
                        </div>

                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="text" name="second_name" value="<?php echo $r['second_name']; ?>"
                              placeholder="Segundo Nombre" class="form-control" maxlength="15" />
                            <label class="form-label" for="second_name">Segundo Nombre
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="text" name="surname" value="<?php echo $r['surname']; ?>"
                              placeholder="Primer Apellido" class="form-control" maxlength="15" required />
                            <label class="form-label" for="surname">Primer Apellido
                            </label>
                          </div>
                        </div>

                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="text" name="second_surname" value="<?php echo $r['second_surname']; ?>"
                              placeholder="Segundo Apellido" class="form-control" maxlength="15" />
                            <label class="form-label" for="second_surname">Segundo Apellido</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <select class="form-control" name="gender">
                              <?php
                              $result = $db->query('SELECT * FROM gender WHERE state = 1');
                              ?>
                              <?php foreach ($result as $row): ?>
                              <option value="<?php echo $row['id_gender']; ?>">
                                <?php echo $row['description']; ?>
                              </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                          <label for="gender" class="form-label">Género</label>
                        </div>

                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="number" name="phone" value="<?php echo $r['phone']; ?>" placeholder="Teléfono"
                              class="form-control" maxlength="15" />
                            <label class="form-label" for="phone">Teléfono</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="text" name="address" value="<?php echo $r['address']; ?>"
                              placeholder="Dirección" class="form-control" maxlength="40" />
                            <label class="form-label" for="address">Dirección</label>
                          </div>
                        </div>

                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="email" name="email" value="<?php echo $r['email']; ?>"
                              placeholder="Correo electrónico" class="form-control" maxlength="35" required />
                            <label class="form-label" for="email">Correo</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="text" name="username" value="<?php echo $r['username']; ?>"
                              placeholder="Usuario" class="form-control" maxlength="30" required />
                            <label class="form-label" for="username">Usuario</label>
                          </div>
                        </div>

                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="password" name="password" value="<?php echo $r['password']; ?>"
                              placeholder="Contraseña" class="form-control" maxlength="20" minlength="10" required />
                            <label class="form-label" for="password">Contraseña</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12 mb-4">
                          <div class="form-outline">
                            <input type="file" name="photo" placeholder="Imagen de perfil" class="form-control"
                              accept="image/*" />
                            <label class="form-label" for="photo">Foto de perfil</label>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <select class="form-control" name="security_question">
                              <?php
                                $result = $db->query('
                                  SELECT * FROM security_question
                                  WHERE state = 1
                                ');
                              ?>
                              <?php foreach ($result as $row): ?>
                              <option value="<?php echo $row['id_security_question']; ?>">
                                <?php echo $row['description']; ?>
                              </option>
                              <?php endforeach; ?>
                            </select>
                            <label class="form-label" for="security_question">Pregunta de seguridad</label>
                          </div>
                        </div>

                        <div class="col-md-6 mb-4">
                          <div class="form-outline">
                            <input type="text" name="answer" value="<?php echo $r['security_answer']; ?>"
                              placeholder="Respuesta de seguridad" class="form-control" style="text-transform:uppercase"
                              required />
                            <label class="form-label" for="answer">Ingrese Su Respuesta De Seguridad</label>
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