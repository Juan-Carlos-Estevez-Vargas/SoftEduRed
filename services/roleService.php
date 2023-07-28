<?php
  	require_once '../persistence/database/Database.php';
  	require_once '../persistence/RoleDAO.php';
  	require_once '../utils/Message.php';
	require_once '../utils/constants.php';

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
		 * @return void
		 */
		public function register(string $description): void
		{
			try {
				// Check if the description is not empty
				if (!empty($description)) {
					// Check if the role is already registered
					if (Message::isRegistered(Database::connect(), 'role', 'description', $description, false, null)) {
						Message::showErrorMessage(ROLE_ALREADY_ADDED, ROLE_URL);
						return;
					}

					// Register the role
					$this->role->register($description);

					// Show success message
					Message::showSuccessMessage(ADDED_RECORD, ROLE_URL);
				} else {
					// Show warning message if any field is empty
					Message::showWarningMessage(EMPTY_FIELDS, ROLE_URL);
				}
			} catch (Exception $e) {
				// Show error message if an internal error occurs
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_URL);
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
					Message::showSuccessMessage(UPDATED_RECORD, ROLE_URL);
				} else {
					// Show warning message if $idRole is empty.
					Message::showWarningMessage(EMPTY_FIELDS, ROLE_URL);
				}
			} catch (Exception $e) {
				// Show error message if an exception occurs.
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_URL);
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
					Message::showSuccessMessage(DELETED_RECORD, ROLE_URL);
				} else {
					// Show warning message if ID is empty
					Message::showWarningMessage(EMPTY_FIELDS, ROLE_URL);
				}
			} catch (Exception $e) {
				// Show error message if there is an exception
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_URL);
			}
		}

		/**
		 * Retrieves a role by its ID.
		 *
		 * @param int $id The ID of the role to retrieve.
		 * @throws Exception If an error occurs while retrieving the role.
		 * @return mixed The retrieved role, or null if no role is found.
		 */
		public function getRoleById(int $id)
		{
			try {
				if (!empty($id)) {
					return $this->role->getRoleById($id);
				} else {
					Message::showWarningMessage(INTERNAL_ERROR, ROLE_URL);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_URL);
			}
		}

		/**
		 * Retrieves the role list data for a specific page.
		 *
		 * @param mixed $page The page number for the role list data.
		 * @throws Exception If an error occurs while retrieving the role list data.
		 * @return mixed The role list data for the specified page.
		 */
		public function getRoleListData($page)
		{
			try {
				if (!empty($page)) {
					return $this->role->getRoleListData($page);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_URL);
			}
		}

		/**
		 * Retrieves an array of unassigned roles for a given user ID.
		 *
		 * @param int $userId The ID of the user.
		 * @throws Exception If an error occurs while fetching unassigned roles.
		 * @return array|null An array of unassigned roles or null if the user ID is empty.
		 */
		public function getUnassignedRoles(int $userId): ?array
		{
			try {
				if (!empty($userId)) {
					return $this->role->getUnassignedRoles($userId);
				}
				return null;
			} catch (Exception $e) {
				// Show error message if an exception occurs.
				throw new Exception('Error fetching unassigned roles: ' . $e->getMessage());
			}
		}

		/**
		 * Retrieves all roles.
		 *
		 * @return array|null The array of roles, or null if no roles found.
		 * @throws Exception If an error occurs while fetching the roles.
		 */
		public function getAllRoles(): ?array
        {
            try {
                $roles = $this->role->getAllRoles();
                if (empty($roles)) {
                    return null;
                }
                return $roles;
            } catch (Exception $e) {
                // Show error message if an exception occurs.
                throw new Exception('Error fetching users: ' . $e->getMessage());
            }
        }

	}
?>