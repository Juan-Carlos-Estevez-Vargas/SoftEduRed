<?php
require_once "../pages/BasePage.php";
require_once "../persistence/database/Database.php";
require_once "../services/courseService.php";

class CoursePage extends BasePage
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
        $this->courseService = new CourseService($this->db);
    }

    /**
     * Renders the new course HTML based on the current request parameters.
     *
     * @throws Some_Exception_Class If the request action is not set to 'ver' or 'edit'.
     */
    private function renderNewCourse()
    {
        if (!isset($_REQUEST['action']) || ($_REQUEST['action'] !== 'ver' && $_REQUEST['action'] !== 'edit')) {
            echo '
            <h3 class="text-center d-flex justify-content-center justify-content-md-end">
              <a class="btn btn-success" href="?action=ver&m=1">Agregar Curso</a>
            </h3>
            ';
        }

        // Check if the form is submitted and the course data is provided
        if (!empty($_POST['course'])) {
            $this->courseService->register($_POST['course']);
        }
    
        if (!empty($_GET['m']) && !empty($_GET['action'])) {
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="?action=insert" method="post" enctype="multipart/form-data">
                            <div class="row justify-content-end align-items-center mb-5">
                                <div class="col-md-11 d-flex align-items-center justify-content-center">
                                    <h4 class="text-uppercase text-success">Nuevo Curso</h4>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-end">
                                    <a href="?action=&m=" class="btn btn-danger btn-block">X</a>
                                </div>
                            </div>
    
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input class="form-control" type="text" name="course" placeholder="Curso" required maxlength="5" />
                                        <label class="form-label" for="course">Curso:</label>
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
     * Renders the update course form if the 'action' query parameter is not empty and the 'id' variable is not empty.
     *
     * @throws Some_Exception_Class description of exception
     */
    private function renderUpdateCourse(int $id)
    {
        if (!empty($_GET['action']) && !empty($id)) {
            $course = $this->courseService->getCourseById($id);

            if (!$course) {
                // Course not found, handle the error here
                echo "Error: Course not found.";
                return;
            }
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="?action=update" method="post" enctype="multipart/form-data">
                            <div class="row justify-content-end align-items-center mb-5">
                                <div class="col-md-11 d-flex align-items-center justify-content-center">
                                    <h4 class="text-uppercase text-success">Actualizar Curso</h4>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-end">
                                    <a href="?action=&m=" class="btn btn-danger btn-block">X</a>
                                </div>
                            </div>

                            <div>
                                <input type="text" name="id_course" value="<?php echo $course['id_course']?>" style="display: none;">
                            </div>

                            <div class=" row">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input class="form-control" type="text" name="course" value="<?php echo $course['course']?>"
                                            required maxlength="5" />
                                        <label class="form-label">Curso:</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-outline">
                                        <label class="form-label mr-5">Estado</label>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="state" value="1"
                                                <?php echo $course['state'] === 1 ? 'checked' : '' ?> />
                                            <label class="form-check-label">Activo</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="state" value="0"
                                                <?php echo $course['state'] === 0 ? 'checked' : '' ?> />
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
     * Renders the course list.
     *
     * This function retrieves the course records from the database and displays them in a table.
     * It also handles pagination and displays the appropriate number of records per page.
     *
     * @throws PDOException if there is an error executing the SQL queries.
     */
    private function renderCourseList()
    {
      if (!isset($_REQUEST['action']) || ($_REQUEST['action'] !== 'ver' && $_REQUEST['action'] !== 'edit'))
      {
        $data = $this->courseService->getCourseListData(isset($_GET['page']) ? $_GET['page'] : 1);

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
            <h4 class="mb-5 text-uppercase text-primary">Cursos</h4>
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
                            <th>Curso</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['course']; ?></td>
                        <?php
                        if ($row['state'] == 1) {
                            echo "<td class='text-success'>Activo</td>";
                        } else {
                            echo "<td class='text-warning'>Inactivo</td>";
                        }
                        ?>
                        <td>
                            <a class="btn btn-primary" href="?action=edit&id_course=<?php echo $row['id_course'];?>">
                                Actualizar
                            </a>
                            <a class="btn btn-danger" href="?action=delete&id_course=<?php echo $row['id_course'];?>"
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
     * This function calls three other functions to render the new course,
     * update course, and course list.
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
                    $this->handleUpdateCourse();
                    break;
                case 'delete':
                    $this->handleDeleteCourse();
                    break;
            }
        }

        $this->renderNewCourse();
        $this->renderCourseList();

        if ($this->id !== null) {
            $this->renderUpdateCourse($this->id);
        }
    }

    /**
     * Handles the update course functionality.
     *
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    private function handleUpdateCourse()
    {
        if (isset($_POST['id_course'], $_POST['course'], $_POST['state'])) {
            $this->courseService->update($_POST['id_course'], $_POST['course'], $_POST['state']);
        }
    }

    /**
     * Handles the deletion of a course.
     *
     * @throws Some_Exception_Class if the course ID is not set in the query string
     */
    private function handleDeleteCourse()
    {
        if (isset($_GET['id_course'])) {
            $this->courseService->delete($_GET['id_course']);
        }
    }

}

$pageTitle = "Curso";
$id = isset($_GET['id_course']) ? $_GET['id_course'] : null;
$coursePage = new CoursePage($pageTitle, $id);
$coursePage->render();
?>
