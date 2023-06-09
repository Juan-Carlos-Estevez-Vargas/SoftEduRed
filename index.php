<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="images/login.ico" />
  <link rel="stylesheet" type="text/css" href="style/style_index.css">
  <META charset="utf-8"/>
  <title>Bienvenidos</title>
</head>
<body>
  <div id="contenedor">
    <?php
      require_once "Database/conexion.php";
      $db = database::conectar();
      session_start();
      if (isset($_SESSION['active'])) {
        switch ($_SESSION["FK_ROL"]) {
          case 'ADMIN':
            header("location:indexs/index.php?role=e");
            exit;
          case 'ATTENDANT':
            header("location:indexs/index.php?role=att");
            exit;
          case 'STUDENT':
            header("location:indexs/index.php?role=st");
            exit;
          case 'TEACHER':
            header("location:indexs/index.php?role=t");
            exit;
          default:
            exit;
        }
      }
    ?>

    <img src="style/img1.png" width="500" alt="Iniciar Sesión" />
    <div id="text">
      <h1>Iniciar Sesión</h1>
      <form method="post" action="Login/validacion_login.php">
        <div id="contenido">
        <label id="doc">Tipo de Documento de Identidad</label>
        <select id="form-control" class="form-control" name="tipo_doc">
          <?php
            $resultado = $db->query("SELECT * FROM type_of_document");
            foreach ($resultado as $row):
          ?>
          <option value="<?php echo $row['cod_document']; ?>"><?php echo $row['Des_doc'];?></option>
          <?php endforeach; ?>
        </select>

        <br />
        <label id="NO">N° de Documento</label>
        <label id="user">
          <input type="text" name="id" id="user" placeholder="Numero De Documento" required />
        </label>

        <br />
        <label id="pass1">Contraseña</label>
        <label id="pass">
          <input type="password" name="pass" id="pass" placeholder="Contraseña" required />
        </label>
        
        <br />
        <button id="ing" type="submit" class="boton" name="a_registro">Iniciar Sesión</button>
        <a id="olv" href="Login/formulario_rec_contrasena.php" class="b_rcontra">Olvidé mi Contraseña</a><br>
        <a id="reg" href="Login/registro.php" class="b_regis">Registrarse</a></label>
      </form>
    </div>
  </div>
</body>
</html>
