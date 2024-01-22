<?php date_default_timezone_set("Etc/GMT+8"); ?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Loan Management System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" integrity="sha512-HXXR0l2yMwHDrDyxJbrMD9eLvPe3z3qL3PPeozNTsiHJEENxx8DH2CxmV05iwG0dwoz5n4gQZQyYLUNt1Wdgfg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/custom.css" rel="stylesheet">
</head>

<body style="background-color: #618B7C;">
    <section class="vh-300" style="background-color: #618B7C;">
        <div class="container py-5 h-150">
            
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                          
                            <img style="width: 100px;" src="image/Imagem1.png" alt="" srcset="">
                            <br>
                        
                            <h3 class="mb-5">Bem Vindo!!!</h3>
                            <form action="login.php" method="post">
                                <div class="form-outline mb-4">
                                    <input type="text" name="username" placeholder="Nome do Utilizador" class="form-control form-control-lg" required="required" />

                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" placeholder="senha" name="password" class="form-control form-control-lg" required="required" />
                                </div>
                                <?php
                                session_start();
                                if (isset($_SESSION['message'])) {
                                    echo "<div class='alert alert-danger text-center'>" . $_SESSION['message'] . "</div>";
                                }
                                ?>

                                <button class="btn btn-primary btn-user btn-block" type="submit" name="login">Login</button>

                            </form>


                            <hr class="my-4">
                            <h6>Sistema de Gestão de Micro-Finaças</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <footer class="stocky-footer">

        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <h6 class="text-white bord"> Loan System V1.0.1</h6>
            </div>
        </div>
    </footer>
    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>

</html>