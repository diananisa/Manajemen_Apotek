<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek | Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-info d-flex justify-content-center align-items-center vh-100">

<div class="card shadow p-4" style="width: 100%; max-width: 400px;">
    <div class="text-center mb-4">
        <img src="{{ asset('asset/logo.png') }}" alt="Logo" style="max-width: 90px;">
        <h5 class="fw-bold mt-2">Login to Account</h5>
        <p class="text-muted mb-0">Please enter your username and password</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger text-center">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST">
        @csrf
        <div class="form-floating mb-3">
            <input type="text" name="Username" class="form-control" id="Username" placeholder="Username" required>
            <label for="Username">Username</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="password" class="form-control" id="Password" placeholder="Password" required>
            <label for="Password">Password</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Remember Me</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Sign In</button>
    </form>
</div>

</body>
</html>
