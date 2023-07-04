<?php
	require_once '../utils/Message.php';
	
	class GenderDAO
	{
		private $pdo;

		/**
		 * Class constructor.
		 *
		 * @throws PDOException If database connection fails.
		 */
		public function __construct()
		{
				try {
						$this->pdo = Database::connect();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Registers a new gender in the database.
		 *
		 * @param string $gender The name of the gender to be registered.
		 * @param string $state The state where the gender is located.
		 */
		public function register(string $gender, string $state)
		{
				try {
						$sql = "
							INSERT INTO gender(description, state)
							VALUES(UPPER(:gender), :state)
						";
						$stmt = $this->pdo->prepare($sql);
						$stmt->execute(['gender' => $gender, 'state' => $state]);
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/genderView.php'
						);
				}
		}

		/**
		 * Update gender information in the database.
		 *
		 * @param string $idGender The id of the gender to be updated.
		 * @param string $gender The new gender description.
		 * @param string $state The new state of the gender in the database.
		 *
		 * @return void
		 */
		public function update(string $idGender, string $gender, string $state)
		{
			try {
					$sql = "
						UPDATE gender
						SET description = UPPER(?), state = ?
						WHERE id_gender = ?
					";
					$stmt = $this->pdo->prepare($sql);
					$stmt->execute([$gender, $state, $idGender]);
			} catch (Exception $e) {
					Message::showErrorMessage(
							"Ocurrió un error interno. Consulta al Administrador.",
							'../../views/genderView.php'
					);
			}
		}
		
		/**
		 * Deletes a record from the gender table based on the given gender id.
		 *
		 * @param string $idGender The gender id to be deleted.
		 * @return void
		 */
		public function delete(string $idGender)
		{
			try {
					$sql = "
						UPDATE gender
						SET state = 3
						WHERE id_gender = ?
					";
					$stmt = $this->pdo->prepare($sql);
					$stmt->bindParam(1, $idGender);
					$stmt->execute();
			} catch (Exception $e) {
					Message::showErrorMessage(
							"Ocurrió un error interno. Consulta al Administrador.",
							'../../views/genderView.php'
					);
			}
		}
	}
?>