<?php
require_once "../pages/BasePage.php";
require_once "../persistence/database/Database.php";
require_once "../services/roleHasUserService.php";
require_once "../services/userService.php";
require_once "../services/roleService.php";

class UserHasRolePage extends BasePage
{
    private $id;
    private $userId;
    private $roleId;

    /**
     * Constructor for the class.
     *
     * @param mixed $pageTitle The title of the page.
     * @param int|null $id The id of the course for updating (optional).
     * @return void
     */
    public function __construct($pageTitle, $id = null, $userId = null, $roleId = null)
    {
        parent::__construct($pageTitle);
        $this->id = $id;
        $this->userId = $userId;
        $this->roleId = $roleId;
        $this->db = Database::connect();
        $this->userHasRoleService = new RoleHasUserService($this->db);
        $this->userService = new UserService($this->db);
        $this->roleService = new RoleService($this->db);
    }

    /**
     * Renders the new user has role HTML based on the current request parameters.
     *
     * @throws Some_Exception_Class If the request action is not set to 'ver' or 'edit'.
     */
    private function renderNewUserHasRole()
    {
        if (!isset($_REQUEST['action']) || ($_REQUEST['action'] !== 'ver' && $_REQUEST['action'] !== 'edit')) {
            echo '
            <h3 class="text-center d-flex justify-content-center justify-content-md-end">
              <a class="btn btn-success" href="?action=ver&m=1">Agregar Registro</a>
            </h3>
            ';
        }

        // Check if the form is submitted and the course data is provided
        if (!empty($_POST['id_user']) && !empty($_POST['role'])) {
            $this->userHasRoleService->register($_POST['id_user'], $_POST['role']);
        }
    
        if (!empty($_GET['m']) && !empty($_GET['action'])) {
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="?action=insert" method="post" enctype="multipart/form-data">
                            <div class="row justify-content-end align-items-center mb-5">
                                <div class="col-md-11 d-flex align-items-center justify-content-center">
                                    <h4 class="text-uppercase text-success">Nuevo Rol de Usuario</h4>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-end">
                                    <a href="?action=&m=" class="btn btn-danger btn-block">X</a>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-4">
                                    <div class="form-outline">
                                        <select class="form-control" name="role">
                                        <?php
                                            //foreach ($this->roleService->getUnassignedRoles($_POST['id_user']) as $row) {
                                            //    echo '<option value="'.$row['id_role'].'">'.$row["description"].'</option>';
                                            //}
                                            foreach ($this->roleService->getAllRoles() as $row) {
                                                echo '<option value="'.$row['id_role'].'">'.$row["description"].'</option>';
                                            }
                                        ?>
                                        </select>
                                        <label class="form-label" for="role">Tipo de Rol:</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-outline">
                                        <select class="form-control" name="id_user">
                                        <?php
                                        foreach ($this->userService->getAllUsers() as $row) {
                                            echo '<option value="'.$row['id_user'].'">'.$row["identification_number"]." - ".$row["first_name"]." - ".$row["surname"].'</option>';
                                        }
                                        ?>
                                        </select>
                                        <label class="form-label" for="id_user">Usuario:</label>
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
     * Render the update user has role functionality.
     *
     * @param int $userId The ID of the user.
     * @param int $roleId The ID of the role.
     * @return void
     */
    private function renderUpdateUserHasRole(int $id, int $userId, int $roleId)
    {
        if (!empty($_GET['action']) && !empty($userId) && !empty($roleId) && !empty($id)) {
            $roleHasUser = $this->userHasRoleService->getRoleHasUserByUserAndRole($userId, $roleId);

            if (!$roleHasUser) {
                // User Has Role not found, handle the error here
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
                                    <h4 class="text-uppercase text-success">Actualizar Rol de Usuario</h4>
                                </div>
                                <div class="col-md-1 d-flex align-items-center justify-content-end">
                                    <a href="?action=&m=" class="btn btn-danger btn-block">X</a>
                                </div>
                            </div>

                            <div>
                                <input type="text" name="id_user_has_role" value="<?php echo $roleHasUser['id_user_has_role']?>"
                                    style="display: none" class="form-control" />
                            </div>

                            <div class=" row">
                                <div class="col-md-3">
                                    <div class="form-outline">
                                        <input type="text" class="form-control" style="text-transform:uppercase;" name="user"
                                            value="<?php echo $roleHasUser['first_name']." ".$roleHasUser['surname']?>" disabled required />
                                        <label class="form-label">Usuario:</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-outline">
                                        <input type="text" class="form-control" style="text-transform:uppercase;" name="role"
                                            value="<?php echo $roleHasUser['description']?>" maxlength="15" disabled required />
                                        <label class="form-label" for="role">Tipo de Rol:</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-outline">
                                        <label class="form-label mr-5">Estado</label>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="state" value="1"
                                                <?php echo $roleHasUser['state'] === 1 ? 'checked' : '' ?> />
                                            <label class="form-check-label">Activo</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="state" value="0"
                                                <?php echo $roleHasUser['state'] === 0 ? 'checked' : '' ?> />
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
     * Renders the user has role list.
     *
     * @throws None
     * @return None
     */
    private function renderUserHasRoleList()
    {
      if (!isset($_REQUEST['action']) || ($_REQUEST['action'] !== 'ver' && $_REQUEST['action'] !== 'edit'))
      {
        $data = $this->userHasRoleService->getRoleHasUserListData(isset($_GET['page']) ? $_GET['page'] : 1);

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
            <h4 class="mb-5 text-uppercase text-primary">Roles por Usuario</h4>
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
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['first_name'].' '.$row['surname']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <?php
                        if ($row['state'] == 1) {
                            echo "<td class='text-success'>Activo</td>";
                        } else {
                            echo "<td class='text-warning'>Inactivo</td>";
                        }
                        ?>
                        <td>
                            <a class="btn btn-primary" 
                                href="?action=edit&id_user_has_role=<?php echo $row['id_user_has_role'];?>&id_user=<?php echo $row['user_id'];?>&role=<?php echo $row['role_id'];?>">
                                Actualizar
                            </a>
                            <a class="btn btn-danger" href="?action=delete&id_user_has_role=<?php echo $row['id_user_has_role'];?>"
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
     * Render the content of the page.
     *
     * This function is responsible for rendering the content of the page. It checks if the 'action' parameter is set in the $_REQUEST array. If it is, it performs different actions based on the value of the 'action' parameter. If the 'action' parameter is 'update', it calls the handleUpdateUserHasRole() method. If the 'action' parameter is 'delete', it calls the handleDeleteUserHasRole() method. 
     *
     * After performing the actions based on the 'action' parameter, it calls the renderNewUserHasRole() method, followed by the renderUserHasRoleList() method. If the 'id' property of the class is not null, it calls the renderUpdateUserHasRole() method, passing the 'id' as a parameter.
     *
     * @throws None
     * @return None
     */
    public function renderContent()
    {
        if (isset($_REQUEST['action'])) {
            $action = $_REQUEST['action'];

            switch ($action) {
                case 'update':
                    $this->handleUpdateUserHasRole();
                    break;
                case 'delete':
                    $this->handleDeleteUserHasRole();
                    break;
            }
        }

        $this->renderNewUserHasRole();
        $this->renderUserHasRoleList();

        if ($this->id !== null && $this->userId !== null && $this->roleId !== null) {
            $this->renderUpdateUserHasRole($this->id, $this->userId, $this->roleId);
        }
    }

    /**
     * Handles the update role has user functionality.
     *
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    private function handleUpdateUserHasRole()
    {
        if (isset($_POST['id_user_has_role'], $_POST['state'])) {
            $this->userHasRoleService->update($_POST['id_user_has_role'], $_POST['state']);
        }
    }

    /**
     * Handles the deletion of an role has user.
     *
     * @throws Some_Exception_Class if the course ID is not set in the query string
     */
    private function handleDeleteUserHasRole()
    {
        if (isset($_GET['id_user_has_role'])) {
            $this->userHasRoleService->delete($_GET['id_user_has_role']);
        }
    }

}

$pageTitle = "Roles por Usuario";
$id = isset($_GET['id_user_has_role']) ? $_GET['id_user_has_role'] : null;
$userId = isset($_GET['id_user']) ? $_GET['id_user'] : null;
$roleId = isset($_GET['role']) ? $_GET['role'] : null;
$userHasRolePage = new UserHasRolePage($pageTitle, $id, $userId, $roleId);
$userHasRolePage->render();
?>


