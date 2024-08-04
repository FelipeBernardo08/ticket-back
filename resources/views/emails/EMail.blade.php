<!DOCTYPE html>
<html>

<head>
    <title>E-mail</title>
</head>

<body>
    <h1>Olá!</h1>
    <p>Este e-mail refere-se a recuperação de senha do seu cadastro na plataforma Banca Evento.<br>Ao realizar seu login, enão se esqueça de realizar a troca de senha.</p>

    @if($data)
    <p>Senha: {{ $data }}</p>
    @endif

    <p>Atenciosamente,<br>Banca Eventos</p>

    <a href="{{ url('http://localhost:8000/api/confirm-account/bernardodev0809@gmail.com') }}" style="display: inline-block; background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; text-decoration: none; border-radius: 5px;">
        Confirmar Cadastro
    </a>
</body>

</html>