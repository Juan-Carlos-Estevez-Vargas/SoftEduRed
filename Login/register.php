<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"\/>
	<title>Register</title>
</head>
<body>
<?php
    class Register
    {
        /**
         * Registers a new user in the database with the provided data.
         *
         * @param string $id_doc The type of identification document of the user.
         * @param string $id The identification number of the user.
         * @param string $fname The first name of the user.
         * @param string $sname The second name of the user.
         * @param string $flname The first last name of the user.
         * @param string $slname The second last name of the user.
         * @param string $gender The gender of the user.
         * @param string $address The address of the user.
         * @param string $email The email of the user.
         * @param string $username The username of the user.
         * @param string $password The password of the user.
         * @param string $phone The phone number of the user.
         * @param string $photo The photo of the user.
         * @param string $question The security question of the user.
         * @param string $answer The security answer of the user.
         * @return void
         */
        public function register(
            string $id_doc, string $id, string $fname, string $sname,
            string $flname, string $slname, string $gender, string $address,
            string $email, string $username, string $password, string $phone,
            string $photo, string $question, string $answer
        ) {
            session_start();
            
            require_once "../persistence/Database/Database.php";
            $db = database::conectar();
            
            $role = "INVITED";
            $state = 1;
            
            $sql = "
                INSERT INTO `user`
                    (`pk_fk_cod_doc`,
                    `id_user`,
                    `first_name`,
                    `second_name`,
                    `surname`,
                    `second_surname`,
                    `fk_gender`,
                    `adress`,
                    `email`,
                    `phone`,
                    `user_name`,
                    `pass`,
                    `photo`,
                    `security_answer`,
                    `fk_s_question`)
                VALUES (
                    '$id_doc',
                    '$id',
                    '$fname',
                    '$sname',
                    '$flname',
                    '$slname',
                    '$gender',
                    '$address',
                    '$email',
                    '$phone',
                    '$username',
                    '$password',
                    '$photo',
                    UPPER('$answer'),
                    '$question')
            ";
            $db->query($sql);
            
            $sql1 = "
                INSERT INTO user_has_role
                    (tdoc_role,
                    pk_fk_id_user,
                    pk_fk_role,
                    state_role_user)
                VALUES (
                    '$id_doc',
                    '$id',
                    '$role',
                    '$state')
            ";
            
            try {
                $db->query($sql1);
                print "
                    <script>
                        alert(\"Agregado Exitosamente.\");
                        window.location='../index.php';
                    </script>
                ";
            } catch (Exception $e){
                echo $e->getMessage();
            }
        }
    }
    $Nuevo = new Register();
    $Nuevo->register(
        $_POST['tipo_doc'],
        $_POST['n_id'],
        $_POST['name'],
        $_POST['sname'],
        $_POST['lname'],
        $_POST['slname'],
        $_POST['gender'],
        $_POST['direc'],
        $_POST['emai'],
        $_POST['usern'],
        $_POST['pass'],
        $_POST['phone'],
        $_POST['photo'],
        $_POST['p_seg'],
        $_POST['r_seg']
    );
?>
</body>
</html>

