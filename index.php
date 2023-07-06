<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  <style>
  /* Ocultar el contenido del colegio en pantallas móviles */
  @media (max-width: 767px) {
    .college-info {
      display: none;
    }
  }
  </style>
  <title>Bienvenidos</title>
</head>

<body>
  <section>
    <div class="px-4 py-5 px-md-5 text-center text-lg-center" style="background-color: hsl(0, 0%, 96%)">
      <div class="container">
        <?php
          require_once "persistence/database/Database.php";
          $db = Database::connect();
          session_start();

          if (isset($_SESSION['active']) && isset($_SESSION['ROL_ID'])) {
            $sesion = $_SESSION['ROL_ID'];

            if ($sesion === 'ADMINISTRADOR') {
              header("location:utils/index.php?role=e");
              exit;
            } elseif ($sesion === 'ATTENDANT') {
              header("location:utils/index.php?role=a");
              exit;
            } elseif ($sesion === 'STUDENT') {
              header("location:utils/index.php?role=s");
              exit;
            } elseif ($sesion === 'TEACHER') {
              header("location:utils/index.php?role=t");
              exit;
            }
          }
        ?>
        <div class="row gx-lg-5 align-items-center">
          <div class="col-lg-7 mb-5 mb-lg-0 college-info">
            <h1 class="my-5 display-3 fw-bold ls-tight">
              Liceo Campestre de Prueba <br />
            </h1>
            <p style="color: hsl(217, 10%, 50.8%)">
              Lorem ipsum dolor sit amet consectetur adipisicing elit.
              Eveniet, itaque accusantium odio, soluta, corrupti aliquam
              quibusdam tempora at cupiditate quis eum maiores libero
              veritatis? Dicta facilis sint aliquid ipsum atque?
            </p>
          </div>

          <div class="col-lg-5 mb-5 mb-lg-0">
            <div class="card">
              <div class="card-body py-5 px-md-5 text-left">
                <form id="form-login" method="POST" action="controllers/loginController.php">
                  <h1 class="text-primary mb-4 text-center">Iniciar Sesión</h1>
                  <div class="row">
                    <div class="col-md-12 mb-4">
                      <div class="form-outline">
                        <input class="form-control" type="text" name="username" id="username" placeholder="Usuario"
                          required />
                        <label class="form-label" for="username">Usuario</label>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12 mb-4">
                      <div class="form-outline">
                        <input class="form-control" type="password" name="password" id="password"
                          placeholder="Contraseña" required />
                        <label class="form-label " for="password">Contraseña</label>
                      </div>
                    </div>
                  </div>

                  <div class="row mb-4">
                    <div class="col">
                      <button type="submit" name="g-recaptcha-response"
                        class="g-recaptcha btn btn-primary btn-block col"
                        data-sitekey="6LfljvYmAAAAABfCT7iAG0pjC8fWf2DYFM3qpB4p" data-callback='onSubmit'
                        data-action='submit'>
                        Iniciar Sesión
                      </button>
                    </div>
                  </div>

                  <div class="col text-center">
                    <a href="login/formRecPassword.php">Olvidé mi contraseña</a>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-light text-center text-lg-start">
    <div class="text-center p-3" style="background-color: hsl(0, 0%, 96%)">
      © <?php echo date('Y'); ?> SoftEduRed.com
    </div>
  </footer>

  <script>
  function onSubmit(token) {
    document.getElementById("form-login").submit();
  }
  </script>
</body>

</html>