<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Account</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{'/css/notifications.css'}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".notifications .icon_wrap").click(function() {
                $('.notifications').toggleClass("active");
                $('#notification_number').html('0');
                $('#formular').click();
            });

            $('#preventt').submit(function (event) {
                event.preventDefault();
                $.post($(this).attr("action"), $(this).serialize());
            });
        });
    </script>
</head>
<body>
    @switch(session()->has('id'))
        @case(true)
            <header class="p-3 mb-3 border-bottom bg-dark">
                <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="/" class="nav-link px-2 text-white">Home</a></li>
                        <li><a href="/about" class="nav-link px-2 text-white">About</a></li>
                        <li><a href="/create" class="nav-link px-2 text-white">Create</a></li>
                    </ul>

                    <div class="notifications">
                        <input type="hidden" name="random" value="3">
                        <div class="icon_wrap">
                            <span class="material-symbols-outlined">
                                notifications
                            </span>
                            @foreach ($notificationsNumber as $nr)
                                <span class="icon-button__badge" id="notification_number">{{$nr->nnr}}</span>
                            @endforeach       
                        </div>
                    
                    <form action="/" method="post" id="preventt">
                        @method('PUT')
                        @csrf
                        <button type="submit" id="formular" hidden>aha</button>
                    </form>

                    <div class="notification_dd" >
                        <ul class="notification_ul">
                            @if ($notifications -> isNotEmpty())
                                @foreach ($notifications as $notification)
                                    <li>
                                        <div class="notify_icon">
                                            <span class="iconn">
                                                @if (isset($notification->comment_id))
                                                    <a href="/thread/{{$notification->post_id}}#{{$notification->comment_id}}">
                                                        <img src="{{url('/images/' . $notification->image)}}" alt="notification_picture">
                                                    </a>  
                                                @endif
                                                @if (isset($notification->reply_id))
                                                    <a href="/thread/{{$notification->post_id}}#{{$notification->reply_id}}">
                                                        <img src="{{url('/images/' . $notification->image)}}" alt="notification_picture">
                                                    </a> 
                                                @endif  
                                                @if (!isset($notification->reply_id) && !isset($notification->comment_id))
                                                    <a href="/thread/{{$notification->post_id}}">
                                                        <img src="{{url('/images/' . $notification->image)}}" alt="notification_picture">
                                                    </a>
                                                @endif  
                                            </span>
                                        </div>
                                        
                                        <div class="notify_data">
                                            <div class="title">
                                                @if (isset($notification->comment_id))
                                                    <a style="text-decoration: none;" href="/thread/{{$notification->post_id}}#{{$notification->comment_id}}">
                                                        <p class="text-dark">{{$notification->title}}</p>
                                                    </a>
                                                @endif 
                                                @if (isset($notification->reply_id))
                                                    <a style="text-decoration: none;" href="/thread/{{$notification->post_id}}#{{$notification->reply_id}}">
                                                        <p class="text-dark">{{$notification->title}}</p>
                                                    </a>
                                                @endif        
                                                @if (!isset($notification->reply_id) && !isset($notification->comment_id))
                                                    <a style="text-decoration: none;" href="/thread/{{$notification->post_id}}">
                                                        <p class="text-dark">{{$notification->title}}</p>
                                                    </a>
                                                @endif 
                                            </div>
                                            <div class="sub_title">
                                                @if (isset($notification->comment_id))
                                                    <a style="text-decoration: none;" href="/thread/{{$notification->post_id}}#{{$notification->comment_id}}">
                                                        <p class="text-muted">{{$notification->creation_date}}</p>
                                                    </a>  
                                                @endif 
                                                @if (isset($notification->reply_id))
                                                    <a style="text-decoration: none;" href="/thread/{{$notification->post_id}}#{{$notification->reply_id}}">
                                                        <p class="text-muted">{{$notification->creation_date}}</p>
                                                    </a> 
                                                @endif 
                                                @if (!isset($notification->reply_id) && !isset($notification->comment_id))
                                                    <a style="text-decoration: none;" href="/thread/{{$notification->post_id}}">
                                                        <p class="text-muted">{{$notification->creation_date}}</p>
                                                    </a> 
                                                @endif 
                                            </div>
                                        </div>
                                    </li>
                                @endforeach  
                            @else
                                <p class="text-dark fs-2 fw-bold mt-5">You have no notifications yet</p>
                            @endif                          
                        </ul>
                    </div>
                </div>

                    <div class="dropdown text-end">
                        <a href="#" class="d-block text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{url('/images/' . session('photo'))}}" alt="mdo" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1" style="">
                            <li><a class="dropdown-item" href="/account/{{session('id')}}">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/update_account">Edit profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout">Log out</a></li>
                        </ul>
                    </div>
                </div>
                </div>
            </header>
            @break
        @case(false)
            <header class="p-3 bg-dark text-white">
                <div class="container">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                
                        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                            <li><a href="/" class="nav-link px-2 text-secondary">Home</a></li>
                            <li><a href="/about" class="nav-link px-2 text-white">About</a></li>
                        </ul>
                
                        <div class="text-end">
                            <a href="/login" type="button" class="btn btn-outline-light me-2">Login</a>
                            <a href="/signup" type="button" class="btn btn-warning">Sign-up</a>
                        </div>
                    </div>
                </div>
            </header>
            @break
    @endswitch

    <div class="container">
        <form action="/update_account" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input type="hidden" name="id" value="{{session('id')}}">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label fs-5">Login</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Enter a login" value="{{session('login')}}" name="login">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput2" class="form-label fs-5">Password</label>
                <input type="password" class="form-control" id="exampleFormControlInput2" placeholder="Enter a password" name="password">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label fs-5">Confirm your password</label>
                <input type="password" class="form-control" id="exampleFormControlInput3" placeholder="Confirm your password" name="passwordVerification">
            </div>
            {{-- <div class="mb-3">
                <label for="exampleFormControlInput4" class="form-label fs-5">Email address</label>
                <input type="email" class="form-control" id="exampleFormControlInput4" placeholder="Enter your email" name="email" value="{{session('email')}}">
            </div> --}}
            {{-- <div class="mb-3">
                <label for="inputGroupFile02" class="form-label fs-5">Choose a profile picture</label>
                <input type="file" class="form-control" id="inputGroupFile02" name="image">
            </div> --}}
            <button type="submit" class="w-100 btn btn-lg btn-primary" name="submit">Update</button>
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
                    <p class="mt-3 mb-3 text-muted">login input was empty</p>
                    @break
                @case("11")
                    <p class="mt-3 mb-3 text-muted">password input is empty</p>
                    @break
                @case("12")
                    <p class="mt-3 mb-3 text-muted">password verification input is empty</p>
                    @break
                @case("13")
                    <p class="mt-3 mb-3 text-muted">email input was empty</p>
                    @break
            @endswitch
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

</body>
</html>