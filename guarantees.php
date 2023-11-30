<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'session.php';
require_once 'class.php';
include 'cf.php';
$db = new db_class();
$user_id = $_SESSION['user_id'];
$account_type = "";
$result = $db->userID();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $account_type = $row['account_type'];
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Sistema de Gerenciamento de Empréstimos</title>

    <link href="fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" integrity="sha512-HXXR0l2yMwHDrDyxJbrMD9eLvPe3z3qL3PPeozNTsiHJEENxx8DH2CxmV05iwG0dwoz5n4gQZQyYLUNt1Wdgfg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <style>
        .botao-flutuante {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #32C581;
            /* Vermelho */
            color: white;
            padding: 15px 25px;
            text-decoration: none;
            border-radius: 5px;
            z-index: 9999;
            animation: aparece-desaparece 5s infinite;
        }


        .conteudo {
            margin: 20px;
            padding: 20px;
            background-color: #f2f2f2;
        }
    </style>

</head>

<body id="page-top">

    <!-- Wrapper da Página -->
    <div id="wrapper">

        <!-- Barra Lateral (Sidebar) -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Marca da Barra Lateral -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
                <div class="sidebar-brand-text mx-3">PAINEL DE ADMINISTRAÇÃO </div>
            </a>


            <!-- Item de Navegação - Painel Principal -->
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
            <li class="nav-item">
                <a class="nav-link" href="Reports.php">
                    <i class="ri-git-repository-fill"></i>
                    <span>Relatórios</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="loan_type.php">
                    <i class="fas fa-fw fa-money-check"></i>
                    <span>Tipos de Empréstimo</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="guarantees.php">
                    <i class="ri-circle-fill"></i>
                    <span>Tipos de Gatatias</span></a>
            </li>

            <li class="nav-item">
                <?php
                if ($account_type === "gerente") {
                } else { ?>

                    <a class="nav-link" href="user.php">
                        <i class="fas fa-fw fa-user"></i>
                        <span>Usuários</span></a>
                <?php } ?>
            </li>


        </ul>
        <!-- Fim da Barra Lateral (Sidebar) -->

        <!-- Conteúdo Principal -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Conteúdo Principal -->
            <div id="content">

                <!-- Barra Superior (Topbar) -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Alternar Barra Lateral (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Menu de Navegação Superior (Topbar) -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Informações do Usuário - Item de Navegação -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $db->user_acc($_SESSION['user_id']) ?></span>
                                <img class="img-profile rounded-circle" src="image/admin_profile.svg">
                            </a>
                            <!-- Menu Suspenso - Informações do Usuário -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Sair
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- Fim da Barra Superior (Topbar) -->

                <!-- Conteúdo da Página -->
                <div class="container-fluid">

                    <!-- Título da Página -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Painel de Garantias</h1>
                    </div>

                    <!-- Linha de Conteúdo -->
                    <div class="row">
                        
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="save_guarantees.php">
                                        <div class="form-group">
                                            <label>Nome da Garantia</label>
                                            <input type="text" class="form-control" name="gua_name" required="required" />
                                        </div>
                                        <div class="form-group">
                                            <label>Descrição da Garantia</label>
                                            <textarea style="resize:none;" class="form-control" name="gua_desc" required="required"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block" name="save">Salvar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9  mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Nome da Garantia</th>
                                                    <th>Descrição da Garantia</th>
                                                    <th>Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tbl_ltype = $db->display_guarantees();
                                                while ($fetch = $tbl_ltype->fetch_array()) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $fetch['name'] ?></td>
                                                        <td><?php echo $fetch['description'] ?></td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Ação
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item bg-warning text-white" href="#" data-toggle="modal" data-target="#updateltype<?php echo $fetch['id'] ?>">Editar</a>
                                                                    <a class="dropdown-item bg-danger text-white" href="#" data-toggle="modal" data-target="#deleteltype<?php echo $fetch['id'] ?>">Excluir</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- Delete Loan Type Modal -->

                                                    <div class="modal fade" id="deleteltype<?php echo $fetch['id'] ?>" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger">
                                                                    <h5 class="modal-title text-white">Informações do Sistema</h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">Tem certeza de que deseja excluir esse registro?</div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                                                    <!--<a class="btn btn-danger" href="delete_ltype.php?ltype_id=<?php echo $fetch['id'] ?>">Excluir</a> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Update Loan Type Modal -->

                                                    <div class="modal fade" id="updateltype<?php echo $fetch['id'] ?>" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="POST" action="update_guarantees.php">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-warning">
                                                                        <h5 class="modal-title text-white">Editar tipo de empréstimo</h5>
                                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">×</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label>Nome do Empréstimo</label>
                                                                            <input type="text" class="form-control" value="<?php echo $fetch['name'] ?>" name="gua_name" required="required" />
                                                                            <input type="hidden" class="form-control" value="<?php echo $fetch['id'] ?>" name="gua_id" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Descrição do Empréstimo</label>
                                                                            <textarea style="resize:none;" class="form-control" name="gua_desc" required="required"><?php echo $fetch['description'] ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" name="update" class="btn btn-warning">Atualização</a>
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
                    <!-- Fim do Conteúdo Principal -->

                    <!-- Rodapé -->
                    <footer class="stocky-footer">

                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Direitos Autorais &copy; <a class="text-green"> Contacto do Desenvolvedor </a> Sistema de Gerenciamento de Empréstimos <?php echo date("Y") ?></span>
                            </div>
                        </div>
                    </footer>
                    <!-- Fim do Rodapé -->

                </div>
                <!-- Fim do Conteúdo Principal -->

            </div>
            <!-- Fim do Wrapper da Página -->

            <!-- Botão de Rolagem para o Topo -->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <!-- Modal de Logout -->
            <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title text-white">Informações do Sistema</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span class="text-white" aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Tem certeza de que deseja sair?</div>
                        <div class="modal-footer">
                            <button class="btn btn-success" type="button" data-dismiss="modal">Cancelar</button>
                            <a class="btn btn-warning" href="logout.php">Sair</a>
                        </div>
                    </div>
                </div>
            </div>


            <!-- JavaScript do Bootstrap -->
            <script src="js/jquery.js"></script>
            <script src="js/bootstrap.bundle.js"></script>

            <!-- JavaScript do Plugin Core -->
            <script src="js/jquery.easing.js"></script>

            <!-- Scripts Personalizados para Todas as Páginas -->
            <script src="js/sb-admin-2.js"></script>


</body>

</html>