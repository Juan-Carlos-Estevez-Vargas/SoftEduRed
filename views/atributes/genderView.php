<?php
	require_once "../../persistence/database/Database.php";
	require_once "../../persistence/atributes/Gender.php";
	//include "../indexs/cruds.php";
	$db = database::conectar();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new gender();
			$update->actualizar($_POST['gender'],$_POST['queryy'],$_POST['state']);
		} elseif ($action == 'register') {
			$insert = new gender();
			$insert ->registrar($_POST['gender'],$_POST['state']);
		} elseif ($action == 'delete') {
			$eliminar = new gender();
			$eliminar->eliminar($_GET['id_gender']);
		} elseif ($action == 'edit') {
			$id = $_GET['id_gender'];
		}
	}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Gnero</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
  <section class="h-100 bg-dark">
    <div class="container py-4 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
          <div class="card card-registration my-4">
            <div class="row g-0">
              <div class="col-xl-12">
                <div class="card-body p-md-5 text-black">
                  <h3 class="mb-5 text-uppercase text-center"><a href="?action=ver&m=1">New Record</a></h3>

                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12 mb-4">
                        <?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <h4 class="mb-5 text-uppercase text-center">Nuevo Registro</h4>

                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-outline">
                                <input id="space" type="text" name="doc" placeholder="Ej: Masculino, Femenino" required
                                  style="text-transform:uppercase" class="form-control" />
                                <label class="form-label">Género:</label>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-outline">
                                Activo <input id="space" type="radio" name="state" value="1" checked />
                                Inactivo <input id="space" type="radio" name="state" value="0" checked />
                                <label class="form-label">Estado</label>
                              </div>
                            </div>
                            <div class="col-auto">
                              <div class="form-outline">
                                <input id="boton" type="submit" class="btn btn-primary" value="Guardar"
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
                      <div class="col-md-12 mb-4">
                        <?php if (!empty($_GET['id_gender']) && !empty($_GET['action'])) { ?>
                        <form action="#" method="post" enctype="multipart/form-data">
                          <?php 
														$sql = "SELECT * FROM gender WHERE desc_gender = '$id'";
														$query = $db->query($sql);
														while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
													?>
                          <h4 class="mb-5 text-uppercase text-center">Actualizar Relación</h4>

                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-outline">
                                <input type="text" name="queryy" value="<?php echo $r['desc_gender']?>"
                                  style="display: none" />
                                <input type="text" name="gender" value="<?php echo $r['desc_gender']?>" required />
                                <label class="form-label">Tipo de Relación:</label>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-outline">
                                Activo <input type="radio" name="state" value="1"
                                  <?php echo $r['state'] === '1' ? 'checked' : '' ?> />
                                Inactivo <input type="radio" name="state" value="0"
                                  <?php echo $r['state'] === '0' ? 'checked' : '' ?> />
                                <label class="form-label">Estado</label>
                              </div>
                            </div>
                            <div class="col-auto">
                              <div class="form-outline">
                                <input id="boton" type="submit" class="btn btn-primary" value="Actualizar"
                                  onclick="this.form.action = '?action=update';" />
                              </div>
                            </div>
                          </div>
                        </form>
                        <?php } } ?>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12 text-center mt-5">
                    <?php
											$sql="SELECT * FROM gender" ; $query=$db ->query($sql);
    									if ($query->rowCount() > 0):
										?>
                    <h4 class="mb-5 text-uppercase">Registros</h4>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <caption>Attendant Role Information Results</caption>
                        <thead>
                          <tr>
                            <th>Género</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
                          <tr>
                            <td><?php echo $row['desc_gender']; ?></td>
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
                              <a href="?action=edit&id_gender=<?php echo $row['desc_gender'];?>">
                                Update
                              </a>
                              <a href="?action=delete&id_gender=<?php echo $row['desc_gender'];?>"
                                onclick="return confirm('¿Esta seguro de eliminar este usuario?')">
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
                  <h4>Mr.User DO NOT find registration</h4>
                  <?php endif; ?>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>