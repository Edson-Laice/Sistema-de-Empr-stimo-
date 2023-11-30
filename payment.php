<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'session.php';
require_once 'class.php';
require_once 'config.php';
$connection = new db_connect();
$context = "";
if (isset($_GET["context"])) {
    $context = $_GET["context"];
}
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
        .alert-danger {
        text-align: center;
    }

    .alert-danger h4 {
        margin-bottom: 0; /* Para remover a margem padrão do h4 */
    }

    .alert-danger a {
        display: block;
        margin: 10px auto; /* Ajuste a margem conforme necessário */
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
            <li class="nav-item">
                <a class="nav-link" href="Reports.php">
                    <i class="ri-git-repository-fill"></i>
                    <span>Relatórios</span></a>
            </li>
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
                <div class="card shadow mb-4">
                    <?php if ($account_type === "gerente") {
                        if ($context === "pr") {
                            echo '<div class="card shadow mb-4">';
                            $total = 0;
                            $sql = "SELECT * FROM payments WHERE user_id = $user_id";
                            $result = $conn2->query($sql);
                            if ($result->num_rows > 0) {
                                echo '<div class="card-body">';
                                echo '<table class="table table-striped" id="dataTable" >';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th>Mutuário</th>';
                                echo '<th>ID</th>';
                                echo '<th>Parcela ID</th>';
                                echo '<th>Data e Hora do Pagamento</th>';
                                echo '<th>Valor do Pagamento</th>';
                                echo '<th>Gerente</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';

                                    $borrowerID = $row['br_id'];
                                    $borrower_sql = "SELECT firstname, lastname FROM borrower WHERE borrower_id = $borrowerID";
                                    $rsl = $conn2->query($borrower_sql);
                                    if($rsl->num_rows > 0)
                                    {
                                        while($row2 = $rsl->fetch_assoc())
                                        {
                                            echo '<td class="text-primary">'. $row2['firstname'].' ' . $row2['lastname'].'</td>';
                                        }
                                        
                                    }
                                    echo '<td>' . $row['id'] . '</td>';
                                    echo '<td>' . $row['parcela_id'] . '</td>';
                                    echo '<td>' . $row['data_hora_pagamento'] . '</td>';
                                    echo '<td>' . $row['valor_pagamento'] . ' MT' . '</td>';
                                    $total += $row['valor_pagamento'];
                                    $user_id = $row['user_id'];
                                    $user_sql = "SELECT firstname, lastname FROM user WHERE user_id = $user_id";
                                    $rsl2 = $conn2->query($user_sql);
                                    if($rsl2->num_rows > 0)
                                    {
                                        while($row3 = $rsl2->fetch_assoc())
                                        {
                                            echo '<td class="text-dark">'. $row3['firstname'].' ' . $row3['lastname'].'</td>';
                                        }
                                        
                                    }
                                    echo '</tr>';
                                }
                                echo '</tbody>';
                                echo '<thead>';
                                echo '<th class="" >Total</th>';
                                echo '</thead>';
                                echo '<tbody>';
                                echo '<td>' . $total . ' MT' . '</td>';
                                echo '<tbody>';
                                echo '</table>';
                                echo '</div>';
                            } else {
                                echo 'Nenhum pagamento encontrado para esta parcela.';
                            }
                            $conn2->close();
                            echo '</div>';
                        }
                    } else {
                        if ($context === "pr") {
                            echo '<div class="card shadow mb-4">';
                            $total = 0;
                            $sql = "SELECT * FROM payments";
                            $result = $conn2->query($sql);
                            if ($result->num_rows > 0) {
                                echo '<div class="card-body">';
                                echo '<table class="table table-striped" id="dataTable" >';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th>Mutuário</th>';
                                echo '<th>Parcela ID</th>';
                                echo '<th>Data e Hora do Pagamento</th>';
                                echo '<th>Valor do Pagamento</th>';
                                echo '<th>Gerente</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    $borrowerID = $row['br_id'];
                                    $borrower_sql = "SELECT firstname, lastname FROM borrower WHERE borrower_id = $borrowerID";
                                    $rsl = $conn2->query($borrower_sql);
                                    if($rsl->num_rows > 0)
                                    {
                                        while($row2 = $rsl->fetch_assoc())
                                        {
                                            echo '<td class="text-primary">'. $row2['firstname'].' ' . $row2['lastname'].'</td>';
                                        }
                                        
                                    }
                                    echo '<td>' . $row['parcela_id'] . '</td>';
                                    echo '<td>' . $row['data_hora_pagamento'] . '</td>';
                                    echo '<td>' . $row['valor_pagamento'] . ' MT' . '</td>';
                                    $total += $row['valor_pagamento'];

                                    $user_id = $row['user_id'];
                                    $user_sql = "SELECT firstname, lastname FROM user WHERE user_id = $user_id";
                                    $rsl2 = $conn2->query($user_sql);
                                    if($rsl2->num_rows > 0)
                                    {
                                        while($row3 = $rsl2->fetch_assoc())
                                        {
                                            echo '<td class="text-dark">'. $row3['firstname'].' ' . $row3['lastname'].'</td>';
                                        }
                                        
                                    }
                                    echo '</tr>';
                                }
                                echo '</tbody>';
                                echo '<thead>';
                                echo '<th class="" >Total</th>';
                                echo '</thead>';
                                echo '<tbody>';
                                echo '<td>' . $total . ' MT' . '</td>';
                                echo '<tbody>';
                                echo '</table>';
                                echo '</div>';
                            } else {
                                echo 'Nenhum pagamento encontrado para esta parcela.';
                            }
                            $conn2->close();
                            echo '</div>';
                        }
                    } ?>
                    <?php
                    if ($context == "pg") { ?>
                        <div class='card-body shadow mb-4'>
                            <?php
                            if ($account_type === "gerente") {
                            ?>
                                <div class="alert alert-danger text-center" role="alert">
                                    <h4 class="alert-heading">Dados não Disponíveis</h4>
                                    <a href="loan.php" class="btn btn-danger">Ir para a Página de Empréstimos</a>
                                    <hr>
                                </div>

                            <?php
                            } else {
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
                                            if ($account_type === "gerente") {
                                            ?>

                                                <?php
                                            } else {
                                                $query = "SELECT * FROM parcelas
                                    WHERE data_vencimento = '$dataAtual' AND status_pagamento = 'Não Pago'";

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
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            }
                            ?>

                        <?php } ?>
                        </div>
                            <?php 
                        if ($context == "multas") { ?>
                        <div class='card-body shadow mb-4'>
                            
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
                                            if ($account_type === "gerente") {
                                            ?>

                                                <?php
                                            } else {
                                                $query = "SELECT * FROM parcelas
                                    WHERE status_pagamento = 'Não Pago' AND status_multa = 'Multado'";

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
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        
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