<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="../images/student-attendant.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php session_start();?> WELCOME</title>
</head>
<?php
    if  ($_SESSION['active'] === 1 && isset($_GET['role'])){     
      $_SESSION['role_index']=$_GET['role'];  ?>
   <frameset rows="191,*" cols="*" framespacing="0" frameborder="no" border="0">
     <frame src="botones.php" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="titulo" />
     <frame src="marco.php" name="mainFrame" id="mainFrame" title="contenido" />
   </frameset>
   <noframes>
<?php         
    }else {
      session_destroy();
      print "<script>alert(\"No Se Ha Iniciado Sesion\");window.location='../index.php';</script>";
    }?>
<body>
</body>
</noframes>
</html>
