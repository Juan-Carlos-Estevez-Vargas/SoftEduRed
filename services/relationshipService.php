<?php
  	require_once '../persistence/database/Database.php';
  	require_once '../persistence/RelationshipDAO.php';
  	require_once '../utils/Message.php';
	require_once '../utils/constants.php';

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
		 * @return void
		 */
		public function register(string $description): void
		{
			try {
				if (!empty($description)) {
            	    if (Message::isRegistered(Database::connect(), 'relationship', 'description', $description, false, null))
                	{
                    	Message::showErrorMessage(RELATIONSHIP_ALREADY_ADDED, RELATIONSHIP_URL);
	                    return;
    	            }
                
        	        $this->relationship->register($description);
			
					Message::showSuccessMessage(ADDED_RECORD, RELATIONSHIP_URL);
				} else {
					Message::showWarningMessage(EMPTY_FIELDS, RELATIONSHIP_URL);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, RELATIONSHIP_URL);
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
					Message::showSuccessMessage(UPDATED_RECORD, RELATIONSHIP_URL);
				} else {
					// Show warning message if required fields are empty
					Message::showWarningMessage(EMPTY_FIELDS, RELATIONSHIP_URL);
				}
			} catch (Exception $e) {
				// Show error message if there is an error updating the record
				Message::showErrorMessage(INTERNAL_ERROR, RELATIONSHIP_URL);
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
					Message::showSuccessMessage(DELETED_RECORD, RELATIONSHIP_URL);
				} else {
					// Show warning message and redirect to relationship view
					Message::showWarningMessage(EMPTY_FIELDS, RELATIONSHIP_URL);
				}
			} catch (Exception $e) {
				// Show error message and redirect to relationship view
				Message::showErrorMessage(INTERNAL_ERROR, RELATIONSHIP_URL);
			}
		}

		/**
		 * Retrieves a relationship by its ID.
		 *
		 * @param int $id The ID of the relationship to retrieve.
		 * @throws Exception If an error occurs while retrieving the relationship.
		 * @return mixed The relationship with the specified ID, or null if it doesn't exist.
		 */
		public function getRelationshipById(int $id)
		{
			try {
				if (!empty($id)) {
					return $this->relationship->getRelationshipById($id);
				} else {
					Message::showWarningMessage(INTERNAL_ERROR, RELATIONSHIP_URL);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, RELATIONSHIP_URL);
			}
		}

		/**
		 * Retrieves the relationship list data based on the specified page.
		 *
		 * @param mixed $page The page number to retrieve the data for.
		 * @throws Exception If an error occurs while retrieving the data.
		 * @return mixed The relationship list data for the specified page.
		 */
		public function getRelationshipListData($page)
		{
			try {
				if (!empty($page)) {
					return $this->relationship->getRelationshipListData($page);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, RELATIONSHIP_URL);
			}
		}
	}
?>