<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Produto em leilão</title>
</head>
<body>
<h1>Produto em leilão</h1>

@foreach ($errors->all() as $error)
    <div class="alert alert-danger">
        {{ $error }}
    </div>
@endforeach

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<h2>{{ $produto->nome }}</h2>

<dl>
    <dt>Descrição</dt>
    <dd>{{ $produto->descricao }}</dd>

    <dt>Lance mínimo</dt>
    <dd>{{ $fmt->formatCurrency($produto->lance_minimo, 'BRL') }}</dd>

    <dt>Maior lance</dt>
    <dd>{{ $fmt->formatCurrency($produto->maior_lance, 'BRL') }}</dd>

    <dt>Valor de <i>Buyout</i></dt>
    <dd>{{ $fmt->formatCurrency($produto->valor_buyout, 'BRL') }}</dd>
</dl>
</body>
</html>