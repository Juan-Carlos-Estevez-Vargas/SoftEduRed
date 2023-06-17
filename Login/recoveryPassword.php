<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"\/>
	<title>Login</title>
</head>
<body>
<?php
    class RecoveryPassword
    {
        /**
         * Retrieve user information and redirect accordingly.
         *
         * @param string $documentType - Document type.
         * @param string $userId - User ID.
         * @param string $securityQuestion - Security question.
         * @param string $securityAnswer - Security answer.
         * @return void
         */
        public function retrieveUserInfoAndRedirect($documentType, $userId, $securityQuestion, $securityAnswer) {
            session_start();
            require_once "../Database/conexion.php";
            $database = database::conectar();

            $query = "
                SELECT
                    pk_fk_cod_doc,
                    id_user,
                    fk_s_question,
                    security_answer
                FROM user
                WHERE
                    pk_fk_cod_doc = '$documentType' &&
                    id_user ='$userId' &&
                    fk_s_question = '$securityQuestion' &&
                    security_answer = '$securityAnswer'
            ";
            $result = $database->query($query);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $documentType = stripslashes($row["pk_fk_cod_doc"]);
                $userId = stripslashes($row["id_user"]);
            }
            $_SESSION['tdoc'] = $documentType;
            $_SESSION['id'] = $userId;

            if ($userId === null) {
                print "
                    <script>
                        alert(\"Usuario No Encontrado O Respuesta Incorrecta\");
                        window.location='formulario_rec_contrasena.php';
                    </script>
                ";
            }
            if ($userId != null) {
                header("location: formulario_new_contrasena.php");
                exit();
            }
        }
    }
    $Nuevo = new Formu_pass();
    $Nuevo->formulario(
        $_POST['tipo_doc'],
        $_POST['n_id'],
        $_POST['p_seg'],
        $_POST['r_seg']
    );
?>
</body>
</html>
