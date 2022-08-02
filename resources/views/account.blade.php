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
    <title>Account</title>
</head>
<body>
    @switch(session()->has('id'))
        @case(true)
            <header class="p-3 mb-3 border-bottom bg-dark">
                <div class="container">
                    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

                        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                            <li><a href="/" class="nav-link px-2 text-white">Home</a></li>
                            <li><a href="/about" class="nav-link px-2 link text-white">About</a></li>
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
        <div class="p-4 p-md-5 mb-4 border-bottom">
            <div class="d-flex justify-content-start flex-row">
                <div class = "my-auto">
                    <img src="{{url('/images/' . $photo)}}" class="img-fluid rounded-circle border-dark" style="width: 200px; height:200px" alt="account photo">
                </div>
                <div class="flex-column mx-5 my-auto">
                    <div class=" my-3">
                        <h2>Login</h2>
                        <input class="form-control" type="text" value="{{$login}}"  readonly>
                    </div>
                    <div class=" my-3">
                        <h2>Email</h2>
                        <input class="form-control" type="text" value="{{$email}}"  readonly>
                    </div>
                    <div class="d-flex flex-row">
                        <div >
                            @if (session()->has('id'))
                                @if (session('id') != $id)
                                    @if ($isFollowing->isEmpty())
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#followModal" data-bs-followedId="{{$id}}" data-bs-subscriberId="{{session('id')}}" data-bs-login="{{$login}}">Follow</button>   
                                    @else
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#unfollowModal" data-bs-followedId="{{$id}}" data-bs-subscriberId="{{session('id')}}" data-bs-login="{{$login}}">Unfollow</button>   
                                    @endif
                                @endif  
                            @else
                                <button class="btn btn-primary" disabled>Follow</button> 
                            @endif
                            {{-- Modal --}}
                            <div class="modal fade" id="unfollowModal" tabindex="-1" aria-labelledby="unfollowModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="unfollowModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h3 id="unfollowQuestion"></h3>
                                            <form action="/unfollow" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <input type="hidden" name="followed_id" id="unfollowed_id">                                   
                                                <input type="hidden" name="subscriber_id" id="unsubscriber_id">                                   
                                                <button type="submit" class=" btn btn-danger mt-3" name="submit">Unfollow</button>                  
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal --}}
                            <div class="modal fade" id="followModal" tabindex="-1" aria-labelledby="followModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="followModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h3 id="followQuestion"></h3>
                                            <form action="/follow" method="POST">
                                                @csrf
                                                <input type="hidden" name="followed_id" id="followed_id">                                   
                                                <input type="hidden" name="subscriber_id" id="subscriber_id">                                   
                                                <button type="submit" class=" btn btn-primary mt-3" name="submit">Follow</button>                  
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ms-2">
                            @if (session()->has('id'))
                                @if(session('role') == 'admin' && $id != session('id'))
                                    @if($role != 'admin')
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adminModal" data-bs-whatever="{{$id}}" data-bs-username="{{$login}}">Make admin</button>
                                    @else
                                        <button class="btn btn-primary" disabled>This user is already an admin</button>
                                    @endif  
                                @endif                      
                            @else
                                @php
                                    return redirect('/');
                                @endphp
                            @endif 
                        </div>                        
                    </div>
                </div>
                @if (session()->has('id') || !session()->has('id'))
                    <div class="flex-column mx-5 my-auto">
                        <div class="mt-4">
                            @foreach ($nrPostari as $item)
                                @if ($item->uid == $id)
                                    <h2>Created posts: {{$item->pnr}}</h2>
                                @endif
                            @endforeach     
                        </div>
                        <div class="mt-4">
                            @php
                                $totall = 0;
                            @endphp
                            @foreach ($nrComments as $comment)
                                    @if($comment->uid1 == $id)
                                        @php
                                            $totall += $comment->cnr; 
                                        @endphp
                                    @endif
                                @endforeach
                                @foreach ($nrReplies as $reply)
                                    @if ($reply->uid2 == $id)
                                        @php
                                            $totall += $reply->rnr;
                                        @endphp
                                    @endif
                                @endforeach   
                            <h2>Created comments: {{$totall}}</h2>
                        </div>
                        <div class="mt-4">
                            <h2>Registration date: {{$register_date}}</h2>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Modal --}}
        <div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3 id="question"></h3>
                        <form action="/make_admin" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" id="utilizator_id">                                   
                            <button type="submit" class=" btn btn-primary mt-3" name="submit">Make Admin</button>                  
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-evenly flex-row ">
            <div class="mb-5">
                <h1>Created posts</h1> 
                @if ($threads->isEmpty())
                    <p class="d-flex justify-content-center">User has no posts</p>
                @endif
                <div class="list-group">
                    @foreach ($threads as $thread)
                        <a href="/thread/{{$thread->id}}"  class="list-group-item list-group-item-action">{{$thread->title}}</a>
                    @endforeach   
                </div>
                <span>
                    {{$threads->appends(['comments' => $comments->currentPage(), 'replies' => $replies->currentPage(), 'contentCreators' => $contentCreators->currentPage()])->links("pagination::bootstrap-5")}}
                </span>
            </div>
            <div class="mb-5">
                <h1>Created comments</h1>
                @if ($comments->isEmpty())
                    <p class="d-flex justify-content-center">User has no comments</p>
                @endif
                <div class="list-group">
                    @foreach($comments as $comment)
                        <a href="/thread/{{$comment->articol_id}}#{{$comment->id}}" class="list-group-item list-group-item-action">{{$comment->content}}</a>
                    @endforeach              
                </div>
                <span>
                    {{$comments->appends(['posts' => $threads->currentPage(), 'replies' => $replies->currentPage(), 'contentCreators' => $contentCreators->currentPage()])->links("pagination::bootstrap-5")}}
                </span>
            </div>
            <div class="mb-5">
                <h1>Created Replies</h1>
                @if ($replies->isEmpty())
                    <p class="d-flex justify-content-center">User has no replies</p>
                @endif
                <div class="list-group">
                    @foreach($replies as $reply)
                        <a href="/thread/{{$reply->articol_id}}#{{$reply->id}}" class="list-group-item list-group-item-action">{{$reply->content}}</a>
                    @endforeach
                </div>
                <span>
                    {{$replies->appends(['comments' => $comments->currentPage(), 'posts' => $threads->currentPage(), 'contentCreators' => $contentCreators->currentPage()])->links("pagination::bootstrap-5")}}
                </span>
            </div>
            <div class="mb-5">
                <h1>Followed users</h1>
                @if ($contentCreators->isEmpty())
                    <p class="d-flex justify-content-center">User doesn't follow anyone</p>
                @endif
                <div class="list-group">
                    @foreach ($contentCreators as $contentCreator)
                        <a href="/account/{{$contentCreator->id}}" class="list-group-item list-group-item-action">{{$contentCreator->login}}</a>
                    @endforeach
                </div>
                <span>{{$contentCreators->appends(['comments' => $comments->currentPage(), 'replies' => $replies->currentPage(), 'posts' => $threads->currentPage()])->links("pagination::bootstrap-5")}}</span>
            </div>
        </div>
    </div>
    
    <script src="{{'/js/admin.js'}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>