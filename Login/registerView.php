<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Bienvenidos</title>
    <link rel="shortcut icon" href="../images/register.ico" />
    <link rel="stylesheet" type="text/css" href="../style/style_reg.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <?php require_once "../persistence/Database/Database.php";
    $db = database::conectar(); ?>
    <section class="h-100 bg-dark">
        <div class="container py-5 h-100">
            <form method="post" action="register.php">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col">
                        <div class="card card-registration my-4">
                            <div class="row g-0">
                                <div class="col-xl-6 d-none d-xl-block">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/img4.webp"
                                        alt="Sample photo" class="img-fluid"
                                        style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;" />
                                </div>
                                <div class="col-xl-6">
                                    <div class="card-body p-md-5 text-black">
                                        <h3 class="mb-5 text-uppercase">Formulario de Registro</h3>
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="form-outline">
                                                    <select id="select" class="form-control" name="tipo_doc">
                                                        <?php
                                                        foreach ($db->query('SELECT * FROM type_of_document') as $row) {
                                                            echo '
                                                                <option
                                                                    value="' . $row['cod_document'] . '">
                                                                    ' . $row["Des_doc"] .
                                                                '</option>
                                                            ';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <label class="form-label" id="titulo">Tipo de Documento</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input type="text" id="space" class="form-control form-control-lg"
                                                        name="n_id" placeholder="N° de Identificación" required />
                                                    <label class="form-label" for="n_id">No° de Identificación</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input type="number" name="phone" id="phone" placeholder="Teléfono"
                                                        class="form-control form-control-lg" />
                                                    <label class="form-label" for="slname" id="tel">Teléfono</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input type="text" name="name" id="Spacen"
                                                        placeholder="Primer Nombre" class="form-control form-control-lg"
                                                        required />
                                                    <label class="form-label" for="name" id="name">Primer Nombre</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input type="text" name="sname" id="sspace"
                                                        placeholder="Segundo Nombre"
                                                        class="form-control form-control-lg" required />
                                                    <label class="form-label" for="sname" id="sname">
                                                        Segundo Nombre
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input type="text" name="lname" id="ape"
                                                        placeholder="Primer Apellido"
                                                        class="form-control form-control-lg" required />
                                                    <label class="form-label" for="lname" id="Apellido">
                                                        Primer Apellido
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input type="text" name="slname" id="sa"
                                                        placeholder="Segundo Apellido"
                                                        class="form-control form-control-lg" required />
                                                    <label class="form-label" for="slname" id="sape">
                                                        Segundo Apellido
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="form-outline">
                                                    <select id="slect" class="form-control" name="gender">
                                                        <?php
                                                        $result = $db->query('SELECT * FROM gender WHERE state = 1');
                                                        ?>
                                                        <?php foreach ($result as $row): ?>
                                                <opt        ion value="<?php echo $row['desc_gender']; ?>">
                                            <?php echo $row['desc_gender']; ?>
                                                      </op  tion>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <label id="gender" class="form-label">Género</label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input type="text" name="direc" id="dir" placeholder="Dirección"
                                                        class="form-control form-control-lg" required />
                                                    <label class="form-label" for="direc" id="direc">Dirección</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input type="email" name="email" id="mail"
                                                        placeholder="Correo electrónico"
                                                        class="form-control form-control-lg" required />
                                                    <label class="form-label" for="email" id="email">Correo</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input type="text" name="usern" id="User" placeholder="Usuario"
                                                        class="form-control form-control-lg" required />
                                                    <label class="form-label" for="usern" id="nickname">Usuario</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <input type="password" name="pass" id="pass"
                                                        placeholder="Contraseña" class="form-control form-control-lg"
                                                        maxlength="20" minlength="10" required />
                                                    <label class="form-label" for="pass" id="pasw">Contraseña</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="form-outline">
                                                    <input type="file" name="usern" id="photo"
                                                        placeholder="Imagen de perfil"
                                                        class="form-control form-control-lg" accept="image/*" />
                                                    <label class="form-label" for="photo" id="photo">
                                                        Foto de perfil
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="form-outline">
                                                    <select id="listp" class="form-control" name="p_seg">
                                                        <?php $result = $db->query('
                                                        SELECT * FROM security_question
                                                        WHERE state = 1
                                                    ');
                                                        ?>
                                                        <?php foreach ($result as $row): ?>
                                <opt                        ion value="<?php echo $row['question']; ?>">
                                  <?php echo $row['question']; ?>
                                </op                        tion>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <label class="form-label" for="p_seg" id="ask">
                                                        Pregunta de seguridad
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="form-outline">
                                                    <input type="text" name="r_seg" id="ans"
                                                        placeholder="Respuesta de seguridad"
                                                        class="form-control form-control-lg"
                                                        style="text-transform:uppercase" required />
                                                    <label class="form-label" for="p_seg" id="answer">
                                                        Ingrese Su Respuesta De Seguridad (MAYÚSCULA)
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end pt-3">
                                            <button id="boton" type="submit" class="btn btn-primary btn-lg"
                                                name="a_registro">
                                                Registrar
                                            </button>
                                            <a id="reg" href="../index.php" class="btn btn-ligth btn-lg ms-2">
                                                Regresar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>

</html>