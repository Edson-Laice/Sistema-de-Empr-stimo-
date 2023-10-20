<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'session.php';
require_once 'class.php';
require_once 'config.php';
$connection = new db_connect();

$db = new db_class();


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Sistema de Gerenciamento de Empréstimos</title>

    <link href="fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css">
    <link href="css/dataTables.bootstrap4.css" rel="stylesheet">

    <link href="css/sb-admin-2.css" rel="stylesheet">
    <style>
        /* Estilos adicionais */


        .text-pending {
            color: orange;
        }

        .text-approved {
            color: green;
        }

        .text-completed {
            color: blue;
        }

        .text-denied {
            color: red;
        }
    </style>

</head>

<body id="page-top">

    <!-- Wrapper da Página -->
    <div id="wrapper">

        <!-- Barra Lateral (Sidebar) -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Marca da Barra Lateral -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3">PAINEL DE ADMINISTRAÇÃO</div>
            </a>


            <!-- Item de Navegação - Painel Principal -->
            <li class="nav-item ">
                <a class="nav-link" href="home.php">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Início</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="loan.php">
                    <i class="fas fa-fw fas fa-comment-dollar"></i>
                    <span>Empréstimos</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link " href="payment.php">
                    <i class="fas fa-fw fas fa-coins"></i>
                    <span>Pagamentos</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="borrower.php">
                    <i class="fas fa-fw fas fa-book"></i>
                    <span>Mutuários</span></a>
            </li>
            <li class="nav-item">
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
                        <h1 class="h3 mb-0 text-gray-800">Painel de Controle</h1>
                    </div>

                    <!-- Linha de Conteúdo -->
                    <div class="card shadow mb-4">
                        <?php
                        include 'cf.php';

                        if (isset($_GET['parcelId'])) {
                            $loanID = $_GET['parcelId'];

                            $query = "SELECT parcelas.*, borrower.firstname , borrower.lastname FROM parcelas JOIN loan 
    ON parcelas.loan_id = loan.id JOIN borrower ON loan.borrower_id = 
    borrower.borrower_id WHERE parcelas.id = $loanID";

                            $result = $conn2->query($query);

                            if ($result) {
                                $row = $result->fetch_assoc();
                            } else {
                                $row = array(); // Define $row como um array vazio se não houver resultados
                            }
                        }
                        ?>

                        <div class="card-body">

                            <?php if (!empty($row)) : ?>
                                <table class="table table-striped">
                                    <tr>
                                        <th>Atributo</th>
                                        <th>Valor</th>
                                    </tr>
                                    <tr>
                                        <td>borrower_ref</td>
                                        <td><?php echo $row['borrower_ref']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Valor do Empréstimo</td>
                                        <td><?php echo $row['valor_total'] . ' MT'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Parcelas</td>
                                        <td><?php echo $row['status']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Valor da Parcela</td>
                                        <td><?php echo $row['valor_parcela'] . ' MT'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Data de Vencimento</td>
                                        <td><?php echo $row['data_vencimento']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Situação</td>
                                        <td><?php echo $row['status_pagamento']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Valor da Multa</td>
                                        <td><?php echo $row['multa']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status da Multa</td>
                                        <td><?php echo $row['status_multa']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nome do Devedor</td>
                                        <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                                    </tr>
                                </table>
                            <?php else : ?>
                                <div class="atributo">Nenhum resultado encontrado.</div>
                            <?php endif; ?>

                        </div>

                    </div>
                </div>
                <!-- Fim do Conteúdo Principal -->

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
        <!-- Fim do Wrapper da Página -->

        <!-- Botão de Rolagem para o Topo -->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Modal para solicitar empréstimo -->
        <!-- Modal de Detalhes -->
        <!-- Modal de Detalhes do Mutuário -->
        <!-- Botão para acionar o modal e incluir os detalhes do mutuário no atributo data -->


        <!-- Modal para exibir os detalhes do mutuário -->








        <!-- Modal para solicitar empréstimo -->



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>



        <!-- Modal de Logout -->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">Informações do Sistema</h5>
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

        <!-- JavaScript do Plugin Core -->
        <script src="js/jquery.easing.js"></script>

        <!-- Scripts Personalizados para Todas as Páginas -->
        <script src="js/sb-admin-2.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js"></script>
        <script src="js/jquery.dataTables.js"></script>
        <script src="js/dataTables.bootstrap4.js"></script>

        <!-- Scripts Personalizados para Todas as Páginas -->
        <script src="js/sb-admin-2.js"></script>

        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    "order": [
                        [2, "asc"]
                    ]
                });
            });
        </script>

</body>

</html>