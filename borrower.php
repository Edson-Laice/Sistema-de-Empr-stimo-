<?php
	date_default_timezone_set("Etc/GMT+8");
	require_once 'session.php';
	require_once 'class.php';
	$db = new db_class();
?>
<!DOCTYPE html>
<html lang="pt">

<head>
	<style>
		input[type=number]::-webkit-inner-spin-button,
		input[type=number]::-webkit-outer-spin-button {
			-webkit-appearance: none;
		}
	</style>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Sistema de Gerenciamento de Empréstimos</title>

	<link href="fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">


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
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
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
			<li class="nav-item active">
				<a class="nav-link" href="borrower.php">
					<i class="fas fa-fw fas fa-book"></i>
					<span>Mutuárois</span></a>
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

						<!-- Item de Navegação - Informações do Usuário -->
						<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
								data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $db->user_acc($_SESSION['user_id'])?></span>
								<img class="img-profile rounded-circle"
									src="image/admin_profile.svg">
							</a>
							<!-- Menu Suspenso - Informações do Usuário -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
								aria-labelledby="userDropdown">
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
									<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
									Sair
								</a>
							</div>
						</li>

					</ul>

				</nav>
				<!-- Fim da Barra Superior -->

				<!-- Conteúdo da Página -->
				<div class="container-fluid">

					<!-- Título da Página -->
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h3 mb-0 text-gray-800">Lista de Tomadores</h1>
					</div>
					<div class="row">
						<button class="ml-3 mb-3 btn btn-lg btn-primary" href="#" data-toggle="modal" data-target="#addModal"><span class="fa fa-plus"></span> Novo Tomador</button>
					</div>
					<!-- Exemplo da Tabela de Dados -->
					<div class="card shadow mb-4">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>Nome</th>
											<th>Nome do Meio</th>
											<th>Sobrenome</th>
											<th>Número de Contato</th>
											<th>Endereço</th>
											<th>Email</th>
											<th>Identificação Fiscal</th>
											<th>Ação</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$tbl_borrower = $db->display_borrower();
											
											while ($fetch = $tbl_borrower->fetch_array()) {
										?>
										<tr>
											<td><?php echo $fetch['firstname']?></td>
											<td><?php echo $fetch['middlename']?></td>
											<td><?php echo $fetch['lastname']?></td>
											<td><?php echo $fetch['contact_no']?></td>
											<td><?php echo $fetch['address']?></td>
											<td><?php echo $fetch['email']?></td>
											<td><?php echo $fetch['tax_id']?></td>
											<td>
												<div class="dropdown">
													<button class="btn btn-secondary dropdown-toggle" type="button"
														id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
														aria-expanded="false">
														Ação
													</button>
													<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
														<a class="dropdown-item bg-warning text-white" href="#"
															data-toggle="modal" data-target="#updateborrower<?php echo $fetch['borrower_id']?>">Editar</a>
														<a class="dropdown-item bg-danger text-white" href="#"
															data-toggle="modal" data-target="#deleteborrower<?php echo $fetch['borrower_id']?>">Excluir</a>
													</div>
												</div>
											</td>
										</tr>

										<!-- Modal de Atualização de Tomador -->
										<div class="modal fade" id="updateborrower<?php echo $fetch['borrower_id']?>" tabindex="-1"
											aria-hidden="true">
											<div class="modal-dialog">
												<form method="POST" action="updateBorrower.php">
													<div class="modal-content">
														<div class="modal-header bg-warning">
															<h5 class="modal-title text-white">Editar Tomador</h5>
															<button class="close" type="button" data-dismiss="modal"
																aria-label="Close">
																<span aria-hidden="true">×</span>
															</button>
														</div>
														<div class="modal-body">
															<div class="form-group">
																<label>Nome</label>
																<input type="text" name="firstname" value="<?php echo $fetch['firstname']?>"
																	class="form-control" required="required" />
																<input type="hidden" name="borrower_id"
																	value="<?php echo $fetch['borrower_id']?>" />
															</div>
															<div class="form-group">
																<label>Nome do Meio</label>
																<input type="text" name="middlename"
																	value="<?php echo $fetch['middlename']?>" class="form-control"
																	required="required" />
															</div>
															<div class="form-group">
																<label>Sobrenome</label>
																<input type="text" name="lastname" value="<?php echo $fetch['lastname']?>"
																	class="form-control" required="required" />
															</div>
															<div class="form-group">
																<label>Número de Contato</label>
																<input type="tel" name="contact_no"
																	value="<?php echo $fetch['contact_no']?>" class="form-control"
																	placeholder="Ex.[0965 567 6544]"
																	pattern="[0-9]{4} [0-9]{3} [0-9]{4}" required="required" />
															</div>
															<div class="form-group">
																<label>Endereço</label>
																<input type="text" name="address" value="<?php echo $fetch['address']?>"
																	class="form-control" required="required" />
															</div>
															<div class="form-group">
																<label>Email</label>
																<input type="email" name="email" value="<?php echo $fetch['email']?>"
																	class="form-control" required="required" maxlength="30" />
															</div>
															<div class="form-group">
																<label>Identificação Fiscal (deve ser válida)</label>
																<input type="number" name="tax_id" min="0" value="<?php echo $fetch['tax_id']?>"
																	class="form-control" required="required" />
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

										<!-- Modal de Exclusão de Tomador -->
										<div class="modal fade" id="deleteborrower<?php echo $fetch['borrower_id']?>" tabindex="-1"
											aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header bg-danger">
														<h5 class="modal-title text-white">Informação do Sistema</h5>
														<button class="close" type="button" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">×</span>
														</button>
													</div>
													<div class="modal-body">Tem certeza de que deseja excluir este registro?</div>
													<div class="modal-footer">
														<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
														<a class="btn btn-danger" href="deleteBorrower.php?borrower_id=<?php echo $fetch['borrower_id']?>">Excluir</a>
													</div>
												</div>
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
				<!-- Fim do Conteúdo Principal -->

				<!-- Rodapé -->
				<footer class="stocky-footer">
					<div class="container my-auto">
						<div class="copyright text-center my-auto">
							<span>Direitos Autorais &copy; Sistema de Gerenciamento de Empréstimos <?php echo date("Y")?></span>
						</div>
					</div>
				</footer>
				<!-- Fim do Rodapé -->

			</div>
			<!-- Fim do Envoltório do Conteúdo -->

		</div>
		<!-- Fim do Envoltório da Página -->

		<!-- Botão de Rolagem para o Topo -->
		<a class="scroll-to-top rounded" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>

		<!-- Modal de Adicionar Tomador -->
		<div class="modal fade" id="addModal" aria-hidden="true">
			<div class="modal-dialog">
				<form method="POST" action="save_borrower.php">
					<div class="modal-content">
						<div class="modal-header bg-primary">
							<h5 class="modal-title text-white">Formulário de Tomador</h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label>Nome</label>
								<input type="text" name="firstname" class="form-control" required="required" />
							</div>
							<div class="form-group">
								<label>Nome do Meio</label>
								<input type="text" name="middlename" class="form-control" required="required" />
							</div>
							<div class="form-group">
								<label>Sobrenome</label>
								<input type="text" name="lastname" class="form-control" required="required" />
							</div>
							<div class="form-group">
								<label>Número de Contato</label>
								<input type="tel" name="contact_no" class="form-control" placeholder="Ex.[+258 84 000 0000]"
									 required="required" />
							</div>
							<div class="form-group">
								<label>Endereço</label>
								<input type="text" name="address" class="form-control" required="required" />
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" name="email" class="form-control" required="required" maxlength="30" />
							</div>
							<div class="form-group">
								<label>Identificação Fiscal (deve ser válida)</label>
								<input type="number" name="tax_id" min="0" class="form-control" required="required" />
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
							<button type="submit" name="save" class="btn btn-primary">Salvar</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<!-- Modal de Logout -->
		<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header bg-danger">
						<h5 class="modal-title text-white">Informação do Sistema</h5>
						<button class="close" type="button" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">Tem certeza de que deseja fazer logout?</div>
					<div class="modal-footer">
						<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
						<a class="btn btn-danger" href="logout.php">Logout</a>
					</div>
				</div>
			</div>
		</div>

		<!-- JavaScript do Bootstrap -->
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.bundle.js"></script>

		<!-- JavaScript do Plugin Principal -->
		<script src="js/jquery.easing.js"></script>

		<!-- Plugins de Nível da Página -->
		<script src="js/jquery.dataTables.js"></script>
		<script src="js/dataTables.bootstrap4.js"></script>

		<!-- Scripts Personalizados para Todas as Páginas -->
		<script src="js/sb-admin-2.js"></script>

		<script>
			$(document).ready(function () {
				$('#dataTable').DataTable({
					"order": [[2, "asc"]]
				});
			});
		</script>

	</body>

</html>
