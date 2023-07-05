<?php
  require_once '../persistence/database/Database.php';
  require_once '../persistence/CourseDAO.php';
  require_once '../utils/Message.php';
  
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
		public function register(string $course, string $state): void
		{
				try {
					 	if (!empty($course)) {
                if (Message::isRegistered(Database::connect(), 'course', 'course', $course, false, null))
                {
                    Message::showErrorMessage(
                        "El curso ingresado ya se encuentra registrado en la plataforma",
                        '../../views/courseView.php'
                    );
                    return;
                }
                $this->course->register($course, $state);

								Message::showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/courseView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/courseView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/courseView.php'
						);
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
								
								Message::showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/courseView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/courseView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/courseView.php'
						);
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
								
								Message::showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/courseView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/courseView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/courseView.php'
						);
				}
		}
	}
?>