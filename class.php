<?php
require_once 'config.php';

class db_class extends db_connect
{

	public function __construct()
	{
		$this->connect();
	}
	/* User Function */

	public function aplicarMultasDiarias()
	{
		// Obtém empréstimos atrasados
		$query = $this->conn->prepare("SELECT id, amount, penalty FROM loan WHERE status = 'aprovado' AND completion_date < CURDATE()");
		$query->execute();
		$result = $query->get_result();

		while ($loan = $result->fetch_assoc()) {
			// Verifica se o empréstimo já foi multado hoje
			$multaAplicadaHoje = $this->verificarMultaAplicadaHoje($loan['id']);

			if (!$multaAplicadaHoje) {
				// Obtém o número total e o status_pagamento das parcelas não pagas
				$queryParcelas = $this->conn->prepare("SELECT COUNT(*) AS total, SUM(CASE WHEN status_pagamento = 'Não Pago' THEN 1 ELSE 0 END) AS nao_pagas FROM parcelas WHERE loan_id = ? AND data_vencimento < CURDATE() AND status_multa IS NULL");
				$queryParcelas->bind_param("i", $loan['id']);
				$queryParcelas->execute();
				$resultParcelas = $queryParcelas->get_result();
				$dadosParcelas = $resultParcelas->fetch_assoc();

				if ($dadosParcelas['total'] > 0) {
					// Calcula a porcentagem de parcelas não pagas
					$porcentagemNaoPagas = ($dadosParcelas['nao_pagas'] / $dadosParcelas['total']) * 100;

					// Calcula o valor da multa
					$valorMulta = $loan['amount'] * ($porcentagemNaoPagas / 100) * ($loan['penalty'] / 100);

					// Aplica a multa nas parcelas para cada dia ausente
					$diasAusentes = $this->obterDiasAusentes($loan['completion_date']);
					foreach ($diasAusentes as $dia) {
						$this->aplicarMultaNasParcelas($loan['id'], $valorMulta, $dia);
					}

					// Registra a multa aplicada hoje na tabela multas_diarias
					$this->registrarMultaDiaria($loan['id']);
				}
			}
		}
	}

	private function obterDiasAusentes($dataInicio)
	{
		$diasAusentes = array();
		$dataAtual = new DateTime();
		$dataInicio = new DateTime($dataInicio);

		while ($dataInicio < $dataAtual) {
			$diasAusentes[] = $dataInicio->format('Y-m-d');
			$dataInicio->modify('+1 day');
		}

		return $diasAusentes;
	}

	private function verificarMultaAplicadaHoje($loanId)
	{
		$query = $this->conn->prepare("SELECT id FROM multas_diarias WHERE loan_id = ? AND data_multa = CURDATE()");
		$query->bind_param("i", $loanId);
		$query->execute();
		$result = $query->get_result();
		return $result->num_rows > 0;
	}

	private function aplicarMultaNasParcelas($loanId, $valorMulta, $data)
	{
		$query = $this->conn->prepare("UPDATE parcelas SET multa = multa + ?, status_multa = 'Multado' WHERE loan_id = ? AND status_pagamento = 'Não Pago' AND status_multa IS NULL AND data_vencimento = ?");
		$query->bind_param("dis", $valorMulta, $loanId, $data);
		$query->execute();
	}

	private function registrarMultaDiaria($loanId)
	{
		$query = $this->conn->prepare("INSERT INTO multas_diarias (loan_id, data_multa, multa_aplicada) VALUES (?, CURDATE(), 1)");
		$query->bind_param("i", $loanId);
		$query->execute();
	}



	public function add_user($username, $password, $firstname, $lastname, $account_type)
	{


		$query = $this->conn->prepare("INSERT INTO `user` (`username`, `password`, `firstname`, `lastname`, `account_type`) VALUES(?, ?, ?, ?, ?)") or die($this->conn->error);
		$query->bind_param("sssss", $username, $password, $firstname, $lastname, $account_type);

		if ($query->execute()) {
			$query->close();
			$this->conn->close();
			return true;
		}
	}


	public function update_user($user_id, $username, $password, $firstname, $lastname, $account_type)
	{
		$query = $this->conn->prepare("UPDATE `user` SET `username`=?, `password`=?, `firstname`=?, `lastname`=?, `account_type`=? WHERE `user_id`=?") or die($this->conn->error);
		$query->bind_param("sssssi", $username, $password, $firstname, $lastname, $account_type, $user_id);

		if ($query->execute()) {
			$query->close();
			$this->conn->close();
			return true;
		}
	}

