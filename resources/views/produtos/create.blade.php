<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <title>Produtos | Cadastrar</title>
</head>
<body>
<div class="container">
    <h1>Produtos | Cadastrar</h1>

    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible">
            {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach

    <form action="/produtos" method="post">
        @csrf
        <div class="mb-3">
            <label for="nome">Nome *</label>
            <input type="text" class="form-control" name="nome" id="nome" required>
        </div>
        <div class="mb-3">
            <label for="descricao">Descrição *</label>
            <input type="text" class="form-control" name="descricao" id="descricao" required>
        </div>
        <div class="mb-3">
            <label for="lance-minimo">Lance mínimo *</label>
            <input type="number" class="form-control" name="lance_minimo" id="lance-minimo" required min="1"
                   step="0.01">
        </div>
        <div class="mb-3">
            <label for="ordem">Ordem *</label>
            <input type="number" class="form-control" name="ordem" id="ordem" required min="1" step="1">
        </div>
        <div class="mb-3">
            <label for="valor-buyout">Valor de buyout *</label>
            <input type="number" class="form-control" name="valor_buyout" id="valor-buyout" required min="10"
                   step="0.01">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>
</html>
