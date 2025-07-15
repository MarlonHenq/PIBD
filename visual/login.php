<!doctype html>
<html lang="en">
  <head>
    <title>Portal de Mobilidade - Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="../static/img/logo.png" type="image/x-icon" />

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="../static/css/style.css" />
  </head>
  <body class="bg-light">

    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
          <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
              <div class="text-center mb-4">
                <img src="../static/img/logo.png" alt="Portal Logo" class="img-fluid mb-3" style="max-width: 120px;">
                <h2 class="fw-bold">Login no Portal de Mobilidade</h2>
              </div>
              <form action="login.php" method="post">
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    required
                    autofocus
                  />
                </div>
                <div class="mb-3">
                  <label for="captcha" class="form-label">Captcha: 2 + 2</label>
                  <input
                    type="text"
                    class="form-control"
                    id="captcha"
                    name="captcha"
                    required
                  />
                </div>
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary">
                    Login
                  </button>
                </div>
              </form>
              <div class="text-center mt-3">
                <small>
                  Não tem uma conta?
                  <a href="register.php">Registre-se aqui</a>
                </small>
              </div>
            </div>
          </div>

          <div class="text-center mt-4">
            <img src="../static/img/secure.png" alt="Security Seal" class="img-fluid" style="max-width: 300px;">
            <p class="text-muted mt-2 small">&copy; 2025 Portal de Mobilidade. Todos os direitos reservados.</p>
          </div>
        </div>
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
  </body>
</html>