	public function login($username, $password)
	{
		$query = $this->conn->prepare("SELECT * FROM `user` WHERE `username`='$username' && `password`='$password'") or die($this->conn->error);
		if ($query->execute()) {

			$result = $query->get_result();

			$valid = $result->num_rows;

			$fetch = $result->fetch_array();

			return array(
				'user_id' => isset($fetch['user_id']) ? $fetch['user_id'] : 0,
				'count' => isset($valid) ? $valid : 0
			);
		}
	}

	public function hasPendingOrApprovedLoan($borrower_id)
	{
		// Consulta SQL para verificar se o mutuário possui um empréstimo pendente ou aprovado
		$query = "SELECT COUNT(*) as count FROM loans WHERE borrower_id = $borrower_id AND (status = 'pendente' OR status = 'aprovado')";

		$result = $this->conn->query($query);

		if ($result) {
			$row = $result->fetch_assoc();
			$count = $row['count'];

			return $count > 0;
		} else {
			return false;
		}
	}

	public function getLoanById($loanID)
	{
		$query = $this->conn->prepare("SELECT * FROM `loan` WHERE `id` = ?");
		$query->bind_param("i", $loanID);

		if ($query->execute()) {
			$result = $query->get_result();
			if ($result->num_rows > 0) {
				return $result->fetch_assoc();
			}
		}
		return null;
	}



	public function user_acc($user_id)
	{
		$query = $this->conn->prepare("SELECT * FROM `user` WHERE `user_id`='$user_id'") or die($this->conn->error);
		if ($query->execute()) {
			$result = $query->get_result();

			$valid = $result->num_rows;

			$fetch = $result->fetch_array();

			return $fetch['firstname'] . " " . $fetch['lastname'];
		}
	}

	function hide_pass($str)
	{
		$len = strlen($str);

		return str_repeat('*', $len);
	}

	public function display_user()
	{
		$query = $this->conn->prepare("SELECT * FROM `user`") or die($this->conn->error);
		if ($query->execute()) {
			$result = $query->get_result();
			return $result;
		}
	}


	public function delete_user($user_id)
	{
		$query = $this->conn->prepare("DELETE FROM `user` WHERE `user_id` = '$user_id'") or die($this->conn->error);
		if ($query->execute()) {
			$query->close();
			$this->conn->close();
			return true;
		}
	}

