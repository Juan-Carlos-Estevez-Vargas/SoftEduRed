<?php
  require_once '../persistence/database/Database.php';
  require_once '../persistence/RoleDAO.php';
  require_once '../utils/Message.php';

	class RoleService
	{
		/**
		 * Initializes a new instance of the class.
		 *
		 * Creates a new RoleDAO object to handle roles.
		 * Throws an exception if the RoleDAO initialization fails.
		 */
		public function __construct()
		{
				try {
						$this->role = new RoleDAO();
				} catch (Exception $e) {
						throw new Exception($e->getMessage());
				}
		}

		/**
		 * Adds a new role to the database with the provided description and state
		 *
		 * @param string $description The description of the role
		 * @param string $state The state of the role
		 * @return void
		 */
		public function register(string $description, string $state): void
		{
				try {
						// Check if the description is not empty
						if (!empty($description)) {
								// Check if the role is already registered
								if (Message::isRegistered(Database::connect(), 'role', 'description', $description, false, null)) {
										Message::showErrorMessage(
												"El rol ingresado ya se encuentra registrado en la plataforma",
												'../../views/roleView.php'
										);
										return;
								}

								// Register the role
								$this->role->register($description, $state);

								// Show success message
								Message::showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/roleView.php'
								);
						} else {
								// Show warning message if any field is empty
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/roleView.php'
								);
						}
				} catch (Exception $e) {
						// Show error message if an internal error occurs
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/roleView.php'
						);
				}
		}

		/**
		 * Updates a record in the "role" table.
		 *
		 * @param string $idRole  The ID of the role to update.
		 * @param string $state   The new value for the "state" column.
		 * @return void
		 */
		public function update(string $idRole, string $state)
		{
				try {
						// Only update if both $idRole and $state are not empty.
						if (!empty($idRole)) {
								$this->role->update($idRole, $state);

								// Show success message.
								Message::showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/roleView.php'
								);
						} else {
								// Show warning message if $idRole is empty.
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/roleView.php'
								);
						}
				} catch (Exception $e) {
						// Show error message if an exception occurs.
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/roleView.php'
						);
				}
		}

		/**
		 * Deletes a record from the "role" table based on a given ID.
		 *
		 * @param string $idRole The ID of the role to be deleted
		 * @throws PDOException If there is an error executing the SQL statement
		 */
		public function delete(string $idRole)
		{
				try {
						// Check if ID is not empty
						if (!empty($idRole)) {
								$this->role->delete($idRole);

								// Show success message
								Message::showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/roleView.php'
								);
						} else {
								// Show warning message if ID is empty
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/roleView.php'
								);
						}
				} catch (Exception $e) {
						// Show error message if there is an exception
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/roleView.php'
						);
				}
		}
	}
?>