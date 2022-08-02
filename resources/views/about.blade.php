<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>About us</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
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
                                                        <img src="{{url('/images/' . $notification->image)}}" alt="profile_pic">
                                                    </a>  
                                                @endif
                                                @if (isset($notification->reply_id))
                                                    <a href="/thread/{{$notification->post_id}}#{{$notification->reply_id}}">
                                                        <img src="{{url('/images/' . $notification->image)}}" alt="profile_pic">
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
                            <li><a href="/" class="nav-link px-2 text-white">Home</a></li>
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
        <h1>About us</h1>
        <p>This site can help people find a job they were always wishing about. Unemployed people can create a post and write everything about their preferences, abilities and the job they are willing
            to embrace and, sooner or later, an employee will find about them. In addition, companies can also create posts, informing other users that they are searching for employess. If one 
            has any questions regarding a post, they can easily be asked in the comments section, however, in order to create posts and comments, users have to be logged in. If one is willing
            to change the information of their post, it can easily be updated when accessing it. However, everyone should be attentive when creating posts and comments, since if they will be 
            inappropriate, an admin can easily delete them. 
        </p>
        <br>
        <img src="{{url('/images/job2.jpeg')}}" style="height: 600px" alt="job image">
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>