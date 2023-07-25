<?php
require_once "../pages/BasePage.php";
require_once "../persistence/database/Database.php";
require_once "../services/securityQuestionService.php";

class SecurityQuestionPage extends BasePage
{
    private $id; 

    /**
     * Constructor for the class.
     *
     * @param mixed $pageTitle The title of the page.
     * @param int|null $id The id of the course for updating (optional).
     * @return void
     */
    public function __construct($pageTitle, $id = null)
    {
        parent::__construct($pageTitle);
        $this->id = $id;
        $this->db = Database::connect();
        $this->questionService = new SecurityQuestionService($this->db);
    }

    /**
     * Renders the new security question HTML based on the current request parameters.
     *
     * @throws Some_Exception_Class If the request action is not set to 'ver' or 'edit'.
     */
    private function renderNewSecurityQuestion()
    {
        if (!isset($_REQUEST['action']) || ($_REQUEST['action'] !== 'ver' && $_REQUEST['action'] !== 'edit')) {
            echo '
            <h3 class="text-center d-flex justify-content-center justify-content-md-end">
              <a class="btn btn-success" href="?action=ver&m=1">Agregar Registro</a>
            </h3>
            ';
        }

        // Check if the form is submitted and the course data is provided
        if (!empty($_POST['question'])) {
            $this->questionService->register($_POST['question']);
        }
    
        if (!empty($_GET['m']) && !empty($_GET['action'])) {
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="?action=insert" method="post" enctype="multipart/form-data">
                            <div class="row justify-content-end align-items-center mb-5">
                                <div class="col-md-11 d-flex align-items-center justify-content-center">
                                    <h4 class="text-uppercase text-success">Nueva Pregunta de Seguridad</h4>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-end">
                                    <a href="?action=&m=" class="btn btn-danger btn-block">X</a>
                                </div>
                            </div>
    
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input type="text" name="question" placeholder="Ingresa la pregunta" required
                                            style="text-transform:uppercase" size="100" maxlength="100" class="form-control" />
                                        <label class="form-label" for="question">Pregunta de Seguridad:</label>
                                    </div>
                                </div>
    
                                <div class="col-md-2">
                                    <div class="form-outline">
                                        <input type="submit" class="btn btn-primary btn-block" value="Guardar" onclick="this.form.action = '?action=register'" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    /**
     * Renders the update security question form if the 'action' query parameter is not empty and the 'id' variable is not empty.
     *
     * @throws Some_Exception_Class description of exception
     */
    private function renderUpdateSecurityQuestion(int $id)
    {
        if (!empty($_GET['action']) && !empty($id)) {
            $question = $this->questionService->getSecurityQuestionById($id);

            if (!$question) {
                // Security question not found, handle the error here
                echo "Error: Security question not found.";
                return;
            }
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="?action=update" method="post" enctype="multipart/form-data">
                            <div class="row justify-content-end align-items-center mb-5">
                                <div class="col-md-11 d-flex align-items-center justify-content-center">
                                    <h4 class="text-uppercase text-success">Actualizar Pregunta de Seguridad</h4>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-end">
                                    <a href="?action=&m=" class="btn btn-danger btn-block">X</a>
                                </div>
                            </div>

                            <div>
                                <input type="text" name="id_course" value="<?php echo $question['id_security_question']?>" style="display: none;">
                            </div>

                            <div class=" row">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input type="text" name="question" class="form-control"
                                            value="<?php echo $question['description']?>" required style="text-transform:uppercase"
                                            size="100" maxlenght="100" readonly />
                                        <label class="form-label" for="question">Pregunta de Seguridad:</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-outline">
                                        <label class="form-label mr-5">Estado</label>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="state" value="1"
                                                <?php echo $question['state'] === 1 ? 'checked' : '' ?> />
                                            <label class="form-check-label">Activo</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="state" value="0"
                                                <?php echo $question['state'] === 0 ? 'checked' : '' ?> />
                                            <label class="form-check-label">Inactivo</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-outline">
                                        <input type="submit" class="btn btn-primary btn-block" value="Actualizar"
                                            onclick="this.form.action = '?action=update';" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    /**
     * Renders the security question list.
     *
     * This function retrieves the course records from the database and displays them in a table.
     * It also handles pagination and displays the appropriate number of records per page.
     *
     * @throws PDOException if there is an error executing the SQL queries.
     */
    private function renderSecurityQuestionList()
    {
      if (!isset($_REQUEST['action']) || ($_REQUEST['action'] !== 'ver' && $_REQUEST['action'] !== 'edit'))
      {
        $data = $this->questionService->getSecurityQuestionListData(isset($_GET['page']) ? $_GET['page'] : 1);

        if ($data === null) {
            // Ocurrió un error en la consulta, no renderizar nada
            return;
        }

        $totalRecords = $data['totalRecords'];
        $recordsPerPage = $data['recordsPerPage'];
        $currentPage = $data['currentPage'];
        $offset = $data['offset'];
        $query = $data['query'];
        $hasRecords = $data['hasRecords'];
        ?>
        <div class="col-md-12 text-center mt-4">
            <h4 class="mb-5 text-uppercase text-primary">Preguntas de Seguridad</h4>
            <?php if ($hasRecords) : ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <caption class="text-center">
                        Mostrando
                        <?php echo $recordsPerPage * ($currentPage - 1) + 1; ?> -
                        <?php echo $recordsPerPage * $currentPage; ?> de
                        <?php echo $totalRecords; ?> registros
                    </caption>
                    <thead>
                        <tr>
                            <th>Pregunta de Seguridad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['description']; ?></td>
                        <?php
                        if ($row['state'] == 1) {
                            echo "<td class='text-success'>Activo</td>";
                        } else {
                            echo "<td class='text-warning'>Inactivo</td>";
                        }
                        ?>
                        <td>
                            <a class="btn btn-primary" href="?action=edit&id_security_question=<?php echo $row['id_security_question'];?>">
                                Actualizar
                            </a>
                            <a class="btn btn-danger" href="?action=delete&id_security_question=<?php echo $row['id_security_question'];?>"
                                onclick="confirmDelete(event)">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                    <?php endwhile ?>
                    </tbody>
                </table>
            </div>
    
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php
                        include_once "../utils/pagination.php";
                        ?>
                    </ul>
                    </nav>
                </div>
            </div>
            <?php else: ?>
            <h4><?php echo "No se encontraron registros"; ?></h4>
            <?php endif ?>
        </div>
        <?php
        }
    }
    
    /**
     * Renders the content of the current object.
     *
     * This function calls three other functions to render the new security question,
     * update security question, and security question list.
     *
     * @throws Some_Exception_Class A description of the exception that can be thrown
     * @return void
     */
    public function renderContent()
    {
        if (isset($_REQUEST['action'])) {
            $action = $_REQUEST['action'];

            switch ($action) {
                case 'update':
                    $this->handleUpdateSecurityQuestion();
                    break;
                case 'delete':
                    $this->handleDeleteSecurityQuestion();
                    break;
            }
        }

        $this->renderNewSecurityQuestion();
        $this->renderSecurityQuestionList();

        if ($this->id !== null) {
            $this->renderUpdateSecurityQuestion($this->id);
        }
    }

    /**
     * Handles the update security question functionality.
     *
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    private function handleUpdateSecurityQuestion()
    {
        if (isset($_POST['id_security_question'], $_POST['question'], $_POST['state'])) {
            $this->questionService->update($_POST['id_security_question'], $_POST['question'], $_POST['state']);
        }
    }

    /**
     * Handles the deletion of a security question.
     *
     * @throws Some_Exception_Class if the security question ID is not set in the query string
     */
    private function handleDeleteSecurityQuestion()
    {
        if (isset($_GET['id_security_question'])) {
            $this->questionService->delete($_GET['id_security_question']);
        }
    }

}

$pageTitle = "Pregunta de Seguridad";
$id = isset($_GET['id_security_question']) ? $_GET['id_security_question'] : null;
$questionPage = new SecurityQuestionPage($pageTitle, $id);
$questionPage->render();
?>