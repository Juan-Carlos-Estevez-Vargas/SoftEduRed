<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"\/>
	<title>Login</title>
</head>
<body>
<?php  
    class Formu_pass{
        public function formulario($tdoc, $id_usu,$p_seg,$r_seg){        
            session_start();
            require_once "../Database/conexion.php";
            $db = database::conectar();         
            $sql2 = "SELECT pk_fk_cod_doc, id_user, fk_s_question, security_answer FROM user WHERE pk_fk_cod_doc = '$tdoc' && id_user ='$id_usu' && fk_s_question = '$p_seg' && security_answer = '$r_seg' ";
            $result2 = $db->query($sql2);
            while ($row1=$result2->fetch(PDO::FETCH_ASSOC)){
                $ft_doc=stripslashes($row1["pk_fk_cod_doc"]);
                $id_user=stripslashes($row1["id_user"]);
            }
                $_SESSION['tdoc']=$ft_doc;
                $_SESSION['id']=$id_user;   
           if ($id_user === null){
               print "<script>alert(\"Usuario No Encontrado O Respuesta Incorrecta\");window.location='formulario_rec_contrasena.php';</script>";
           }
           if ($id_user != null){
              header ("location: formulario_new_contrasena.php") ;
           }
        }
    }
    $Nuevo = new Formu_pass();
    $Nuevo->formulario($_POST['tipo_doc'],$_POST['n_id'],$_POST['p_seg'],$_POST['r_seg']);''
?>    
</body>

</html>

