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

    /*Resto do seu código...
    $loginAdmin = "admin"; // Substitua pelo valor desejado
    $senhaAdmin = 'fixfixfix'; // Substitua 'senha_admin' pela senha do superusuário

    // Gerar o hash da senha
    $senhaHash = password_hash($senhaAdmin, PASSWORD_DEFAULT);

    // Armazenar o hash da senha no banco de dados
    $stmt = $pdo->prepare("INSERT INTO superusuario (login, senha) VALUES (:login, :senha)");
    $stmt->bindValue(':login', $loginAdmin);
    $stmt->bindValue(':senha', $senhaHash);
    $stmt->execute();
*/

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $codigo = $_POST['codigo'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $csenha = $_POST['confirmarsenha'];

        // Verificar se as informações já existem nas tabelas users e superusuario
        $stmt = $pdo->prepare("SELECT * FROM users WHERE codigo = :codigo OR email = :email");
        $stmt->bindValue(':codigo', $codigo);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("SELECT * FROM superusuario WHERE codigo = :codigo OR email = :email");
        $stmt->bindValue(':codigo', $codigo);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $superusuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar se as informações já existem em alguma tabela
        if (!empty($users) || !empty($superusuario)) {
            foreach ($users as $user) {
                if (strtolower($user['codigo']) == strtolower($codigo)) {
                    echo "<p>O código de acesso já está em uso. Por favor, insira um código diferente.</p>";
                    return;
                }
                if (strtolower($user['email']) == strtolower($email)) {
                    echo "<p>O email já está em uso. Por favor, insira um email diferente.</p>";
                    return;
                }
            }

            foreach ($superusuario as $su) {
                if (strtolower($su['codigo']) == strtolower($codigo)) {
                    echo "<p>O código de acesso já está em uso. Por favor, insira um código diferente.</p>";
                    header('Location : cadastro.php');
                    return;
                }
                if (strtolower($su['email']) == strtolower($email)) {
                    echo "<p>O email já está em uso. Por favor, insira um email diferente.</p>";
                    header('Location : cadastro.php');
                    return;
                }
            }
        } else {
            // Inserir informações na tabela cadastro
            $stmt = $pdo->prepare("INSERT INTO cadastro (nome, codigo, email, senha, checksenha) VALUES (:nome, :codigo, :email, :senha, :csenha)");
            $stmt->execute([
                ':nome' => $nome,
                ':codigo' => $codigo,
                ':email' => $email,
                ':senha' => $senha,
                ':csenha' => $csenha
            ]);

            // Obter o ID do último registro inserido na tabela cadastro
            $cadastroId = $pdo->lastInsertId();

            // Inserir informações na tabela users com a foreign key para a tabela cadastro
            $stmt = $pdo->prepare("INSERT INTO users (id, login, codigo, email, senha) VALUES (:cadastroId, :login, :codigo, :email, :senha)");
            $stmt->execute([
                ':cadastroId' => $cadastroId,
                ':login' => $nome,
                ':codigo' => $codigo,
                ':email' => $email,
                ':senha' => $senha
            ]);

            echo "<p>Cadastro realizado com sucesso!</p>";
            echo "<script> setTimeout(function() { window.location.href = 'login.php'; }, 5000);
        </script>";
            header('Location : login.php');
        }
/*
        users
        $stmt = $pdo->prepare("SELECT  * FROM cadastro WHERE nome = :nome AND senha = :senha");
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':codigo', $codigo);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha', $senha);
        $stmt->bindValue(':csenha', $csenha);

        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // É um usuário comum, armazenar os dados na sessão
            $_SESSION['usuario'] = $usuario;
            // É um usuário comum, redirecionar para a página principal
            header('Location: Menu.php');
            exit;
        }
        // Verificar se é um usuário comum
        $consultauser = "SELECT * FROM users WHERE login = :login";
        $stmt = $pdo->prepare($consultauser);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $resconsultauser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resconsultauser && password_verify($senha, $resconsultauser['senha'])) {
            // É um usuário comum, armazenar os dados na sessão
            $_SESSION['usuario'] = $resconsultauser;
            // Redirecionar para a página principal
            header('Location: Menu.php');
            exit;
        }

        // Credenciais inválidas, redirecionar para login.php com mensagem de erro
        header('Location: Login.php?error=1001');
        exit;
    }*/
    }
} catch (PDOException $e) {
    // Tratar exceções de conexão com o banco de dados aqui, se necessário
    echo "Erro de conexão com o banco de dados: " . $e->getMessage();
    exit;
}
