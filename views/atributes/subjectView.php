<?php
	require_once "../../persistence/atributes/SubjectDAO.php";
	require_once "../../persistence/database/Database.php";

  $db = database::connect();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new SubjectDAO();
			$update->updateSubject($_POST['subject'], $_POST['state'], $_POST['tdoc_t'], $_POST['id_user_t'], $_POST['queryy']);
		} elseif ($action == 'register') {
			$insert = new SubjectDAO();
			$insert ->registerSubject($_POST['subject'], $_POST['state'], $_POST['tdoc_t'], $_POST['id_user_t']);
		} elseif ($action == 'delete') {
			$delete = new SubjectDAO();
			$delete->deleteSubject($_GET['id_subject']);
		} elseif ($action == 'edit') {
			$id = $_GET['id_subject'];
		}
	}
?>

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
    <div class="container py-4 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
          <div class="card card-registration my-4">
            <div class="row g-0">
              <div class="col-xl-12">
                <div class="card-body p-md-5 text-black" style="background-color: hsl(0, 0%, 96%)">
                  <h3 class="text-center d-flex justify-content-center justify-content-md-end">
                    <a class="btn btn-success" href="?action=ver&m=1">Agregar Materia</a>
                  </h3>

                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <h4 class="mb-5 text-uppercase text-center text-success">Nueva Materia</h4>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-outline">
                                <input id="space" class="form-control" type="text" name="subject"
                                  placeholder="Materia/Asunto" maxlength="30" required
                                  style="text-transform:uppercase" />
                                <label class="form-label">Materia:</label>
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

                            <div class="col-md-2">
                              <div class="form-outline">
                                <input id="boton" type="submit" class="btn btn-primary btn-block" value="Guardar"
                                  onclick="this.form.action ='?action=register'" />
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-outline">
                                <select class="form-control" name="tdoc_t">
                                  <?php
																		foreach ($db->query("
																			SELECT cod_document, Des_doc FROM type_of_document
																			JOIN user ON cod_document = pk_fk_cod_doc
																			JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user
																			WHERE pk_fk_role = 'TEACHER'"
																		) as $row) {
																			echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
																		}
																	?>
                                </select>
                                <label class="form-label">Tipo de documento Docente:</label>
                              </div>
                            </div>

                            <div class="col-md-2">
                              <div class="form-outline">
                                <select class="form-control" name="id_user_t">
                                  <?php
																		foreach ($db->query("
																			SELECT id_user FROM user
																			JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user
																			WHERE pk_fk_role = 'TEACHER'"
																		) as $row) {
																			echo '<option value="'.$row['id_user'].'">'.$row["id_user"].'</option>';
																		}
																	?>
                                </select>
                                <label class="form-label">Número de identificación Docente:</label>
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
														$sql = "SELECT * FROM subject WHERE n_subject = '$id'";
														$query = $db->query($sql);
														while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
													?>
                          <h4 class="mb-5 text-uppercase text-center text-success">Actualizar Materia</h4>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-outline">
                                <input id="space" class="form-control" type="text" name="queryy"
                                  value="<?php echo $r['n_subject']?>" style="display: none" />
                                <input id="space" class="form-control" type="text" name="subject"
                                  value="<?php echo $r['n_subject']?>" maxlength="30" required />
                                <label class="form-label">Asunto:</label>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-outline">
                                <label class="mr-5">Estado: </label>
                                <div class=" form-check form-check-inline">
                                  <input type="radio" name="state" value="1"
                                    <?php echo $r['state'] === '1' ? 'checked' : '' ?> />
                                  <label class="form-check-label">Activo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" name="state" value="0"
                                    <?php echo $r['state'] === '0' ? 'checked' : '' ?> />
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

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-outline">
                                <select class="form-control" name="tdoc_t">
                                  <?php
																		foreach ($db->query("
																			SELECT id_user FROM user
																			JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user
																			WHERE pk_fk_role = 'TEACHER'"
																		) as $row) {
																			echo '<option value="'.$row['id_user'].'">'.$row["id_user"].'</option>';
																		}
																	?>
                                </select>
                                <label class="form-label">Tipo de documento Docente:</label>
                              </div>
                            </div>

                            <div class="col-md-2">
                              <div class="form-outline">
                                <select class="form-control" name="id_user_t">
                                  <?php
																		foreach ($db->query("
																			SELECT id_user FROM user
																			JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user
																			WHERE pk_fk_role = 'TEACHER'"
																		) as $row) {
																			echo '<option value="'.$row['id_user'].'">'.$row["id_user"].'</option>';
																		}
																	?>
                                </select>
                                <label class="form-label">Número de identificación Docente:</label>
                              </div>
                            </div>
                          </div>
                        </form>
                        <?php } } ?>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 text-center mt-4">
                    <?php
											$sql = "SELECT * FROM subject";
											$query = $db ->query($sql);
										
											if ($query->rowCount() > 0):
										?>
                    <h4 class="mb-5 text-uppercase text-primary">Materias</h4>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <caption class="text-center">Listado de Resultados</caption>
                        <thead>
                          <tr>
                            <th>Asunto</th>
                            <th>Estado</th>
                            <th>Tipo de Documento Docente</th>
                            <th>Número de identificación Docente</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
                          <tr>
                            <td><?php echo $row['n_subject']; ?></td>
                            <td>
                              <?php
																if ($row['state'] == 1) {
																	echo "Activo";
																} else {
																	echo "Inactivo";
																}
															?>
                            </td>
                            <td><?php echo $row['fk_tdoc_user_teacher']; ?></td>
                            <td><?php echo $row['fk_id_user_teacher']; ?></td>
                            <td>
                              <a class="btn btn-primary"
                                href=" ?action=edit&id_subject=<?php echo $row['n_subject'];?>">
                                Actualizar
                              </a>
                              <a class="btn btn-danger" href="?action=delete&id_subject=<?php echo $row['n_subject'];?>"
                                onclick="return confirm('¿Esta seguro de eliminar este usuario?')">
                                Eliminar
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
</body>

</html>