	/**Loan Function */
	public function insertLoan($borrower_id, $loan_type_id, $amount, $interest_rate, $penalty, $duration_months, $user_id, $employment_type, $income_type, $start_date)
	{
		// Gere um número de referência único
		$ref = mt_rand(1, 99999999);

		// Obtenha a data atual
		$release_date = date('Y-m-d');

		// Defina o status como "pendente" por padrão
		$status = 'pendente';

		$query = $this->conn->prepare("INSERT INTO `loan` (`ref`, `borrower_id`, `loan_type_id`, `amount`, `interest_rate`, `penalty`, `status`, `release_date`, `duration_months`, `user_id`, `employment_type`, `income_type`, `start_date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

		if ($query) {
			$query->bind_param("siiddsssiiiss", $ref, $borrower_id, $loan_type_id, $amount, $interest_rate, $penalty, $status, $release_date, $duration_months, $user_id, $employment_type, $income_type, $start_date);

			if ($query->execute()) {
				$query->close();
				$this->conn->close();
				return true;
			} else {
				echo "Erro ao executar a consulta: " . $query->error;
			}
		} else {
			echo "Erro de preparação: " . $this->conn->error;
		}

		return false;
	}






	/* Loan Type Function */

	public function save_ltype($ltype_name, $ltype_desc)
	{
		$query = $this->conn->prepare("INSERT INTO `loan_type` (`ltype_name`, `ltype_desc`) VALUES(?, ?)") or die($this->conn->error);
		$query->bind_param("ss", $ltype_name, $ltype_desc);

		if ($query->execute()) {
			$query->close();
			$this->conn->close();
			return true;
		}
	}

	public function save_guarantees($gua_name, $gua_desc)
	{
		$query = $this->conn->prepare("INSERT INTO `guarantees` (`name`, `description`) VALUES(?, ?)") or die($this->conn->error);
		$query->bind_param("ss", $gua_name, $gua_desc);

		if ($query->execute()) {
			$query->close();
			$this->conn->close();
			return true;
		}
	}

	public function update_guarantees($gua_id, $gua_name, $gua_desc)
	{
		$query = $this->conn->prepare("UPDATE `guarantees` SET  `name`=? , `description`=? WHERE `id`=? ") or die($this->conn->error);
		$query->bind_param("ssi", $gua_name, $gua_desc, $gua_id);

		if ($query->execute()) {
			$query->close();
			$this->conn->close();
			return true;
		}
	}

	public function display_ltype()
	{
		$query = $this->conn->prepare("SELECT * FROM `loan_type`") or die($this->conn->error);
		if ($query->execute()) {
			$result = $query->get_result();
			return $result;
		}
	}

	public function display_guarantees()
	{
		$query = $this->conn->prepare("SELECT * FROM `guarantees`") or die($this->conn->error);
		if ($query->execute()) {
			$result = $query->get_result();
			return $result;
		}
	}

	public function delete_ltype($ltype_id)
	{
		$query = $this->conn->prepare("DELETE FROM `loan_type` WHERE `ltype_id` = '$ltype_id'") or die($this->conn->error);
		if ($query->execute()) {
			$query->close();
			$this->conn->close();
			return true;
		}
	}

	public function update_ltype($ltype_id, $ltype_name, $ltype_desc)
	{
		$query = $this->conn->prepare("UPDATE `loan_type` SET `ltype_name`=?, `ltype_desc`=? WHERE `ltype_id`=?") or die($this->conn->error);
		$query->bind_param("ssi", $ltype_name, $ltype_desc, $ltype_id);

		if ($query->execute()) {
			$query->close();
			$this->conn->close();
			return true;
		}
	}
	public function userID()
	{
		$user_id = $_SESSION['user_id'];
		$dataUser = $this->conn->prepare("SELECT account_type FROM user WHERE user_id = $user_id") or die($this->conn->error);
		if ($dataUser->execute()) {
			$result = $dataUser->get_result();
			return $result;
		}
	}

	/* Loan Type Function */
	public function display_loan()
	{
		$user_id = $_SESSION['user_id'];
		$dataUser = $this->conn->query("SELECT account_type FROM user WHERE user_id = $user_id") or die($this->conn->error);
		if ($dataUser->num_rows > 0) {
			while ($row = $dataUser->fetch_assoc()) {
				$account_type = $row['account_type'];
				if ($account_type === 'gerente') {
					$query = $this->conn->prepare("SELECT * FROM `loan` WHERE user_id = $user_id  AND status != 'concluído' AND status != 'negado'") or die($this->conn->error);
					if ($query->execute()) {
						$result = $query->get_result();
						return $result;
					}
				} else {
					$query = $this->conn->prepare("SELECT * FROM `loan` WHERE status != 'concluído' AND status != 'negado'") or die($this->conn->error);
					if ($query->execute()) {
						$result = $query->get_result();
						return $result;
					}
				}
			}
		}
	}

	public function display_loanfinche()
	{
		$user_id = $_SESSION['user_id'];
		$dataUser = $this->conn->query("SELECT account_type FROM user WHERE user_id = $user_id") or die($this->conn->error);
		if ($dataUser->num_rows > 0) {
			while ($row = $dataUser->fetch_assoc()) {
				$account_type = $row['account_type'];
				if ($account_type === 'gerente') {
					$query = $this->conn->prepare("SELECT * FROM `loan` WHERE user_id = $user_id AND status = 'concluído'") or die($this->conn->error);
					if ($query->execute()) {
						$result = $query->get_result();
						return $result;
					}
				} else {
					$query = $this->conn->prepare("SELECT * FROM `loan` WHERE status = 'concluído'") or die($this->conn->error);
					if ($query->execute()) {
						$result = $query->get_result();
						return $result;
					}
				}
			}
		}
	}

	public function display_loanfiled()
	{
		$user_id = $_SESSION['user_id'];
		$dataUser = $this->conn->query("SELECT account_type FROM user WHERE user_id = $user_id") or die($this->conn->error);
		if ($dataUser->num_rows > 0) {
			while ($row = $dataUser->fetch_assoc()) {
				$account_type = $row['account_type'];
				if ($account_type === 'gerente') {
					$query = $this->conn->prepare("SELECT * FROM `loan` WHERE user_id = $user_id AND status = 'negado'") or die($this->conn->error);
					if ($query->execute()) {
						$result = $query->get_result();
						return $result;
					}
				} else {
					$query = $this->conn->prepare("SELECT * FROM `loan` WHERE status = 'negado'") or die($this->conn->error);
					if ($query->execute()) {
						$result = $query->get_result();
						return $result;
					}
				}
			}
		}
	}

	public function aplicarMultaEmEmprestimosVencidos()
	{
		$parcelasAnalisadas = 0;

		$multaAplicada = 0;
		// Obtenha a data atual
		$dataAtual = date('Y-m-d');

		// Consulta para obter empréstimos pendentes com parcelas vencidas
		$result = $this->conn->query("SELECT loan.id, loan.amount, loan.penalty, parcelas.id AS parcela_id, parcelas.data_vencimento, parcelas.valor_parcela
					FROM loan
					JOIN parcelas ON loan.id = parcelas.loan_id
					WHERE loan.status = 'pendente'
					AND parcelas.data_vencimento < '$dataAtual'
					AND parcelas.status_pagamento = 'Não Pago'") or die($this->conn->error);



		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$parcelasAnalisadas++;
				// Calcule o valor original do empréstimo (amount) sem a taxa de juros
				$valorOriginal = $row['amount'];

				// Calcule o valor total pago em parcelas
				$sqlValorPago = "SELECT SUM(valor_pagamento) AS valor_pago
									FROM payments
									WHERE parcela_id = " . $row['parcela_id'];

				$resultValorPago = $this->conn->query($sqlValorPago);
				$valorPago = ($resultValorPago->num_rows > 0) ? $resultValorPago->fetch_assoc()['valor_pago'] : 0;

				// Calcule o valor restante sem a taxa de juros (original - total pago)
				$valorRestanteSemJuros = $valorOriginal - $valorPago;

				// Calcule a multa com base no valor restante
				$multa = ($valorRestanteSemJuros * $row['penalty'] / 100);

				// Atualize a parcela com a multa e status multado
				if ($multa > 0) {
					$multaAplicada++;
					$parcela_id = $row['parcela_id'];
					$sql = "UPDATE parcelas
							SET multa = multa + $multa,
								status_multa = 'Multado'
							WHERE id = $parcela_id";

					$this->conn->query($sql);
				}
			}
			$resposta = "Parcelas analisadas: $parcelasAnalisadas<br>Multas aplicadas: $multaAplicada";

			// Redirecionar para outra página com a resposta
			header("Location: outra_pagina.php?resposta=" . urlencode($resposta));
		}
	}



