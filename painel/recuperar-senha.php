<?php
include('../database.php');

$conn = new mysqli($db_server, $db_user, $db_pass, $db_name);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KBRTEC ADMIN</title>

    <link rel="icon" type="image/x-icon" href="img/favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="bg-dark">
    <main class="py-5" style="min-height: calc(100vh - 72px);">
        <div class="container">
            <div class="bg-custom mx-auto row col-8 rounded shadow-sm overflow-hidden">
                <div class="col-6 bg-white p-5 d-flex align-items-center justify-content-center">
                    <img src="img/kbrtec.webp" alt="KBRTEC" height="200" width="200" class="object-fit-contain">
                </div>

                <div class="col-6 d-flex align-items-center p-5">
                    <form action="recuperar-senha.php" method="POST" class="form w-100">
                        <h2 class="h4 text-light">Esqueceu sua senha?</h2>
                        <p class="mb-4 text-light fw-light">Apenans digite seu e-mail abaixo e enviaremos um link para
                            ele para redefinir sua senha!</p>

                        <div class="row row-gap-3">
                            <div class="col-12 form-group text-light">
                                <label for="email">E-mail:</label>
                                <input type="email" name="email" class="form-control bg-dark border-dark text-light"
                                    id="email" placeholder="example@kbrtec.com.br">
                                <!-- <small class="bg-danger rounded py-1 px-2 mt-1 d-block text-light">Erro</small> -->
                            </div>

                            <div class="col-12 mt-3 d-flex gap-2 align-items-center justify-content-between">
                                <button type="submit" class="btn btn-light">Resetar senha</button>
                                <a href="login.php" class="link-light">Voltar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-custom text-light text-center py-4">
        <small>© Copyright 2023 - KBR TEC - Todos os Direitos Reservados</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);

    $stmt = $conn->prepare("SELECT id, usuario, email FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $usuario, $email);
        $stmt->fetch();

        // Gerar um token único para redefinição de senha
        $token = bin2hex(random_bytes(32));

        // Armazenar o token no banco de dados junto com o ID do usuário e o tempo de expiração
        $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $stmt = $conn->prepare("INSERT INTO senha_reset_tokens (usuario_id, token, expiracao) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id, $token, $expiracao);
        $stmt->execute();

        // Enviar e-mail com o link de redefinição de senha
        $assunto = "Redefinição de Senha - KBRTEC";
        $mensagem = "Olá $usuario,\n\nPara redefinir sua senha, clique no link abaixo:\n\n";
        $mensagem .= "http://localhost/kbrtecpets/painel/resetar-senha.php?token=$token\n\n";
        $mensagem .= "Este link expirará em 1 hora.\n\nAtenciosamente,\nEquipe KBRTEC";

        mail($email, $assunto, $mensagem);

        echo "Um link de redefinição de senha foi enviado para o seu e-mail.";
    } else {
        echo "Usuário não encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>