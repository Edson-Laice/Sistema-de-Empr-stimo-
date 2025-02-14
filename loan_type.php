<?php
date_default_timezone_set("Etc/GMT+8");
require_once 'session.php';
require_once 'class.php';
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
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Sistema de Gestão de Empréstimos</title>

    <link href="fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" integrity="sha512-HXXR0l2yMwHDrDyxJbrMD9eLvPe3z3qL3PPeozNTsiHJEENxx8DH2CxmV05iwG0dwoz5n4gQZQyYLUNt1Wdgfg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="css/dataTables.bootstrap4.css" rel="stylesheet">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" style=" background-color: #3d3747;
  background-image: linear-gradient(180deg, #3d3747 10%, #3d3747 100%);
  background-size: cover;" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3">PAINEL DE ADMINISTRAÇÃO</div>
            </a>


            <!-- Nav Item - Dashboard -->
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
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $db->user_acc($_SESSION['user_id']) ?></span>
                                <img class="img-profile rounded-circle" src="image/admin_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Sair
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tipo de Empréstimo</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="save_ltype.php">
                                        <div class="form-group">
                                            <label>Nome do Empréstimo</label>
                                            <input type="text" class="form-control" name="ltype_name" required="required" />
                                        </div>
                                        <div class="form-group">
                                            <label>Descrição do Empréstimo</label>
                                            <textarea style="resize:none;" class="form-control" name="ltype_desc" required="required"></textarea>
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
                                                    <th>Nome do Empréstimo</th>
                                                    <th>Descrição do Empréstimo</th>
                                                    <th>Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tbl_ltype = $db->display_ltype();
                                                while ($fetch = $tbl_ltype->fetch_array()) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $fetch['ltype_name'] ?></td>
                                                        <td><?php echo $fetch['ltype_desc'] ?></td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Ação
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item bg-warning text-white" href="#" data-toggle="modal" data-target="#updateltype<?php echo $fetch['ltype_id'] ?>">Editar</a>
                                                                    <a class="dropdown-item bg-danger text-white" href="#" data-toggle="modal" data-target="#deleteltype<?php echo $fetch['ltype_id'] ?>">Excluir</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- Delete Loan Type Modal -->

                                                    <div class="modal fade" id="deleteltype<?php echo $fetch['ltype_id'] ?>" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger">
                                                                    <h5 class="modal-title text-white">Informações do Sistema</h5>
                                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                        <span class="text-white" aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">Tem certeza de que deseja excluir esse registro?</div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                                                    <!--<a class="btn btn-danger" href="delete_ltype.php?ltype_id=<?php echo $fetch['ltype_id'] ?>">Excluir</a> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Update Loan Type Modal -->

                                                    <div class="modal fade" id="updateltype<?php echo $fetch['ltype_id'] ?>" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="POST" action="update_ltype.php">
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
                                                                            <input type="text" class="form-control" value="<?php echo $fetch['ltype_name'] ?>" name="ltype_name" required="required" />
                                                                            <input type="hidden" class="form-control" value="<?php echo $fetch['ltype_id'] ?>" name="ltype_id" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Descrição do Empréstimo</label>
                                                                            <textarea style="resize:none;" class="form-control" name="ltype_desc" required="required"><?php echo $fetch['ltype_desc'] ?></textarea>
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
                    <!-- End of Main Content -->

                    <!-- Footer -->
                    <footer class="stocky-footer">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Sistema de Gestão de Empréstimos com Direitos Autorais ©<?php echo date("Y") ?></span>
                            </div>
                        </div>
                    </footer>
                    <!-- End of Footer -->

                </div>
                <!-- End of Content Wrapper -->

            </div>
            <!-- End of Page Wrapper -->

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <!-- Logout Modal-->
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

            <!-- Bootstrap core JavaScript-->
            <script src="js/jquery.js"></script>
            <script src="js/bootstrap.bundle.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="js/jquery.easing.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.js"></script>

            <!-- Page level plugins -->
            <script src="js/jquery.dataTables.js"></script>
            <script src="js/dataTables.bootstrap4.js"></script>

            <script>
                $(document).ready(function() {
                    $('#dataTable').DataTable({
                        "order": [
                            [1, "asc"]
                        ]
                    });

                });
            </script>

</body>

</html>