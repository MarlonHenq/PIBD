<!doctype html>
<html lang="en">
  <head>
    <title>Portal de Mobilidade - Registrar</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="../static/img/logo.png" type="image/x-icon" />

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="../static/css/style.css" />
  </head>

  <body>
    <div class="container min-vh-100 d-flex flex-column justify-content-center">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
          <div class="register-card">
            <div class="text-center">
              <img
                src="../static/img/logo.png"
                alt="Logo"
                class="img-fluid mb-3"
                style="max-width: 100px"
              />
              <h2 class="mb-4">Criar Sua Conta no Portal de Mobilidade</h2>
            </div>
            <form action="register.php" method="post">
              <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo</label>
                <input
                  type="text"
                  class="form-control"
                  id="nome"
                  name="nome"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  name="email"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="captcha" class="form-label">Captcha: 2 + 2</label>
                <input
                  type="text"
                  class="form-control"
                  id="captcha"
                  name="captcha"
                  placeholder="Resposta"
                  required
                />
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Registrar</button>
              </div>
            </form>
            <div class="text-center mt-3">
              <p class="mb-0">
                Já tem uma conta?
                <a href="index.php" class="text-decoration-none">Faça login aqui</a>
              </p>
            </div>
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