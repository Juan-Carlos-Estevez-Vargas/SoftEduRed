<?php
	require_once "../../persistence/database/Database.php";
	require_once "../../persistence/atributes/RelationshipDAO.php";

  $db = database::connect();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'register') {
			$registrar = new RelationshipDAO();
			$registrar->registerRelationship($_POST['relation'], $_POST['state']);
		} elseif ($action == 'update') {
			$update = new RelationshipDAO();
			$update->updateRecord($_POST['relation'], $_POST['queryy'], $_POST['state']);
		} elseif ($action == 'delete') {
			$eliminar = new RelationshipDAO();
				$eliminar->deleteRelationship($_GET['desc_relat']);
		} elseif ($action == 'edit') {
			$id = $_GET['desc_relat'];
		}
	}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Relación</title>
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
                    <a class="btn btn-success" href="?action=ver&m=1">Agregar Parentesco</a>
                  </h3>

                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <h4 class="mb-5 text-uppercase text-center text-success">Nuevo Parentesco</h4>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-outline">
                                <input id="space" type="text" name="relation" placeholder="Tipo de Relación" required
                                  style="text-transform:uppercase" class="form-control" />
                                <label class="form-label">Tipo de Parentesco:</label>
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
                        </form>
                        <?php } ?>
                      </div>
                    </div>
                  </div>

                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <?php if (!empty($_GET['desc_relat']) && !empty($_GET['action']) && !empty($id)) { ?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <?php
														$sql = "SELECT * FROM relationship WHERE desc_relationship = '$id'";
														$query = $db->query($sql);
														while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
													?>
                          <h4 class="mb-5 text-uppercase text-center text-success">Actualizar Parentesco</h4>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-outline">
                                <input id="Space" type="text" class="form-control" name="queryy"
                                  value="<?php echo $r['desc_relationship']?>" style="display: none" />
                                <input id="Space" type="text" class="form-control" name=" relation"
                                  value="<?php echo $r['desc_relationship']?>" required />
                                <label class="form-label">Tipo de Parentesco:</label>
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
											 $sql = "SELECT * FROM relationship";
											 $query = $db ->query($sql);
										 
											 if ($query->rowCount() > 0):
										?>
                    <h4 class="mb-5 text-uppercase text-primary">Parentescos</h4>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <caption class="text-center">Listado de Resultados</caption>
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
                            <td><?php echo $row['desc_relationship']; ?></td>
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
                                href="?action=edit&desc_relat=<?php echo $row['desc_relationship'];?>" />
                              Actualizar
                              </a>
                              <a class="btn btn-danger"
                                href="?action=delete&desc_relat=<?php echo $row['desc_relationship'];?>"
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