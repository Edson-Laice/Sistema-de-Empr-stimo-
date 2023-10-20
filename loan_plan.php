<?php
    date_default_timezone_set("Etc/GMT+8");
    require_once 'session.php';
    require_once 'class.php';
    $db = new db_class();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistema de Gerenciamento de Empréstimos</title>
    <link href="fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="css/dataTables.bootstrap4.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Envoltório da Página -->
    <div id="wrapper">

        <!-- Barra Lateral -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Marca da Barra Lateral -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3">PAINEL DE ADMIN</div>
            </a>

            <!-- Item de Navegação - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="home.php">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Início</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="loan.php">
                    <i class="fas fa-fw fas fa-comment-dollar"></i>
                    <span>Empréstimos</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="payment.php">
                    <i class="fas fa-fw fas fa-coins"></i>
                    <span>Pagamentos</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="borrower.php">
                    <i class="fas fa-fw fas fa-book"></i>
                    <span>Mutuários</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="loan_plan.php">
                    <i class="fas fa-fw fa-piggy-bank"></i>
                    <span>Planos de Empréstimo</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="loan_type.php">
                    <i class="fas fa-fw fa-money-check"></i>
                    <span>Tipos de Empréstimo</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="user.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Usuários</span></a>
            </li>
        </ul>
        <!-- Fim da Barra Lateral -->

        <!-- Envoltório do Conteúdo -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Conteúdo Principal -->
            <div id="content">

                <!-- Barra Superior -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Alternar Barra Lateral (Barra Superior) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Navbar da Barra Superior -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Informações do Usuário na Barra Superior -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $db->user_acc($_SESSION['user_id']) ?></span>
                                <img class="img-profile rounded-circle"
                                    src="image/admin_profile.svg">
                            </a>
                            <!-- Dropdown - Informações do Usuário -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Sair
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- Fim da Barra Superior -->

                <!-- Conteúdo da Página -->
                <div class="container-fluid">

                    <!-- Título da Página -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Plano de Empréstimo</h1>
                    </div>

                    <!-- Linha de Conteúdo -->
                    <div class="row">
                        <!-- Exemplo de Cartão de Rendimentos (Mensais) -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="save_lplan.php">
                                        <div class="form-group">
                                            <label>Plano (meses)</label>
                                            <input type="number" class="form-control" name="lplan_month" required="required" />
                                        </div>
                                        <div class="i-group">
                                            <label>Juros</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="lplan_interest" min="0" required="required" />
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Multa Mensal por Atraso</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="lplan_penalty" min="0" required="required" />
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block" name="save">Salvar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Plano (meses)</th>
                                                    <th>Juros (%)</th>
                                                    <th>Multa Mensal por Atraso (%)</th>
                                                    <th>Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $tbl_lplan = $db->display_lplan();
                                                    while ($fetch = $tbl_lplan->fetch_array()) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo $fetch['lplan_month'] ?></td>
                                                            <td><?php echo $fetch['lplan_interest'] ?></td>
                                                            <td><?php echo $fetch['lplan_penalty'] ?></td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                        Ação
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item bg-warning text-white" href="#"
                                                                            data-toggle="modal" data-target="#updatelplan<?php echo $fetch['lplan_id'] ?>">Editar</a>
                                                                        <a class="dropdown-item bg-danger text-white" href="#"
                                                                            data-toggle="modal" data-target="#deletelplan<?php echo $fetch['lplan_id'] ?>">Excluir</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <!-- Modal de Exclusão do Plano de Empréstimo -->
                                                        <div class="modal fade" id="deletelplan<?php echo $fetch['lplan_id'] ?>" tabindex="-1"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-danger">
                                                                        <h5 class="modal-title text-white">Informação do Sistema</h5>
                                                                        <button class="close" type="button" data-dismiss="modal"
                                                                            aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">Tem certeza de que deseja excluir este registro?</div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                                                        <a class="btn btn-danger"
                                                                            href="delete_lplan.php?lplan_id=<?php echo $fetch['lplan_id'] ?>">Excluir</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Modal de Atualização do Plano de Empréstimo -->
                                                        <div class="modal fade" id="updatelplan<?php echo $fetch['lplan_id'] ?>" tabindex="-1"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form method="POST" action="update_lplan.php">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header bg-warning">
                                                                            <h5 class="modal-title text-white">Editar Plano de Empréstimo</h5>
                                                                            <button class="close" type="button" data-dismiss="modal"
                                                                                aria-label="Close">
                                                                                <span aria-hidden="true">×</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label>Plano (meses)</label>
                                                                                <input type="text" class="form-control"
                                                                                    value="<?php echo $fetch['lplan_month'] ?>" name="lplan_month"
                                                                                    required="required" />
                                                                                <input type="hidden" value="<?php echo $fetch['lplan_id'] ?>"
                                                                                    name="lplan_id" />
                                                                            </div>
                                                                            <div class="i-group">
                                                                                <label>Juros</label>
                                                                                <div class="input-group">
                                                                                    <input type="number" class="form-control"
                                                                                        value="<?php echo $fetch['lplan_interest'] ?>"
                                                                                        name="lplan_interest" min="0" required="required" />
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text">%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>Multa Mensal por Atraso</label>
                                                                                <div class="input-group">
                                                                                    <input type="number" class="form-control"
                                                                                        value="<?php echo $fetch['lplan_penalty'] ?>"
                                                                                        name="lplan_penalty" min="0" required="required" />
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text">%</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button class="btn btn-secondary" type="button"
                                                                                data-dismiss="modal">Cancelar</button>
                                                                            <button type="submit" name="update"
                                                                                class="btn btn-warning">Atualizar</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fim do Conteúdo da Página -->

                <!-- Rodapé -->
                <footer class="stocky-footer">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Direitos Autorais &copy; Sistema de Gerenciamento de Empréstimos <?php echo date("Y") ?></span>
                        </div>
                    </div>
                </footer>
                <!-- Fim do Rodapé -->

            </div>
            <!-- Fim do Conteúdo Principal -->

        </div>
        <!-- Fim do Envoltório do Conteúdo -->

    </div>
    <!-- Fim do Envoltório da Página -->

    <!-- Botão para Voltar ao Topo -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Modal de Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">Informação do Sistema</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Tem certeza de que deseja sair?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-danger" href="logout.php">Sair</a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript do Bootstrap -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.bundle.js"></script>

    <!-- JavaScript do Plugin Principal -->
    <script src="js/jquery.easing.js"></script>

    <!-- Scripts Personalizados para Todas as Páginas -->
    <script src="js/sb-admin-2.js"></script>

    <!-- Plugins de Nível da Página -->
    <script src="js/jquery.dataTables.js"></script>
    <script src="js/dataTables.bootstrap4.js"></script>

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                "order": [
                    [1, "asc"]
                ]
            });
        });
    </script>
</body>

</html>
