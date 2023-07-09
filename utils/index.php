<!DOCTYPE html>
<html lang="es">

<head>
  <link rel="shortcut icon" href="../images/student-attendant.ico" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php session_start();?> Bienvenido</title>
</head>
<?php
    if ($_SESSION['active'] === 1 && isset($_GET['role'])) {
      $_SESSION['role_index']=$_GET['role'];
  ?>
<frameset rows="160,*" cols="*" framespacing="0" frameborder="no">
  <frame src="buttons.php" name="topFrame" noresize="noresize" id="topFrame"></frame>
  <frame src="../views/home.php" name="mainFrame" id="mainFrame"></frame>
</frameset>

<noframes>
  <?php
      } else {
        require_once '../utils/Message.php';

        session_destroy();
        Message::showErrorMessage(
            "No se ha iniciado sesión.",
            '../../index.php'
        );
      }
    ?>
</noframes>

<body>
</body>

</html>