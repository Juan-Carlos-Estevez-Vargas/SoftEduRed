<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <title>Bienvenidos</title>
    <link rel="shortcut icon" href="../images/register.ico" />
    <link rel="stylesheet" type="text/css" href="../style/style_reg.css" />
</head>
<body>
    <?php require_once "../Database/conexion.php"; $db = database::conectar();?>
    <header>Registro</header>
    <div id="contenedorr">
        <div id="text">
        <form method="post" action="insert_login.php">
            <label id="titulo">Tipo de Documento</label>
            <select id="select"class="form-control" name="tipo_doc">
            <?php
                foreach ($db->query('SELECT * FROM type_of_document') as $row) {
                    echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
                }
            ?>
            </select>

            <label id="id">No° Identificación </label>
            <input id="space" type="text" name="n_id" placeholder="N° de Identificación" required />
        
            <label id="name">Primer Nombre</label>
            <input id="Spacen"type="text" name="name" placeholder="Primer Nombre" required />
        
            <label id="sname">Segundo Nombre</label>
            <input id="sspace" type="text" name="sname" placeholder="Segundo Nombre" />

            <label id="Apellido">Primer Apellido</label>
            <input id="ape" type="text" name="lname" placeholder="Primer Apellido" required />
        
            <label id="sape">Segundo Apellido</label>
            <input id="sa" type="text" name="slname" placeholder=" Segundo Apellido" />
        
            <label id="gender">Gender</label>
            <select id="slect"class="form-control" name="gender">
            <?php
                $resultado = $db->query('SELECT * FROM gender WHERE state = 1');
            ?>
            <?php foreach ($resultado as $row): ?>
                <option value="<?php echo $row['desc_gender']; ?>"><?php echo $row['desc_gender'];?></option>
            <?php endforeach; ?>
            </select>
        
            <label id="direc">Dirección</label>
            <input id="dir" type="text" name="direc" placeholder="Dirección" />
        
            <label id="email">E-Mail</label>
            <input id="mail" type="email" name="emai" placeholder="Email" required />
            
            <label id="nickname">User Name</label>
            <input id="User" type="text" name="usern" placeholder="User Name" required />

            <label id="pasw">Password</label>
            <input id="pass" type="password" name="pass" maxlength="20" minlength="10" placeholder="Password" required />
            
            <label id="tel">Teléfono</label>
            <input id="phone" type="numb" name="phone" placeholder="Telefono" />
        
            <label id="photo">Seleccione Foto de Perfil:</label>
            <input id="sphoto" type="file" name="photo" placeholder="Photo" accept="image/*" />
            <img src="../style/img2.jpg" align="center" width="5%" />
        
            <label id="ask">Pregunta De Seguridad</label>
            <select id="listp"class="form-control" name="p_seg">
            <?php $resultado = $db->query('SELECT * FROM security_question WHERE state =1'); ?>
                <?php foreach ($resultado as $row): ?>
                <option value="<?php echo $row['question']; ?>"><?php echo $row['question'];?></option>
            <?php endforeach; ?>
            </select>

            <label id="answer">Ingrese Su Respuesta De Seguridad (MAYÚSCULA):</label>
            <input id="ans" type="text" name="r_seg" style="text-transform:uppercase" placeholder="Respuesta De Seguridad" required />
        </div>

        <button id="boton" type="submit" class="boton" name="a_registro">Registrar</button>
            <a id="reg" href="../index.php" class="b_rcontra">Regresar</a>
        </div>
    </form>
</body>
</html>