<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Cadastro - Banca Evento</title>
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
    <div class="container" style="margin-top: 2rem;">
        <div class="header">
            <h1>Banca Evento</h1>
        </div>
        <div class="content">
            <p>Olá,</p>
            <p>Obrigado por se cadastrar na Banca Evento! Estamos muito felizes em tê-lo conosco.</p>
            <p>Para confirmar seu cadastro, clique no botão abaixo:</p>
            <a href="{{ url($data) }}" style="display: inline-block; background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; text-decoration: none; border-radius: 5px;">
                Confirmar
            </a>
            <p>Se você não se cadastrou na Banca Evento, por favor, ignore este e-mail.</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 Banca Evento. Todos os direitos reservados.</p>
        </div>
    </div>
</body>

</html>