<?php require_once "../controllers/subjectController.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Materia</title>
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
                    <a class="btn btn-success" href="?action=ver&m=1">Agregar Materia</a>
                  </h3>
                  <?php endif; ?>

                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <div class="row justify-content-end align-items-center mb-5">
                            <div class="col-md-11 d-flex align-items-center justify-content-center">
                              <h4 class="text-uppercase text-success">Nueva Materia</h4>
                            </div>
                            <div class="col-md-1 d-flex align-items-center justify-content-end">
                              <a href="?action=&m=" class="btn btn-danger btn-block">X</a>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-5">
                              <div class="form-outline">
                                <input class="form-control" type="text" name="subject" placeholder="Materia"
                                  maxlength="30" required style="text-transform:uppercase" />
                                <label class="form-label">Materia:</label>
                              </div>
                            </div>

                            <div class="col-md-5">
                              <div class="form-outline">
                                <select class="form-control" name="teacher_id">
                                  <?php
																		foreach ($db->query("
                                      SELECT u.*, t.id_teacher
                                      FROM `user` AS u
                                      INNER JOIN `user_has_role` AS uhr ON u.id_user = uhr.user_id
                                      INNER JOIN `role` AS r ON uhr.role_id = r.id_role
                                      INNER JOIN `teacher` AS t ON u.id_user = t.user_id
                                      WHERE r.description = 'DOCENTE'
                                    ") as $row) {
																			echo '<option value="'.$row['id_teacher'].'">'.$row["first_name"].' '.$row["surname"].'</option>';
																		}
																	?>
                                </select>
                                <label class="form-label">Docente:</label>
                              </div>
                            </div>

                            <div class="col-md-2">
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
                        <?php if (!empty($_GET['id_subject']) && !empty($_GET['action']) && !empty($id)) { ?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <?php
														$sql = "SELECT * FROM subject WHERE id_subject = '$id'";
														$query = $db->query($sql);
														while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
													?>
                          <div class="row justify-content-end align-items-center mb-5">
                            <div class="col-md-11 d-flex align-items-center justify-content-center">
                              <h4 class="text-uppercase text-success">Actualizar Materia</h4>
                            </div>
                            <div class="col-md-1 d-flex align-items-center justify-content-end">
                              <a href="?action=&m=" class="btn btn-danger btn-block">X</a>
                            </div>
                          </div>

                          <div>
                            <input type="text" style="display: none;" value="<?php echo $r['id_subject'];?>"
                              name="id_subject" />
                          </div>

                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-outline">
                                <input class="form-control" type="text" name="subject"
                                  value="<?php echo $r['description']?>" maxlength="30" required />
                                <label class="form-label">Asunto:</label>
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

                            <div class="col-md-3">
                              <div class="form-outline">
                                <select class="form-control" name="teacher_id">
                                  <?php
																		foreach ($db->query("
                                      SELECT u.*, t.id_teacher
                                      FROM `user` AS u
                                      INNER JOIN `user_has_role` AS uhr ON u.id_user = uhr.user_id
                                      INNER JOIN `role` AS r ON uhr.role_id = r.id_role
                                      INNER JOIN `teacher` AS t ON u.id_user = t.user_id
                                      WHERE r.description = 'DOCENTE'
                                    ") as $row) {
																			echo '<option value="'.$row['id_teacher'].'">'.$row["first_name"].' '.$row["surname"].'</option>';
																		}
																	?>
                                </select>
                                <label class="form-label">Docente:</label>
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
                        <?php } } ?>
                      </div>
                    </div>
                  </div>

                  <?php if (!isset($_REQUEST['action']) || ($_REQUEST['action'] !== 'ver' && $_REQUEST['action'] !== 'edit')) : ?>
                  <div class="col-md-12 text-center mt-4">
                    <?php
											// Obtener el número total de registros
                      $sqlCount = "
                        SELECT COUNT(*) AS total
                        FROM subject
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
                          SELECT u.first_name, u.surname, s.description, s.id_subject, s.state
                          FROM `user` AS u
                          INNER JOIN `user_has_role` AS uhr ON u.id_user = uhr.user_id
                          INNER JOIN `role` AS r ON uhr.role_id = r.id_role
                          INNER JOIN `teacher` AS t ON u.id_user = t.user_id
                          inner join `subject` AS s ON t.id_teacher = s.teacher_id
                          WHERE r.description = 'DOCENTE'
                          LIMIT $offset, $recordsPerPage
                      ";
                      $query = $db->query($sql);

                      // Verificar si existen registros
                      $hasRecords = $query->rowCount() > 0;
										?>
                    <h4 class="mb-5 text-uppercase text-primary">Materias</h4>
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
                            <th>Materia</th>
                            <th>Docente</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
                          <tr>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['first_name'].' '.$row['surname']; ?></td>
                            <?php
                              if ($row['state'] == 1) {
                                echo "<td class='text-success'>Activo</td>";
                              } else {
                                echo "<td class='text-warning'>Inactivo</td>";
                              }
                            ?>
                            <td>
                              <a class="btn btn-primary"
                                href=" ?action=edit&id_subject=<?php echo $row['id_subject'];?>">
                                Actualizar
                              </a>
                              <a class="btn btn-danger"
                                href="?action=delete&id_subject=<?php echo $row['id_subject'];?>"
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