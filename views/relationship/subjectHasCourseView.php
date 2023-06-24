<?php
	require_once "../../persistence/relationship/SubjectHasCourseDAO.php";
	require_once "../../persistence/database/Database.php";

  $db = database::connect();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new SubjectCourseDAO();
			$update->updateSubjectHasCourse(
        $_POST['subj'], $_POST['subj2'], $_POST['course'],
        $_POST['course2'],$_POST['state']
      );
		} elseif ($action == 'register') {
			$insert = new SubjectCourseDAO();
			$insert->addSubjectHasCourse($_POST['course']);
		} elseif ($action == 'delete') {
			$delete = new SubjectCourseDAO();
			$delete->deleteSubjectHasCourse($_GET['subj'], $_GET['course']);
		} elseif ($action == 'edit') {
			$subj = $_GET['subj'];
      $course = $_GET['course'];
		}
	}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Materia por Curso</title>
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
                          <h4 class="mb-5 text-uppercase text-center text-success">Nueva Materia por Curso</h4>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-outline">
                                <select class="form-control" name="course">
                                  <?php
																		foreach ($db->query('SELECT * FROM course WHERE state = 1') as $row) {
																			echo '<option value="'.$row['cod_course'].'">'.$row["cod_course"].'</option>';
																		}
																	?>
                                </select>
                                <label class="form-label">Curso:</label>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-outline">
                                <?php
																	foreach ($db->query('SELECT * FROM subject where state= 1') as $row) { ?>
                                <input type="checkbox" name="<?php echo $row['n_subject']?>" />
                                <?php echo $row['n_subject'];?>
                                <input type="radio" name="state_<?php echo $row['n_subject']?>" value="1"
                                  checked />Active
                                <input type="radio" name="state_<?php echo $row['n_subject']?>" value="0"
                                  checked />Inactive
                                <?php } ?>
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
                        <?php if (!empty($_GET['subj']) && !empty($_GET['course']) && !empty($_GET['action'])) { ?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <?php
														$sql = "
															SELECT * FROM subject_has_course
															WHERE pk_fk_te_sub = '$subj' &&
																		pk_fk_course_stu = '$course'
														";
										
														$query = $db->query($sql);
														while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
													?>
                          <h4 class="mb-5 text-uppercase text-center text-success">Actualizar Materia por Curso</h4>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-outline">
                                <select class="form-control" name="subj">
                                  <?php
																		foreach ($db->query('SELECT * FROM subject WHERE state = 1') as $row) {
																			echo '<option value="'.$row['n_subject'].'">'.$row["n_subject"].'</option>';
																		}
																	?>
                                </select>
                                <label class="form-label">Materia:</label>
                              </div>
                            </div>

                            <div class="col-md-6">
                              <div class="form-outline">
                                <select class="form-control" name="course">
                                  <?php
																		foreach ($db->query('SELECT * FROM course WHERE state = 1') as $row) {
																			echo '<option value="'.$row['cod_course'].'">'.$row["cod_course"].'</option>';
																		}
																	?>
                                </select>
                                <label class="form-label">Curso:</label>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <div class="form-outline">
                                <label class="mr-5">Estado: </label>
                                <div class=" form-check form-check-inline">
                                  <input type="radio" name="state" value="1"
                                    <?php echo $r['state_sub_course'] === '1' ? 'checked' : '' ?> />
                                  <label class="form-check-label">Activo</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input type="radio" name="state" value="0"
                                    <?php echo $r['state_sub_course'] === '0' ? 'checked' : '' ?> />
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
                        <?php
														}
											 		}
												?>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 text-center mt-4">
                    <?php
											$sql = "SELECT * FROM subject_has_course ORDER BY pk_fk_te_sub ASC";
											$query = $db->query($sql);
										
											if ($query->rowCount() > 0):
										?>
                    <h4 class="mb-5 text-uppercase text-primary">Materias por Curso</h4>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <caption class="text-center">Listado de Resultados</caption>
                        <thead>
                          <tr>
                            <th>Curso</th>
                            <th>Materia</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
                          <tr>
                            <td><?php echo $row['pk_fk_course_stu']; ?></td>
                            <td><?php echo $row['pk_fk_te_sub']; ?></td>
                            <td>
                              <?php
																if ($row['state_sub_course'] == 1) {
																	echo "Activo";
																} else {
																	echo "Inactivo";
																}
															?>
                            </td>
                            <td>
                              <a class="btn btn-primary"
                                href="?action=edit&subj=<?php echo $row['pk_fk_te_sub'];?>&course=<?php echo $row['pk_fk_course_stu'];?>">
                                Actualizar
                              </a>
                              <a class="btn btn-danger"
                                href="?action=delete&subj=<?php echo $row['pk_fk_te_sub'];?>&course=<?php echo $row['pk_fk_course_stu'];?>"
                                onclick="confirmDelete(event)">
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