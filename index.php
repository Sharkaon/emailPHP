<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/style.css">
        <title>E-mail</title>
    </head>
    <body>
        <?php
            if(isset($_POST["enviar"])){
                if(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)){
                    $nome=$_POST["nome"];
                    $email=$_POST["email"];
                    $file=fopen("cadastros.txt", "a");
                    fclose($file);
                    if($file=fopen("cadastros.txt", "r")){
                        while($linha=fgets($file)){
                            $linhas[]=explode("|", $linha);
                            foreach ($linhas as $info){
                                if($email==$info[0]){
                                    $repeatedEmail=true;
                                }
                            }
                        }
                        fclose($file);
                    }

                    if(!isset($repeatedEmail)){
                        if($file=fopen("cadastros.txt", "a")){
                            fwrite($file, "$email|\r\n");
                            fclose($file);
                        }
                    }
                }
                $message="Olá $nome, você entrou em contato para receber o arquivo dos 12 estudos de Chopin Op. 25, use este link para baixar o arquivo:\narturmonteiro.tk/mail/index.php?file=1";

                $headers = "MIME-Version: 1.1\r\n";
                $headers .= "Content-type: text/plain; charset=UTF-8\r\n";
                $headers .= "From: rutrakpm@gmail.com\r\n";
                $headers .= "Return-Path: rutrakpm@gmail.com\r\n";
                $envio = mail($email, "Teste", $message, $headers);
                
                if($envio){
                    echo "<p>Mensagem enviada com sucesso</p>";
                }
                else{
                    echo "<p>A mensagem não pode ser enviada</p>";
                }

            
            }

            $file = filter_input(INPUT_GET, "file", FILTER_SANITIZE_SPECIAL_CHARS);

            switch($file){
                case "1":
                    $filename="Doze Etudes Chopin OP 25.pdf";
                    $filepath="files/$filename";
                    header("Content-disposition: attachment; filename=$filename");
                    header("Content-type: application/pdf");
                    readfile($filepath);
                break;
            }
        ?>

        <p class="row" id="text">INFORME SEU NOME E EMAIL PARA RECEBER OS 12 ESTUDOS DE FREDERIC CHOPIN OP. 25 POR EMAIL</p>

        <form action="index.php" method="post" id="enviar">
            <input type="text" name="nome" placeholder="NOME" class="row" required></input>
            <input type="email" name="email" placeholder="EMAIL" class="row" required></input>
            <button type="submit" name="enviar" value="enviar" class="row">ENVIAR</button>
        </form>

    </body>
</html>