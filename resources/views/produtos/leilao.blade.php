<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <title>Produto em leilão</title>
</head>
<body>
<div class="container">
    <h1>Produto em leilão</h1>

    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible">
            {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach

    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

    <form action="/produtos/em-leilao/lance" method="post">
        @csrf
        <div class="input-group mb-3 w-50">
            <button class="btn btn-outline-success" type="submit" id="button-addon1">Dar lance</button>
            <input type="number" class="form-control" name="valor" min="1" step="0.01" required>
        </div>
    </form>

    <a href="/produtos/em-leilao/encerrar" class="btn btn-danger">Encerrar leilão deste produto</a>
</div>
</body>
</html>
