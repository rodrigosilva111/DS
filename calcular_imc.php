<?php

// Conexão com o banco de dados
$servername = "localhost";
$username = "root"; // Substitua pelo seu usuário do MySQL
$password = ""; // Substitua pela sua senha do MySQL
$dbname = "imc"; // Substitua pelo nome do seu banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $peso = floatval($_POST['peso']);
    $altura = floatval($_POST['altura']);

    // Cálculo do IMC
    $imc = $peso / ($altura * $altura);
    $classificacao = "";
    $dieta = "";

    // Classificação do IMC e dieta recomendada
    if ($imc < 18.5) {
        $classificacao = "Abaixo do peso";
        $dieta = "Sua dieta deve ser rica em proteínas, carboidratos saudáveis e gorduras boas. Consuma alimentos como: carnes magras, ovos, legumes, frutas e cereais integrais.";
    } elseif ($imc >= 18.5 && $imc <= 24.9) {
        $classificacao = "Peso normal";
        $dieta = "Mantenha uma dieta balanceada, com proteínas magras, carboidratos complexos, gorduras saudáveis e muitas frutas e verduras. Beba muita água e evite alimentos processados.";
    } elseif ($imc >= 25 && $imc <= 29.9) {
        $classificacao = "Sobrepeso";
        $dieta = "Reduza o consumo de carboidratos simples e aumente a ingestão de proteínas e fibras. Alimentos recomendados: frango, peixes, vegetais de folhas verdes, frutas com baixo índice glicêmico e grãos integrais.";
    } elseif ($imc >= 30 && $imc <= 34.9) {
        $classificacao = "Obesidade grau 1";
        $dieta = "Evite açúcar, alimentos ultraprocessados e bebidas com calorias. Priorize vegetais, frutas, carnes magras e cereais integrais. Coma pequenas porções e evite longos períodos sem comer.";
    } elseif ($imc >= 35 && $imc <= 39.9) {
        $classificacao = "Obesidade grau 2";
        $dieta = "Adote uma dieta hipocalórica, rica em alimentos nutritivos e com pouca gordura. Consuma principalmente vegetais, proteínas magras e frutas, e evite frituras, doces e refrigerantes.";
    } else {
        $classificacao = "Obesidade grau 3";
        $dieta = "É importante seguir uma dieta controlada e monitorada por um nutricionista. Aumente o consumo de vegetais, fibras e proteínas magras, e evite completamente alimentos ricos em gordura e açúcar.";
    }

    // Exibição do resultado
    echo "<h1>Resultado do IMC</h1>";
    echo "Nome: $nome<br>";
    echo "Telefone: $telefone<br>";
    echo "Email: $email<br>";
    echo "Peso: $peso kg<br>";
    echo "Altura: $altura m<br>";
    echo "IMC: " . number_format($imc, 2) . "<br>";
    echo "Classificação: $classificacao<br>";
    echo "Dieta recomendada: $dieta<br>";
} else {
    echo "Método inválido.";
}


// Inserir dados na tabela
$sql = "INSERT INTO calcular_imc (nome, telefone, email, peso, altura, imc, classificacao, dieta)
        VALUES ('$nome', '$telefone', '$email', '$peso', '$altura', '$imc', '$classificacao', '$dieta')";

if ($conn->query($sql) === TRUE) {
    echo "<br>Dados inseridos com sucesso!";
} else {
    echo "<br>Erro ao inserir dados: " . $conn->error;
}

    // Fechar conexão
    $conn->close();

?>
