<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'session.php';
require_once 'class.php';
$db = new db_class();
include 'cf.php';
$content = "";
if (isset($_GET['id'])) {
    $content = $_GET['id'];
}
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
<html lang="pt">

<head>
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
        }

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

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Sistema de Gerenciamento de Empréstimos</title>

    <link href="fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" integrity="sha512-HXXR0l2yMwHDrDyxJbrMD9eLvPe3z3qL3PPeozNTsiHJEENxx8DH2CxmV05iwG0dwoz5n4gQZQyYLUNt1Wdgfg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Estilos personalizados para esta página -->
    <link href="css/dataTables.bootstrap4.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Envoltório da Página -->
    <div id="wrapper">

        <!-- Barra Lateral -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Barra Lateral - Marca -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
                <div class="sidebar-brand-text mx-3">PAINEL ADMINISTRATIVO</div>
            </a>

            <!-- Item de Navegação - Painel -->
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
            <li class="nav-item ">
                <a class="nav-link" href="borrower.php">
                    <i class="fas fa-fw fas fa-book"></i>
                    <span>Mutuárois</span></a>
            </li>
            <li class="nav-item active">
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

                    <!-- Barra de Navegação Superior -->
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

                <!-- Conteúdo da Página -->
                <div class="container-fluid">
                    <!-- Título da Página -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <?php
                        if ($content == "loanActive") {
                        ?>
                            <h1 class="h3 mb-0 text-gray-800">Painel de Relatórios <h6><a tabindex="0" class="btn btn-lg btn-warning" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?">Pagamentos Pedentes</a></h6>
                            </h1>
                        <?php } elseif ($content == "delayed_parcels") {
                        ?>
                            <h1 class="h3 mb-0 text-gray-800">Painel de Relatórios <h6><a tabindex="0" class="btn btn-lg btn-danger" role="button" data-toggle="popover" data-trigger="focus" title="Dismissible popover" data-content="And here's some amazing content. It's very engaging. Right?">Parcelas Atrazadas</a></h6>
                            </h1>
                        <?php } else {
                        ?>
                            <h1 class="h3 mb-0 text-gray-800">Painel de Relatórios</h1>
                        <?php
                        }

                        ?>

                    </div>

                    <!-- Linha de Conteúdo -->
                    <div class="card shadow mb-4">
                        <div class='card-body'>
                            <form action="pesquisa_avancada.php" method="post">
                                <div class="row">

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="loanTypeSelect">Mutuário</label>
                                            <select class="form-control" id="borrowerSelect" name="borrowerSelect">
                                                <option value="">Selecione o Mutuário</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="loanTypeSelect">Gerente</label>
                                            <select class="form-control" id="managerSelect" name="managerSelect">
                                                <option value="">Selecione o Gerente</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="loanTypeSelect">Tipo de Empréstimo</label>
                                            <select class="form-control" id="loanTypeSelect" name="loanTypeSelect">
                                                <option value="">Selecione o Tipo de Emprestimo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for "loanTypeSelect">Data Inicio</label>
                                            <input class="form-control" type="date" name="dataInicio" id="dataInicio">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for "loanTypeSelect">Data Fim</label>
                                            <input class="form-control" type="date" name="dataFim" id="dataFim">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col">
                                    <div class="form-group">
                                            <label for="loanTypeSelect">Status de Empréstmos</label>
                                            <select class="form-control" id="loanStatusSelect" name="loanStatusSelect">
                                                <option value="">Selecione o Status de Empréstimos</option>
                                                <option value="pendentes">Pendentes</option>
                                                <option value="aprovados">Aprovados</option>
                                                <option value="concluidos">Concluídos</option>
                                                <option value="negados">Negados</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Pesquisar</button>
                            </form>


                            <hr class="my-4">
                            <div class="mt-4">
                                <div class="row">
                                    <div class="col">   
                                        <h4 class="text-dark bord">Entradas</h4>
                                        <p>2102 MT</p>
                                    </div>
                                    <div class="col">   
                                        <h4 class="text-dark bord">Saídas</h4>
                                        <p>2102 MT</p>
                                    </div>
                                    <div class="col">   
                                        <h4 class="text-dark bord">Total de Empréstimos</h4>
                                        <p>21</p>
                                    </div>
                                    <div class="col">   
                                        <h4 class="text-dark bord">Total de Mutuário</h4>
                                        <p>21</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">



                        <?php
                        if ($content == "loanActive") {
                            echo "<div class='card-body'>";

                        ?>
                            <div class="table-responsive">
                                <table class="table" id="dataTable">
                                    <thead>
                                        <tr>

                                            <th>Mutuário</th>
                                            <th>Valor emprestado</th>
                                            <th>Status</th>
                                            <th>Data de Lançamento</th>
                                            <th>Data de Aprovação</th>
                                            <th>Data de Conclusão</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ($account_type === "gerente") {
                                        $tbl_loan = $db->conn->query("SELECT * FROM `loan` WHERE `status`='aprovado' AND user_id = $user_id");
                                    } else {
                                        $tbl_loan = $db->conn->query("SELECT * FROM `loan` WHERE `status`='aprovado'");
                                    }

                                    if ($tbl_loan && $tbl_loan->num_rows > 0) {
                                        while ($row = $tbl_loan->fetch_assoc()) {
                                            $statusClass = '';
                                            switch ($row['status']) {
                                                case 'pendente':
                                                    $statusClass = 'text-pending';
                                                    break;
                                                case 'aprovado':
                                                    $statusClass = 'text-approved';
                                                    break;
                                                case 'concluído':
                                                    $statusClass = 'text-completed';
                                                    break;
                                                case 'negado':
                                                    $statusClass = 'text-denied';
                                                    break;
                                                default:
                                                    $statusClass = '';
                                                    break;
                                            }

                                            // Preencha as células da tabela com os dados
                                            echo '<tr>';

                                            if (isset($row['borrower_id'])) {
                                                $borrowerId = $row['borrower_id'];

                                                $query2 = "SELECT firstname, lastname FROM borrower WHERE borrower_id = $borrowerId";
                                                $result2 = $conn2->query($query2);

                                                if ($result2 && $result2->num_rows > 0) {
                                                    $data = $result2->fetch_assoc();
                                                    echo '<td class="text-completed">' . $data['firstname'] . ' ' . $data['lastname'] . '</td>';
                                                }
                                            }

                                            echo '<td>' . number_format($row['amount'], 2) . ' MT</td>';
                                            echo '<td class="' . $statusClass . '">' . $row['status'] . '</td>';
                                            echo '<td>' . strftime("%d de %B de %Y", strtotime($row['release_date'])) . '</td>';
                                            echo '<td>' . strftime("%d de %B de %Y", strtotime($row['approval_date'])) . '</td>';
                                            echo '<td>' . strftime("%d de %B de %Y", strtotime($row['completion_date'])) . '</td>';
                                            echo '<td><a class="btn btn-warning"" href="loan_details.php?id=' . $row['id'] . '">Detalhes</a></td>';



                                            echo '</tr>';
                                        }
                                    } else {
                                        echo "<tr><td colspan='13'>Nenhum resultado encontrado.</td></tr>";
                                    }
                                }
                                    ?>
                                    </tbody>
                                </table>

                            </div>
                    </div>
                </div>
                <div class="card shadow mb-4">

                    <?php
                    if ($content == "delayed_parcels") { ?>
                        <div class='card-body'>
                            <?php
                            ?>
                            <div class="table-responsive">
                                <table class="table table-striped" id="dataTable">
                                    <thead>
                                        <tr>

                                            <th>Referencia</th>
                                            <th>Tipo do Emprestimo</th>
                                            <th>Divida Total</th>
                                            <th>Parcelas</th>
                                            <th>Valor das parcela</th>
                                            <th>Data de Vencimento</th>
                                            <th>Pagamentos</th>
                                            <th>Situação multaria</th>
                                            <th>Valor da Multa</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $dataAtual = date('Y-m-d');
                                        // Realize a consulta SQL para obter os dados da tabela 'parcelas' com base no '$loanID'
                                        $query = "SELECT * FROM parcelas
                                    WHERE data_vencimento <= '$dataAtual' AND status_pagamento = 'Não Pago'";

                                        $result = $conn2->query($query);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";

                                                echo "<td>" . $row['borrower_ref'] . "</td>";
                                                $sd = "SELECT ltype_name FROM loan_type WHERE ltype_id = " . $row['loan_type_id'];
                                                $rs = $conn2->query($sd);
                                                if ($rs->num_rows > 0) {
                                                    while ($r = $rs->fetch_assoc()) {
                                                        echo "<td>" . $r['ltype_name'] . "</td>";
                                                    }
                                                }

                                                echo "<td>" . $row['valor_total'] . ' MT' . "</td>";
                                                echo "<td>" . $row['status'] . "</td>";
                                                echo "<td>" . $row['valor_parcela'] . ' MT' . "</td>";

                                                echo "<td>" . strftime("%d de %B de %Y", strtotime($row['data_vencimento'])) . "</td>";
                                                echo "<td>" . $row['status_pagamento'] . "</td>";
                                                echo "<td>" . $row['status_multa'] . "</td>";
                                                echo "<td>" . $row['multa'] . ' MT' . "</td>";
                                                if ($row['status_pagamento'] === 'Pago') {
                                                    echo "<td><button class='btn btn-success pagar-btn' disabled>Pago</button></td>";
                                                } else {
                                                    echo "<td><button class='btn btn-danger pagar-btn' data-toggle='modal' data-target='#paymentModal" . $row['id'] . "' data-id='" . $row['id'] . "'>Pagar</button></td>";
                                                }

                                                echo "</tr>";
                                        ?>
                                                <div class="modal fade" id="paymentModal<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Pagar Parcela</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="paymentForm" method="POST" action="pagamentos.php">

                                                                    <div class="form-group">
                                                                        <label for="paymentAmount">Valor do Pagamento: <?php
                                                                                                                        $valor_parcela = $row['valor_parcela'];
                                                                                                                        $valor_multa = $row['multa'];
                                                                                                                        $valorTotal = $valor_parcela + $valor_multa;
                                                                                                                        echo $valorTotal . ' MT'; ?></label>
                                                                        <br>

                                                                        <input type="hidden" class="form-control" id="parcelId" name="parcelId" value="<?php echo $row['id']; ?>">
                                                                        </br>
                                                                        <input type="hidden" class="form-control" id="paymentAmount" name="paymentAmount" value="<?php echo $valorTotal; ?>">
                                                                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">

                                                                    </div>
                                                                    <div class="model-footer">
                                                                        <button type="submit" class="btn btn-primary" id="submitPayment">Enviar Pagamento</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='12'>Nenhum dado encontrado.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            <?php }

                            ?>
                            </div>

                        </div>

                </div>

            </div>
        </div>
    </div>
    </div>

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