<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <title>Home</title>
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

                        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" action="/search" method="GET">
                            <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search" name="search">
                        </form>
                        
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
                            <li><a href="/" class="nav-link px-2 text-white">Home</a></li>
                            <li><a href="/about" class="nav-link px-2 text-white">About</a></li>
                        </ul>
                
                        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" action="/search" method="GET">
                            <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search" name="search">
                        </form>

                        <div class="text-end">
                            <a href="/login" type="button" class="btn btn-outline-light me-2">Login</a>
                            <a href="/signup" type="button" class="btn btn-warning">Sign-up</a>
                        </div>
                    </div>
                </div>
            </header>
            @break
    @endswitch

    <main>
        <div class="container">
            
            <div class="d-flex justify-content-between">
                <div class="d-flex justify-content-start mt-1">
                    @foreach ($nrPosts as $item)
                        <h3 class="mt-4">Total number of posts: {{$item->pnr}}</h3>
                    @endforeach
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <div class="me-1">
                        <form action="/sort_newest" method="GET">
                            <button type="submit" class="btn btn-outline-secondary">Sort by date(newest)</button>
                        </form>
                    </div>
                    <div class="ms-1">
                        <form action="/sort_oldest" method="GET">
                            <button type="submit" class="btn btn-outline-secondary">Sort by date(oldest)</button>
                        </form>
                    </div>
                </div>
            </div>
            
            {{-- <div class="mt-2">
                <span>{{$posts->links("pagination::bootstrap-5")}}</span>
            </div> --}}

            {{-- Modal --}}
            <div class="modal fade" id="banModall" tabindex="-1" aria-labelledby="banModalLabel2" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="banModalLabel2">Ban user</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h3>Are you sure you want to ban this user?</h3>
                            <form action="/ban_post1" method="POST">
                                @method('PUT')
                                @csrf                    
                                <input type="hidden" name="banned_user_id" id="banned_user_id">          
                                <input type="hidden" name="articol_id" id="banned_from_post_id">                
                                <input type="hidden" name="author" id="banned_author">                
                                <select name="ban" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                    <option value="1" selected>Ban for 30 minutes</option>
                                    <option value="2">Ban for 1 hour</option>
                                    <option value="3">Ban for 2 hours</option>
                                    <option value="4">Ban for 1 day</option>
                                    <option value="5">Ban for 2 days</option>
                                    <option value="6">Ban for 1 week</option>
                                    <option value="7">Ban for 1 month</option>
                                    <option value="8">Ban for 1 year</option>
                                    <option value="9">Ban for 10 years</option>
                                </select> 
                                <button type="submit" class="btn btn-danger mt-3" name="submit">Ban</button>                  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    {{-- Modal --}}
    <div class="modal fade" id="deleteModal1" tabindex="-1" aria-labelledby="deleteModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel1">Delete Post </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>Are you sure you want to delete this post?</h3>
                    <form action="/delete_thread" method="POST">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="id" id="inputId">                                   
                        <button type="submit" class=" btn btn-danger mt-3" name="submit">Delete</button>                  
                    </form>
                </div>
            </div>
        </div>
    </div>

            <br>
                @if ($posts->isNotEmpty())
                    @foreach ($posts as $post)
                        @php
                            $totall = 0;
                        @endphp
                            <div class="p-4 p-md-5 mb-4 text-white rounded bg-dark ">
                                <div class="d-flex flex-row justify-content-between">
                                    <div class="col-md-6 px-0 flex-column">
                                        <h1 class="display-4 fst-italic">{{$post->title}}</h1>
                                        <p class="lead my-3">Author: <a class="text-white" href="/account/{{$post->utilizators_id}}">{{$post->author}}</a></p>
                                        <div class="mb-1 text-muted">{{$post->upload_date}}</div>
                                        <p class="lead mb-0"><a href="/thread/{{$post->id}}" class="text-white fw-bold">Continue reading...</a></p>
                                        @if(session()->has('id') && session('role') == 'admin')
                                            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#deleteModal1" data-bs-whatever="{{$post->id}}">Delete post</button>
                                        @endif
                                        @php
                                            $role = '';
                                            foreach ($users as $user) {
                                                if($user->id == $post->utilizators_id) {
                                                    $role = $user->role;
                                                    break;
                                                }
                                            }
                                        @endphp
                                        @if(session()->has('id') && session('role') == 'admin' && $role != 'admin')
                                            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#banModall" data-bs-whatever="{{$post->id}}" data-bs-user="{{$user->id}}" data-bs-author="{{$post->author}}">Ban author</button>
                                        @endif
                                        
                                    </div>
                                    <div class="col-auto mx-auto my-auto"> 
                                        <img src="{{url('/posts_images/' . $post->photo)}}" class="img-thumbnail" style="width:450px; max-height:200px; object-fit:cover;" alt="post-image">
                                        @foreach ($nrComments as $comment)
                                            @if($comment->aid == $post->id)
                                                @php
                                                    $totall += $comment->cnr; 
                                                @endphp
                                            @endif
                                        @endforeach
                                        @foreach ($nrReplies as $reply)
                                            @if ($reply->aid == $post->id)
                                                @php
                                                    $totall += $reply->rnr;
                                                @endphp
                                            @endif
                                        @endforeach
                                        <div class="my-auto text-muted">Total comments: {{$totall}}</div>                          
                                    </div>
                                </div>             
                            </div>
                    @endforeach
                    <span>{{$posts->links("pagination::bootstrap-5")}}</span>
                @else
                    <div class="text-danger">
                        <h1>No post found with this name</h1>
                    </div>
                @endif

            {{-- @else
                <span>{{$posts->links("pagination::bootstrap-5")}}</span>  
            @endif --}}
        </div>
    </main>
    
    
    <script src="{{'/js/delete.js'}}"></script>
    <script src="{{'/js/admin.js'}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>