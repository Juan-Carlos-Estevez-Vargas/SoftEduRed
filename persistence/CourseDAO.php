<?php
	require_once '../utils/Message.php';
	require_once '../utils/constants.php';

	class CourseDAO {
		private $pdo;

		/**
		 * Constructor of the class.
		 * Initializes the PDO object by connecting to the database.
		 *
		 * @throws PDOException if the connection to the database fails.
		 */
		public function __construct()
		{
			try {
				$this->pdo = Database::connect();
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
				$sql = "
					INSERT INTO course (course, state)
					VALUES (UPPER(:course), 1)
				";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute(['course' => $course]);
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
				$sql = "
					UPDATE course
					SET course = UPPER(:course),
						state = :state
					WHERE id_course = :id
				";
			
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute([
					'course' => $course,
					'state' => $state,
					'id' => $courseId
				]);
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
				$sql = "
					UPDATE course
					SET state = 3
					WHERE id_course = '$courseId'
				";
				$this->pdo->query($sql);
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, COURSE_URL);
			}
		}

		/**
		 * Retrieves a course from the database based on its ID.
		 *
		 * @param int $id The ID of the course to retrieve.
		 * @throws Exception If an error occurs while retrieving the course.
		 * @return array|false The course data as an associative array, or false if the course does not exist.
		 */
		public function getCourseById(int $id)
		{
			try {
				$sql = "SELECT * FROM course WHERE id_course = :id";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute(['id' => $id]);
				return $stmt->fetch(PDO::FETCH_ASSOC);
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, COURSE_URL);
			}
		}

		/**
		 * Retrieves course list data for a given page.
		 *
		 * @param int $page The page number.
		 * @throws PDOException When there is an error executing the database query.
		 * @return array Returns an array containing the total number of records, 
		 * the number of records per page, the current page number, the offset for the query, 
		 * the query object, and a boolean indicating if there are records or not.
		 */
		public function getCourseListData($page)
		{
			try {
				// Obtener el número total de registros
				$sqlCount = "SELECT COUNT(*) AS total FROM course WHERE state != 3";
				$countQuery = $this->pdo->query($sqlCount);
				$totalRecords = $countQuery->fetchColumn();

				// Calcular el límite y el desplazamiento para la consulta actual
				$recordsPerPage = 5; // Número de registros por página
				$currentPage = $page; // Página actual
				$offset = ($currentPage - 1) * $recordsPerPage;

				// Consulta para obtener los registros de la página actual con límite y desplazamiento
				$sql = "SELECT * FROM course WHERE state != 3 LIMIT :offset, :limit";
				$query = $this->pdo->prepare($sql);
				$query->bindValue(':offset', $offset, PDO::PARAM_INT);
				$query->bindValue(':limit', $recordsPerPage, PDO::PARAM_INT);
				$query->execute();

				// Verificar si existen registros
				$hasRecords = $query->rowCount() > 0;

				// Devolver los resultados como un arreglo
				return [
					'totalRecords' => $totalRecords,
					'recordsPerPage' => $recordsPerPage,
					'currentPage' => $currentPage,
					'offset' => $offset,
					'query' => $query,
					'hasRecords' => $hasRecords,
				];
			} catch (PDOException $e) {
				// Manejo de errores de la base de datos
				Message::showErrorMessage(INTERNAL_ERROR, COURSE_URL);
				return null;
			}
		}
	}
?>