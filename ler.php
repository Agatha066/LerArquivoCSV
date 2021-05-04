<!DOCTYPE html>
<html lang="pt">
	<head>
		<meta charset="utf-8">
		<title>importar PHP</title>
	</head>
	<body>
		<form action="ler.php" method="post" enctype="multipart/form-data">
			<h2>Nome do arquivo </h2>
			arquivo: <input type="file" name="file"><br><br>
			<input type="submit" value="Enviar Dados">
		</form>
	</body>
<html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{	
		//fazendo conexao com o banco
		$servidor = "localhost";
		$usuario = "root";
		$senha = "";
		$nomebanco= "3daw";
		
		//$conexao = mysqli_connect('localhost','root','root','3daw');
		$conn = new mysqli($servidor,$usuario,$senha,$nomebanco);
		if (!$conn) 
		{
			echo "ERRO AO CONECTAR BANCO DE DADOS!!";
		}
		
	$arquivo= $_FILES["file"]["tmp_name"];
	$nome= $_FILES["file"]["name"];
	
	$ext= explode(".",$nome);
	$extensao= end($ext);
	
	if($extensao != "csv")
	{
		echo "extensao invalida";
	}
	else
	{
		echo "extensao valida";
		$objeto=fopen($arquivo,'r');
		
		while(($dados=fgetcsv($objeto,1000,";")) !==FALSE)
		{
			$nome = utf8_encode($dados[0]);
			$email = utf8_encode($dados[1]);
			$matricula = utf8_encode($dados[2]);
			
			$result = $conn->query("INSERT INTO alunos(nome, email, matricula) VALUES ('$nome', '$email', '$matricula')");
		}
		
		if($result)
		{
			echo "<br><br>dados inseridos com sucesso!!";
		}
		else
		{
			echo "<br><br>erro ao inserir os dados";
		}
	}
}
?>
