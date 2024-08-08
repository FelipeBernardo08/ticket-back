<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agradecimento - Banca Evento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #4CAF50;
            color: #fff;
        }

        .header h1 {
            margin: 0;
        }

        .content {
            padding: 20px;
            text-align: center;
        }

        .content h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .content p {
            font-size: 16px;
            line-height: 1.5;
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #4CAF50;
            text-decoration: none;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            padding: 10px 0;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Banca Evento</h1>
        </div>
        <div class="content">
            <h1>Cadastro Confirmado</h1>
            <p>Obrigado por confirmar seu cadastro!</p>
            <p>Seu cadastro foi confirmado com sucesso. Você pode acessar o site através do botão abaixo.</p>
            <a href="{{ url('https://bancaevento.com.br/login') }}" class="button">Ir para o site</a> <!-- prod -->
            <!-- <a href="{{ url('http://localhost:4300/login') }}" class="button">Ir para o site</a> dev -->
        </div>
        <div class="footer">
            <p>&copy; 2024 Banca Evento. Todos os direitos reservados.</p>
        </div>
    </div>
</body>

</html>