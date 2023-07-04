<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rol</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
  require_once '../persistence/database/Database.php';
  require_once '../persistence/RoleDAO.php';
  require_once '../utils/Message.php';

	class RoleService
	{
		private $pdo;

		/**
		 * Initializes a new instance of the class.
		 *
		 * Creates a new PDO connection object using database::conectar().
		 * Throws an exception with the error message if the connection fails.
		 */
		public function __construct()
		{
				try {
						$this->role = new RoleDAO();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
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
						if (!empty($description)) {
                if (Message::isRegistered(Database::connect(), 'role', 'description', $description, false, null))
                {
                    Message::showErrorMessage(
                        "El rol ingresado ya se encuentra registrado en la plataforma",
                        '../../views/roleView.php'
                    );
                    return;
                }
                
                $this->role->register($description, $state);
								
								Message::showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/roleView.php'
								);
					} else {
							Message::showWarningMessage(
									"Debes llenar todos los campos.",
									'../../views/roleView.php'
							);
					}
			} catch (Exception $e) {
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
		 * @param string $role    The new value for the "description" column.
		 * @param string $state   The new value for the "state" column.
		 *
		 * @return void
		 */
		public function update(string $idRole, string $role, string $state)
		{
				try {
						// Only update if both $idRole and $role are not empty.
						if (!empty($role) && !empty($idRole)) {
                if (Message::isRegistered(Database::connect(), 'role', 'description', $role, true, $idRole, 'id_role'))
                {
                    Message::showErrorMessage(
                        "El género ingresado ya se encuentra registrado en la plataforma",
                        '../../views/roleView.php'
                    );
                    return;
                }
                
                $this->role->update($idRole, $role, $state);
              
								// Show success message.
								Message::showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/roleView.php'
								);
						} else {
								// Show warning message if $idRole or $role is empty.
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
</body>

</html>