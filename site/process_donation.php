<?php
    $sql = "SELECT * FROM donations ORDER BY amount DESC LIMIT 4";
    $result = $conn->query($sql);
    $conn->close();
// process_donation.php
header('Content-Type: application/json');

// 1. Inclui aqui o teu ficheiro de conexão à base de dados (Ex: include 'db.php';)
// Como o teu código já usa a variável $conn, assume-se que ela venha dessa inclusão:
// include 'caminho_para_a_tua_conexao.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Validar se a conexão existe
    if (!isset($conn)) {
        echo json_encode(['success' => false, 'message' => 'Erro interno: Conexão à base de dados não encontrada.']);
        exit;
    }

    // Capturar e limpar os dados recebidos do AJAX
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
    $method = filter_input(INPUT_POST, 'donationMethod', FILTER_DEFAULT);

    // Validações básicas no lado do servidor
    if (!$amount || $amount <= 0) {
        echo json_encode(['success' => false, 'message' => 'O valor da doação deve ser superior a 0.']);
        exit;
    }

    if (empty($method)) {
        echo json_encode(['success' => false, 'message' => 'O método de pagamento é obrigatório.']);
        exit;
    }

    // Preparar a Query SQL para evitar SQL Injection
    // Ajusta o nome das colunas se na tua tabela forem diferentes
    $sql = "INSERT INTO donations (amount, payment_method, donation_date) VALUES (?, ?, NOW())";
    
    if ($stmt = $conn->prepare($sql)) {
        // "ds" significa: d = double/float (amount), s = string (method)
        $stmt->bind_param("ds", $amount, $method);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Doação inserida com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao executar a gravação: ' . $stmt->error]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao preparar a consulta: ' . $conn->error]);
    }
    
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método de requisição inválido.']);
}