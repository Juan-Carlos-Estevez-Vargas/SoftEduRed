<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" type="text/css" href="../style/style_new_pass.css">
	<meta charset="utf-8">
	<title>Recuperación Contraseña</title>
</head>
<body>
<center>
<header>NEW PASSWORD</header>
<div id="contenedor">
     <?php session_start(); ?>
    <div id="text">
    <form method="post" action="update_pass.php">
        <label>Ingrese Su Nueva Contraseña</label><br><br>
        <input id="Spacen" type="password" name="pass" placeholder="Contraseña" required><br>
        <br>
        <label>Confirmar Contraseña</label><br><br>
        <input id="Spacen" type="password" name="pass_conf" placeholder="Repetir Contraseña" required><br><br>
        <button id="buton" type="submit" class="boton" name="a_registro">Validar</button>
    <a id="boton" href="../index.php" class="b_rcontra">Regresar</a>
</form> 
</div>
</center>  
</body>
</html>

