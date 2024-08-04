<!DOCTYPE html>
<html>

<head>
    <title>Confirmação de Cadastro</title>
</head>

<body>
    <h1>Olá, {{ $usuario->name }}!</h1>
    <p>Obrigado por se cadastrar. Para confirmar seu cadastro, clique no botão abaixo:</p>

    <a href="{{ url('/api/cadastro/confirmar/' . $usuario->confirmation_token) }}" style="display: inline-block; background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; text-decoration: none; border-radius: 5px;">
        Confirmar Cadastro
    </a>

    <p>Se você não se cadastrou, ignore este e-mail.</p>
</body>

</html>