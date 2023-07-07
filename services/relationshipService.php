<?php
  require_once '../persistence/database/Database.php';
  require_once '../persistence/RelationshipDAO.php';
  require_once '../utils/Message.php';

	class RelationshipService
	{
		/**
		 * Initializes a new instance of the class by setting up a PDO connection to the database
		 *
		 * @throws PDOException if there is an error connecting to the database
		 */
		public function __construct()
		{
				try {
            $this->relationship = new RelationshipDAO();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Registers a new relationship with the given description and state.
		 *
		 * @param string $description The description of the relationship to be registered.
		 * @param string $state The state of the relationship to be registered.
		 * @return void
		 */
		public function register(string $description, string $state): void
		{
				try {
						if (!empty($description)) {
                if (Message::isRegistered(Database::connect(), 'relationship', 'description', $description, false, null))
                {
                    Message::showErrorMessage(
                        "El parentesco ingresado ya se encuentra registrado en la plataforma",
                        '../../views/relationshipView.php'
                    );
                    return;
                }
                
                $this->relationship->register($description, $state);
			
								Message::showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/relationshipView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationshipView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationshipView.php'
						);
				}
		}

		/**
		 * Update a record in the 'relationship' table.
		 *
		 * @param string $idRelationship The id of the record to update.
		 * @param string $state The new value for 'state'.
		 *
		 * @throws Exception If there is an error updating the record.
		 *
		 * @return void
		 */
		public function update(string $idRelationship, string $state)
		{
				try {
						// Check that required fields are not empty
						if (!empty($idRelationship)) {
                $this->relationship->update($idRelationship, $state);

								// Show success message
								Message::showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/relationshipView.php'
								);
						} else {
								// Show warning message if required fields are empty
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationshipView.php'
								);
						}
				} catch (Exception $e) {
						// Show error message if there is an error updating the record
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationshipView.php'
						);
						throw $e;
				}
		}

		/**
		 * Deletes a record from the relationship table based on the description of the relationship.
		 *
		 * @param string $idRelationship The ID of the relationship to delete.
		 * @return void
		 */
		public function delete(string $idRelationship): void
		{
				try {
						if (!empty($idRelationship)) { // Check if ID is not empty
                $this->relationship->delete($idRelationship);

								// Show success message and redirect to relationship view
								Message::showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/relationshipView.php'
								);
						} else {
								// Show warning message and redirect to relationship view
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationshipView.php'
								);
						}
				} catch (Exception $e) {
						// Show error message and redirect to relationship view
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationshipView.php'
						);
				}
		}
	}
?>