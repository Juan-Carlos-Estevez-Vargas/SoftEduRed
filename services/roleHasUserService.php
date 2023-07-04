<?php
	require_once '../persistence/database/Database.php';
  require_once '../persistence/roleHasUserDAO.php';
  require_once '../utils/Message.php';

	class RoleHasUserService
	{
		/**
		 * Constructor method for the class.
		 *
		 * Establish a database connection using the database class.
		 *
		 * @throws PDOException If there is an error connecting to the database.
		 */
		public function __construct()
		{
				try {
            $this->roleHasUser = new RoleHasUserDAO();
				} catch (PDOException $e) {
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
            if (!empty($userId) || !empty($roleId) || ($state !== '1' && $state !== '0')) {
								if ($this->roleHasUser->exists($userId, $roleId)){
										Message::showErrorMessage(
												"El usuario ya tiene asignado el rol.",
												'../../views/roleHasUserView.php'
										);
										return;
								}
                $this->roleHasUser->register($userId, $roleId, $state);
          
                Message::showSuccessMessage(
                    "Registro Agregado Exitosamente.",
                    '../../views/roleHasUserView.php'
                );
            } else {
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
						if (!empty($id))
						{
                $this->roleHasUser->update($id, $state);
            
                Message::showSuccessMessage(
                    "Registro Actualizado Exitosamente.",
                    '../../views/roleHasUserView.php'
                );
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/roleHasUserView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/roleHasUserView.php'
						);
				}
		}

		/**
		 * Deletes a user's role from the database.
		 *
		 * @param string $documentType The type of document of the user.
		 * @param int $userId The ID of the user.
		 * @param string $role The role to be deleted.
		 * @return void
		 */
		public function delete(string $idUserHasRole)
		{
				try {
						if (!empty($idUserHasRole)) {
                $this->roleHasUser->delete($idUserHasRole);

								Message::showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/roleHasUserView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/roleHasUserView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/roleHasUserView.php'
						);
				}
		}
	}
?>