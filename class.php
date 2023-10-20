<?php
	require_once'config.php';
	
	class db_class extends db_connect{
		
		public function __construct(){
			$this->connect();
		}
		
		
		/* User Function */
		
		public function add_user($username,$password,$firstname,$lastname){
			$query=$this->conn->prepare("INSERT INTO `user` (`username`, `password`, `firstname`, `lastname`) VALUES(?, ?, ?, ?)") or die($this->conn->error);
			$query->bind_param("ssss", $username, $password, $firstname, $lastname);
			
			if($query->execute()){
				$query->close();
				$this->conn->close();
				return true;
			}
		}
		
		public function update_user($user_id,$username,$password,$firstname,$lastname){
			$query=$this->conn->prepare("UPDATE `user` SET `username`=?, `password`=?, `firstname`=?, `lastname`=? WHERE `user_id`=?") or die($this->conn->error);
			$query->bind_param("ssssi", $username, $password, $firstname, $lastname, $user_id);
			
			if($query->execute()){
				$query->close();
				$this->conn->close();
				return true;
			}
		}
		
		public function login($username, $password){
			$query=$this->conn->prepare("SELECT * FROM `user` WHERE `username`='$username' && `password`='$password'") or die($this->conn->error);
			if($query->execute()){
				
				$result=$query->get_result();
				
				$valid=$result->num_rows;
			
				$fetch=$result->fetch_array();
				
				return array(
					'user_id'=>isset($fetch['user_id']) ? $fetch['user_id'] : 0,
					'count'=>isset($valid) ? $valid: 0
				);	
			}
		}
		public function hasPendingOrApprovedLoan($borrower_id) {
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

		public function getLoanById($loanID) {
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

		
		
		public function user_acc($user_id){
			$query=$this->conn->prepare("SELECT * FROM `user` WHERE `user_id`='$user_id'") or die($this->conn->error);
			if($query->execute()){
				$result=$query->get_result();
				
				$valid=$result->num_rows;
			
				$fetch=$result->fetch_array();
				
				return $fetch['firstname']." ".$fetch['lastname'];	
			}
		}
		
		function hide_pass($str) {
			$len = strlen($str);
		
			return str_repeat('*', $len);
		}
		
		public function display_user(){
			$query=$this->conn->prepare("SELECT * FROM `user`") or die($this->conn->error);
			if($query->execute()){
				$result = $query->get_result();
				return $result;
			}
		}
		
		
		public function delete_user($user_id){
			$query=$this->conn->prepare("DELETE FROM `user` WHERE `user_id` = '$user_id'") or die($this->conn->error);
			if($query->execute()){
				$query->close();
				$this->conn->close();
				return true;
			}
		}

		/**Loan Function */
		public function insertLoan($borrower_id, $loan_type_id, $amount, $interest_rate, $penalty, $duration_months) {
			// Gere um número de referência único
			$ref = mt_rand(1,99999999);
		
			// Obtenha a data atual
			$release_date = date('Y-m-d');
		
			// Defina o status como "pendente" por padrão
			$status = 'pendente';
		
			$query = $this->conn->prepare("INSERT INTO `loan` (`ref`, `borrower_id`, `loan_type_id`, `amount`, `interest_rate`, `penalty`, `status`, `release_date`, `duration_months`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
			
			if ($query) {
				$query->bind_param("siiddsssi", $ref, $borrower_id, $loan_type_id, $amount, $interest_rate, $penalty, $status, $release_date, $duration_months);
		
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
		
		public function save_ltype($ltype_name,$ltype_desc){
			$query=$this->conn->prepare("INSERT INTO `loan_type` (`ltype_name`, `ltype_desc`) VALUES(?, ?)") or die($this->conn->error);
			$query->bind_param("ss", $ltype_name, $ltype_desc);
			
			if($query->execute()){
				$query->close();
				$this->conn->close();
				return true;
			}
		}
		
		public function display_ltype(){
			$query=$this->conn->prepare("SELECT * FROM `loan_type`") or die($this->conn->error);
			if($query->execute()){
				$result = $query->get_result();
				return $result;
			}
		}
		
		public function delete_ltype($ltype_id){
			$query=$this->conn->prepare("DELETE FROM `loan_type` WHERE `ltype_id` = '$ltype_id'") or die($this->conn->error);
			if($query->execute()){
				$query->close();
				$this->conn->close();
				return true;
			}
		}
		
		public function update_ltype($ltype_id,$ltype_name,$ltype_desc){
			$query=$this->conn->prepare("UPDATE `loan_type` SET `ltype_name`=?, `ltype_desc`=? WHERE `ltype_id`=?") or die($this->conn->error);
			$query->bind_param("ssi", $ltype_name, $ltype_desc, $ltype_id);
			
			if($query->execute()){
				$query->close();
				$this->conn->close();
				return true;
			}
		}
		
		
		/* Loan Type Function */
		public function display_loan() {
			$query = $this->conn->prepare("SELECT * FROM `loan`") or die($this->conn->error);
			if ($query->execute()) {
				$result = $query->get_result();
				return $result;
			}
		}
		
		
		
		/* Borrower Function */
		
		public function save_borrower($firstname, $middlename, $lastname, $contact_no, $address, $email, $tax_id, $data_nascimento, $nacionalidade, $naturalidade, $provincia, $bi_passaport_n, $emissor, $data_emissao, $estado_civil, $sexo, $profissao, $residencia, $bairro, $av_rua, $casa_flat_n, $quarteirao) {
			$query = $this->conn->prepare("INSERT INTO `borrower` (`firstname`, `middlename`, `lastname`, `contact_no`, `address`, `email`, `tax_id`, `data_nascimento`, `nacionalidade`, `naturalidade`, `provincia`, `bi_passaport_n`, `emissor`, `data_emissao`, `estado_civil`, `sexo`, `profissao`, `residencia`, `bairro`, `av_rua`, `casa_flat_n`, `quarteirao`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)") or die($this->conn->error);
			
			$query->bind_param("ssssssisssssssssssssss", $firstname, $middlename, $lastname, $contact_no, $address, $email, $tax_id, $data_nascimento, $nacionalidade, $naturalidade, $provincia, $bi_passaport_n, $emissor, $data_emissao, $estado_civil, $sexo, $profissao, $residencia, $bairro, $av_rua, $casa_flat_n, $quarteirao);
			
			if ($query->execute()) {
				$query->close();
				$this->conn->close();
				return true;
			}
		}
		
		
		public function display_borrower(){
			$query=$this->conn->prepare("SELECT * FROM `borrower`") or die($this->conn->error);
			if($query->execute()){
				$result = $query->get_result();
				return $result;
			}
		}
		
		public function delete_borrower($borrower_id){
			$query=$this->conn->prepare("DELETE FROM `borrower` WHERE `borrower_id` = '$borrower_id'") or die($this->conn->error);
			if($query->execute()){
				$query->close();
				$this->conn->close();
				return true;
			}
		}
		
		public function update_borrower($borrower_id,$firstname,$middlename,$lastname,$contact_no,$address,$email,$tax_id){
			$query=$this->conn->prepare("UPDATE `borrower` SET `firstname`=?, `middlename`=?, `lastname`=?, `contact_no`=?, `address`=?, `email`=?, `tax_id`=? WHERE `borrower_id`=?") or die($this->conn->error);
			$query->bind_param("ssssssii", $firstname, $middlename, $lastname, $contact_no, $address, $email, $tax_id, $borrower_id);
			
			if($query->execute()){
				$query->close();
				$this->conn->close();
				return true;
			}
		}

		/* Loan Type*/
		public function display_loan_type() {
			$query = "SELECT * FROM `loan_type`";
			
			$result = $this->conn->query($query);
			
			if ($result) {
				return $result;
			}
		}
		
		
	}
?>