<!DOCTYPE html>
<html>
<head>
    <title>Upload de Arquivos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ff66b2; /* Rosa */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto; /* Centraliza o container verticalmente */
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #ff66b2; /* Rosa */
            font-size: 24px;
            text-align: center; /* Centraliza o título horizontalmente */
        }

        fieldset {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        legend {
            font-size: 20px;
            color: #ff66b2; /* Rosa */
        }

        .file-input {
            margin-bottom: 20px;
            margin-top: 20px; /* Adicione margem superior para mover o botão "Enviar" para baixo */
            text-align: center; /* Centraliza o input de arquivo */
        }

        input[type="file"] {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
        }

        input[type="submit"] {
            background-color: #ff66b2; /* Rosa */
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            display: block; /* Para centralizar o botão horizontalmente */
            margin: 20px auto; /* Mova o botão "Enviar" para baixo e centralize-o horizontalmente */
        }

        input[type="submit"]:hover {
            background-color: #e64a8a; /* Rosa mais escuro ao passar o mouse */
        }

        .message {
            color: #f00;
            text-align: center; /* Centraliza a mensagem de erro */
            margin-top: 10px; /* Adicione margem superior para espaçamento */
        }

        .link {
            text-align: center;
            margin-top: 20px; /* Adicione margem superior para espaçamento */
        }

        .link a {
            text-decoration: none;
            color: #ff66b2; /* Rosa */
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upload de Arquivos</h2>

        <?php
        if (isset($_POST["submit"])) {
            if ($_FILES["arquivo"]["error"] == 4) {
                echo "<p class='message'>Erro: Nenhum arquivo foi enviado.</p>";
            } else {
                // Verificar se há um erro durante o upload
                if ($_FILES["arquivo"]["error"] == 0) {
                    $diretorioDestino = "uploads/";
                    $caminhoArquivo = $diretorioDestino . $_FILES["arquivo"]["name"];

                    // Verificar o tamanho do arquivo
                    if ($_FILES["arquivo"]["size"] > 1000000) { // 1MB em bytes
                        echo "<p class='message'>Erro: O tamanho do arquivo excede o limite permitido (1MB).</p>";
                    } else {
                        // Verificar a extensão do arquivo
                        $extensoesPermitidas = array("docx", "pdf", "txt");
                        $extensao = strtolower(pathinfo($_FILES["arquivo"]["name"], PATHINFO_EXTENSION));

                        if (in_array($extensao, $extensoesPermitidas)) {
                            // Verificar se o diretório de destino existe, caso contrário, crie-o
                            if (!file_exists($diretorioDestino)) {
                                mkdir($diretorioDestino, 0777, true); // Cria o diretório com permissões adequadas
                            }

                            // Mover o arquivo para o diretório de destino
                            move_uploaded_file($_FILES["arquivo"]["tmp_name"], $caminhoArquivo);

                            echo "<p class='message'>Upload realizado com sucesso!</p>";
                            echo "<p class='link'><a href='$caminhoArquivo' target='_blank'>Acessar o arquivo</a></p>";
                        } else {
                            echo "<p class='message'>Erro: Apenas arquivos com extensões .docx, .pdf e .txt são permitidos.</p>";
                        }
                    }
                } else {
                    echo "<p class='message'>Erro: Ocorreu um erro durante o upload do arquivo. Código de erro: " . $_FILES["arquivo"]["error"] . "</p>";
                }
            }
        }
        ?>

        <fieldset>
            <legend>Envie um arquivo de texto (.txt):</legend>
            <form method="post" enctype="multipart/form-data" class="file-input">
                <input type="file" name="arquivo" accept=".docx, .pdf, .txt">
                <input type="submit" name="submit" value="Enviar">
            </form>
        </fieldset>
    </div>
</body>
</html>
