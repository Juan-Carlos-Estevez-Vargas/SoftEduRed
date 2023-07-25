<?php
require_once "../pages/BasePage.php";
require_once "../persistence/database/Database.php";
require_once "../services/DocumentTypeService.php";

class DocumentTypePage extends BasePage
{
    private $id; 

    /**
     * Constructor for the class.
     *
     * @param mixed $pageTitle The title of the page.
     * @param int|null $id The id of the document type for updating (optional).
     * @return void
     */
    public function __construct($pageTitle, $id = null)
    {
        parent::__construct($pageTitle);
        $this->id = $id;
        $this->db = Database::connect();
        $this->documentTypeService = new DocumentTypeService($this->db);
    }

    /**
     * Renders the new document type.
     *
     * This function checks if the 'action' parameter is set in the request and if it is either 'ver' or 'edit'. If it is not, it displays a button to add a new record. 
     *
     * If the form is submitted and the 'document_type' and 'description' parameters are provided, it calls the 'register' method of the 'documentTypeService' object with the provided parameters.
     *
     * If the 'm' and 'action' parameters are provided in the GET request, it displays a form to insert a new record.
     *
     * @throws Some_Exception_Class If there is an error in the registration process.
     * @return void
     */
    private function renderNewDocumentType()
    {
        if (!isset($_REQUEST['action']) || ($_REQUEST['action'] !== 'ver' && $_REQUEST['action'] !== 'edit')) {
            echo '
            <h3 class="text-center d-flex justify-content-center justify-content-md-end">
              <a class="btn btn-success" href="?action=ver&m=1">Agregar Registro</a>
            </h3>
            ';
        }

        // Check if the form is submitted and the course data is provided
        if (!empty($_POST['document_type']) && !empty($_POST['description'])) {
            $this->documentTypeService->register($_POST['document_type'], $_POST['description']);
        }
    
        if (!empty($_GET['m']) && !empty($_GET['action'])) {
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="?action=insert" method="post" enctype="multipart/form-data">
                            <div class="row justify-content-end align-items-center mb-5">
                                <div class="col-md-11 d-flex align-items-center justify-content-center">
                                    <h4 class="text-uppercase text-success">Nuevo Registro</h4>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-end">
                                    <a href="?action=&m=" class="btn btn-danger btn-block">X</a>
                                </div>
                            </div>
    
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="form-outline">
                                        <input type="text" name="document_type" placeholder="Ej: C.C" required
                                            style="text-transform:uppercase" class="form-control" maxlength="6" />
                                        <label class="form-label" for="document_type">Tipo de Documento:</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input type="text" name="description" placeholder="Ej: Cedula de Ciudadania"
                                            style="text-transform:uppercase" class="form-control" required maxlength="50"
                                            minlength="2" />
                                        <label class="form-label" for="description">Descripción</label>
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
     * Renders the update document type functionality.
     *
     * @param int $id The ID of the document type to update.
     */
    private function renderUpdateDocumentType(int $id)
    {
        if (!empty($_GET['action']) && !empty($id)) {
            $documentType = $this->documentTypeService->getDocumentTypeById($id);

            if (!$documentType) {
                // Course not found, handle the error here
                echo "Error: Document Type not found.";
                return;
            }
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="?action=update" method="post" enctype="multipart/form-data">
                            <div class="row justify-content-end align-items-center mb-5">
                                <div class="col-md-11 d-flex align-items-center justify-content-center">
                                    <h4 class="text-uppercase text-success">Actualizar Registro</h4>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-end">
                                    <a href="?action=&m=" class="btn btn-danger btn-block">X</a>
                                </div>
                            </div>

                            <div>
                                <input type="text" name="id_course" value="<?php echo $documentType['id_document_type']?>" style="display: none;">
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-outline">
                                        <input type="text" name="document_type" placeholder="Ej: C.C" required
                                            style="text-transform:uppercase" class="form-control" maxlength="6"
                                            value="<?php echo $documentType['type']?>" readonly />
                                        <label class="form-label" for="document_type">Tipo de Documento:</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-outline">
                                        <input type="text" name="description" placeholder="Ej: Cedula de Ciudadania"
                                            style="text-transform:uppercase" class="form-control"
                                            value="<?php echo $documentType['description']?>" required maxlength="50" minlength="2" />
                                        <label class="form-label" for="description">Descripción</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-outline">
                                        <label class="form-label mr-5">Estado</label>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="state" value="1"
                                                <?php echo $documentType['state'] === 1 ? 'checked' : '' ?> />
                                            <label class="form-check-label">Activo</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="state" value="0"
                                                <?php echo $documentType['state'] === 0 ? 'checked' : '' ?> />
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
     * Renders the document type list.
     *
     * @throws Some_Exception_Class Ocurrió un error en la consulta, no renderizar nada
     */
    private function renderDocumentTypeList()
    {
      if (!isset($_REQUEST['action']) || ($_REQUEST['action'] !== 'ver' && $_REQUEST['action'] !== 'edit'))
      {
        $data = $this->documentTypeService->getDocumentTypeListData(isset($_GET['page']) ? $_GET['page'] : 1);

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
            <h4 class="mb-5 text-uppercase text-primary">Tipos de Documento</h4>
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
                            <th>Tipo de Documento</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $row['type']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <?php
                                if ($row['state'] == 1) {
                                    echo "<td class='text-success'>Activo</td>";
                                } else {
                                    echo "<td class='text-warning'>Inactivo</td>";
                                }
                            ?>
                            <td>
                                <a class="btn btn-primary" href="?action=edit&id_course=<?php echo $row['id_document_type'];?>">
                                    Actualizar
                                </a>
                                <a class="btn btn-danger" href="?action=delete&id_course=<?php echo $row['id_document_type'];?>"
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
     * Renders the content of the page.
     *
     * This function handles the rendering of the page content based on the
     * action specified in the $_REQUEST['action'] parameter. It first checks
     * if the action is 'update' or 'delete' and calls the respective handler
     * functions. Then, it proceeds to render the new document type form and
     * the document type list. If the $id property is not null, it also
     * renders the update document type form.
     *
     * @throws Some_Exception_Class The exception that can be thrown
     */
    public function renderContent()
    {
        if (isset($_REQUEST['action'])) {
            $action = $_REQUEST['action'];

            switch ($action) {
                case 'update':
                    $this->handleUpdateDocumentType();
                    break;
                case 'delete':
                    $this->handleDeleteDocumentType();
                    break;
            }
        }

        $this->renderNewDocumentType();
        $this->renderDocumentTypeList();

        if ($this->id !== null) {
            $this->renderUpdateDocumentType($this->id);
        }
    }

    /**
     * Handles updating the document type.
     *
     * @throws Some_Exception_Class description of exception
     * @return void
     */
    private function handleUpdateDocumentType()
    {
        if (isset($_POST['id_document_type'], $_POST['document_type'], $_POST['description'], $_POST['state']))
        {
            $this->documentTypeService->update($_POST['id_document_type'], $_POST['document_type'], $_POST['description'], $_POST['state']);
        }
    }

    /**
     * Handles the deletion of a document type.
     *
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    private function handleDeleteDocumentType()
    {
        if (isset($_GET['id_document_type'])) {
            $this->documentTypeService->delete($_GET['id_document_type']);
        }
    }

}

$pageTitle = "Tipo de Documento";
$id = isset($_GET['id_document_type']) ? $_GET['id_document_type'] : null;
$documentTypePage = new DocumentTypePage($pageTitle, $id);
$documentTypePage->render();
?>