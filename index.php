<!DOCTYPE HTML>
<html>
<head>
	  <link rel="shortcut icon" href="images/login.ico" />
    <link rel="stylesheet" type="text/css" href="style/style_index.css">
    <META charset="utf-8"/>
    <TITLE>BIENVENIDOS</TITLE>
</head>
    <BODY>
    <center>
        <div id="contenedor">
        <br/>
        <br/>
        <?php
          require_once "Database/conexion.php";
          $db = database::conectar();
          session_start();
          if (isset($_SESSION['active']) && $_SESSION["FK_ROL"] === 'ADMIN'){
           header("location:indexs/index.php?role=e");
          }
          if (isset($_SESSION['active']) && $_SESSION["FK_ROL"] === 'ATTENDANT'){
           header("location:indexs/index.php?role=att");
          }
          if (isset($_SESSION['active']) && $_SESSION["FK_ROL"] === 'STUDENT'){
           header("location:indexs/index.php?role=st");
          }
          if (isset($_SESSION['active']) && $_SESSION["FK_ROL"] === 'TEACHER'){
           header("location:indexs/index.php?role=t");
          }
        ?>

        <img src="style/img1.png" align="left" width="500">           
          <div id="text">
            <h1>INICIAR SESIÓN</h1>
            <form method="post" action="Login/validacion_login.php">
            <div id="contenido">
            <label id="doc">Tipo de Documento de Identidad</label>
            <select id="form-control" class="form-control" name="tipo_doc">
              <?php 
                $resultado = $db->query("SELECT * FROM type_of_document");
              ?>
              <?php foreach ($resultado as $row): ?>
                  <option value="<?php echo $row['cod_document']; ?>"><?php echo $row['Des_doc'];?></option>
              <?php endforeach; ?>
            </select>
            <br>
            <label id="NO">N° de Documento</label>
            <label id="user"><input type="text" name="id" id="user" placeholder="Numero De Documento" required></label><br>
            <label id="pass1">Contraseña</label>
            <label id="pass"><input type="password" name="pass" id="pass" placeholder="Contraseña" required></label><br>
            <br>
            <button id="ing" type="submit" class="boton" name="a_registro">INICIAR SESIÓN</button> 
            <a id="olv" href="Login/formulario_rec_contrasena.php" class="b_rcontra">Olvide mi Contraseña</a><br>
            <a id="reg" href="Login/registro.php" class="b_regis">Registrarse</a></label>                       
            </form>
        </div>
      </div> 
     </center>
    </BODY> 
</html>
