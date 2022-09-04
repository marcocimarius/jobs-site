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
                                <button type="submit" id="formular" hidden></button>
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
                                <img src="{{url('/images/' . session('photo'))}}" alt="mdo" width="32" height="32" style="object-fit: cover;" class="rounded-circle">
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
    
    {{-- Modal --}}
    <div class="modal fade" id="changePhotoModal" tabindex="-1" aria-labelledby="changePhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePhotoModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/change_photo" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="user_id" id="changePhotoInputId">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">The image must have .jpg or .jpeg extensions only</label>
                            <input class="form-control" type="file" id="formFile" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Change photo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="d-flex flex-row justify-content-around border-bottom pb-4">
            <div class="d-flex flex-column mx-5">
                <div class="d-flex text-dark justify-content-center mt-2 fw-bold">
                    {{$login}}
                </div>
                <div class="mt-2">
                    <img src="{{url('/images/' . $photo)}}"  style="width: 200px; height:200px; object-fit: cover;" class=" rounded-circle border-dark" alt="account photo">
                </div>
                <div class="d-flex text-dark justify-content-center mt-2 fw-bold">
                    @if ($id == session('id'))
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changePhotoModal" data-bs-whatever="{{$id}}" data-bs-username="{{$login}}">Change photo</button>
                    @endif 
                </div>
            </div>
            <div class="d-flex flex-column my-auto align-items-center mx-5">
                <div class="d-flex flex-row ">
                    {{-- auto --}}
                    <div class="d-flex flex-column m-auto">
                        <div class="fw-bold text-dark">
                            @if ($nrPostari->isNotEmpty())
                                @foreach ($nrPostari as $item)
                                    @if ($item->uid == $id)
                                        <h2 class="ps-2" >{{$item->pnr}}</h2>
                                    @endif
                                @endforeach 
                            @else
                                <h2 class="ps-2" >0</h2>
                            @endif
                        </div>
                        <div class="text-mute">
                            posts
                        </div>
                    </div>
                    {{-- mx-5 --}}
                    <div class="d-flex flex-column ms-4">
                        <div class="fw-bold text-dark">
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
                            <h2 class="ps-4">{{$totall}}</h2> 
                        </div>
                        <div class="text-mute">
                            comments
                        </div>
                    </div>
                    <div class="d-flex flex-column ms-4">
                        <div class="fw-bold text-dark">
                            @if ($nrFollowers->isNotEmpty())
                                @foreach ($nrFollowers as $item)
                                    {{-- @if ($item->uid4 == $id) --}}
                                        <h2 class="ps-4">{{$item->fsnr}}</h2>
                                    {{-- @endif --}}
                                @endforeach 
                            @else
                                <h2 class="ps-4">0</h2>
                            @endif
                        </div>
                        <div class="text-mute">
                            followers
                        </div>
                    </div>
                    {{-- auto --}}
                    <div class="d-flex flex-column ms-4">
                        <div class="fw-bold text-dark">
                            @if ($nrFollowing->isNotEmpty())
                                @foreach ($nrFollowing as $item)
                                    @if ($item->uid3 == $id)
                                        <h2 class="ps-4">{{$item->fnr}}</h2>
                                    @endif
                                @endforeach 
                            @else
                                <h2 class="ps-4">0</h2>
                            @endif
                        </div>
                        <div class="text-mute">
                            following
                        </div>
                    </div>
                </div>
                <div>
                    <div class="mt-2">
                        @if ($id == session('id'))
                            <a style="padding: 5px 115px;" href="/update_account" class="btn btn-primary">Edit profile</a>
                        @endif
                    </div>
                    <div class="mt-2">
                        @if (session()->has('id'))
                            @if(session('role') == 'admin' && $id != session('id'))
                                @if($role != 'admin')
                                    <button style="padding: 5px 110px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adminModal" data-bs-whatever="{{$id}}" data-bs-username="{{$login}}">Make admin</button>
                                @else
                                    <button style="padding: 5px 51px;" class="btn btn-primary" disabled>This user is already an admin</button>
                                @endif  
                            @endif                      
                        @endif
                    </div>
                    <div class="mt-2">
                        @if (session()->has('id'))
                            @if (session('id') != $id)
                                @if ($isFollowing->isEmpty())
                                    <button style="padding: 5px 130px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#followModal" data-bs-followedId="{{$id}}" data-bs-subscriberId="{{session('id')}}" data-bs-login="{{$login}}">Follow</button>   
                                @else
                                    <button style="padding: 5px 122px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#unfollowModal" data-bs-followedId="{{$id}}" data-bs-subscriberId="{{session('id')}}" data-bs-login="{{$login}}">Unfollow</button>   
                                @endif
                            @endif  
                        @else
                            <button class="btn btn-primary" style="padding: 5px 130px;" disabled>Follow</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column my-auto">
                <h2 class="fw-bold mx-5">Bio</h2>
                @if ($bio != "" )
                    <div class="d-flex flex-column justify-content-start">
                        <p class="mx-5">
                            {!! nl2br(e($bio)) !!}
                        </p>
                        @if (session('id') == $id)
                            <button class="text-primary" style="background: none; border: none; padding: none" data-bs-toggle="modal" data-bs-target="#bioModal" data-bs-whatever="{{$id}}" data-bs-content="{{$bio}}">Edit bio</button>
                        @endif
                    </div>
                @else
                    @if ($id != session('id'))
                        <p class="mx-5">
                            This user has no bio.
                        </p>
                    @else
                        <p class="mx-5">
                            You have no bio.  <button class="text-primary" style="background: none; border: none; padding: none" data-bs-toggle="modal" data-bs-target="#bioModal" data-bs-whatever="{{$id}}">Add one</button>
                        </p>
                    @endif
                @endif
                {{-- Modal --}}
                <div class="modal fade" id="bioModal" tabindex="-1" aria-labelledby="bioModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="bioModalLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h3 id="bioQuestion"></h3>
                                <form action="/add_bio" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{$id}}" id="bioInputId">                                   
                                    <textarea class="form-control" placeholder="Add your bio" id="bioTextarea" name="bio" style="height: 3cm" required></textarea>
                                    <div class="invalid-feedback">
                                        Please provide a valid comment
                                    </div>                                 
                                    <button type="submit" class=" btn btn-danger mt-3" name="submit">Add</button>                  
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-evenly flex-row mt-5">
            <div class="mb-5 pe-3 border-end">
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
            <div class="mb-5 ps-3 pe-3 border-end">
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
            <div class="mb-5 ps-3 pe-3 border-end">
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
            <div class="mb-5 ps-3">
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
    
    {{-- Modal --}}
    <div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adminModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 id="questioon"></h3>
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

    <script src="{{'/js/admin.js'}}"></script>
    <script src="{{'/js/account.js'}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>