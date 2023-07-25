<?php
require_once "../pages/BasePage.php";
require_once "../persistence/database/Database.php";
require_once "../services/relationshipService.php";

class RelationshipPage extends BasePage
{
    private $id; 

    /**
     * Constructor for the class.
     *
     * @param mixed $pageTitle The title of the page.
     * @param int|null $id The id of the relationship for updating (optional).
     * @return void
     */
    public function __construct($pageTitle, $id = null)
    {
        parent::__construct($pageTitle);
        $this->id = $id;
        $this->db = Database::connect();
        $this->relationshipService = new RelationshipService($this->db);
    }

    /**
     * Renders the new relationship HTML based on the current request parameters.
     *
     * @throws Some_Exception_Class If the request action is not set to 'ver' or 'edit'.
     */
    private function renderNewRelationship()
    {
        if (!isset($_REQUEST['action']) || ($_REQUEST['action'] !== 'ver' && $_REQUEST['action'] !== 'edit')) {
            echo '
            <h3 class="text-center d-flex justify-content-center justify-content-md-end">
              <a class="btn btn-success" href="?action=ver&m=1">Agregar Parentesco</a>
            </h3>
            ';
        }

        // Check if the form is submitted and the course data is provided
        if (!empty($_POST['relationship'])) {
            $this->relationshipService->register($_POST['relationship']);
        }
    
        if (!empty($_GET['m']) && !empty($_GET['action'])) {
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="?action=insert" method="post" enctype="multipart/form-data">
                            <div class="row justify-content-end align-items-center mb-5">
                                <div class="col-md-11 d-flex align-items-center justify-content-center">
                                    <h4 class="text-uppercase text-success">Nuevo Parentesco</h4>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-end">
                                    <a href="?action=&m=" class="btn btn-danger btn-block">X</a>
                                </div>
                            </div>
    
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input type="text" name="relationship" placeholder="Tipo de Relación" required
                                            style="text-transform:uppercase" class="form-control" maxlength="30" />
                                        <label class="form-label" for="relationship">Tipo de Parentesco:</label>
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
     * Renders the update relationship form if the 'action' query parameter is not empty and the 'id' variable is not empty.
     *
     * @throws Some_Exception_Class description of exception
     */
    private function renderUpdateRelationship(int $id)
    {
        if (!empty($_GET['action']) && !empty($id)) {
            $relationship = $this->relationshipService->getRelationshipById($id);

            if (!$relationship) {
                // Relationship not found, handle the error here
                echo "Error: Relationship not found.";
                return;
            }
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="?action=update" method="post" enctype="multipart/form-data">
                            <div class="row justify-content-end align-items-center mb-5">
                                <div class="col-md-11 d-flex align-items-center justify-content-center">
                                    <h4 class="text-uppercase text-success">Actualizar Parentesco</h4>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-end">
                                    <a href="?action=&m=" class="btn btn-danger btn-block">X</a>
                                </div>
                            </div>

                            <div>
                                <input type="text" name="id_course" value="<?php echo $relationship['id_relationship']?>" style="display: none;">
                            </div>

                            <div class=" row">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input type="text" class="form-control" name="relationship"
                                            style="text-transform:uppercase" value="<?php echo $relationship['description']?>" maxlength="30"
                                            readonly required />
                                        <label class="form-label" for="relationship">Tipo de Parentesco:</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-outline">
                                        <label class="form-label mr-5">Estado</label>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="state" value="1"
                                                <?php echo $relationship['state'] === 1 ? 'checked' : '' ?> />
                                            <label class="form-check-label">Activo</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="state" value="0"
                                                <?php echo $relationship['state'] === 0 ? 'checked' : '' ?> />
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
     * Renders the relationship list.
     *
     * This function retrieves the relationship records from the database and displays them in a table.
     * It also handles pagination and displays the appropriate number of records per page.
     *
     * @throws PDOException if there is an error executing the SQL queries.
     */
    private function renderRelationshipList()
    {
      if (!isset($_REQUEST['action']) || ($_REQUEST['action'] !== 'ver' && $_REQUEST['action'] !== 'edit'))
      {
        $data = $this->relationshipService->getRelationshipListData(isset($_GET['page']) ? $_GET['page'] : 1);

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
            <h4 class="mb-5 text-uppercase text-primary">Parentescos</h4>
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
                            <th>Parentesco</th>
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
                            <a class="btn btn-primary" href="?action=edit&id_relationship=<?php echo $row['id_relationship'];?>">
                                Actualizar
                            </a>
                            <a class="btn btn-danger" href="?action=delete&id_relationship=<?php echo $row['id_relationship'];?>"
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
     * This function calls three other functions to render the new relationship,
     * update relationship, and relationship list.
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
                    $this->handleUpdateRelationship();
                    break;
                case 'delete':
                    $this->handleDeleteRelationship();
                    break;
            }
        }

        $this->renderNewRelationship();
        $this->renderRelationshipList();

        if ($this->id !== null) {
            $this->renderUpdateRelationship($this->id);
        }
    }

    /**
     * Handles the update relationship functionality.
     *
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    private function handleUpdateRelationship()
    {
        if (isset($_POST['id_course'], $_POST['relationship'], $_POST['state'])) {
            $this->relationshipService->update($_POST['id_course'], $_POST['relationship'], $_POST['state']);
        }
    }

    /**
     * Handles the deletion of a relationship.
     *
     * @throws Some_Exception_Class if the relationship ID is not set in the query string
     */
    private function handleDeleteRelationship()
    {
        if (isset($_GET['id_relationship'])) {
            $this->relationshipService->delete($_GET['id_relationship']);
        }
    }

}

$pageTitle = "Parentesco";
$id = isset($_GET['id_relationship']) ? $_GET['id_relationship'] : null;
$relationshipPage = new RelationshipPage($pageTitle, $id);
$relationshipPage->render();
?>