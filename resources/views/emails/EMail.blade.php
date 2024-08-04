<!DOCTYPE html>
<html>

<head>
    <title>Recuperação de Senha</title>
</head>

<body>
    <h1>Olá!</h1>
    <p>Este e-mail refere-se a recuperação de senha do seu cadastro na plataforma Banca Evento.<br>Ao realizar seu login, enão se esqueça de realizar a troca de senha.</p>

    @if($data)
    <p>Senha: {{ $data }}</p>
    @endif

    <p>Atenciosamente,<br>Banca Eventos</p>
</body>

</html>