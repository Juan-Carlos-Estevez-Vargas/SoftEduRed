<?php
	require_once '../persistence/database/Database.php';
  require_once '../persistence/roleHasUserDAO.php';
  require_once '../utils/Message.php';

	class RoleHasUserService
	{
		/**
		 * Constructor method for the class.
		 *
		 * Establishes a database connection by initializing the RoleHasUserDAO object.
		 *
		 * @throws PDOException If there is an error connecting to the database.
		 */
		public function __construct()
		{
				try {
						// Initialize the RoleHasUserDAO object to establish a database connection
						$this->roleHasUser = new RoleHasUserDAO();
				} catch (PDOException $e) {
						// Rethrow the exception with the error message
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Registers a user with the specified roles and states.
		 *
		 * @param int $userId The ID of the user being registered.
		 * @param int $roleId The ID of the role being assigned to the user.
		 * @param string $state The state of the registration.
		 * @throws Exception If the registration fails.
		 */
		public function register(int $userId, int $roleId, string $state): void
		{
				try {
						// Check if any of the required parameters is empty or the state is not valid
						if (!empty($userId) || !empty($roleId) || ($state !== '1' && $state !== '0')) {
								// Check if the role is already assigned to the user
								if ($this->roleHasUser->exists($userId, $roleId)){
										// Show error message and return if the role is already assigned
										Message::showErrorMessage(
												"El usuario ya tiene asignado el rol.",
												'../../views/roleHasUserView.php'
										);
										return;
								}
								
								// Register the user with the role and state
								$this->roleHasUser->register($userId, $roleId, $state);
								
								// Show success message after successful registration
								Message::showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/roleHasUserView.php'
								);
						} else {
								// Show warning message if any of the required parameters is empty
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/roleHasUserView.php'
								);
						}
				} catch (Exception $e) {
						// Show error message if registration fails due to internal error.
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/roleHasUserView.php'
						);
				}
		}

		/**
		 * Updates a record in the user_has_role database table.
		 *
		 * @param string $id The id_user_has_role to update.
		 * @param string $state The new value for the state field.
		 *
		 * @return void
		 */
		public function update(string $id, string $state): void
		{
				try {
						if (!empty($id)) {
								$this->roleHasUser->update($id, $state);

								// Show success message
								Message::showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/roleHasUserView.php'
								);
						} else {
								// Show warning message if ID is empty
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/roleHasUserView.php'
								);
						}
				} catch (Exception $e) {
						// Show error message if an exception occurs
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/roleHasUserView.php'
						);
				}
		}

		/**
		 * Deletes a user's role from the database.
		 *
		 * @param string $idUserHasRole The ID of the user's role.
		 * @return void
		 */
		public function delete(string $idUserHasRole)
		{
				try {
						if (!empty($idUserHasRole)) {
								$this->roleHasUser->delete($idUserHasRole);

								// Show success message
								Message::showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/roleHasUserView.php'
								);
						} else {
								// Show warning message if the ID is empty
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/roleHasUserView.php'
								);
						}
				} catch (Exception $e) {
						// Show error message if an exception occurs
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/roleHasUserView.php'
						);
				}
		}
	}
?>