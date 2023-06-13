<?php
	class UserDAO
	{
		private $pdo;

		public function __construct()
		{
			try {
				$this->pdo = database::conectar();
			} catch (Exception $e) {
				die($e->getMessage());
			}
		}

		/**
		 * Registers a new user in the system.
		 *
		 * @param string $idType The type of identification document.
		 * @param string $idNumber The identification document number.
		 * @param string $firstName The first name of the user.
		 * @param string $secondName The second name of the user.
		 * @param string $firstLastName The first last name of the user.
		 * @param string $secondLastName The second last name of the user.
		 * @param string $gender The gender of the user.
		 * @param string $address The address of the user.
		 * @param string $email The email of the user.
		 * @param string $phoneNumber The phone number of the user.
		 * @param string $username The username of the user.
		 * @param string $password The password of the user.
		 * @param string $securityAnswer The security answer of the user.
		 * @param string $securityQuestion The security question of the user.
		 */
		public function registerUser(
			string $idType, string $idNumber, string $firstName, string $secondName,
			string $firstLastName, string $secondLastName, string $gender, string $address,
			string $email, string $phoneNumber, string $username, string $password,
			string $securityAnswer, string $securityQuestion
		): void {
			$sql = "INSERT INTO user (
					pk_fk_cod_doc, id_user, first_name, second_name, surname, second_surname,
					`fk_gender`, address, email, phone, user_name, pass, security_answer, `fk_s_question`
				) VALUES (
					'$idType', '$idNumber', '$firstName', '$secondName', '$firstLastName', '$secondLastName',
					'$gender', '$address', '$email', '$phoneNumber', '$username', '$password',
					'$securityAnswer', '$securityQuestion'
				)";
			$this->pdo->query($sql);
			print "<script>
				alert('Registro Agregado Exitosamente.');
				window.location='formu_view.php';
			</script>";
		}

		/**
		 * Updates user information in the database
		 *
		 * @param string $docType The user's document type
		 * @param int $userId The user's ID
		 * @param string $firstName The user's first name
		 * @param string|null $secondName The user's second name (optional)
		 * @param string $firstLastName The user's first surname
		 * @param string|null $secondLastName The user's second surname (optional)
		 * @param string $gender The user's gender
		 * @param string $adress The user's address
		 * @param string $email The user's email
		 * @param string $phone The user's phone number
		 * @param string $username The user's username
		 * @param string $pass The user's password
		 * @param string $securityAnswer The user's security answer
		 * @param int $securityQuestion The user's security question ID
		 * @return void
		 */
		public function updateUser(
			string $docType, int $userId, string $firstName, ?string $secondName, string $firstLastName,
			?string $secondLastName, string $gender, string $adress, string $email, string $phone,
			string $username, string $pass, string $securityAnswer, int $securityQuestion
		): void {
			$sql = "UPDATE user SET
					first_name = '$firstName', second_name = '$secondName', surname = '$firstLastName',
					second_surname = '$secondLastName', fk_gender = '$gender', adress = '$adress',
					email = '$email', phone = '$phone', user_name = '$username', pass = '$pass',
					security_answer = '$securityAnswer', fk_s_question = '$securityQuestion'
				WHERE pk_fk_cod_doc = '$docType' AND id_user = '$userId'";

			$this->pdo->query($sql);

			// Display success message and redirect to formu_view.php
			print "<script>
				alert('Registro Actualizado Exitosamente.');
				window.location='formu_view.php';
			</script>";
		}

		/**
		 * Deletes a user from the database based on their ID and document type.
		 *
		 * @param int $userId The ID of the user to delete.
		 * @param string $docType The document type of the user to delete.
		 *
		 * @return void
		 */
		public function deleteUser(int $userId, string $docType) {
				$sql = "DELETE FROM user WHERE id_user = '$userId' AND pk_fk_cod_doc = '$docType'";
				$this->pdo->query($sql);
				print "<script>
					alert('Registro Eliminado Exitosamente.');
					window.location='formu_view.php';
				</script>";
		}

	}

?>
