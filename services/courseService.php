<?php
	require_once '../persistence/database/Database.php';
	require_once '../persistence/CourseDAO.php';
	require_once '../utils/Message.php';
	require_once '../utils/constants.php';
  
	class CourseService {

		/**
		 * Constructor of the class.
		 * Initializes the PDO object by connecting to the database.
		 *
		 * @throws PDOException if the connection to the database fails.
		 */
		public function __construct()
		{
			try {
				$this->course = new CourseDAO();
			} catch (PDOException $e) {
				throw new PDOException($e->getMessage());
			}
		}

		/**
		 * Registers a new course with a given code and state.
		 *
		 * @param string $course - The code of the course to register.
		 * @param string $state - The state of the course to register.
		 *
		 * @return void
		 */
		public function register(string $course): void
		{
			try {
				if (!empty($course)) {
					if (Message::isRegistered(Database::connect(), 'course', 'course', $course, false, null))
					{
						Message::showErrorMessage(COURSE_ALREADY_ADDED,	COURSE_URL);
						return;
					}
					$this->course->register($course);
					Message::showSuccessMessage(ADDED_RECORD, COURSE_URL);
				} else {
					Message::showWarningMessage(EMPTY_FIELDS, COURSE_URL);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, COURSE_URL);
			}
		}

		/**
		 * Updates a course record in the database.
		 *
		 * @param string $courseId - The id of the course to update.
 		 * @param string $course - The updated course code.
		 * @param string $state - The updated state of the course.
		 * @return void
		 */
		public function update(string $courseId, string $course, string $state)
		{
			try {
				if (!empty($courseId) && !empty($course)) {
					$this->course->update($courseId, $course, $state);
					Message::showSuccessMessage(UPDATED_RECORD, COURSE_URL);
				} else {
					Message::showWarningMessage(EMPTY_FIELDS, COURSE_URL);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, COURSE_URL);
			}
		}

		/**
		 * Deletes a course from the database
		 *
		 * @param string $courseId - The code of the course to be deleted
		 * @return void
		 */
		public function delete(string $courseId)
		{
			try {
				if (!empty($courseId)) {
					$this->course->delete($courseId);
					Message::showSuccessMessage(DELETED_RECORD, COURSE_URL);
				} else {
					Message::showWarningMessage(EMPTY_FIELDS, COURSE_URL);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, COURSE_URL);
			}
		}

		/**
		 * Retrieves a course by its ID.
		 *
		 * @param int $id The ID of the course.
		 * @throws Exception If an error occurs while retrieving the course.
		 * @return mixed The course object if found, or null otherwise.
		 */
		public function getCourseById(int $id)
		{
			try {
				if (!empty($id)) {
					return $this->course->getCourseById($id);
				} else {
					Message::showWarningMessage(INTERNAL_ERROR, COURSE_URL);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, COURSE_URL);
			}
		}

		/**
		 * Retrieves the course list data for a given page.
		 *
		 * @param int $page The page number.
		 * @throws Exception If an error occurs while retrieving the course list data.
		 * @return mixed The course list data.
		 */
		public function getCourseListData($page)
		{
			try {
				if (!empty($page)) {
					return $this->course->getCourseListData($page);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, COURSE_URL);
			}
		}
	}
?>