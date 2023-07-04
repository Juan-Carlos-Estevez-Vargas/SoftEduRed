<?php require_once "../controllers/roleHasUserController.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Rol de Usuario</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <section class="h-100 bg-white">
    <div class="container py-3 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
          <div class="card card-registration my-4">
            <div class="row g-0">
              <div class="col-xl-12">
                <div class="card-body p-md-4 text-black" style="background-color: hsl(0, 0%, 96%)">
                  <?php if (!isset($_REQUEST['action']) || ($_REQUEST['action'] !== 'ver' && $_REQUEST['action'] !== 'edit')) : ?>
                  <h3 class="text-center d-flex justify-content-center justify-content-md-end">
                    <a class="btn btn-success" href="?action=ver&m=1">Agregar Registro</a>
                  </h3>
                  <?php endif; ?>

                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <div class="row justify-content-end align-items-center mb-5">
                            <div class="col-md-11 d-flex align-items-center justify-content-center">
                              <h4 class="text-uppercase text-success">Nuevo Rol de Usuario</h4>
                            </div>
                            <div class="col-md-1 d-flex align-items-center justify-content-end">
                              <a href="?action=&m=" class="btn btn-danger btn-block">X</a>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-outline">
                                <select class="form-control" name="id_user">
                                  <?php
                                    foreach ($db->query('SELECT * FROM user') as $row) {
                                        echo '<option value="'.$row['id_user'].'">'.$row["identification_number"]." - ".$row["first_name"]." - ".$row["surname"].'</option>';
                                    }
                                  ?>
                                </select>
                                <label class="form-label" for="id_user">Usuario:</label>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-outline">
                                <select class="form-control" name="role">
                                  <?php
                                    $selectedUserId = $_POST['id_user'];

                                    $sql = '
                                    SELECT r.id_role, r.description
                                    FROM role r
                                    LEFT JOIN user_has_role uhr
                                        ON r.id_role = uhr.role_id
                                        AND uhr.user_id = :user_id
                                    WHERE uhr.user_id IS NULL
                                    ';

                                    $stmt = $db->prepare($sql);
                                    $stmt->execute(['user_id' => $selectedUserId]);

                                    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                                        echo '<option value="'.$row['id_role'].'">'.$row["description"].'</option>';
                                    }
                                  ?>
                                </select>
                                <label class="form-label" for="role">Rol:</label>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-outline">
                                <label class="mr-2">Estado:</label>
                                <div class=" form-check form-check-inline">
                                  <input type="radio" class="form-check-input" name="state" value="1" checked />
                                  <label class="form-check-label">Activo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" name="state" value="0" />
                                  <label class="form-check-label">Inactivo</label>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="row justify-content-end">
                            <div class="col-md-2 text-end">
                              <div class="form-outline">
                                <input id="boton" type="submit" class="btn btn-primary btn-block" value="Guardar"
                                  onclick="this.form.action ='?action=register'" />
                              </div>
                            </div>
                          </div>
                        </form>
                        <?php } ?>
                      </div>
                    </div>
                  </div>

                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <?php if (!empty($_GET['action']) && !empty($id)) {?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <?php
														$sql = "
															SELECT
                                user.id_user,
                                user.first_name,
                                user.surname,
                                role.description,
                                user_has_role.state,
                                user_has_role.id_user_has_role
                              FROM
                                user_has_role
                              JOIN user
                                ON user.id_user = user_has_role.user_id
                              JOIN role
                                ON role.id_role = user_has_role.role_id
															WHERE
                                user_id  = '$id' &&
																role_id = '$role'
														";
														$query = $db->query($sql);
										
														while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
													?>
                          <div class="row justify-content-end align-items-center mb-5">
                            <div class="col-md-11 d-flex align-items-center justify-content-center">
                              <h4 class="text-uppercase text-success">Actualizar Rol de usuario</h4>
                            </div>
                            <div class="col-md-1 d-flex align-items-center justify-content-end">
                              <a href="?action=&m=" class="btn btn-danger btn-block">X</a>
                            </div>
                          </div>

                          <div>
                            <input type="text" name="id_user_has_role" value="<?php echo $r['id_user_has_role']?>"
                              style="display: none" class="form-control" />
                          </div>

                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <input type="text" class="form-control" style="text-transform:uppercase;" name="role"
                                  value="<?php echo $r['first_name']." ".$r['surname']?>" disabled required />
                                <label class="form-label">Usuario:</label>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-outline">
                                <input type="text" class="form-control" style="text-transform:uppercase;" name="role"
                                  value="<?php echo $r['description']?>" maxlength="15" disabled required />
                                <label class="form-label" for="role">Tipo de Rol:</label>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-outline">
                                <label class="form-label mr-5">Estado</label>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" name="state" value="1"
                                    <?php echo $r['state'] === 1 ? 'checked' : '' ?> />
                                  <label class="form-check-label">Activo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input" name="state" value="0"
                                    <?php echo $r['state'] === 0 ? 'checked' : '' ?> />
                                  <label class="form-check-label">Inactivo</label>
                                </div>
                              </div>
                            </div>

                            <div class="col-md-2">
                              <div class="form-outline">
                                <input id="boton" type="submit" class="btn btn-primary btn-block" value="Actualizar"
                                  onclick="this.form.action = '?action=update';" />
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>

                      <?php
                            }
                          }
                        ?>
                    </div>
                  </div>
                </div>

                <?php if (!isset($_REQUEST['action']) || ($_REQUEST['action'] !== 'ver' && $_REQUEST['action'] !== 'edit')) : ?>
                <div class="col-md-12 text-center mt-4">
                  <?php
                    // Obtener el número total de registros
                    $sqlCount = "
                      SELECT COUNT(*) AS total
                      FROM user_has_role
                      WHERE state != 3
                    ";
                    $countQuery = $db->query($sqlCount);
                    $totalRecords = $countQuery->fetch(PDO::FETCH_ASSOC)['total'];

                    // Calcular el límite y el desplazamiento para la consulta actual
                    $recordsPerPage = 5; // Número de registros por página
                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // Página actual
                    $offset = ($currentPage - 1) * $recordsPerPage;

                    // Consulta para obtener los registros de la página actual con límite y desplazamiento
                    $sql = "
                      SELECT
                        user.first_name,
                        user.surname,
                        user_has_role.user_id,
                        user_has_role.role_id,
                        user_has_role.id_user_has_role,
                        role.description,
                        user_has_role.state
                      FROM user_has_role
                      JOIN user ON user.id_user = user_has_role.user_id
                      JOIN role ON role.id_role = user_has_role.role_id
                      WHERE role.state = 1
                      ORDER BY user_id, role_id ASC
                      LIMIT $offset, $recordsPerPage
                    ";
                    $query = $db->query($sql);

                    // Verificar si existen registros
                    $hasRecords = $query->rowCount() > 0;
                  ?>
                  <h4 class="mb-5 text-uppercase text-primary">Roles por Usuario</h4>
                  <?php if ($hasRecords) : ?>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <caption class="text-center">Listado de Resultados</caption>
                      <thead>
                        <tr>
                          <th>Usuario</th>
                          <th>Rol</th>
                          <th>Estado</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($row=$query->fetch(PDO::FETCH_ASSOC)): ?>
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
                              Update
                            </a>
                            <a class="btn btn-danger"
                              href="?action=delete&id_user_has_role=<?php echo $row['id_user_has_role'];?>"
                              onclick=" confirmDelete(event)">
                              Delete
                            </a>
                          </td>
                        </tr>
                        <?php endwhile ?>
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <nav aria-label="Page navigation">
                      <ul class="pagination justify-content-center">
                        <?php
                          // Calcular el número total de páginas
                          $totalPages = ceil($totalRecords / $recordsPerPage);
                          
                          // Mostrar el botón "Anterior" solo si no estamos en la primera página
                          if ($currentPage > 1) {
                              echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage - 1) . '">Anterior</a></li>';
                          }
                          
                          // Mostrar enlaces a las páginas individuales
                          for ($i = 1; $i <= $totalPages; $i++) {
                              echo '<li class="page-item';
                              if ($i == $currentPage) {
                                  echo ' active';
                              }
                              echo '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                          }
                          
                          // Mostrar el botón "Siguiente" solo si no estamos en la última página
                          if ($currentPage < $totalPages) {
                              echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage + 1) . '">Siguiente</a></li>';
                          }
                        ?>
                      </ul>
                    </nav>
                  </div>
                </div>
                <?php else: ?>
                <h4><?php echo "No se encontraron registros"; ?></h4>
                <?php endif ?>
              </div>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>

  <footer class="bg-light text-center text-lg-start">
    <div class="text-center p-3" style="background-color: hsl(0, 0%, 96%)">
      © 2023 Copyright:
      <a class="text-blue" href="https://github.com/Juan-Carlos-Estevez-Vargas/SoftEduRed">SoftEduRed.com</a>
    </div>
  </footer>

  <script>
  function confirmDelete(event) {
    event.preventDefault();

    Swal.fire({
      title: '¿Estás seguro de eliminar este registro?',
      text: "Esta acción no se puede deshacer.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = event.target.href;
      }
    });
  }
  </script>
</body>

</html>