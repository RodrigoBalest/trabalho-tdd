<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Produtos</title>
</head>
<body>
<h1>Produtos</h1>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<ul>
@forelse($produtos as $produto)
    <li>{{ $produto->nome }}</li>
@empty
    <li>Nenhum produto disponível para leilão</li>
@endforelse
</ul>
</body>
</html>
