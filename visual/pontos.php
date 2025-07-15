<!doctype html>
<html lang="en">
  <head>
    <title>Ônibus em Rota - Pontos de Ônibus</title>
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
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../static/img/logo.png" alt="Logo Ônibus em Rota" width="30" height="30" class="d-inline-block align-text-top me-2">
                Ônibus em Rota
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="pontos.php">Pontos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Veículos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="itinerarios.php">Itinerários</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): // Se o usuário está logado (admin ou comum) ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Sair</a>
                        </li>
                    <?php else: // Se o usuário NÃO está logado ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Registro</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Pontos de Ônibus</h1>
            <?php if ($is_admin): // Botão de cadastro apenas para admin ?>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPointModal">
                    <i class="fas fa-plus me-2"></i> Cadastrar Ponto
                </button>
            <?php endif; ?>
        </div>
        <p class="text-muted">Gerencie os pontos de ônibus do sistema</p>

        <?php if ($alert_message): ?>
            <div class="alert alert-<?= $alert_type ?> mt-3"><?= $alert_message ?></div>
        <?php endif; ?>

        <div class="mb-4">
            <form action="pontos.php" method="GET" class="input-group">
                <input type="text" class="form-control" placeholder="Buscar pontos por endereço..." name="search" value="<?= htmlspecialchars($search_term) ?>">
                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
            </form>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php if (!empty($pontos)): ?>
                <?php foreach ($pontos as $ponto): ?>
                    <div class="col">
                        <div class="point-card">
                            <?php if ($is_admin): // Ícones de editar/excluir apenas para admin ?>
                                <div class="actions">
                                    <a href="#" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="deletePonto.php?id=<?= htmlspecialchars($ponto['codigo']) ?>" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este ponto de ônibus?');"><i class="fas fa-trash-alt text-danger"></i></a>
                                </div>
                            <?php endif; ?>
                            <h5 class="fw-bold">Ponto <?= htmlspecialchars($ponto['codigo']) ?></h5>
                            <p class="text-muted mb-2"><?= htmlspecialchars($ponto['endereco']) ?></p>
                            <div class="attributes mb-2">
                                <?php if ($ponto['cobertura']): ?><span>Cobertura</span><?php endif; ?>
                                <?php if ($ponto['banco']): ?><span>Banco</span><?php endif; ?>
                                <?php if ($ponto['iluminacao']): ?><span>Iluminação</span><?php endif; ?>
                                <?php if ($ponto['acessibilidade']): ?><span>Acessibilidade</span><?php endif; ?>
                            </div>
                            <small class="text-muted">Código: <?= htmlspecialchars($ponto['codigo']) ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>Nenhum ponto de ônibus encontrado.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($is_admin): // Modal de cadastro apenas para admin ?>
    <div class="modal fade" id="addPointModal" tabindex="-1" aria-labelledby="addPointModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPointModalLabel">Cadastrar Novo Ponto de Ônibus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="pontos.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="addPonto" value="1">
                        <div class="mb-3">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="cobertura" name="cobertura">
                            <label class="form-check-label" for="cobertura">Tem cobertura</label>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="banco" name="banco">
                            <label class="form-check-label" for="banco">Tem banco</label>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="iluminacao" name="iluminacao">
                            <label class="form-check-label" for="iluminacao">Tem iluminação</label>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="acessibilidade" name="acessibilidade">
                            <label class="form-check-label" for="acessibilidade">Tem acessibilidade</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar Ponto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>
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