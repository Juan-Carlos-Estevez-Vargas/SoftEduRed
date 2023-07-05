<?php
  require_once '../persistence/database/Database.php';
  require_once '../persistence/SubjectHasCourseDAO.php';
  require_once '../utils/Message.php';
  
	class SubjectHasCourseService
	{
		/**
		 * Initializes a new instance of the class with a database connection.
		 * @throws PDOException If there is any error with the database connection.
		 */
		public function __construct() {
				try {
						$this->subjectHasCourse = new SubjectHasCourseDAO;
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Registers a course with its corresponding subjects and state.
		 *
		 * @param int $course The ID of the course to be registered.
		 * @param int $subject The ID of the subject to be registered.
		 * @param string $state The state of the subject in the course.
		 *
		 * @return void
		 */
		public function register($course, $subject)
		{
				try {
						if (!empty($course) && !empty($subject)) {
								if ($this->subjectHasCourse->exists($course, $subject)){
										Message::showErrorMessage(
												"El curso ya tiene asignada esa materia.",
												'../../views/subjectHasCourseView.php'
										);
										return;
								}
								$this->subjectHasCourse->register($course, $subject);
								
								Message::showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/subjectHasCourseView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/subjectHasCourseView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/subjectHasCourseView.php'
						);
				}
		}

		/**
		 * Updates a record in the subject_has_course table.
		 *
		 * @param string $id The id of the record to be updated.
		 * @param string $course The new course id.
		 * @param string $subject The new subject id.
		 * @param string $state The new state.
		 * @return void
		 */
		public function update(
			string $id, string $course,	string $subject, string $state
		)	{
				try {
						if (!empty($id) && !empty($course) && !empty($subject))
						{
								$this->subjectHasCourse->update($id, $course, $subject, $state);
							
								Message::showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/subjectHasCourseView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/subjectHasCourseView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/subjectHasCourseView.php'
						);
				}
		}

		/**
		 * Deletes a record from the subject_has_course table
		 *
		 *v@param string $id - the value to match with id_subject_has_course
		 */
		public function delete(string $id)
		{
				try {
						if (!empty($id)) {
								$this->subjectHasCourse->delete($id);
								
								Message::showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/subjectHasCourseView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/subjectHasCourseView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/subjectHasCourseView.php'
						);
				}
		}
	}
?>