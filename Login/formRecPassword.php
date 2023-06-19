<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/favicon/favicon.ico">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous"
    >
    <title>Recuperar Contraseña</title>
</head>
<body>
    <main style="background-color: hsl(0, 0%, 96%)">
        <section class="container d-flex flex-column">
            <?php require_once "../persistence/Database/Database.php"; $db = database::conectar(); ?>
            <div class="row align-items-center justify-content-center text-center g-0 min-vh-100">
                <div class="col-lg-8 col-md-10 py-8 py-xl-0">
                    <div class="card shadow">
                        <div class="card-body p-6">
                            <div class="mb-4">
                                <h1 class="mb-1 fw-bold">Recuperar Contraseña</h1>
                                <p>Complete el formulario para restablecer su contraseña.</p>
                            </div>
                            <form  method="post" action="recoveryPassword.php">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_doc" id="Titulo" class="form-label">Tipo De Documento</label>
                                        <select id="form-control" class="form-control" name="tipo_doc">
                                            <?php
                                                foreach ($db->query('SELECT * FROM type_of_document') as $row) {
                                                    echo '
                                                        <option
                                                            value="'.$row['cod_document'].'">
                                                            '.$row["Des_doc"].'
                                                        </option>
                                                    ';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-outline">
                                            <label class="form-label" for="n_id">Número de Documento</label>
                                            <input
                                                id="Spacen"
                                                class="form-control"
                                                type="number"
                                                name="n_id"
                                                placeholder="N° de Identificación"
                                                required
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="p_seg" class="form-label">Pregunta de seguridad</label>
                                        <select id="question" class="form-control" name="p_seg">
                                            <?php
                                                foreach ($db->query('
                                                    SELECT * FROM security_question
                                                    WHERE state = 1
                                                ') as $row) {
                                                    echo '
                                                        <option
                                                            value="'.$row['question'].'">
                                                            '.$row["question"].'
                                                        </option>
                                                    ';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="n_id" class="form-label">
                                            Ingrese Su Respuesta De Seguridad
                                        </label>
                                        <input
                                            id="ans"
                                            class="form-control"
                                            type="text"
                                            name="r_seg"
                                            placeholder="Respuesta De Seguridad"
                                            required
                                        />
                                    </div>
                                </div>

                                <div class="mb-3 d-grid">
                                    <button id="buton" type="submit" class="btn btn-primary" name="a_registro">
                                        Validar
                                    </button>
                                </div>
                                <span>Regresar al <a id="boton" href="../index.php">Login</a></span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
