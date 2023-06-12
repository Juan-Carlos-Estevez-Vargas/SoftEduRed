<?php

class UserTeaCruds
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = Database::conectar();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function registrar($tdoc, $id_user, $f_name, $s_name, $f_lname, $s_lname, $gender, $address, $email, $phone, $u_name, $pass, $s_ans, $s_ques)
    {
        $sql = "INSERT INTO user (pk_fk_cod_doc, id_user, first_name, second_name, surname, second_surname, `fk_gender`, address, email, phone, user_name, pass, security_answer, `fk_s_question`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$tdoc, $id_user, $f_name, $s_name, $f_lname, $s_lname, $gender, $address, $email, $phone, $u_name, $pass, $s_ans, $s_ques]);

        $this->registrarTeacher($tdoc, $id_user);
        $this->registrarUserRole($tdoc, $id_user);
        
        echo "<script>alert('Registro Agregado Exitosamente.'); window.location='formu_view.php';</script>";
    }

    private function registrarTeacher($tdoc, $id_user)
    {
        $sql = "INSERT INTO teacher (user_pk_fk_cod_doc, user_id_user) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$tdoc, $id_user]);
    }

    private function registrarUserRole($tdoc, $id_user)
    {
        $sql = "INSERT INTO user_has_role (tdoc_role, pk_fk_id_user, pk_fk_role, state) VALUES (?, ?, 'TEACHER', 1)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$tdoc, $id_user]);
    }

    public function actualizar($tdoc, $id_user, $f_name, $s_name, $f_lname, $s_lname, $gender, $address, $email, $phone, $u_name, $pass, $s_ans, $s_ques)
    {
        $sql = "UPDATE user SET first_name = ?, second_name = ?, surname = ?, second_surname = ?, `fk_gender` = ?, address = ?, email = ?, phone = ?, user_name = ?, pass = ?, security_answer = ?, fk_s_question = ? 
                WHERE pk_fk_cod_doc = ? AND id_user = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$f_name, $s_name, $f_lname, $s_lname, $gender, $address, $email, $phone, $u_name, $pass, $s_ans, $s_ques, $tdoc, $id_user]);

        echo "<script>alert('Registro Actualizado Exitosamente.'); window.location='formu_view.php';</script>";
    }

	/**
	 * Deletes a user from the database with the given id and document type.
	 *
	 * @param int $userId the id of the user to be deleted
	 * @param string $docType the document type of the user to be deleted
	 * @throws PDOException if there was an error executing the SQL query
	 * @return void
	 */
	public function deleteUser(int $userId, string $docType): void
	{
		// Prepare the SQL statement to delete the user with the given ID and document type from the database
		$sql = "DELETE FROM user WHERE id_user = ? AND pk_fk_cod_doc = ?";
		$stmt = $this->pdo->prepare($sql);
		
		// Execute the prepared statement with the given user ID and document type as parameters
		$stmt->execute([$userId, $docType]);
	
		// Log a message indicating that the user was successfully deleted from the database
		error_log("User with id $userId and document type $docType was deleted from the database.");
		
		// Display an alert message indicating that the user was successfully deleted and redirect to the formu_view.php page
		echo "<script>alert('Registro Eliminado Exitosamente.');</script>";
	}
}
