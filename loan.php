<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'session.php';
require_once 'class.php';
require_once 'config.php';
$user_id = $_SESSION['user_id'];
$connection = new db_connect();
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
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Sistema de Gerenciamento de Empréstimos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" integrity="sha512-HXXR0l2yMwHDrDyxJbrMD9eLvPe3z3qL3PPeozNTsiHJEENxx8DH2CxmV05iwG0dwoz5n4gQZQyYLUNt1Wdgfg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <?php
                    if (isset($_GET['message'])) {
                        $alert = $_GET['message'];

                        if ($alert == 'falid') {
                    ?>
                            <div class="container mt-4">
                                <!-- Modal -->
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning">
                                                <h5 class="modal-title text-white" id="exampleModalLabel">Mensagem Importante </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span class="text-white" id="countdown" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Solicitação de Empréstimo Recusada
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }elseif($alert == 'aproved')
                        {
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
                                                Solicitação Salva com Sucesso
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <?php
                        }
                    }
                    ?>




                    <!-- Bootstrap JS e jQuery (necessários para alguns recursos do Bootstrap) -->
                    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

                    <!-- Adicione o script para desaparecer o modal após 5 segundos -->
                    <script>
                        $(document).ready(function() {
                            // Exiba o modal
                            $('#myModal').modal('show');

                            // Defina o tempo inicial do contador
                            var seconds = 2;

                            // Atualize o contador a cada segundo
                            var countdown = setInterval(function() {
                                $('#countdown').text( seconds );
                                seconds--;

                                // Se o contador chegar a 0, feche o modal
                                if (seconds < 0) {
                                    clearInterval(countdown);
                                    $('#myModal').modal('hide');
                                }
                            }, 1000);
                        });
                    </script>'
                    <!-- Título da Página -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Painel de Empréstimos</h1>
                    </div>

                    <!-- Linha de Conteúdo -->
                    <div class="card shadow mb-4">

                        <div class="card-body">
                            <button class="btn btn-success p-2 m-1" data-toggle="modal" data-target="#solicitarEmprestimoModal">Solicitar Empréstimo</button>
                            <button class="btn btn-primary p-2 m-1" data-toggle="modal" data-target="#emprestimoConcluidosmoModal">Empréstimos Concluídos</button>
                            <button class="btn btn-danger p-2 m-1" data-toggle="modal" data-target="#emprestimoRecuzadosmoModal">Empréstimos Recuzados</button>
                            <div class="table-responsive">
                                <table class="table" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Referência</th>
                                            <th>Mutuário</th>
                                            <th>Valor emprestado</th>
                                            <th>Taxa de juros</th>
                                            <th>Multa</th>
                                            <th>Status</th>
                                            <th>Data de Lançamento</th>
                                            <th>Data de Aprovação</th>
                                            <th>Data de Conclusão</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Inclua o arquivo cf.php para obter a conexão com o banco de dados

                                        $obj = new db_class(); // Criar uma instância da classe db_class

                                        // Chame a função display_loan() para obter os dados da tabela "loan"
                                        $result = $obj->display_loan();

                                        // Verifique se a consulta foi bem-sucedida
                                        if ($result) {
                                            while ($row = $result->fetch_assoc()) {
                                                // Define a classe CSS com base no valor da coluna "status"
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
                                                echo '<td>' . $row['id'] . '</td>';
                                                echo '<td>' . $row['ref'] . '</td>';
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
                                                echo '<td>' . $row['interest_rate'] . '%</td>';
                                                echo '<td>' . number_format($row['penalty'], 2) . '%</td>';
                                                echo '<td class="' . $statusClass . '">' . $row['status'] . '</td>';
                                                echo '<td>' . strftime("%d de %B de %Y", strtotime($row['release_date'])) . '</td>';
                                                echo '<td>' . strftime("%d de %B de %Y", strtotime($row['approval_date'])) . '</td>';
                                                echo '<td>' . strftime("%d de %B de %Y", strtotime($row['completion_date'])) . '</td>';
                                                echo '<td><a class="btn btn-primary" href="loan_details.php?id=' . $row['id'] . '">Detalhes</a></td>';



                                                echo '</tr>';
                                            }
                                        } else {
                                            echo "Erro na consulta de dados da tabela loan: " . $conn2->error;
                                        }
                                        ?>


                                    </tbody>
                                </table>

                                <!-- Botões para navegação de páginas -->
                                <div class="text-center">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination" id="pagination">
                                            <!-- Os botões de página serão carregados dinamicamente aqui -->
                                        </ul>
                                    </nav>
                                </div>
                            </div>

                            <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

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


        <script>
            // Manipulador de clique do botão "Detalhes"
            $('button[data-toggle="modal"]').on('click', function() {
                var borrowerID = $(this).data('borrower-id');
                var firstname = $(this).data('firstname');
                var lastname = $(this).data('lastname');
                var address = $(this).data('address');
                var email = $(this).data('email');

                // Preencha os campos do modal com os detalhes do mutuário
                $('#detalhesBorrowerModal #detalhesFirstname').text(firstname);
                $('#detalhesBorrowerModal #detalhesLastname').text(lastname);
                $('#detalhesBorrowerModal #detalhesAddress').text(address);
                $('#detalhesBorrowerModal #detalhesEmail').text(email);

                // Você pode adicionar o ID do mutuário a um campo oculto se precisar usá-lo posteriormente
                $('#detalhesBorrowerModal #borrowerId').val(borrowerID);
            });
        </script>

        <!-- Emprestimos Recuzados-->
        <div class="modal fade" id="emprestimoRecuzadosmoModal" tabindex="-1" role="dialog" aria-labelledby="emprestimoRecuzadosmoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 226%; margin-left:-297px;">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white" id="emprestimoRecuzadosmoModalabel">Empréstimos Recuzados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Referência</th>
                                        <th>Mutuário</th>
                                        <th>Valor emprestado</th>
                                        <th>Taxa de juros</th>
                                        <th>Multa</th>
                                        <th>Status</th>
                                        <th>Data de Lançamento</th>
                                        <th>Data de Aprovação</th>
                                        <th>Data de Conclusão</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Inclua o arquivo cf.php para obter a conexão com o banco de dados

                                    $obj = new db_class(); // Criar uma instância da classe db_class

                                    // Chame a função display_loan() para obter os dados da tabela "loan"
                                    $result = $obj->display_loanfiled();

                                    // Verifique se a consulta foi bem-sucedida
                                    if ($result) {
                                        while ($row = $result->fetch_assoc()) {
                                            // Define a classe CSS com base no valor da coluna "status"
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
                                            echo '<td>' . $row['id'] . '</td>';
                                            echo '<td>' . $row['ref'] . '</td>';
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
                                            echo '<td>' . $row['interest_rate'] . '%</td>';
                                            echo '<td>' . number_format($row['penalty'], 2) . '%</td>';
                                            echo '<td class="' . $statusClass . '">' . $row['status'] . '</td>';
                                            echo '<td>' . strftime("%d de %B de %Y", strtotime($row['release_date'])) . '</td>';
                                            echo '<td>' . strftime("%d de %B de %Y", strtotime($row['approval_date'])) . '</td>';
                                            echo '<td>' . strftime("%d de %B de %Y", strtotime($row['completion_date'])) . '</td>';
                                            echo '<td><a class="btn btn-primary" href="loan_details.php?id=' . $row['id'] . '">Detalhes</a></td>';



                                            echo '</tr>';
                                        }
                                    } else {
                                        echo "Erro na consulta de dados da tabela loan: " . $conn2->error;
                                    }
                                    ?>


                                </tbody>
                            </table>

                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

                    </div>
                </div>
            </div>
        </div>
        <!--Model de  Empréstimos concluídos-->
        <div class="modal fade" id="emprestimoConcluidosmoModal" tabindex="-1" role="dialog" aria-labelledby="emprestimoConcluidosModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 226%; margin-left:-297px;">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="emprestimoConcluidosModalLabel">Empréstimos Concluídos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Referência</th>
                                            <th>Mutuário</th>
                                            <th>Valor emprestado</th>
                                            <th>Taxa de juros</th>
                                            <th>Multa</th>
                                            <th>Status</th>
                                            <th>Data de Lançamento</th>
                                            <th>Data de Aprovação</th>
                                            <th>Data de Conclusão</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Inclua o arquivo cf.php para obter a conexão com o banco de dados

                                        $obj = new db_class(); // Criar uma instância da classe db_class

                                        // Chame a função display_loan() para obter os dados da tabela "loan"
                                        $result = $obj->display_loanfinche();

                                        // Verifique se a consulta foi bem-sucedida
                                        if ($result) {
                                            while ($row = $result->fetch_assoc()) {
                                                // Define a classe CSS com base no valor da coluna "status"
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
                                                echo '<td>' . $row['id'] . '</td>';
                                                echo '<td>' . $row['ref'] . '</td>';
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
                                                echo '<td>' . $row['interest_rate'] . '%</td>';
                                                echo '<td>' . number_format($row['penalty'], 2) . '%</td>';
                                                echo '<td class="' . $statusClass . '">' . $row['status'] . '</td>';
                                                echo '<td>' . strftime("%d de %B de %Y", strtotime($row['release_date'])) . '</td>';
                                                echo '<td>' . strftime("%d de %B de %Y", strtotime($row['approval_date'])) . '</td>';
                                                echo '<td>' . strftime("%d de %B de %Y", strtotime($row['completion_date'])) . '</td>';
                                                echo '<td><a class="btn btn-primary" href="loan_details.php?id=' . $row['id'] . '">Detalhes</a></td>';



                                                echo '</tr>';
                                            }
                                        } else {
                                            echo "Erro na consulta de dados da tabela loan: " . $conn2->error;
                                        }
                                        ?>


                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

                    </div>
                </div>
            </div>
        </div>


        <!-- Modal para solicitar empréstimo -->
        <div class="modal fade" id="solicitarEmprestimoModal" tabindex="-1" role="dialog" aria-labelledby="solicitarEmprestimoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="solicitarEmprestimoModalLabel">Solicitar Empréstimo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="save_loan.php" method="post">

                            <?php
                            // Inclua o arquivo cf.php para obter a conexão
                            include 'cf.php';

                            // Consulta para buscar dados de borrower
                            $queryBorrower = "SELECT * FROM borrower";
                            $resultBorrower = $conn2->query($queryBorrower);

                            // Verifica se a consulta de borrower foi executada com sucesso
                            if (!$resultBorrower) {
                                echo "Erro na consulta de mutuários: " . $conn2->error;
                            } else {
                                // Verifica se não há borrowers disponíveis
                                if ($resultBorrower->num_rows == 0) {
                                    echo '<p>Nenhum mutuário disponível. Crie um mutuário primeiro.</p>';
                                    echo '<a class="btn btn-primary" href="borrower.php">Criar Mutuário</a>';
                                } else {
                                    echo '<div class="form-group">
                                    <label for="borrowerSelect">Selecione o Mutuário:</label>
                                    <select class="form-control borrow" id="borrowerSelect" name="borrower_id" style="width:100%;">
                                        <option selected="selected">Selecione um mutuário</option>';
                                    while ($row = $resultBorrower->fetch_assoc()) {
                                        echo '<option value="' . $row['borrower_id'] . '">' . $row['firstname'] . ' ' . $row['lastname'] . '</option>';
                                    }
                                    echo '</select>
                                </div>';
                                }
                            }

                            // Consulta para buscar dados de loan_type
                            $queryLoanType = "SELECT ltype_id, ltype_name FROM loan_type";
                            $resultLoanType = $conn2->query($queryLoanType);

                            // Verifica se a consulta de loan_type foi executada com sucesso
                            if (!$resultLoanType) {
                                echo "Erro na consulta de tipos de empréstimo: " . $conn2->error;
                            } else {
                                // Verifica se não há loan_types disponíveis
                                if ($resultLoanType->num_rows == 0) {
                                    echo '<p>Nenhum tipo de empréstimo disponível. Crie um tipo de empréstimo primeiro.</p>';
                                    echo '<a class="btn btn-primary" href="loan_type.php">Criar Tipo de Empréstimo</a>';
                                } else {
                                    echo '<div class="form-group">
                                        <label for "loanTypeSelect">Selecione o Tipo de Empréstimo:</label>
                                        <select class="form-control" id="loanTypeSelect" name="loan_type_id">
                                            <option value="">Selecione um tipo de empréstimo</option>';
                                    while ($row = $resultLoanType->fetch_assoc()) {
                                        echo '<option value="' . $row['ltype_id'] . '">' . $row['ltype_name'] . '</option>';
                                    }
                                    echo '</select>
                                    </div>';
                                }
                            }
                            ?>


                            <div class="form-group">
                                <label for="amountInput">Quantia:</label>
                                <input type="text" class="form-control" placeholder="10000.00 MT" id="amountInput" name="amount">
                            </div>

                            <div class="form-group">
                                <label for="interestRateInput">Taxa de Juros:</label>
                                <input type="text" class="form-control" placeholder="25%" id="interestRateInput" name="interest_rate">
                            </div>

                            <div class="form-group">
                                <label for="penaltyInput">Duração (Meses)</label>
                                <input type="text" class="form-control" placeholder="1 = 1 mês" id="penaltyInput" name="duration_months">
                            </div>
                            <div class="form-group">
                                <label for="penaltyInput">Multa:</label>
                                <input type="text" class="form-control" placeholder="10% ao dia" id="penaltyInput" name="penalty">
                            </div>
                            <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                            <button type="submit" name="save" class="btn btn-primary" id="enviarSolicitacao">Enviar Solicitação</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

                    </div>
                </div>
            </div>
        </div>


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