	/* Borrower Function */

	public function save_borrower($firstname, $middlename, $lastname, $contact_no, $address, $email, $tax_id, $data_nascimento, $nacionalidade, $naturalidade, $provincia, $bi_passaport_n, $emissor, $data_emissao, $estado_civil, $sexo, $profissao, $residencia, $bairro, $av_rua, $casa_flat_n, $quarteirao)
	{
		$query = $this->conn->prepare("INSERT INTO `borrower` (`firstname`, `middlename`, `lastname`, `contact_no`, `address`, `email`, `tax_id`, `data_nascimento`, `nacionalidade`, `naturalidade`, `provincia`, `bi_passaport_n`, `emissor`, `data_emissao`, `estado_civil`, `sexo`, `profissao`, `residencia`, `bairro`, `av_rua`, `casa_flat_n`, `quarteirao`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)") or die($this->conn->error);

		$query->bind_param("ssssssisssssssssssssss", $firstname, $middlename, $lastname, $contact_no, $address, $email, $tax_id, $data_nascimento, $nacionalidade, $naturalidade, $provincia, $bi_passaport_n, $emissor, $data_emissao, $estado_civil, $sexo, $profissao, $residencia, $bairro, $av_rua, $casa_flat_n, $quarteirao);

		if ($query->execute()) {
			$query->close();
			$this->conn->close();
			return true;
		}
	}


	public function display_borrower()
	{
		$query = $this->conn->prepare("SELECT * FROM `borrower`") or die($this->conn->error);
		if ($query->execute()) {
			$result = $query->get_result();
			return $result;
		}
	}

	public function delete_borrower($borrower_id)
	{
		$query = $this->conn->prepare("DELETE FROM `borrower` WHERE `borrower_id` = '$borrower_id'") or die($this->conn->error);
		if ($query->execute()) {
			$query->close();
			$this->conn->close();
			return true;
		}
	}

	public function update_borrower($borrower_id, $firstname, $middlename, $lastname, $contact_no, $address, $email, $tax_id,  $data_nascimento, $nacionalidade, $naturalidade, $provincia, $bi_passaport_n, $emissor, $data_emissao, $estado_civil, $sexo, $profissao, $residencia, $bairro, $av_rua, $casa_flat_n, $quarteirao)
	{
		$query = $this->conn->prepare("UPDATE `borrower` SET `firstname`=?, `middlename`=?, `lastname`=?, `contact_no`=?, `address`=?, `email`=?, `tax_id`=? WHERE `borrower_id`=?") or die($this->conn->error);
		$query->bind_param("sssssssssssssssssssssii", $firstname, $middlename, $lastname, $contact_no, $address, $email,  $data_nascimento, $nacionalidade, $naturalidade, $provincia, $bi_passaport_n, $emissor, $data_emissao, $estado_civil, $sexo, $profissao, $residencia, $bairro, $av_rua, $casa_flat_n, $quarteirao, $tax_id, $borrower_id);

		if ($query->execute()) {
			$query->close();
			$this->conn->close();
			return true;
		}
	}

	/* Loan Type*/
	public function display_loan_type()
	{
		$query = "SELECT * FROM `loan_type`";

		$result = $this->conn->query($query);

		if ($result) {
			return $result;
		}
	}
}
