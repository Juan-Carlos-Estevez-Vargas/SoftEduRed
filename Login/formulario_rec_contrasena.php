<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" type="text/css" href="../style/style_recu.css">
    <meta charset="utf-8">
    <title>REMEMBER PASS</title>
</head>
<body>
<center>
<header>RECUPERAR PASSWORD</header>
<div id="contenedor">
<?php require_once "../Database/conexion.php"; $db = database::conectar(); ?>
    <div id="text">
    <form method="post" action="recuperar_pass.php">
        <label id="Titulo">Tipo De Documento</label>
        <select id="form-control" class="form-control" name="tipo_doc">
        <?php
            foreach ($db->query('SELECT * FROM type_of_document') as $row) {
                echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
            }?>
        </select>
        <br>
        <br>
        <label id="n_id">Documento de Identidad</label>
        <input id="Spacen" type="number" name="n_id" placeholder="N° de Identiicación" required><br>
        <br>
        <label>Pregunta De Seguridad</label>
        <select id="question" class="form-control" name="p_seg">
        <?php
            foreach ($db->query('SELECT * FROM security_question where state = 1') as $row) {
                echo '<option value="'.$row['question'].'">'.$row["question"].'</option>';
            } ?>
        </select>
        <br>
        <br>
        <label>Ingrese Su Respuesta De Seguridad</label><br><br>
        <input id="ans" type="text" name="r_seg" placeholder="Respuesta De Seguridad" required><br><br><br>
        <button id="buton" type="submit" class="boton" name="a_registro">Validar</button><br>
        <a id="boton" href="../index.php" class="b_rcontra">Regresar</a>
    </form>    
</div> 
</center>
</body>
</html>

