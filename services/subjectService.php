<?php
  require_once '../persistence/database/Database.php';
  require_once '../persistence/SubjectDAO.php';
  require_once '../utils/Message.php';
  
	class SubjectService
	{
		/**
		* Initializes a new instance of the class and connects it to the database.
		*
		* @throws PDOException if there is an error connecting to the database.
		*/
		public function __construct() {
				try {
						$this->subject = new SubjectDAO();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Registers a subject with the given parameters
		 *
		 * @param string $subject The name of the subject
		 * @param string $teacherId The ID of teacher
		 *
		 * @return void
		 */
		public function register(string $subject, string $teacherId)
		{
				try {
						if (!empty($subject) && !empty($teacherId)) {
                if($this->subject->isRegistered($subject, $teacherId)) {
                    Message::showErrorMessage(
                        "El docente ya cuenta con esa meateria asosiada en la plataforma",
                        '../../views/subjectView.php'
                    );
                    return;
                }
        
                $this->subject->register($subject, $teacherId);
                
                Message::showSuccessMessage(
                    "Registro Agregado Exitosamente.",
                    '../../views/subjectView.php'
                );
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/subjectView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/subjectView.php'
						);
				}
		}

		/**
		 * Updates subject information in the database.
		 *
		 * @param string $idSubject The ID of the subject to be updated.
		 * @param string $subject The new name of the subject.
		 * @param string $state The new state of the subject.
		 * @param int $teacherId The ID of the teacher assigned to the subject.
		 *
		 * @return void
		 */
		public function update(
			string $idSubject, string $subject, string $state, int $teacherId)
		{
				try {
						if (!empty($idSubject) && !empty($subject) && !empty($teacherId))
						{
                $this->subject->update($idSubject, $subject, $state, $teacherId);
								
								Message::showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/subjectView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/subjectView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/subjectView.php'
						);
				}
		}

		/**
		 * Deletes a subject from the database.
		 *
		 * @param string $subjectId The ID of the subject to be deleted.
 		 * @return void
		 */
		public function delete(string $subjectId): void
		{
				try {
						if (!empty($subjectId)) {
                $this->subject->delete($subjectId);
								
								Message::showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/subjectView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/subjectView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/subjectView.php'
						);
				}
		}
  }
?>