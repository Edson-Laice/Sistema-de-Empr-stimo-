<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'session.php';
require_once 'class.php';
require_once 'config.php';
$connection = new db_connect();


$id_borrower = "";
$db = new db_class();
$user_id = $_SESSION['user_id'];
$account_type = "";
$totalPay = "";

// Dados do Muntuario
$firstname = "";
$middlename = "";
$lastname = "";

$result = $db->userID();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $account_type = $row['account_type'];
    }
}
include 'cf.php';
if (isset($_GET['id'])) {
    $loanID = $_GET['id'];

    // Consulta SQL para buscar os detalhes do empréstimo com base no ID
    $query = "SELECT * FROM loan WHERE id = $loanID";

    $result = $conn2->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
    $borrowerID = $row['borrower_id'];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" integrity="sha512-HXXR0l2yMwHDrDyxJbrMD9eLvPe3z3qL3PPeozNTsiHJEENxx8DH2CxmV05iwG0dwoz5n4gQZQyYLUNt1Wdgfg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion fixed" style=" background-color: #3d3747;
  background-image: linear-gradient(180deg, #3d3747 10%, #3d3747 100%);
  background-size: cover;" id="accordionSidebar">

            <!-- Marca da Barra Lateral -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
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
                    

                        
                        <?php
                        $sql = "SELECT * FROM borrower WHERE borrower_id = $borrowerID ";
                        $result = $conn2->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row2 = $result->fetch_assoc()) {

                                $middlename = $row2['middlename'];
                                $lastname = $row2['lastname'];
                                $firstname = $row2['firstname'];

                                echo '<div class="container mt-4">';
                                echo '    <div class="card border-0">';
                                echo '        <div class="row g-0">';
                                echo '            <div class="col-md-8">';
                                echo '                <div class="card-body">';
                                echo '                    <h5 class="card-title">' . $row2["firstname"] . ' ' . $row2["middlename"] . ' ' . $row2["lastname"] . '</h5>';
                                echo '                    <p class="card-text">' . $row2["profissao"] . '</p>';
                                echo '                    <div class="row">';
                                echo '                        <div class="col">';
                                echo '                            <div class="card bg-success text-white">';
                                echo '                                <div class="card-body">';
                                echo '                                    <h6 class="card-subtitle">BI</h6>';
                                echo '                                    <p class="card-text">' . $row2["tax_id"] . '</p>';
                                echo '                                </div>';
                                echo '                            </div>';
                                echo '                        </div>';
                                echo '                        <div class="col">';
                                echo '                            <div class="card bg-success text-white">';
                                echo '                                <div class="card-body">';
                                echo '                                    <h6 class="card-subtitle">Endereço</h6>';
                                echo '                                    <p class="card-text">' . $row2["address"] . '</p>';
                                echo '                                </div>';
                                echo '                            </div>';
                                echo '                        </div>';
                                echo '                        <div class="col">';
                                echo '                            <div class="card bg-success text-white">';
                                echo '                                <div class="card-body">';
                                echo '                                    <h6 class="card-subtitle">Telefone</h6>';
                                echo '                                    <p class="card-text">' . $row2["contact_no"] . '</p>';
                                echo '                                </div>';
                                echo '                            </div>';
                                echo '                        </div>';
                                echo '                        <div class="col">';
                                echo '                            <div class="card bg-success text-white">';
                                echo '                                <div class="card-body">';
                                if($row['status'] == 'negado')
                                {
                            
                                }else{
                                    echo '<a href="print.php?borrower='. $row2["firstname"] .' ' . $row2["middlename"] . ' ' . $row2["lastname"] .'&Bi= '.$row2["bi_passaport_n"].'&natural='.$row2['naturalidade'].','.$row2['provincia'].'&bairro='.$row2['bairro'].'&quarteirao='.$row2['quarteirao'].'&contacto='.$row2['contact_no'].'&profissao='.$row2['profissao'].'&casa_n='.$row2['casa_flat_n'].'&valor='.$row['amount'].'&taxadejuros='.$row['interest_rate'].'&multa='.$row['penalty'].'&data='.$row['approval_date'].'&loanID='.$loanID.' " target="_blank" class="btn btn-warning">Imprimir Contracto</a>';
                                }
                                

                                echo '                                </div>';
                                echo '                            </div>';
                                echo '                        </div>';
                                echo '                    </div>';
                                echo '                </div>';
                                echo '            </div>';
                                echo '        </div>';
                                echo '    </div>';
                                echo '</div>';
                            }
                        }

                        ?>
                    </div>
                    <div class="card shadow mb-4 <?php echo $statusClass ?>">

                        <?php
                        if ($row['status'] == 'pendente') {
                            echo '<div class="container mt-4 p-4">'; // Abre a div do container apenas se o status não for 'aprovado'
                        ?>
                            <div class="row">
                                <?php

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
                        } elseif ($row['status'] == 'aprovado' || $row['status'] == 'concluído') {
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
                                        <a class="nav-link" id="contract-tab" data-bs-toggle="tab" href="#contract" role="tab" aria-controls="contract" aria-selected="false">Contracto</a>
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
                                                <?php
                                                if ($row['status'] === 'concluído') {
                                                } else {
                                                    echo "<li class='nav-item' role='presentation'>
                                                        <a class='nav-link' id='addgarantiastab' data-bs-toggle='tab' href='#addgarantias' role='tab' aria-controls='addgarantias-tab' aria-selected='false'>Adicionar Nova</a>
                                                    </li>";
                                                }
                                                ?>

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
                                                            echo '<td>' . strftime("%d de %B de %Y", strtotime($row['data_aquisicao'])) . '</td>';
                                                            echo '<td>' . strftime("%d de %B de %Y", strtotime($row['data_vencimento'])) . '</td>';
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

                                                            <?php
                                                            // Inclua o arquivo cf.php para obter a conexão
                                                            include 'cf.php';

                                                            // Consulta para buscar dados de borrower
                                                            $queryGuarantees = "SELECT * FROM guarantees";
                                                            $resultGuarantees = $conn2->query($queryGuarantees);

                                                            // Verifica se a consulta de borrower foi executada com sucesso
                                                            if (!$resultGuarantees) {
                                                                echo "Erro na consulta de mutuários: " . $conn2->error;
                                                            } else {
                                                                // Verifica se não há borrowers disponíveis
                                                                if ($resultGuarantees->num_rows == 0) {
                                                                    echo '<p class="text-danger">Nenhuma Garantia disponível...</p>';
                                                                    echo '<a class="btn btn-primary" data-toggle="modal" data-target="#deleteltype">Adicionar Novos Garantias</a>';
                                                                } else {
                                                                    echo '<div class="form-group">
                                                                            <label for="borrowerSelect">Tipo de Garantia:  <a href="#"  data-toggle="modal" data-target="#deleteltype">Adicionar Garantias</a></label>
                                                                            <select class="form-control borrow" id="guaranteesSelect" name="garantiaTipo" style="width:100%;">
                                                                                <option selected="selected">Selecione Tipo de Garantia</option>';
                                                                    while ($row = $resultGuarantees->fetch_assoc()) {
                                                                        echo '<option value="' . $row['id'] . '">' . $row['name'] . ' </option>';
                                                                    }
                                                                    echo '</select>
                                                                     </div>';
                                                                }
                                                            } ?>

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
                                                            $sd = "SELECT ltype_name FROM loan_type WHERE ltype_id = " . $row['loan_type_id'];
                                                            $rs = $conn2->query($sd);
                                                            if ($rs->num_rows > 0) {
                                                                while ($r = $rs->fetch_assoc()) {
                                                                    echo "<td>" . $r['ltype_name'] . "</td>";
                                                                }
                                                            }
                                                            echo "<td>" . $row['valor_total'] . ' MT' . "</td>";
                                                            $totalPay = $row['valor_total'] ;
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
                                                                        <form id="paymentForm" method="POST" action="pagamentos.php">
                                                                            <div class="modal-body">


                                                                                <div class="form-group">
                                                                                    <label for="s"> Mutuário: <input class="form-control" disabled value="<?php echo $firstname . ' ' . $lastname ?>" type="text"></label>

                                                                                    <label for="paymentAmount">Valor do Pagamento: <?php

                                                                                                                                    $valor_parcela = $row['valor_parcela'];
                                                                                                                                    $valor_multa = $row['multa'];
                                                                                                                                    $valorTotal = $valor_parcela + $valor_multa; ?>
                                                                                        <input type="text" disabled class="form-control" value="<?php echo $valorTotal . ' MT'; ?>">
                                                                                    </label>
                                                                                    <br>

                                                                                    <input type="hidden" class="form-control" id="parcelId" name="parcelId" value="<?php echo $row['id']; ?>">
                                                                                    </br>
                                                                                    <input type="hidden" class="form-control" id="paymentAmount" name="paymentAmount" value="<?php echo $valorTotal; ?>">
                                                                                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                                                                                    <input type="hidden" id="borrowerid" name="borrowerid" value="<?php echo $borrowerID; ?>">

                                                                                </div>


                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="submit" class="btn btn-success" id="submitPayment">Enviar Pagamento</button>
                                                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                                                            </div>
                                                                        </form>
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

                                    <!-- Aba de Contracto-->
                                    <div class="tab-pane fade" id="payment-history" role="tabpanel" aria-labelledby="contract-tab">
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



                                echo '                            <div class="card bg-danger  text-white style="max-width: 200px">';
                                echo '                                <div class="card-body">';
                                echo '                                    <h6 class="card-subtitle"> O empréstimo foi recusado</h6>';

                                echo '                                </div>';
                                echo '                            </div>';
                                echo '<p>Detalhes do empréstimo:</p>';



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
                        <?php
                        }
                        echo '</div>';
                        ?>

                    </div>
                    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                </div>
                <!-- Fim do Conteúdo Principal -->

                <?php
                if (isset($_GET['message'])) {
                    $alert = $_GET['message'];

                    if ($alert == 'aproved') {
                ?>
                        <div class="container mt-4">
                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success">
                                            <h5 class="modal-title text-white" id="exampleModalLabel">Mensagem Importante </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span class="text-white" id="countdown" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Pagamento Enfectuado com Sucesso!!!
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>

                <?php
                if (isset($_GET['message'])) {
                    $alert = $_GET['message'];

                    if ($alert == 'garantiasaproved') {
                ?>
                        <div class="container mt-4">
                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success">
                                            <h5 class="modal-title text-white" id="exampleModalLabel">Mensagem Importante </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span class="text-white" id="countdown" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Garantias Salva com Sucesso!!!
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>

                <script>
                    $(document).ready(function() {
                        // Exiba o modal
                        $('#myModal').modal('show');

                        // Defina o tempo inicial do contador
                        var seconds = 5;

                        // Atualize o contador a cada segundo
                        var countdown = setInterval(function() {
                            $('#countdown').text(seconds);
                            seconds--;

                            // Se o contador chegar a 0, feche o modal
                            if (seconds < 0) {
                                clearInterval(countdown);
                                $('#myModal').modal('hide');
                            }
                        }, 1000);
                    });
                </script>'
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
        <!-- Modal Contracto -->

        
        <!-- Modal para solicitar empréstimo -->
        <div class="modal fade" id="deleteltype" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-lath">
                        <h5 class="modal-title text-dark">Adicinar Nova Garantia</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="save_guarantees.php">
                            <div class="form-group">
                                <label>Nome da Garantia</label>
                                <input type="text" class="form-control" name="gua_name" required="required" />
                            </div>
                            <div class="form-group">
                                <label>Descrição da Garantia</label>
                                <textarea style="resize:none;" class="form-control" name="gua_desc" required="required"></textarea>
                            </div>
                            <input type="hidden" name="loan_detalis" value="true">
                            <input type="hidden" name="loanID" value="<?php echo $loanID; ?>">
                            <button type="submit" class="btn btn-primary btn-block" name="save">Salvar</button>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <!--<a class="btn btn-danger" href="delete_ltype.php?ltype_id=<?php echo $fetch['id'] ?>">Excluir</a> -->
                    </div>
                </div>
            </div>
        </div>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

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