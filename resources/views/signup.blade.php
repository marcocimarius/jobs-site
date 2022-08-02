<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{'/css/login.css'}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <body class="text-center">
        <main class="form-signin w-100 m-auto">
            <form action="/signup" method="POST" enctype="multipart/form-data">
                @csrf
                <h1 class="h3 mb-3 fw-normal">Sign up</h1>
            
                <div class="form-floating">
                  <input type="text" class="form-control" id="floatingInput" placeholder="Create a login" name="login">
                  <label for="floatingInput">Create a login</label>
                </div>
                <div class="form-floating">
                  <input type="password" class="form-control" id="floatingPassword" placeholder="Create a password" name="password">
                  <label for="floatingPassword">Create a password</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Retype the password" name="passwordVerification">
                    <label for="floatingPassword">Retype the password</label>
                </div>
                <div class="form-floating">
                    <input type="email" class="form-control" id="floatingEmail" placeholder="Enter your email" name="email">
                    <label for="floatingPassword">Enter your email</label>
                </div>
                <input type="file" class="form-control" id="inputGroupFile02" name="image">
                             
                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
                @switch($errors)
                    @case("1")
                        <p class="mt-3 mb-3 text-muted">no image detected</p>
                        @break
                    @case("2")
                        <p class="mt-3 mb-3 text-muted">invalid image extension </p>
                        @break
                    @case("3")
                        <p class="mt-3 mb-3 text-muted">password length too short</p>
                        @break
                    @case("4")
                        <p class="mt-3 mb-3 text-muted">password lacks capital letters</p>
                        @break
                    @case("5")
                        <p class="mt-3 mb-3 text-muted">password lacks numbers</p>
                        @break
                    @case("6")
                        <p class="mt-3 mb-3 text-muted">password lacks symbols</p>
                        @break
                    @case("7")
                        <p class="mt-3 mb-3 text-muted">passwords dont match when retyping</p>
                        @break
                    @case("8")
                        <p class="mt-3 mb-3 text-muted">login already exists</p> 
                        @break
                    @case("9")
                        <p class="mt-3 mb-3 text-muted">email already exists</p>
                        @break
                    @case("10")
                        <p class="mt-3 mb-3 text-muted">login input is empty</p>
                        @break
                    @case("11")
                        <p class="mt-3 mb-3 text-muted">password input is empty</p>
                        @break
                    @case("12")
                        <p class="mt-3 mb-3 text-muted">password verification input is empty</p>
                        @break
                    @case("13")
                        <p class="mt-3 mb-3 text-muted">email input is empty</p>
                        @break
                @endswitch
            </form>
            <a href="/login">Already have an account? Log in here</a>
        </main>  
    </body>
</body>
</html>
