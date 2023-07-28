<?php
require_once "../pages/BasePage.php";

class Cruds extends BasePage
{
    /**
     * Renders the content for display.
     *
     * @return void
     */
    public function renderContent()
    {
        echo '
        <h3 class="mb-5 text-uppercase text-center text-primary">Registros</h3>

        <div class="row">
          <div class="col-md-12 mb-4">
            <form action="" method="">
              <div class="row align-items-center justify-content-center">
                <label class="col-auto me-2">Seleccione un Recurso: </label>
                <div class="col-md-auto">
                  <select name="select_crud" class="form-control" onchange="window.location.href=this.value">
                    <option selected disabled>Acción:</option>
                    <option value="../pages/documentTypePage.php">Tipo de Documento</option>
                    <option value="../pages/genderPage.php">Género</option>
                    <option value="../pages/relationshipPage.php">Parentesco</option>
                    <option value="../pages/questionPage.php">Pregunta de Seguridad</option>
                    <option value="../pages/rolePage.php">Rol</option>
                    <option value="../pages/roleHasUserPage.php">Rol por Usuario</option>
                    <option value="../pages/userStudentView.php">Estudiante</option>
                    <option value="../pages/userTeacherView.php">Docente</option>
                    <option value="../pages/userAttendantView.php">Acudiente</option>
                    <option value="../pages/subjectView.php">Materia</option>
                    <option value="../pages/coursePage.php">Curso</option>
                    <option value="../pages/subjectHasCourseView.php">Materia por Curso</option>
                    <option value="../pages/atributes/noAttendanceView.php">Asistencia</option>
                  </select>
                </div>
              </div>
            </form>
          </div>
        </div>
        ';
    }
}

// Crear una instancia de la página de registros
$pageTitle = "Registros";
$recordsPage = new Cruds('Cruds');
$recordsPage->render(); // Renderizar la página
?>
