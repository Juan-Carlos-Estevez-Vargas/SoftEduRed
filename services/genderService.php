<?php
	require_once '../persistence/database/Database.php';
	require_once '../persistence/genderDAO.php';
	require_once '../utils/Message.php';
	require_once '../utils/constants.php';
	
	class GenderService
	{
		/**
		 * Class constructor.
		 *
		 * @throws Exception If GenderDAO instantiation fails.
		 */
		public function __construct()
		{
			try {
				// Instantiate GenderDAO
				$this->gender = new GenderDAO();
			} catch (Exception $e) {
				// Rethrow exception with the same message
				throw new Exception($e->getMessage());
			}
		}

		/**
		 * Registers a new gender in the database.
		 *
		 * @param string $gender The name of the gender to be registered.
		 * @param string $state The state where the gender is located.
		 * @return void
		 */
		public function register(string $gender)
		{
			try {
				// Check if gender is not empty
				if (!empty($gender)) {
					// Check if gender is already registered
					if (Message::isRegistered(Database::connect(), 'gender', 'description', $gender, false, null)) {
						// Show error message if gender is already registered
						Message::showErrorMessage(GENDER_ALREADY_ADDED, GENDER_URL);
						return;
					}
					
					// Register the gender in the database
					$this->gender->register($gender);

					// Show success message
					Message::showSuccessMessage(ADDED_RECORD, GENDER_URL);
				} else {
					// Show warning message if gender is empty
					Message::showWarningMessage(EMPTY_FIELDS, GENDER_URL);
				}
			} catch (Exception $e) {
				// Show error message for internal error
				Message::showErrorMessage(INTERNAL_ERROR, GENDER_URL);
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
				if (!empty($idGender) && !empty($gender)) {
					// Check if the new gender description is already registered in the platform
					if (Message::isRegistered(Database::connect(), 'gender', 'description', $gender, true, $idGender, 'id_gender'))
					{
						// Show error message if the gender is already registered
						Message::showErrorMessage(GENDER_ALREADY_ADDED, GENDER_URL);
						return;
					}
					
					// Update the gender information in the database
					$this->gender->update($idGender, $gender, $state);
					
					// Show success message after updating the gender information
					Message::showSuccessMessage(ADDED_RECORD, GENDER_URL);
				} else {
					// Show warning message if any of the required fields are empty
					Message::showWarningMessage(EMPTY_FIELDS, GENDER_URL);
				}
			} catch (Exception $e) {
				// Show error message if an internal error occurs
				Message::showErrorMessage(INTERNAL_ERROR, GENDER_URL);
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
				// Check if gender id is not empty
				if (!empty($idGender)) {
					$this->gender->delete($idGender);

					// Show success message after deleting the gender
					Message::showSuccessMessage(DELETED_RECORD, GENDER_URL);
				} else {
					// Show warning message if gender id is empty
					Message::showWarningMessage(EMPTY_FIELDS, GENDER_URL);
				}
			} catch (Exception $e) {
				// Show error message if an error occurs while deleting the gender
				Message::showErrorMessage(INTERNAL_ERROR, GENDER_URL);
			}
		}

		/**
		 * Retrieves the gender by the specified ID.
		 *
		 * @param int $id The ID of the gender.
		 * @throws Exception If an error occurs while retrieving the gender.
		 * @return mixed The gender data, or null if the ID is empty.
		 */
		public function getGenderById(int $id)
		{
			try {
				if (!empty($id)) {
					return $this->gender->getGenderById($id);
				} else {
					Message::showWarningMessage(INTERNAL_ERROR, GENDER_URL);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, GENDER_URL);
			}
		}

		/**
		 * Retrieves the gender list data based on the specified page.
		 *
		 * @param int $page The page number to retrieve the data from.
		 * @throws Exception If an error occurs while retrieving the data.
		 * @return mixed The gender list data.
		 */
		public function getGenderListData($page)
		{
			try {
				if (!empty($page)) {
					return $this->gender->getGenderListData($page);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, GENDER_URL);
			}
		}
	}
?>