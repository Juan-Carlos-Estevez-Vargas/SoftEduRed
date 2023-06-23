<?php
	require_once "../../persistence/database/Database.php";
	require_once "../../persistence/relationship/RoleHasUserDAO.php";

  $db = database::connect();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new RoleUserDAO();
			$update->updateUserRoles(
				$_POST['tdoc_r'], $_POST['tdoc_r2'], $_POST['id_user_r'], $_POST['id_user_r2'],
				$_POST['role'], $_POST['role2'], $_POST['state']
			);
		} elseif ($action == 'register') {
			$insert = new RoleUserDAO();
			$insert ->registerUserWithRolesAndStates($_POST['tdoc_r'], $_POST['id_user_r']);
		} elseif ($action == 'delete') {
			$delete = new RoleUserDAO();
			$delete->deleteUserRole($_GET['tdoc_r'], $_GET['id_user_r'], $_GET['role']);
		} elseif ($action == 'edit') {
			$id_r = $_GET['id_user_r'];
			$tdoc_r = $_GET['tdoc_r'];
			$role = $_GET['role'];
		}
	}
?>

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
    <div class="container py-4 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
          <div class="card card-registration my-4">
            <div class="row g-0">
              <div class="col-xl-12">
                <div class="card-body p-md-5 text-black" style="background-color: hsl(0, 0%, 96%)">
                  <h3 class="text-center d-flex justify-content-center justify-content-md-end">
                    <a class="btn btn-success" href="?action=ver&m=1">Agregar Registro</a>
                  </h3>

                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <h4 class="mb-5 text-uppercase text-center text-success">Nuevo Rol de Usuario</h4>

                          <div class="row">
                            <div class="col-md-5">
                              <div class="form-outline">
                                <select class="form-control" name="tdoc_r">
                                  <?php
																		foreach ($db->query('SELECT * FROM type_of_document') as $row) {
																				echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
																		}
																	?>
                                </select>
                                <label class="form-label">Tipo de Documento:</label>
                              </div>
                            </div>

                            <div class="col-md-5">
                              <div class="form-outline">
                                <select class="form-control" name="id_user_r">
                                  <?php
																		foreach ($db->query('SELECT * FROM user') as $row) {
																			echo '<option value="'.$row['id_user'].'">'.$row["id_user"]."-".$row["first_name"]."-".$row["surname"].'</option>';
																		}
																	?>
                                </select>
                                <label class="form-label">Número de Identificación:</label>
                              </div>
                            </div>

                            <div class="col-md-2">
                              <div class="form-outline">
                                <input id="boton" type="submit" class="btn btn-primary btn-block" value="Guardar"
                                  onclick="this.form.action ='?action=register'" />
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-12">
                              <label class="mr-3">Tipo de Rol:</label>
                              <div class="form-outline">
                                <?php foreach ($db->query('SELECT * FROM role where state= 1') as $row) { ?>
                                <div class="col-md-6">
                                  <div class="form-check">
                                    <input type="checkbox" class="form-check-input"
                                      name="<?php echo $row['desc_role']?>" />
                                  </div>
                                </div>
                                <span class="ml-8"><?php echo $row['desc_role'];?></span>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input"
                                    name="state_<?php echo $row['desc_role']?>" value="1" checked />
                                  <label class="form-check-label mr-3">Activo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" class="form-check-input"
                                    name="state_<?php echo $row['desc_role']?>" value="0" checked />
                                  <label class="form-check-label">Inactivo</label>
                                </div>
                                <?php } ?>
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
                        <?php if (!empty($_GET['tdoc_r']) && !empty($_GET['id_user_r']) && !empty($_GET['role']) && !empty($_GET['action']) && !empty($id_r)) {?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <?php
														$sql = "
															SELECT * FROM user_has_role
															WHERE tdoc_role = '$tdoc_r' &&
																	pk_fk_id_user  = '$id_r' &&
																	pk_fk_role = '$role'
														";
														$query = $db->query($sql);
										
														while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
													?>
                          <h4 class="mb-5 text-uppercase text-center text-success">Actualizar Rol de Usuario</h4>

                          <div class="row">
                            <div class="col-md-5">
                              <div class="form-outline">
                                <select class="form-control" name="tdoc_r">
                                  <?php
																		foreach ($db->query('SELECT * FROM type_of_document') as $row) {
																			echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
																		}
																	?>
                                  <input type="text" name="tdoc_r2" value="<?php echo $r['tdoc_role']?>"
                                    style="display: none" class="form-control" />
                                  <label class="form-label">Tipo de Documento:</label>
                              </div>
                            </div>

                            <div class="col-md-5">
                              <div class="form-outline">
                                <select class="form-control" name="id_user_r">
                                  <?php
																		foreach ($db->query('SELECT * FROM user') as $row) {
																			echo '<option value="'.$row['id_user'].'">'.$row["id_user"].'</option>';
																		}
																	?>
                                </select>
                                <input type="text" name="id_user_r2" value="<?php echo $r['pk_fk_id_user']?>"
                                  style="display: none" />
                                <label class="form-label">Número de Identificación:</label>
                              </div>
                            </div>

                            <div class="col-md-2">
                              <div class="form-outline">
                                <input id="boton" type="submit" class="btn btn-primary btn-block" value="Actualizar"
                                  onclick="this.form.action = '?action=update';" />
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-5">
                              <div class="form-outline">
                                <select class="form-control" name="role">
                                  <?php
																		foreach ($db->query('SELECT * FROM role WHERE state=1') as $row) {
																			echo '<option value="'.$row['desc_role'].'">'.$row["desc_role"].'</option>';
																		}
																	?>
                                </select>
                                <input type="text" name="role2" value="<?php echo $r['pk_fk_role']?>"
                                  style="display: none" />
                                <label class="form-label">Rol:</label>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-outline">
                                <label class="mr-5">Estado: </label>
                                <div class=" form-check form-check-inline">
                                  <input id="space" type="radio" class="form-check-input" name="state" value="1"
                                    checked />
                                  <label class="form-check-label">Activo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input id="space" type="radio" class="form-check-input" name="state" value="0" />
                                  <label class="form-check-label">Inactivo</label>
                                </div>
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

                <div class="col-md-12 text-center mt-4">
                  <?php
										$sql = "
											SELECT * FROM user_has_role
											WHERE state = 1
											ORDER BY tdoc_role, pk_fk_id_user ASC
										";
										$query = $db ->query($sql);
									
										if ($query->rowCount()>0):
									?>
                  <h4 class="mb-5 text-uppercase text-primary">Registros</h4>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <caption class="text-center">Listado de Resultados</caption>
                      <thead>
                        <tr>
                          <th>Tipo de Documento</th>
                          <th>Número de Identificación</th>
                          <th>Rol</th>
                          <th>Estado</th>
                          <th>Acciones</th>

                      </thead>
                      <tbody>
                        <?php while ($row=$query->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                          <td><?php echo $row['tdoc_role']; ?></td>
                          <td><?php echo $row['pk_fk_id_user']; ?></td>
                          <td><?php echo $row['pk_fk_role']; ?></td>
                          <td>
                            <?php
																if ($row['state'] == 1) {
																	echo "Activo";
																} else {
																	echo "Inactivo";
																}
															?>
                          </td>
                          <td>
                            <a class="btn btn-primary"
                              href="?action=edit&tdoc_r=<?php echo $row['tdoc_role'];?>&id_user_r=<?php echo $row['pk_fk_id_user'];?>&role=<?php echo $row['pk_fk_role'];?>">
                              Update
                            </a>
                            <a class="btn btn-danger"
                              href="?action=delete&tdoc_r=<?php echo $row['tdoc_role'];?>&id_user_r=<?php echo $row['pk_fk_id_user'];?>&role=<?php echo $row['pk_fk_role'];?>"
                              onclick="confirmDelete(event)">
                              Delete
                            </a>
                          </td>
                        </tr>
                        <?php endwhile ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <?php else: ?>
                <h4>No se encontraron registros</h4>
                <?php endif; ?>
              </div>
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