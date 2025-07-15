<!doctype html>
<html lang="en">
  <head>
    <title>Ônibus em Rota - Veículos</title>
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
                        <a class="nav-link" href="pontos.php">Pontos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="veiculos.php">Veículos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="itinerarios.php">Itinerários</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Sair</a>
                        </li>
                    <?php else: ?>
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
            <h1>Veículos</h1>
            <?php if ($is_admin): ?>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVehicleModal">
                    <i class="fas fa-plus me-2"></i> Cadastrar Veículo
                </button>
            <?php endif; ?>
        </div>
        <p class="text-muted">Gerencie os veículos e suas vinculações com linhas</p>

        <?php if ($alert_message): ?>
            <div class="alert alert-<?= $alert_type ?> mt-3"><?= $alert_message ?></div>
        <?php endif; ?>

        <div class="mb-4">
            <form action="veiculos.php" method="GET" class="input-group">
                <input type="text" class="form-control" placeholder="Buscar veículos por placa, modelo ou linha..." name="search" value="<?= htmlspecialchars($search_term) ?>">
                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
            </form>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php if (!empty($veiculos)): ?>
                <?php foreach ($veiculos as $veiculo): ?>
                    <div class="col">
                        <div class="vehicle-card">
                            <?php if ($is_admin): ?>
                                <div class="actions">
                                    <a href="#" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="deleteVeiculo.php?id=<?= htmlspecialchars($veiculo['id_veiculo']) ?>" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este veículo?');"><i class="fas fa-trash-alt text-danger"></i></a>
                                </div>
                            <?php endif; ?>
                            <h5 class="fw-bold"><?= htmlspecialchars($veiculo['placa']) ?></h5>
                            <p class="text-muted mb-2"><?= htmlspecialchars($veiculo['modelo']) ?></p>

                            <div class="info-row">
                                <strong>Capacidade:</strong> <?= htmlspecialchars($veiculo['capacidade']) ?> passageiros
                            </div>
                            <?php if ($veiculo['tipo'] === 'onibus' && !empty($veiculo['itinerario_nome'])): ?>
                                <div class="info-row">
                                    <strong>Linha:</strong> <span class="badge bg-primary"><?= htmlspecialchars($veiculo['itinerario_nome']) ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="mt-3">
                                <a href="#" class="btn btn-sm btn-outline-primary">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>Nenhum veículo encontrado.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($is_admin): ?>
    <div class="modal fade" id="addVehicleModal" tabindex="-1" aria-labelledby="addVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVehicleModalLabel">Cadastrar Novo Veículo (Ônibus)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="veiculos.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="addVeiculo" value="1">
                        <h6>Dados Gerais do Veículo</h6>
                        <div class="mb-3">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" required>
                        </div>
                        <div class="mb-3">
                            <label for="capacidade" class="form-label">Capacidade (passageiros)</label>
                            <input type="number" class="form-control" id="capacidade" name="capacidade" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="placa" class="form-label">Placa</label>
                            <input type="text" class="form-control" id="placa" name="placa" required maxlength="7">
                        </div>
                        <div class="mb-3">
                            <label for="quilometragem" class="form-label">Quilometragem</label>
                            <input type="number" class="form-control" id="quilometragem" name="quilometragem" min="0" required>
                        </div>

                        <h6 class="mt-4">Detalhes do Ônibus</h6>
                        <div class="mb-3">
                            <label for="id_itinerario" class="form-label">Linha/Itinerário</label>
                            <select class="form-select" id="id_itinerario" name="id_itinerario" required>
                                <option value="">Selecione um itinerário</option>
                                <?php foreach ($itinerarios as $itinerario): ?>
                                    <option value="<?= htmlspecialchars($itinerario['id_itinerario']) ?>">
                                        <?= htmlspecialchars($itinerario['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="acessibilidade" name="acessibilidade">
                            <label class="form-check-label" for="acessibilidade">Acessibilidade</label>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="ar_condicionado" name="ar_condicionado">
                            <label class="form-check-label" for="ar_condicionado">Ar Condicionado</label>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="wifi" name="wifi">
                            <label class="form-check-label" for="wifi">Wi-Fi</label>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="cameras" name="cameras">
                            <label class="form-check-label" for="cameras">Câmeras</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar Veículo</button>
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