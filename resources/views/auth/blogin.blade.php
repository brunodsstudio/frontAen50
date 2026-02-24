<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kdam+Thmor+Pro&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h1 class="h5 mb-0">Entrar</h1>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('loginteste.post') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    autocomplete="username"
                                >
                            </div>

                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    required
                                    autocomplete="current-password"
                                >
                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Lembrar-me</label>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="" class="small">Esqueceu a senha?</a>
                                <button type="submit" class="btn btn-primary">Entrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
