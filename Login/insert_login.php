<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"\/>
	<title>REGISTER</title>
</head>
<body>
<?php
    class Registro{
        public function registrar($tdoc, $id_usu,$fname,$sname,$flastname,$slastname,$gender,$direc,$emai,$usernick,$pass,$phone,$photo,$p_seg,$r_seg){
            session_start();
            require_once "../Database/conexion.php";
            $db = database::conectar();
            $rol = "INVITED";
            $state = 1;
            $sql = "INSERT INTO `user` (`pk_fk_cod_doc`, `id_user`, `first_name`, `second_name`, `surname`, `second_surname`, `fk_gender`, `adress`, `email`, `phone`, `user_name`, `pass`, `photo`, `security_answer`, `fk_s_question`) VALUES ('$tdoc', '$id_usu','$fname','$sname','$flastname','$slastname','$gender','$direc','$emai','$phone','$usernick','$pass','$photo',UPPER('$r_seg') ,'$p_seg')";
            $db->query($sql);
            $sql1 = "INSERT INTO user_has_role (tdoc_role, pk_fk_id_user, pk_fk_role, state_role_user) VALUES ('$tdoc', '$id_usu','$rol','$state')";
            
            try {
                $db->query($sql1);
                print "<script>alert(\"Agregado Exitosamente.\");window.location='../index.php';</script>";
            } catch (Exception $e){
                echo $e->getMessage();
            }
        }
    }
    $Nuevo = new Registro();
    $Nuevo->registrar ($_POST['tipo_doc'],$_POST['n_id'],$_POST['name'],$_POST['sname'],$_POST['lname'],$_POST['slname'],$_POST['gender'],$_POST['direc'],$_POST['emai'],$_POST['usern'],$_POST['pass'],$_POST['phone'],$_POST['photo'],$_POST['p_seg'],$_POST['r_seg']);   
?>    
</body>
</html>

