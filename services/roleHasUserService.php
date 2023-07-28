<?php
	require_once '../persistence/database/Database.php';
  	require_once '../persistence/roleHasUserDAO.php';
  	require_once '../utils/Message.php';
  	require_once '../utils/constants.php';

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
		 * @throws Exception If the registration fails.
		 */
		public function register(int $userId, int $roleId): void
		{
			try {
				// Check if any of the required parameters is empty or the state is not valid
				if (!empty($userId) || !empty($roleId)) {
					// Check if the role is already assigned to the user
					if ($this->roleHasUser->exists($userId, $roleId)){
						// Show error message and return if the role is already assigned
						Message::showErrorMessage(USER_ALREADY_ASSIGNED_ROLE, ROLE_HAS_USER_URL);
						return;
					}
					
					// Register the user with the role
					$this->roleHasUser->register($userId, $roleId);
					
					// Show success message after successful registration
					Message::showSuccessMessage(ADDED_RECORD, ROLE_HAS_USER_URL);
				} else {
					// Show warning message if any of the required parameters is empty
					Message::showWarningMessage(EMPTY_FIELDS, ROLE_HAS_USER_URL);
				}
			} catch (Exception $e) {
				// Show error message if registration fails due to internal error.
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_HAS_USER_URL);
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
					Message::showSuccessMessage(UPDATED_RECORD, ROLE_HAS_USER_URL);
				} else {
					// Show warning message if ID is empty
					Message::showWarningMessage(EMPTY_FIELDS, ROLE_HAS_USER_URL);
				}
			} catch (Exception $e) {
				// Show error message if an exception occurs
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_HAS_USER_URL);
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
					Message::showSuccessMessage(DELETED_RECORD, ROLE_HAS_USER_URL);
				} else {
					// Show warning message if the ID is empty
					Message::showWarningMessage(EMPTY_FIELDS, ROLE_HAS_USER_URL);
				}
			} catch (Exception $e) {
				// Show error message if an exception occurs
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_HAS_USER_URL);
			}
		}

		/**
		 * Retrieves the role of a user by their ID.
		 *
		 * @param int $id The ID of the user.
		 * @throws Exception If there is an internal error.
		 * @return Some_Return_Value The role of the user.
		 */
		public function getRoleHasUserById(int $id)
		{
			try {
				if (!empty($id)) {
					return $this->roleHasUser->getRoleHasUserById($id);
				} else {
					Message::showWarningMessage(INTERNAL_ERROR, ROLE_HAS_USER_URL);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_HAS_USER_URL);
			}
		}

		/**
		 * Retrieves the list data for the role-has-user relation based on the given page number.
		 *
		 * @param int $page The page number to retrieve the list data for.
		 * @throws Exception If an error occurs during the retrieval process.
		 * @return mixed The list data for the role-has-user relation.
		 */
		public function getRoleHasUserListData($page)
		{
			try {
				if (!empty($page)) {
					return $this->roleHasUser->getRoleHasUserListData($page);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_HAS_USER_URL);
			}
		}

		/**
		 * Retrieves the role-has-user relationship by user ID and role ID.
		 *
		 * @param int $userId The ID of the user.
		 * @param int $roleId The ID of the role.
		 * @throws Exception If an error occurs while retrieving the relationship.
		 * @return mixed|null The role-has-user relationship if found, otherwise null.
		 */
		public function getRoleHasUserByUserAndRole(int $userId, int $roleId) {
			try {
				if (!empty($userId) && !empty($roleId)) {
					return $this->roleHasUser->getRoleHasUserByUserAndRole($userId, $roleId);
				}
				return null;
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_HAS_USER_URL);
			}
		}
	}
?>