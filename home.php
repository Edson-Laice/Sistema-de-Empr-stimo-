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
$db->aplicarMultasDiarias();

$conn2->close();
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
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" style=" background-color: #3d3747;
  background-image: linear-gradient(180deg, #3d3747 10%, #3d3747 100%);
  background-size: cover;" id="accordionSidebar">

            <!-- Marca da Barra Lateral -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
                <div class="sidebar-brand-text mx-3">PAINEL DE ADMINISTRAÇÃO </div>
            </a>


            <!-- Item de Navegação - Painel Principal -->
            <li class="nav-item active">
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
            <li class="nav-item ">
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
                        <h1 class="h3 mb-0 text-gray-800">Painel de Controle</h1>
                    </div>

                    <!-- Linha de Conteúdo -->
                    <div class="row">


                        <div class="col-xl-4 col-md-4 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Empréstimos Ativos</div>



                                            <div class="h2 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                // Mostrar a div do spinner
                                            

                                                // Aguardar 2 segundos
                                
                                                // Restante do código
                                                if ($account_type === "gerente") {
                                                    $tbl_loan = $db->conn->query("SELECT * FROM `loan` WHERE `status`='aprovado' AND user_id = $user_id");
                                                    echo $tbl_loan->num_rows > 0 ? $tbl_loan->num_rows : "0";
                                                } else {
                                                    $tbl_loan = $db->conn->query("SELECT * FROM `loan` WHERE `status`='aprovado'");
                                                    echo $tbl_loan->num_rows > 0 ? $tbl_loan->num_rows : "0";
                                                }

                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-fw fas fa-comment-dollar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small stretched-link" href="Reports.php?id=loanActive">Ver Lista de Empréstimos</a>
                                    <div class="small">
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-4 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Pagamentos Realizados</div>
                                            <div class="h2 mb-0 font-weight-bold text-success">
                                                <?php
                                                // Obtenha a data atual no formato 'Y-m-d'
                                                $dataAtual = date('Y-m-d');

                                                // Consulta para obter as parcelas com vencimento hoje
                                                if ($account_type === "gerente") {
                                                    $sql = "SELECT p.*
                                                    FROM parcelas p
                                                    INNER JOIN loan l ON p.loan_id = l.id
                                                    WHERE l.user_id = $user_id
                                                    AND p.data_vencimento >= '$dataAtual' AND p.status_pagamento = 'Pago'";

                                                    $result = $db->conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        $totalAPagar = 0;

                                                        while ($row = $result->fetch_assoc()) {
                                                            $valorParcela = $row['valor_parcela'];
                                                            $totalAPagar += $valorParcela;
                                                        }

                                                        echo '+' . number_format($totalAPagar, 2) . " MT";
                                                    }
                                                } else {
                                                    $sql = "SELECT valor_parcela
                                                FROM parcelas
                                                WHERE data_vencimento >= '$dataAtual' AND status_pagamento = 'Pago'";

                                                    $result = $db->conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        $totalAPagar = 0;

                                                        while ($row = $result->fetch_assoc()) {
                                                            $valorParcela = $row['valor_parcela'];
                                                            $totalAPagar += $valorParcela;
                                                        }

                                                        echo '+' . number_format($totalAPagar, 2) . " MT";
                                                    }
                                                }


                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-fw fas fa-coins fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small stretched-link" href="payment.php?context=pr">Ver Lista Pagamentos Realizado</a>
                                    <div class="small">
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="col-xl-4 col-md-4 mb-4">
                            <div class="card border-left-warning  shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pagamentos Pendentes</div>
                                            <div class="h2 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                // Obtenha a data atual
                                                $dataAtual = date('Y-m-d');

                                                // Consulta para obter empréstimos atrasados com os novos atributos
                                                if ($account_type === "gerente") {
                                                    $sql = "SELECT id, amount, penalty
                                                FROM loan
                                                WHERE status = 'aprovado'
                                                AND user_id = $user_id";

                                                    $result = $db->conn->query($sql);

                                                    // Inicialize as variáveis para o cálculo do total a pagar

                                                    $totalAPagar = 0;

                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {

                                                            // Calcule o valor total a pagar para cada empréstimo
                                                            $valorOriginal = $row['amount'];
                                                            $multa = $row['penalty'];
                                                            $valorAPagar = $valorOriginal + ($valorOriginal * $multa / 100);

                                                            $totalAPagar += $valorAPagar;
                                                        }
                                                    }


                                                    echo number_format($totalAPagar, 2) . " MT";
                                                } else {
                                                    $sql = "SELECT id, amount, penalty
                                                FROM loan
                                                WHERE status = 'aprovado'";


                                                    $result = $db->conn->query($sql);

                                                    // Inicialize as variáveis para o cálculo do total a pagar

                                                    $totalAPagar = 0;

                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {

                                                            // Calcule o valor total a pagar para cada empréstimo
                                                            $valorOriginal = $row['amount'];
                                                            $multa = $row['penalty'];
                                                            $valorAPagar = $valorOriginal + ($valorOriginal * $multa / 100);

                                                            $totalAPagar += $valorAPagar;
                                                        }
                                                    }


                                                    echo number_format($totalAPagar, 2) . " MT";
                                                }


                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-fw fas fa-coins fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small stretched-link" href="Reports.php?id=loanActive">Ver Lista Pagamentos Pedentes </a>
                                    <div class="small">
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-4 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Pagamentos Hoje</div>
                                            <div class="h2 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                // Obtenha a data atual no formato 'Y-m-d'
                                                $dataAtual = date('Y-m-d');

                                                // Consulta para obter as parcelas com vencimento hoje
                                                if ($account_type === "gerente") {
                                                    $sql = "SELECT valor_parcela
                                                    FROM parcelas
                                                    WHERE data_vencimento = '$dataAtual' 
                                                    AND loan_id IN (SELECT id FROM loan WHERE user_id = $user_id)";

                                                    $result = $db->conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        $totalAPagar = 0;

                                                        while ($row = $result->fetch_assoc()) {
                                                            $valorParcela = $row['valor_parcela'];
                                                            $totalAPagar += $valorParcela;
                                                        }

                                                        echo number_format($totalAPagar, 2) . " MT";
                                                    } else {
                                                        echo "0.00 MT";
                                                    }
                                                } else {
                                                    $sql = "SELECT valor_parcela
                                                FROM parcelas
                                                WHERE data_vencimento = '$dataAtual'";

                                                    $result = $db->conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        $totalAPagar = 0;

                                                        while ($row = $result->fetch_assoc()) {
                                                            $valorParcela = $row['valor_parcela'];
                                                            $totalAPagar += $valorParcela;
                                                        }

                                                        echo number_format($totalAPagar, 2) . " MT";
                                                    } else {
                                                        echo "0.00 MT";
                                                    }
                                                }


                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-fw fas fa-coins fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small stretched-link" href="payment.php?context=pg">Ver Lista Pagamentos de Hoje</a>
                                    <div class="small">
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-4 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Parcelas Atrazadas</div>
                                            <div class="h2 mb-0 font-weight-bold text-danger">
                                                <?php
                                                // Obtenha a data atual no formato 'Y-m-d'
                                                $dataAtual = date('Y-m-d');

                                                // Consulta para obter as parcelas com vencimento hoje
                                                if ($account_type === "gerente") {
                                                    $sql = "SELECT valor_parcela
                                                FROM parcelas
                                                WHERE data_vencimento <= '$dataAtual' AND status_pagamento = 'Não Pago' AND loan_id IN (SELECT id FROM loan WHERE user_id = $user_id)";

                                                    $result = $db->conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        $totalAPagar = 0;

                                                        while ($row = $result->fetch_assoc()) {
                                                            $valorParcela = $row['valor_parcela'];
                                                            $totalAPagar += $valorParcela;
                                                        }

                                                        echo '-' . number_format($totalAPagar, 2) . " MT";
                                                    } else {
                                                        echo "0.00 MT";
                                                    }
                                                } else {
                                                    $sql = "SELECT valor_parcela
                                                FROM parcelas
                                                WHERE data_vencimento <= '$dataAtual' AND status_pagamento = 'Não Pago'";

                                                    $result = $db->conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        $totalAPagar = 0;

                                                        while ($row = $result->fetch_assoc()) {
                                                            $valorParcela = $row['valor_parcela'];
                                                            $totalAPagar += $valorParcela;
                                                        }

                                                        echo '-' . number_format($totalAPagar, 2) . " MT";
                                                    } else {
                                                        echo "0.00 MT";
                                                    }
                                                }


                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-fw fas fa-coins fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small stretched-link text-danger" href="Reports.php?id=delayed_parcels">Ver Lista Pagamentos Atrazados</a>
                                    <div class="small">
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-4 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Multas</div>
                                            <div class="h2 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                // Obtenha a data atual no formato 'Y-m-d'
                                                $dataAtual = date('Y-m-d');

                                                // Consulta para obter as parcelas com vencimento hoje
                                                if ($account_type === "gerente") {
                                                    $sql = "SELECT valor_parcela
                                                FROM parcelas
                                                WHERE status_multa = 'Multado' AND status_pagamento = 'Não Pago' AND loan_id IN (SELECT id FROM loan WHERE user_id = $user_id) ";

                                                    $result = $db->conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        $totalAPagar = 0;

                                                        while ($row = $result->fetch_assoc()) {
                                                            $valorParcela = $row['valor_parcela'];
                                                            $totalAPagar += $valorParcela;
                                                        }

                                                        echo number_format($totalAPagar, 2) . " MT";
                                                    } else {
                                                        echo "0.00 MT";
                                                    }
                                                } else {
                                                    $sql = "SELECT valor_parcela
                                                FROM parcelas
                                                WHERE status_multa = 'Multado' AND status_pagamento = 'Não Pago' ";

                                                    $result = $db->conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        $totalAPagar = 0;

                                                        while ($row = $result->fetch_assoc()) {
                                                            $valorParcela = $row['valor_parcela'];
                                                            $totalAPagar += $valorParcela;
                                                        }

                                                        echo number_format($totalAPagar, 2) . " MT";
                                                    } else {
                                                        echo "0.00 MT";
                                                    }
                                                }


                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-fw fas fa-coins fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small stretched-link text-success" href="payment.php?context=multas">Ver Lista Multas</a>
                                    <div class="small">
                                        <i class="fa fa-angle-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-4 col-md-4 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Mutuários
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h2 mb-0 mr-3 font-weight-bold text-gray-800">
                                                        <?php
                                                        $tbl_borrower = $db->conn->query("SELECT * FROM `borrower`");
                                                        echo $tbl_borrower->num_rows > 0 ? $tbl_borrower->num_rows : "0";
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-fw fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small stretched-link" href="borrower.php">Ver Mutuários</a>
                                    <div class="small">
                                        <i class="fa fa-angle-right"></i>
                                    </div>
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