<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log in</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{'/css/login.css'}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
</head>
<body class="text-center">
    <main class="form-signin w-100 m-auto">
        <form action="/login" method="POST">
            @csrf
            <h1 class="h3 mb-3 fw-normal">Log in</h1>
        
            <div class="form-floating">
              <input type="text" class="form-control" id="floatingInput" placeholder="Type your login" name="login">
              <label for="floatingInput">Type your login</label>
            </div>
            <div class="form-floating">
              <input type="password" class="form-control" id="floatingPassword" placeholder="Type your password" name="password">
              <label for="floatingPassword">Type your password</label>
            </div>
        
            <button class="w-100 btn btn-lg btn-primary" type="submit">Log in</button>
            @switch($errors)
                @case("1")
                    <p class="mt-3 mb-3 text-muted">User or password are incorrect</p>
                    @break
            @endswitch
        </form>
        <a href="/signup">Don't have an account? Register here</a>
    </main>  
</body>
</html>