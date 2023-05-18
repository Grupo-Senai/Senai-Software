<?php
session_start();
$host = '127.0.0.1';
$dbname = 'biblioteca';
$username = 'root';
$password = '';

// Conectar ao banco de dados usando PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $loginAdmin = "admin"; // Substitua pelo valor desejado
    $senhaAdmin = 'admin'; // Substitua 'senha_admin' pela senha do superusuário

    // Gerar o hash da senha
    $senhaHash = password_hash($senhaAdmin, PASSWORD_DEFAULT);

    // Armazenar o hash da senha no banco de dados
    $stmt = $pdo->prepare("INSERT INTO superusuario (login, senha) VALUES (:login, :senha)");
    $stmt->bindValue(':login', $loginAdmin);
    $stmt->bindValue(':senha', $senhaHash);
    $stmt->execute();*/

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = $_POST['usuario'];
        $senha = $_POST['senha'];

        // Consultar a tabela superusuario para verificar se é um admin
        $stmt = $pdo->prepare("SELECT * FROM superusuario WHERE login = :login AND senha = :senha");
        $stmt->bindValue(':login', $login);
        $stmt->bindValue(':senha', $senha);
        $stmt->execute();
        $superusuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($superusuario) {
            // É um superusuário/administrador, armazenar os dados na sessão
            $_SESSION['usuario'] = $superusuario;
            // É um superusuário/administrador, redirecionar para a página de administração
            header('Location: menu.php');
            exit;
        }

        // Consultar a tabela de usuários comuns para verificar o usuário e senha
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login AND senha = :senha");
        $stmt->bindValue(':login', $login);
        $stmt->bindValue(':senha', $senha);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // É um usuário comum, armazenar os dados na sessão
            $_SESSION['usuario'] = $usuario;
            // É um usuário comum, redirecionar para a página principal
            header('Location: menu.php');
            exit;
        } else {
            header('Location: login.html');
            // Login inválido, exibir mensagem de erro
            echo "Login ou senha inválidos.";
        }
    }
} catch (PDOException $e) { // Exibir uma mensagem de erro
    die("Erro de conexão com o banco de dados: " . $e->getMessage());
}
?>
