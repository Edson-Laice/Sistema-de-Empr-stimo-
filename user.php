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

    <title>Loan Management System</title>

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
            <li class="nav-item">
                <a class="nav-link" href="Reports.php">
                <i class="ri-git-repository-fill"></i>
                    <span>Relatórios</span></a>
            </li>
    
            <li class="nav-item">
                <a class="nav-link" href="loan_type.php">
                    <i class="fas fa-fw fa-money-check"></i>
                    <span>Tipos de Empréstimos</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="user.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Usuários</span></a>
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
                        <h1 class="h3 mb-0 text-gray-800">Panel de Usuários</h1>
                    </div>
                    <button class="mb-2 btn btn-lg btn-success" href="#" data-toggle="modal" data-target="#addModal"><span></span>Novo Usuário</button>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nome de usuário</th>
                                            <th>Nome Completo</th>
                                            <th>Tipo de Conta</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tbl_user = $db->display_user();

                                        while ($fetch = $tbl_user->fetch_array()) {
                                        ?>

                                            <tr>
                                                <td><?php echo $fetch['username'] ?></td>
                                                <td><?php echo $fetch['firstname'] . " " . $fetch['lastname'] ?></td>
                                                <td><?php echo $fetch['account_type']?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item bg-warning text-white" href="#" data-toggle="modal" data-target="#updateModal<?php echo $fetch['user_id'] ?>"><i class="fa fa-edit fa-1x"></i> Edit</a>
                                                            <?php
                                                            if ($fetch['user_id'] == $_SESSION['user_id']) {
                                                            ?>
                                                                <a class="dropdown-item bg-danger text-white" href="#" disabled="disabled"><i class="fa fa-exclamation fa-1x"></i> Cannot Delete</a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="dropdown-item bg-danger text-white" href="#" data-toggle="modal" data-target="#deleteModal<?php echo $fetch['user_id'] ?>"><i class="fa fa-trash fa-1x"></i> Delete</a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>


                                                </td>
                                            </tr>


                                            <!-- Update User Modal -->
                                            <div class="modal fade" id="updateModal<?php echo $fetch['user_id'] ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form method="POST" action="updateUser.php">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-warning">
                                                                <h5 class="modal-title text-white">Edit User</h5>
                                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Nome do Usuário</label>
                                                                    <input type="text" name="username" value="<?php echo $fetch['username'] ?>" class="form-control" required="required" />
                                                                    <input type="hidden" name="user_id" value="<?php echo $fetch['user_id'] ?>" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Senha</label>
                                                                    <input type="password" name="password" value="<?php echo $fetch['password'] ?>" class="form-control" required="required" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Primeiro Nome</label>
                                                                    <input type="text" name="firstname" value="<?php echo $fetch['firstname'] ?>" class="form-control" required="required" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Último Nomre</label>
                                                                    <input type="text" name="lastname" value="<?php echo $fetch['lastname'] ?>" class="form-control" required="required" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Selecione o Novo Tipo de Conta:</label>
                                                                    <select class="form-control" name="account_type" id="account_type">
                                                                        <option value="administrador">Administrador</option>
                                                                        <option value="gerente">Gerente</option>
                                                                        <option value="gerente_geral">Gerente Geral</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                                                <button type="submit" name="update" class="btn btn-warning">Atualizar</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>



                                            <!-- Delete User Modal -->






                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="stocky-footer">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Loan Management System <?php echo date("Y") ?></span>
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


        <!-- Add User Modal-->
        <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="addUser.php">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white">Add User</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nome do Usuário</label>
                                <input type="text" name="username" class="form-control" required="required" />
                            </div>
                            <div class="form-group">
                                <label>Senha</label>
                                <input type="password" name="password" class="form-control" required="required" />
                            </div>
                            <div class="form-group">
                                <label>Primeiro Nome</label>
                                <input type="text" name="firstname" class="form-control" required="required" />
                            </div>
                            <div class="form-group">
                                <label>Ultimo Nome</label>
                                <input type="text" name="lastname" class="form-control" required="required" />
                            </div>
                            </br>
                            <div class="form-group">
                                <select id="cargo" name="account_type" id="account_type" class="form-control">
                                    <option>Selecione o Status da conta</option>
                                    <option value="administrador">Administrador</option>
                                    <option value="gerente">Gerente</option>
                                    <option value="gerente_geral">Gerente Geral</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                            <button type="submit" name="confirm" class="btn btn-primary">Confirmar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">System Information</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Are you sure you want to logout?</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger" href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.bundle.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="js/jquery.easing.js"></script>


        <!-- Page level plugins -->
        <script src="js/jquery.dataTables.js"></script>
        <script src="js/dataTables.bootstrap4.js"></script>


        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.js"></script>

        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable({
                    "order": [
                        [3, "asc"]
                    ]
                });
            });
        </script>

</body>

</html>