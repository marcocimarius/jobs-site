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
    <title>Post</title>
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
                            <img src="{{url('/images/' . session('photo'))}}" alt="mdo" width="32" height="32" class="rounded-circle" style="object-fit: cover;">
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
                    <form action="/change_post_photo" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="post_id" id="changePhotoInputId">
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
        <div class="d-flex flex-row justify-content-between">
            <article class="blog-post">
                <h2 class="blog-post-title mb-1">{{$post->title}}</h2>
                <p class="blog-post-meta">{{$post->upload_date}} by <a class="text-dark" href="/account/{{$post->utilizators_id}}">{{$post->author}}</a> </p>
                <p>{!! nl2br(e($post->content)) !!}</p>
            </article>
            <div class="col-auto mx-auto my-auto"> 
                <img src="{{url('/posts_images/' . $post->photo)}}" class="img-thumbnail" style="max-width:450px; max-height:200px; object-fit:cover;" alt="post photo">
            </div>
        </div>
        <div class="d-flex flex-row border-bottom">
            @if(session('id') == $post->utilizators_id)
                <form action="/update_thread" method="GET">
                    <input type="hidden" name="id" value="{{$post->id}}">
                    <input type="hidden" name="user_id" value="{{$post->utilizators_id}}">
                    <button type="submit" class="btn btn-primary mb-2">Update post</button>
                </form>
            @endif
            @if(session('id') == $post->utilizators_id)
                <button class="btn btn-primary mb-2 ms-2" data-bs-toggle="modal" data-bs-target="#changePhotoModal" data-bs-whatever="{{$post->id}}">Change post photo</button>
            @endif
            @if (session()->has('id') && session('role') == 'admin')
                <button class="btn btn-primary ms-2 mb-2" data-bs-toggle="modal" data-bs-target="#deleteModal1" data-bs-whatever="{{$post->id}}">Delete post</button>
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
                <button class="btn btn-primary ms-2 mb-2" data-bs-toggle="modal" data-bs-target="#banUserModal" data-bs-whatever="{{$post->id}}" data-bs-user="{{$user->id}}" data-bs-author="{{$post->author}}">Ban author</button>
            @endif
        </div>    
            {{-- Modal --}}
            <div class="modal fade" id="banUserModal" tabindex="-1" aria-labelledby="banModalLabelll" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="banModalLabelll">Ban user</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h3>Are you sure you want to ban this user?</h3>
                            <form action="/ban_post2" method="POST">
                                @method('PUT')
                                @csrf                    
                                <input type="hidden" name="banned_user_id" id="bannedd_user_id">          
                                <input type="hidden" name="comment_id" id="bannedd_comment_id">
                                <input type="hidden" name="articol_id" id="bannedd_from_post_id">          
                                <input type="hidden" name="author" id="bannedd_comment_author">          
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
        
        
        {{-- <hr> --}}

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
                        <form action="/destroy_thread" method="POST">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="id" id="inputId">                                   
                            <button type="submit" class="btn btn-danger mt-3" name="submit">Delete</button>                  
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @php
            $totall = 0;
        @endphp       
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

        <div class="d-flex justify-content-start mt-2">
            <div class="me-1">
                <form action="/sort_comments_newest" method="GET">
                    <input type="hidden" name="id" value="{{$post->id}}">
                    <button type="submit" class="btn btn-outline-secondary">Sort the comments by date(newest)</button>
                </form>
            </div>
            <div class="ms-1">
                <form action="/sort_comments_oldest" method="GET">
                    <input type="hidden" name="id" value="{{$post->id}}">
                    <button type="submit" class="btn btn-outline-secondary">Sort the comments by date(oldest)</button>
                </form>
            </div>
        </div>

        <h1 class="mt-3 mb-5">Comments: {{$totall}}</h1>
        @switch(session()->has('id'))
            @case(true)
                @foreach ($comments as $comment)    
                        @foreach($users as $user)
                            @if ($user->id == $comment->user_id)
                                {{-- Comment --}}
                                <div class="d-flex justify-content-start" id="{{$comment->id}}">
                                    <div>
                                        <a href="/account/{{$user->id}}">
                                            <img src="{{url('/images/' . $user->photo)}}" alt="mdo" width="64" height="64" class="rounded-circle" style="object-fit: cover;">                                           
                                        </a>
                                    </div>
                                    <div>
                                        <a style="text-decoration: none;" href="/account/{{$user->id}}">
                                            <h5 class="mx-2 ms-4 text-dark">{{$comment->author}}</h5>
                                        </a>
                                        <p class="ms-4">{!! nl2br(e($comment->content)) !!}</p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-3">
                                    @if ($comment->edited == 0)
                                        <div class="mx-5">
                                            <small>Uploaded at: {{$comment->created_at}}</small>
                                        </div>
                                    @endif
                                    @if ($comment->edited == 1)
                                        <div class="mx-5">
                                            <small>Edited at: {{$comment->updated_at}}</small>
                                        </div>
                                    @endif
                                    @if (session('result') == 1)
                                        <div class="mt-none">
                                            <button style="background: none; border: none; padding: none" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="{{$comment->id}}" data-bs-author="{{$comment->author}}" data-bs-content="{{$comment->content}}" data-bs-recipient_id={{$comment->user_id}}>Reply</button>
                                        </div>
                                    @endif
                                    @if (session('result') == 0)
                                        <div class="mt-none">
                                            <button disabled style="background: none; border: none; padding: none">Reply</button>
                                        </div>
                                    @endif
                                    @if (session('result') == 1 && session('id') == $comment->user_id && $comment->edited == 0)
                                        <div class="mt-none">
                                            <button style="background: none; border: none; padding: none" data-bs-toggle="modal" data-bs-target="#editCommentModal" data-bs-whatever="{{$comment->id}}" data-bs-post_id="{{$comment->articol_id}}" data-bs-content="{{$comment->content}}">Edit</button>
                                        </div>
                                    @endif
                                    @if (session('id') == $comment->user_id)
                                        @if (session('result') == 0 || $comment->edited == 1)
                                            <div class="mt-none">
                                                <button disabled style="background: none; border: none; padding: none">Edit</button>
                                            </div>
                                        @endif
                                    @endif
                                    @if (session()->has('id') && session('role') == 'admin')
                                        <div class="mt-none ms-2">
                                            <button class="text-danger" style="background: none; border: none; padding: none" data-bs-toggle="modal" data-bs-target="#deleteCommentModal" data-bs-articolId="{{$comment->articol_id}}" data-bs-commentId="{{$comment->id}}">Delete Comment</button>
                                        </div>
                                    @endif
                                    @if (session()->has('id') && session('role') == 'admin' && session('id') != $comment->user_id && $user->role != 'admin')
                                        <div class="mt-none ms-2">
                                             <button class="text-warning" style="background: none; border: none; padding: none" data-bs-toggle="modal" data-bs-target="#banModal" data-bs-articolId="{{$comment->articol_id}}" data-bs-commentId="{{$comment->id}}" data-bs-userBanned="{{$comment->user_id}}" data-bs-comment_author="{{$comment->author}}">Ban</button> 
                                        </div>
                                    @endif
                                </div>

                                {{-- Modal --}}
                                <div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="editCommentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editCommentModalLabel">Edit Comment </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h3>You can edit a comment only once</h3>
                                                <form action="/edit_comment" method="POST">
                                                    @method('PUT')
                                                    @csrf                              
                                                    <input type="hidden" name="comment_id" id="edit_comment_id">                                   
                                                    <input type="hidden" name="articol_id" id="edit_comment_post_id">  
                                                    <textarea class="form-control" placeholder="Leave a new comment here" name="content" id="edit_comment_content" style="height: 3cm" required></textarea>                                 
                                                    <button type="submit" class="btn btn-danger mt-3" name="submit">Edit</button>                  
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal --}}
                                <div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="banModalLabel">Ban user</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h3>Are you sure you want to ban this user?</h3>
                                                <form action="/ban_comment" method="POST">
                                                    @method('PUT')
                                                    @csrf                    
                                                    <input type="hidden" name="banned_user_id" id="banned_user_id">          
                                                    <input type="hidden" name="comment_id" id="banned_comment_id">
                                                    <input type="hidden" name="articol_id" id="banned_from_post_id">          
                                                    <input type="hidden" name="comment_author" id="banned_comment_author">          
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
                                <div class="modal fade" id="deleteCommentModal" tabindex="-1" aria-labelledby="deleteCommentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteCommentModalLabel">Delete Comment </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h3>Are you sure you want to delete this comment?</h3>
                                                <form action="/delete_comment" method="POST">
                                                    @method('DELETE')
                                                    @csrf                              
                                                    <input type="hidden" name="comment_id" id="delete1_comment_id">                                   
                                                    <input type="hidden" name="articol_id" id="delete1_articol_id">                                   
                                                    <button type="submit" class="btn btn-danger mt-3" name="submit">Delete</button>                  
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal --}}
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Reply to </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="mb-1">
                                                        <label for="recipient-name" class="col-form-label">Recipient:</label>                      
                                                        <input type="text" class="form-control" id="recipient-name" value="{{$user->login}}" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="previousTextarea" class="col-form-label">Replied comment:</label>  
                                                        <textarea class="form-control" id="previousTextarea" readonly></textarea>
                                                    </div>
                                                </form>
                                                <form action="/create_reply" method="POST">
                                                    @csrf
                                                    <div class="form-floating">
                                                        <input type="hidden" name="user_id" id="user_id" value="{{session('id')}}">
                                                        <input type="hidden" name="comment_id" id="comment_id">
                                                        <input type="hidden" name="post_id" value="{{$post->id}}">
                                                        <input type="hidden" name="recipient_login" id="recipientLoginToDB">
                                                        <input type="hidden" name="recipient_id" id="recipient_id" >
                                                        <textarea class="form-control" placeholder="Leave a reply here" id="floatingTextarea" name="content" style="height: 3cm" required></textarea>
                                                        <label for="floatingTextarea">Reply</label>
                                                        <div class="invalid-feedback">
                                                            Please provide a valid comment
                                                        </div>
                                                    </div>
                                                    <p class="mt-3 mb-3 text-muted" id="errors"> </p>
                                                    <button type="submit" class=" btn btn-primary mt-3" name="submit">Reply</button>                  
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @break
                            @endif    
                        @endforeach 

                                

                    @foreach($replies as $reply)  
                        @if($comment->id == $reply->comment_id)
                            @foreach($users as $user)
                                @if($user->id == $reply->user_id)
                                    {{-- Replies --}}
                                    <div class="ms-5" id="{{$reply->id}}">
                                        <div class="d-flex justify-content-start">
                                            <div>
                                                <a href="/account/{{$reply->user_id}}">
                                                    <img src="{{url('/images/' . $user->photo)}}" alt="mdo" width="64" height="64" class="rounded-circle" style="object-fit: cover;">                                           
                                                </a>
                                            </div>
                                            <div>
                                                <a style="text-decoration: none;" href="/account/{{$user->id}}">
                                                    <h5 class="mx-2 ms-4 text-dark">{{$reply->author}}</h5>
                                                </a>

                                                <div class="d-flex flex-row"> 
                                                    <div class="text-primary ms-4"><p>{!! nl2br(e($reply->recipient)) !!}&nbsp;</p></div>
                                                    <div>{!! nl2br(e($reply->content)) !!}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-start mb-3">
                                            @if ($reply->edited == 0)
                                                <div class="mx-5">
                                                    <small>Uploaded at: {{$reply->created_at}}</small>
                                                </div>
                                            @endif
                                            @if ($reply->edited == 1)
                                                <div class="mx-5">
                                                    <small>Edited at: {{$reply->updated_at}}</small>
                                                </div>
                                            @endif
                                            @if (session('result') == 1)
                                                <div class="mt-none">
                                                    <button style="background: none; border: none; padding: none" data-bs-toggle="modal" data-bs-target="#exampleModal2" data-bs-whatever="{{$comment->id}}" data-bs-author="{{$reply->author}}" data-bs-content="{{$reply->content}}" data-bs-recipient_id={{$reply->user_id}} data-bs-main_reply_id={{$reply->id}} data-bs-isBanned={{$result}} data-bs-banDate={{session('ban_until')}}>Reply</button>
                                                </div>
                                            @endif
                                            @if (session('result') == 0)
                                                <div class="mt-none">
                                                    <button disabled style="background: none; border: none; padding: none">Reply</button>
                                                </div>
                                            @endif
                                            @if (session('result') == 1 && session('id') == $reply->user_id && $reply->edited == 0)
                                                <div class="mt-none">
                                                    <button style="background: none; border: none; padding: none" data-bs-toggle="modal" data-bs-target="#editReplyModal" data-bs-whatever="{{$reply->id}}" data-bs-post_id="{{$reply->articol_id}}" data-bs-content="{{$reply->content}}">Edit</button>
                                                </div>
                                            @endif
                                            @if (session('id') == $reply->user_id)
                                                @if (session('result') == 0 || $reply->edited == 1)
                                                    <div class="mt-none">
                                                        <button disabled style="background: none; border: none; padding: none">Edit</button>
                                                    </div>
                                                @endif
                                            @endif
                                            @if (session()->has('id') && session('role') == 'admin')
                                                <div class="mt-none ms-2">
                                                    <button class="text-danger" style="background: none; border: none; padding: none" data-bs-toggle="modal" data-bs-target="#deleteReplyModal" data-bs-articolId="{{$reply->articol_id}}" data-bs-replyId="{{$reply->id}}" data-bs-commentId="{{$reply->comment_id}}" data-bs-recipient="{{$reply->recipient}}" data-bs-user="{{$reply->user_id}}">Delete Reply</button>
                                                </div>
                                             @endif 
                                            @if (session()->has('id') && session('role') == 'admin' && session('id') != $reply->user_id && $user->role != 'admin')
                                                <div class="mt-none ms-2">
                                                    <button class="text-warning" style="background: none; border: none; padding: none" data-bs-toggle="modal" data-bs-target="#banModal2" data-bs-articolId="{{$comment->articol_id}}" data-bs-commentId="{{$reply->id}}" data-bs-userBanned="{{$reply->user_id}}" data-bs-comment_author="{{$reply->author}}">Ban</button> 
                                                </div>
                                            @endif

                                            {{-- Modal --}}
                                            <div class="modal fade" id="banModal2" tabindex="-1" aria-labelledby="banModalLabel35" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="banModalLabel35">Ban user</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h3>Are you sure you want to ban this user?</h3>
                                                            <form action="/ban_reply" method="POST">
                                                                @method('PUT')
                                                                @csrf                    
                                                                <input type="hidden" name="banned_user_id" id="banneed_user_id">          
                                                                <input type="hidden" name="comment_id" id="banneed_comment_id">
                                                                <input type="hidden" name="articol_id" id="banneed_from_post_id">          
                                                                <input type="hidden" name="comment_author" id="banneed_comment_author">          
                                                                <input type="hidden" name="main_reply_id" id="banneed_main_reply_id">          
                                                                <select name="repban" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
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
                                            <div class="modal fade" id="editReplyModal" tabindex="-1" aria-labelledby="editReplyModelLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editReplyModelLabel">Edit Reply</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h3>You can edit a comment only once</h3>
                                                            <form action="/edit_reply" method="POST">
                                                                @method('PUT')
                                                                @csrf
                                                                <input type="hidden" name="reply_id" id="edit_reply_id">                                                                   
                                                                <input type="hidden" name="post_id" id="edit_post_id">                                                                   
                                                                <textarea class="form-control" placeholder="Leave a new reply here" name="content" style="height: 3cm" id="edit_reply_content" required></textarea>                               
                                                                <button type="submit" class="btn btn-danger mt-3" name="submit">Edit</button>                  
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Modal --}}
                                            <div class="modal fade" id="deleteReplyModal" tabindex="-1" aria-labelledby="deleteReplyModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteReplyModalLabel">Delete Reply </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h3>Are you sure you want to delete this reply?</h3>
                                                            <form action="/delete_reply" method="POST">
                                                                @method('DELETE')
                                                                @csrf
                                                                <input type="hidden" name="reply_id" id="reply_id">                                                                   
                                                                <input type="hidden" name="articol_id" id="delete2_articol_id">                                   
                                                                <input type="hidden" name="comment_id" id="delete2_comment_id">                                   
                                                                <input type="hidden" name="recipient" id="delete2_recipient">                                   
                                                                <input type="hidden" name="main_reply_id" id="delete2_main_reply_id">                                   
                                                                <input type="hidden" name="user_id" id="delete2_user_id">                                   
                                                                <button type="submit" class="btn btn-danger mt-3" name="submit">Delete</button>                  
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>              
                                    {{-- Modal --}}
                                    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel2">Reply to </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="mb-3">
                                                            <label for="recipient-name2" class="col-form-label">Recipient:</label>                      
                                                            <input type="text" class="form-control" id="recipient-name2" value="{{$user->login}}" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="previousTextarea" class="col-form-label">Replied comment:</label>  
                                                            <textarea class="form-control" id="previousTextarea2" readonly></textarea>
                                                        </div>
                                                    </form>
                                                    {{-- @if ($result == 1) --}}
                                                        <form action="/thread/{{$post->id}}" method="POST">
                                                            @csrf
                                                            <div class="form-floating">
                                                                <input type="hidden" name="user_id" id="userId" value="{{session('id')}}">
                                                                <input type="hidden" name="comment_id" id="commentId">
                                                                <input type="hidden" name="post_id" value="{{$post->id}}">
                                                                <input type="hidden" name="recipient_login" id="nameToDB">
                                                                <input type="hidden" name="recipient_id" id="recipient_id2">
                                                                <input type="hidden" name="main_reply_id" id="main_reply_id2">
                                                                <textarea class="form-control" placeholder="Leave a reply here" id="contentTextarea" name="content" style="height: 3cm" required></textarea>
                                                                <label for="floatingTextarea2">Reply</label>
                                                                <div class="invalid-feedback">
                                                                    Please provide a valid comment
                                                                </div>
                                                            </div>
                                                            <button type="submit" class=" btn btn-primary mt-3" name="submit">Reply</button>                  
                                                        </form>
                                                    {{-- @endif --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @endif
                            @endforeach    
                        @endif 
                    @endforeach            
                @endforeach  

                <hr>

                {{-- Create Comment --}}
                <div class="bg-light border p-4 m-3">
                    @if ($result == 1)
                        <form action="/create_comment" method="POST">
                            @csrf
                                <div class="form-floating">
                                    <input type="hidden" name="post_user_id" value="{{$post->utilizators_id}}">
                                    <input type="hidden" name="post_id" value="{{$post->id}}">
                                    <input type="hidden" name="recipient_id" value="{{$post->utilizators_id}}">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="content" style="height: 3cm" required></textarea>
                                    <label for="floatingTextarea">Make a comment</label>
                                    <div class="invalid-feedback">
                                        Please provide a valid comment
                                    </div>
                                </div>
                                <button type="submit" class=" btn btn-primary mt-3" name="submit">Comment</button>                
                        </form>
                    @endif
                    @if($result == 0)
                        <form>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="content" style="height: 3cm" disabled>You have been banned and can't post anything until {{session('ban_until')}}</textarea>
                                <label for="floatingTextarea">Make a comment</label>
                                <div class="invalid-feedback">
                                    Please provide a valid comment
                                </div>
                            </div>
                            <button type="submit" class=" btn btn-primary mt-3" name="submit" disabled>Comment</button>
                        </form>
                    @endif
                </div>
                
                @break
            @case(false)
                <div class="bg-light border p-4 m-3">
                    <textarea class="form-control" placeholder="In order to see the comments, you need to be logged in" id="floatingTextarea" name="content" readonly></textarea>
                    <button type="submit" class=" btn btn-primary mt-3" name="submit">Comment</button>    
                </div>
                @break
        @endswitch
    </div>

    <script src="{{'/js/script.js'}}"></script>
    <script src="{{'/js/delete.js'}}"></script>
    <script src="{{'/js/admin.js'}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>