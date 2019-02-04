<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="admin/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="admin/css/signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" action="{{ to('loginController', 'login') }}" method="POST">
      <h1 class="h3 mb-3 font-weight-normal">Login</h1>
      <label class="sr-only">Email</label>
      <input name="email" type="email" class="form-control" placeholder="Email address" required autofocus>
      <label class="sr-only">Password</label>
      <input name="password" type="password" class="form-control" placeholder="Password" required>
      @php
      if(sessionHas('error')){
      @endphp
      <div class="alert alert-danger" role="alert">
        {{ session('error') }}
      </div>
      @php
      }
      @endphp
      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
      <p class="mt-5 mb-3 text-muted">AlpfaCMS&copy; 2018-2020</p>
    </form>
    <!-- scripts snippit -->
    <?php include_once 'partials/scripts.php'; ?>
  </body>
</html>