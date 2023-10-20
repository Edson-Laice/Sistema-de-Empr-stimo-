<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'session.php';
require_once 'class.php';
require_once 'config.php';
$connection = new db_connect();

$db = new db_class();

include 'cf.php';
if (isset($_GET['id'])) {
    $loanID = $_GET['id'];

    // Consulta SQL para buscar os detalhes do empréstimo com base no ID
    $query = "SELECT * FROM loan WHERE id = $loanID";

    $result = $conn2->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
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

        /* Barra para status "pendente" (laranja) */
        .status-pending {
            border-bottom: 4px solid orange;
        }

        /* Barra para status "aprovado" (verde) */
        .status-approved {
            border-bottom: 4px solid green;
        }

        /* Barra para status "concluído" (azul) */
        .status-completed {
            border-bottom: 4px solid blue;
        }

        /* Barra para status "negado" (vermelho) */
        .status-denied {
            border-bottom: 4px solid red;
        }
    </style>

</head>

<body id="page-top">

    <!-- Wrapper da Página -->
    <div id="wrapper">

        <!-- Barra Lateral (Sidebar) -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion fixed" id="accordionSidebar">

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
            <li class="nav-item active">
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
                        <h1 class="h3 mb-0 text-gray-800">Detalhes de Emprestimo</h1>
                    </div>

                    <!-- Linha de Conteúdo -->
                    <?php
                    $status = $row['status']; // Suponha que esta variável contenha o status do empréstimo

                    // Defina uma classe personalizada com base no status
                    $statusClass = '';

                    if ($status === 'pendente') {
                        $statusClass = 'status-pending';
                    } elseif ($status === 'aprovado') {
                        $statusClass = 'status-approved';
                    } elseif ($status === 'concluído') {
                        $statusClass = 'status-completed';
                    } elseif ($status === 'negado') {
                        $statusClass = 'status-denied';
                    }
                    ?>
                    <div class="card shadow mb-4">
                        <div class="container mt-5 d-flex justify-content-center">

                            <div class="card p-3">

                                <div class="d-flex align-items-center">

                                    <div class="image">
                                        <img src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=80" class="rounded" width="155">
                                    </div>

                                    <div class="ml-3 w-100">

                                        <h4 class="mb-0 mt-0">Alex HMorrision</h4>
                                        <span>Senior Journalist</span>

                                        <div class="p-2 mt-2 bg-primary d-flex justify-content-between rounded text-white stats">

                                            <div class="d-flex flex-column">

                                                <span class="articles">Articles</span>
                                                <span class="number1">38</span>

                                            </div>

                                            <div class="d-flex flex-column">

                                                <span class="followers">Followers</span>
                                                <span class="number2">980</span>

                                            </div>


                                            <div class="d-flex flex-column">

                                                <span class="rating">Rating</span>
                                                <span class="number3">8.9</span>

                                            </div>

                                        </div>


                                        <div class="button mt-2 d-flex flex-row align-items-center">

                                            <button class="btn btn-sm btn-outline-primary w-100">Chat</button>
                                            <button class="btn btn-sm btn-primary w-100 ml-2">Follow</button>


                                        </div>


                                    </div>


                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="card shadow mb-4 <?php echo $statusClass ?>">

                        <?php
                        if ($row['status'] == 'pendente') {
                            echo '<div class="container mt-4 p-4">'; // Abre a div do container apenas se o status não for 'aprovado'
                        ?>
                            <div class="row">
                                <?php
                                $borrowerID = $row['borrower_id'];
                                $queryBorrower = "SELECT firstname, lastname FROM borrower WHERE borrower_id = $borrowerID";
                                $resultBorrower = $conn2->query($queryBorrower);
                                $borrower = $resultBorrower->fetch_assoc();
                                ?>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="<?php echo $borrower['firstname'] . ' ' . $borrower['lastname']; ?>" aria-label="First name" disabled>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="<?php echo $row['id']; ?>" aria-label="First name" disabled>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="<?php echo 'Referencia: ' . $row['ref']; ?>" aria-label="First name" disabled>
                                </div>
                            </div>
                            <form method="post" action="atualizar_emprestimo.php">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <div class="form-group">
                                    <label for="amount">Valor emprestado:</label>
                                    <input type="text" class="form-control" id="amount" name="amount" value="<?php echo $row['amount'] . ' MT'; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="interestRate">Taxa de juros:</label>
                                    <input type="text" class="form-control" id="interestRate" name="interestRate" value="<?php echo $row['interest_rate'] . '%'; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="penalty">Multa:</label>
                                    <input type="text" class="form-control" id="penalty" name="penalty" value="<?php echo $row['penalty'] . '%'; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="durationMonths">Duração em meses:</label>
                                    <input type="text" class="form-control" id="durationMonths" name="durationMonths" value="<?php echo $row['duration_months']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status:</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="pendente" <?php echo ($row['status'] === 'pendente') ? 'selected' : ''; ?>>Pendente</option>
                                        <option value="aprovado" <?php echo ($row['status'] === 'aprovado') ? 'selected' : ''; ?>>Aprovado</option>
                                        <option value="negado" <?php echo ($row['status'] === 'negado') ? 'selected' : ''; ?>>Negado</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="parcelType">Tipo de Parcela:</label>
                                    <select class="form-control" id="parcelType" name="parcelType">
                                        <option value="Díario">Díario</option>
                                        <option value="Semanal">Semanal</option>
                                        <option value="Mensal">Mensal</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Atualizar</button>
                            </form>
                        <?php
                            // Fecha a div interna
                        } elseif ($row['status'] == 'aprovado') {
                        ?>
                            <div class="container mt-4 p-4">
                                <ul class="nav nav-tabs nav-fill mb-3" id="ex1" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="loan-info-tab" data-bs-toggle="tab" href="#loan-info" role="tab" aria-controls="loan-info" aria-selected="true">Detalhes do Empréstimo</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="guarantee-tab" data-bs-toggle="tab" href="#guarantee" role="tab" aria-controls="guarantee-tab" aria-selected="false">Garantias do Empestimos</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="payment-history-tab" data-bs-toggle="tab" href="#payment-history" role="tab" aria-controls="payment-history" aria-selected="false">Cronologia de Pagamentos</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="payment-history-tab" data-bs-toggle="tab" href="#payment-history" role="tab" aria-controls="payment-history" aria-selected="false">Testemunhas</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="ex2-content">
                                    <!-- Aba de Detalhes do Empréstimo -->
                                    <div class="tab-pane fade show active" id="loan-info" role="tabpanel" aria-labelledby="loan-info-tab">

                                        <!-- Lista vertical de detalhes do empréstimo -->
                                        <?php

                                        echo '<ul>';
                                        echo '<li>ID do Empréstimo: ' . $row['ref'] . '</li>';
                                        echo '<li>Valor: ' . $row['amount'] . ' MT</li>';
                                        echo '<li>Taxa de Juros: ' . $row['interest_rate'] . '%</li>';
                                        echo '<li>Data de Aprovação: ' . strftime("%d de %B de %Y", strtotime($row['approval_date'])) . '</li>';
                                        echo '<li>Data de Conclusão: ' . strftime("%d de %B de %Y", strtotime($row['completion_date'])) . '</li>';
                                        echo '<li>Status: ' . $row['status'] . '</li>';
                                        // Adicione mais detalhes conforme necessário
                                        echo '</ul>';


                                        ?>

                                    </div>

                                    <!-- Aba de Garantias-->
                                    <div class="tab-pane fade" id="guarantee" role="tabpanel" aria-labelledby="guarantee-tab">

                                        <div class="container mt-4 p-4">
                                            <ul class="nav nav-tabs nav-fill mb-3" id="ex1" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active" id="garantias-tab" data-bs-toggle="tab" href="#garantias-info" role="tab" aria-controls="garantias-info" aria-selected="true">Garantias</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" id="addgarantiastab" data-bs-toggle="tab" href="#addgarantias" role="tab" aria-controls="addgarantias-tab" aria-selected="false">Adiciovar Nova</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="tab-content" id="ex2-content">
                                            <div class="tab-pane fade show active" id="garantias-info" role="tabpanel" aria-labelledby="garantias-tab">
                                                <div class="table-responsive">
                                                    <?php


                                                    $query2 = "SELECT * FROM garantia WHERE loan_id = $loanID";
                                                    $result2 = $conn2->query($query2);

                                                    if ($result2 && $result2->num_rows > 0) {
                                                        echo '<table class="table table-striped" id="dataTable">';
                                                        echo '<thead>';
                                                        echo '<tr>';
                                                        echo '<th>Tipo de Garantia</th>';
                                                        echo '<th>Descrição</th>';
                                                        echo '<th>Valor</th>';
                                                        echo '<th>Status</th>';
                                                        echo '<th>Data de Aquisição</th>';
                                                        echo '<th>Data de Vencimento</th>';
                                                        echo '<th>Avaliador</th>';
                                                        echo '</tr>';
                                                        echo '</thead>';
                                                        echo '<tbody>';

                                                        while ($row = $result2->fetch_assoc()) {
                                                            echo '<tr>';
                                                            echo '<td>' . $row['tipo_garantia'] . '</td>';
                                                            echo '<td>' . $row['descricao'] . '</td>';
                                                            echo '<td>' . $row['valor'] . ' MT' . '</td>';
                                                            echo '<td>' . $row['status'] . '</td>';
                                                            echo '<td>' . $row['data_aquisicao'] . '</td>';
                                                            echo '<td>' . $row['data_vencimento'] . '</td>';
                                                            echo '<td>' . $row['avaliador'] . '</td>';
                                                            echo '</tr>';
                                                        }

                                                        echo '</tbody>';
                                                        echo '</table>';
                                                    } else {
                                                        echo 'Nenhuma garantia encontrada para este empréstimo.';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="addgarantias" role="tabpanel" aria-labelledby="addgarantiastab">
                                                <div class="container">
                                                    <form id="guaranteeForm" method="POST" action="adicionar_garantia.php">
                                                        <input type="hidden" name="loan" value="<?php echo $loanID; ?>">

                                                        <div class="form-group">
                                                            <label for="garantiaTipo">Tipo de Garantia:</label>
                                                            <select class="form-control" id="garantiaTipo" name="garantiaTipo" required>
                                                                <option value="Veículo">Veículo</option>
                                                                <option value="Imóvel">Imóvel</option>
                                                                <option value="Jóia">Jóia</option>
                                                                <option value="Equipamento Eletrônico">Equipamento Eletrônico</option>
                                                                <option value="Máquinas Industriais">Máquinas Industriais</option>
                                                                <option value="Estoque de Mercadorias">Estoque de Mercadorias</option>
                                                                <option value="Títulos Financeiros">Títulos Financeiros</option>
                                                                <option value="Terras Agrícolas">Terras Agrícolas</option>
                                                                <option value="Terras Florestais">Terras Florestais</option>
                                                                <option value="Outra">Outra</option>
                                                            </select>

                                                        </div>

                                                        <div class="form-group">
                                                            <label for="descricaoGarantia">Descrição da Garantia:</label>
                                                            <input type="text" class="form-control" id="descricaoGarantia" name="descricaoGarantia" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="statusGarantia">Status da Garantia:</label>
                                                            <select class="form-control" id="statusGarantia" name="statusGarantia" required>
                                                                <option value="Ativa">Ativa</option>
                                                                <option value="Inativa">Inativa</option>
                                                                <!-- Adicione outros estados de garantia, se necessário -->
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="valorGarantia">Valor da Garantia (em MT):</label>
                                                            <input type="text" class="form-control" id="valorGarantia" name="valorGarantia" required>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label for="dataAquisicao">Data de Aquisição:</label>
                                                                    <input type="date" class="form-control" id="dataAquisicao" name="dataAquisicao" required>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label for="dataVencimento">Data de Vencimento:</label>
                                                                    <input type="date" class="form-control" id="dataVencimento" name="dataVencimento" required>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <button type="submit" class="btn btn-primary">Adicionar Garantia</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Aba de Cronologia de Pagamentos -->
                                    <div class="tab-pane fade" id="payment-history" role="tabpanel" aria-labelledby="payment-history-tab">
                                        <!-- Insira a tabela de cronologia de pagamentos aqui -->
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
                                                    // Realize a consulta SQL para obter os dados da tabela 'parcelas' com base no '$loanID'
                                                    $query = "SELECT * FROM parcelas WHERE loan_id = $loanID ORDER BY data_vencimento ASC";
                                                    $result = $conn2->query($query);

                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<tr>";

                                                            echo "<td>" . $row['borrower_ref'] . "</td>";
                                                            echo "<td>" . $row['loan_type_id'] . "</td>";
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
                                                                echo "<td><button class='btn btn-primary pagar-btn' data-toggle='modal' data-target='#paymentModal" . $row['id'] . "' data-id='" . $row['id'] . "'>Pagar</button></td>";
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
                                                                                    <label for="paymentAmount">Valor do Pagamento: <?php echo $row['valor_parcela'] . ' MT'; ?></label>
                                                                                    <br>
                                                                                    <div class="container">
                                                                                        <button class="btn btn-dark" disabled><?php echo strftime("%d de %B de %Y", strtotime($row['data_vencimento'])); ?></button>
                                                                                    </div>
                                                                                    <input type="hidden" class="form-control" id="parcelId" name="parcelId" value="<?php echo $row['id']; ?>">
                                                                                    </br>
                                                                                    <input type="hidden" class="form-control" id="paymentAmount" name="paymentAmount" value="<?php echo $row['valor_parcela']; ?>">
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
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php
                        } elseif ($row['status'] == 'concluído') {
                        ?>
                            <div class="container mt-4 p-4">

                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="container mt-4 p-4">
                                <?php
                                // ...


                                echo '<p>Seu empréstimo foi recusado.</p>';

                                echo '<p>Detalhes do empréstimo:</p>';

                                // Restante do código para exibir os detalhes do empréstimo
                                // ...


                                ?>
                            </div>
                        <?php
                        }
                        echo '</div>';
                        ?>

                    </div>
                    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
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