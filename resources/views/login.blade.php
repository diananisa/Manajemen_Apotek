<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Login Page</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-info text-white d-flex justify-content-center align-items-center vh-100">
    <div class="login-box">
        <!-- <div class="text-center">
            <img src="{{ asset('asset/logo.png') }}" alt="ApotekKu Logo" class="img-fluid mb-3" style="max-width: 80px;">
        </div> -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="{{ asset('asset/logo.png') }}" class="img-fluid mb-3" style="max-width: 95px;">
                <!-- <img src="{{ asset('assets/logo.png') }}" alt="Logo Apotek" style="height: 50px;"> -->
                <h5 class="mt-0 fw-bold" style="color: black; font-family: 'Source Sans 3', sans-serif; margin-top: 0;">Login to Account</h5>
                <h6 style="color: black; margin-top: 0;" >Please enter yout email and password to continue</h6>
            <!-- </a> -->
            </div>
        <div class="card-body login-card-body">
          <!-- <p class="login-box-msg">Sign in to start your session</p> -->
          <form action="{{ route('dashboard_manager') }}" method="get"> 
          @csrf
            <div class="input-group mb-1">
              <div class="form-floating">
                <input id="loginUsername" type="username" class="form-control" value="" placeholder="" />
                <label for="loginEmail">Username</label>
              </div>
              <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            </div>
            <div class="input-group mb-1">
              <div class="form-floating">
                <input id="loginPassword" type="password" class="form-control" placeholder="" />
                <label for="loginPassword">Password</label>
              </div>
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>
            <div class="col-8 mx-auto">
                <div class="d-grid gap-4">
                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </div> 
            <div class="row">
                  <div class="col-8 d-inline-flex align-items-center">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                      <label class="form-check-label" for="flexCheckDefault"> Remember Password </label>
                    </div>
                  </div>
        </form>
              </p>
            </div>
          </div>
        </div>
</body>
</html>
