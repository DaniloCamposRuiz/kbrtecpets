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
    <title>KBRTEC PETS</title>

    <link rel="icon" type="image/x-icon" href="img/favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bowlby+One&family=Montserrat:wght@500&display=swap"
        rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <header class="border-bottom-1 shadow py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-4">
                    <a href="index.php" title="KBR TEC" class="d-inline-block">
                        <h1>
                            <img src="img/logo.webp" alt="KBR TEC" width="150">
                        </h1>
                    </a>
                </div>

                <div class="col-8">
                    <nav class="d-flex gap-4 align-items-center justify-content-end">
                        <a href="index.php">Home</a>
                        <a href="quero-adotar.php">Quero Adotar</a>
                        <a href="../painel/login.php" class="btn btn-custom">Admin</a>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <nav aria-label="breadcrumb" class="p-3 bg-custom-light">
        <div class="container">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item fs-sm"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item fs-sm"><a href="quero-adotar.php">Quero Adotar</a></li>
                <li class="breadcrumb-item fs-sm"><a href="integra.php">Tini</a></li>
                <li class="breadcrumb-item active fs-sm" aria-current="page">Formulário de Solicitação</li>
            </ol>
        </div>
    </nav>

    <section class="bg-light py-5">
        <div class="container mb-5">
            <h2 class="m-0 bowlby-one text-uppercase h5 text-center">Solicitação de adoção</h2>
            <p class="text-center">Preencha aqui os dados da pessoa interessada em adotar o animal selecionado:</p>

            <form action="" method="post" class="bg-custom rounded p-4 mt-4 col-6 mx-auto row">
                <input type="hidden" name="id_animal" value="1"> <!-- Defina o ID do animal aqui -->

                <form action="" class="bg-custom rounded p-4 mt-4 col-6 mx-auto row">
                    <div class="form-group py-2 col-12">
                        <label for="solicitante" class="text-capitalize text-light">Seu nome:</label>
                        <input type="text" class="form-control" name="solicitante" id="solicitante">
                    </div>

                    <div class="form-group py-2 col-12">
                        <label for="animal" class="text-capitalize text-light">Nome <span
                                class="text-lowercase">do</span>
                            animal:</label>
                        <input type="text" class="form-control" name="animal" id="animal" value="Tini" disabled>
                    </div>

                    <div class="form-group py-2 col-6">
                        <label for="cpf" class="text-capitalize text-light">CPF:</label>
                        <input type="text" class="form-control" name="cpf" id="cpf">
                    </div>

                    <div class="form-group py-2 col-6">
                        <label for="email" class="text-capitalize text-light">E-mail:</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>

                    <div class="form-group py-2 col-6">
                        <label for="cel" class="text-capitalize text-light">Celular:</label>
                        <input type="text" class="form-control" name="cel" id="cel">
                    </div>

                    <div class="form-group py-2 col-6">
                        <label for="nascimento" class="text-capitalize text-light">Data <span
                                class="text-lowercase">de</span> Nascimento:</label>
                        <input type="text" class="form-control" name="nascimento" id="nascimento">
                    </div>

                    <div class="col-12 d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-custom-2">Solicitar</button>
                    </div>
                </form>
        </div>
    </section>

    <section class="bg-custom py-3" style="background-color: #FFECCE;">
        <div class="container">
            <div class="d-flex align-items-center justify-content-center gap-3">
                <div class="d-flex flex-column align-items-end">
                    <h2 class="bowlby-one text-uppercase h4 m-0">Alguma dúvida?</h2>

                    <a href="#" class="btn btn-custom">Entre em contato</a>
                </div>
                <img src="img/cartoon-cat-3.webp" alt="Gato" width="150">
            </div>
        </div>
    </section>

    <footer class="py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <p class="m-0">
                    Copyright © 2023. Todos os direitos reservados
                </p>

                <a href="https://www.kbrtec.com.br/" target="_blank" title="Acesse o site da KBR TEC">
                    <img src="img/kbrtec.webp" alt="KBRTEC" width="100">
                </a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
</body>

</html>
<?php
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validando e sanitizando os dados
    $nome = mysqli_real_escape_string($conn, $_POST["solicitante"]);
    $id_animal = mysqli_real_escape_string($conn, $_POST["id_animal"]);
    $cpf = mysqli_real_escape_string($conn, $_POST["cpf"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $celular = mysqli_real_escape_string($conn, $_POST["cel"]);
    $data_nascimento = mysqli_real_escape_string($conn, $_POST["nascimento"]);

    // Validando o nome
    if (empty($nome)) {
        $errors[] = "Por favor, insira seu nome.";
    }

    // Validando o CPF
    if (empty($cpf) || !preg_match('/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/', $cpf)) {
        $errors[] = "Por favor, insira um CPF válido.";
    }

    // Validando o email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Por favor, insira um endereço de e-mail válido.";
    }

    // Validando o celular
    if (empty($celular) || !preg_match('/^\d{2} \d{4,5}\-\d{4}$/', $celular)) {
        $errors[] = "Por favor, insira um número de celular válido no formato 99 12345-6789.";
    }

    // Validando a data de nascimento
    if (empty($data_nascimento) || !preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $data_nascimento)) {
        $errors[] = "Por favor, insira uma data de nascimento válida no formato DD/MM/AAAA.";
    }

    // Se não houver erros, inserir os dados no banco de dados
    if (empty($errors)) {
        $sql = "INSERT INTO solicitacoes_adocao (id_animal, nome_solicitante, cpf, email, celular, data_nascimento)
                VALUES ('$id_animal', '$nome', '$cpf', '$email', '$celular', '$data_nascimento')";

        if (mysqli_query($conn, $sql)) {
            echo "Solicitação de adoção realizada com sucesso!";
        } else {
            echo "Erro ao realizar a solicitação de adoção: " . mysqli_error($conn);
        }
    } else {
        // Se houver erros, exibi-los
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }

    mysqli_close($conn);
}
?>