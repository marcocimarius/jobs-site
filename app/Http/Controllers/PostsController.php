<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Articol;
use App\Models\Utilizator;
use App\Models\Reply;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Follow;
use Carbon\Carbon;

class PostsController extends Controller
{
    function generateId() {
        $number = mt_rand(1000000000, 9999999999); 

        if (self::idExists($number)) {
            return generateId();
        }
    
        return $number;
    }
    
    function idExists($number) {

        return Articol::whereId($number)->exists();
    }

    function generateCommentId() {
        $number = mt_rand(30, 9999999); 

        if (self::CommentIdExists($number)) {
            return generateCommentId();
        }
    
        return $number;
    }

    function CommentIdExists($number) {

        return Notification::whereComment_id($number)->exists();
    }

    function generateReplyId() {
        $number = mt_rand(30, 9999999); 

        if (self::ReplyIdExists($number)) {
            return generateReplyId();
        }
    
        return $number;
    }

    function ReplyIdExists($number) {

        return Notification::whereReply_id($number)->exists();
    }

    public function show_threads() {
        $users = Utilizator::all();
        $posts = Articol::paginate(5);
        $nrComments = DB::table('comments')->join('articols', 'comments.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as cnr'))->groupBy('articols.id')->get();
        $nrReplies = DB::table('replies')->join('articols', 'replies.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as rnr'))->groupBy('articols.id')->get();
        $nrPosts = DB::table('articols')->select(DB::raw('count(*) as pnr'))->get();
        $idd = session('id');
        $notifications = Notification::where('recipient_id', '=', $idd)->orderBy('id', 'desc')->get();
        $notificationsNumber = DB::table('notifications')->select(DB::raw('count(*) as nnr'))->where([['recipient_id', '=', $idd], ['was_seen', '=', 0]])->get();

        return view('index', ['posts' => $posts, 'nrComments' => $nrComments, 'nrReplies' => $nrReplies, 'nrPosts' => $nrPosts, 'notifications' => $notifications, 'id' => $idd, 'notificationsNumber' => $notificationsNumber, 'users' => $users]);
    }

    public function show_thread($id) {
        $post = Articol::findOrFail($id);
        $comments = Comment::where('articol_id', '=', $id)->orderBy('created_at', 'asc')->get();
        $replies = Reply::where('articol_id', '=', $id)->orderBy('created_at', 'asc')->get();
        $users = Utilizator::all();
        $nrComments = DB::table('comments')->join('articols', 'comments.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as cnr'))->groupBy('articols.id')->get();
        $nrReplies = DB::table('replies')->join('articols', 'replies.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as rnr'))->groupBy('articols.id')->get();
        $idd = session('id');
        $notifications = Notification::where('recipient_id', '=', $idd)->orderBy('id', 'desc')->get();
        $notificationsNumber = DB::table('notifications')->select(DB::raw('count(*) as nnr'))->where([['recipient_id', '=', $idd], ['was_seen', '=', 0]])->get();
        $result = 0;
        if(session('ban_until') !== null) {
            $now = Carbon::now();
            $ban = Carbon::parse(session('ban_until'));
            $result = $ban->lt($now);
        }
        else {
            $result = 1;
        }
        
        
        return view('articol', ['post' => $post, 'users' => $users, 'comments' => $comments, 'replies' => $replies, 'nrComments' => $nrComments, 'nrReplies' => $nrReplies, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber, 'result' => $result]);
    }

    public function show_create_thread() {
        $idd = session('id');
        $notifications = Notification::where('recipient_id', '=', $idd)->orderBy('id', 'desc')->get();
        $notificationsNumber = DB::table('notifications')->select(DB::raw('count(*) as nnr'))->where([['recipient_id', '=', $idd], ['was_seen', '=', 0]])->get();
        $result = 0;
        if(session('ban_until') !== null) {
            $now = Carbon::now();
            $ban = Carbon::parse(session('ban_until'));
            $result = $ban->lt($now);
        }
        else {
            $result = 1;
        }

        return view('createArticol', ['notifications' => $notifications, 'notificationsNumber' => $notificationsNumber, 'result' => $result]);
    }

    public function create_thread(Request $req) {
        $posts = new Articol();

        $title = $req -> title;
        $content = $req -> content;
        $author = $req -> author;
        $errors = '';
        $id = self::generateId();

        if($title != '') {
            if($content != '') {
                if($req->hasFile('image')) {
                    $image = $req -> file('image');
                    $imageExtension = $image -> getClientOriginalExtension();
                    if($imageExtension == 'jpeg' || $imageExtension == 'jpg') {
                        $imageName = uniqid() . "." . $imageExtension;
                        $imageFolder = public_path('posts_images/');
                        $image -> move($imageFolder, $imageName);
                        $posts -> id = $id;
                        $posts -> utilizators_id = session('id');
                        $posts -> title = $title;                       
                        $posts -> content = $content;
                        $posts -> photo = $imageName;
                        $posts -> author = $author;
                        $date = Carbon::now();
                        $posts -> upload_date = $date; 
                        $posts -> save();

                        $follows = Follow::where('followed_id', '=', session('id'))->get();
                        foreach($follows as $follow) {
                            $notification = new Notification();
                            $notification->user_id = session('id');
                            $notification->post_id = $id;
                            $notification->content = 'post';
                            $notification->creation_date = $date;
                            $notification->recipient_id = $follow->subscriber_id;
                            $notification->title = session('login') . ' has created a new post';
                            $notification->image = session('photo');
                            $notification->was_seen = 0;
                            $notification->save();
                        }
                    }
                    else {
                        $errors = '2';
                        return view('createArticol', ['errors' => $errors]);
                    }
                }
                else {
                    $errors = '1';
                    return view('createArticol', ['errors' => $errors]);
                }
            }
            else {
                $errors = '15';
                return view('createArticol', ['errors' => $errors]);
            }
        }
        else {
            $errors = '14';
            return view('createArticol', ['errors' => $errors]);
        }

        return redirect('/thread/' . $id);
    }

    public function create_comment(Request $req) {
        $newComment = new Comment();
        $newNotification = new Notification();

        $comment_id = self::generateCommentId();
        $post_id = $req->post_id;
        $post_user_id = $req->post_user_id;
        $user_id = session('id');
        $content = $req -> content;
        $author = session('login');
        $upload_date = Carbon::now();
        $recipient_id = $req->recipient_id;

        $newComment -> id = $comment_id;
        $newComment -> articol_id = $post_id;
        $newComment -> author = $author;
        $newComment -> content = $content;
        $newComment -> upload_date = $upload_date;
        $newComment -> user_id = $user_id;
        $newComment -> save();

        if($post_user_id != session('id')) {
            $newNotification -> user_id = $user_id;
            $newNotification -> recipient_id = $recipient_id;
            $newNotification -> post_id = $post_id;
            $newNotification -> comment_id = $comment_id;
            $newNotification -> title = $author . ' has commented on one of your posts';
            $newNotification -> content = $content;
            $newNotification -> image = session('photo');
            $newNotification -> creation_date = $upload_date;
            $newNotification -> was_seen = 0;
            $newNotification -> save();
        }

        return redirect('/thread/' . $post_id);
    }

    public function create_reply(Request $req) {
        $newReply = new Reply();
        $newNotification = new Notification();

        $reply_id = self::generateReplyId();
        $articol_id = $req->post_id;
        $author = session('login');
        $comment_id = $req->comment_id;
        $content = $req->content;
        $upload_date = Carbon::now();
        $user_id = $req->user_id;
        $recipient = $req->recipient_login;
        $recipient_id = $req->recipient_id;

        $newReply -> id = $reply_id;
        $newReply -> articol_id = $articol_id;
        $newReply -> author = $author;
        $newReply -> comment_id = $comment_id;
        $newReply -> recipient = '@' . $recipient . ' ';
        $newReply -> content = $content;
        $newReply -> upload_date = $upload_date;
        $newReply -> user_id = $user_id;
        $newReply -> save();

        if($recipient_id != session('id')) {
            $newNotification -> user_id = $user_id;
            $newNotification -> recipient_id = $recipient_id;
            $newNotification -> post_id = $articol_id;
            $newNotification -> reply_id = $reply_id;
            $newNotification -> title = $author . ' has replied to one of your comments';
            $newNotification -> content = $content;
            $newNotification -> image = session('photo');
            $newNotification -> creation_date = $upload_date;
            $newNotification -> was_seen = 0;
            $newNotification -> save();
        }

        return redirect('/thread/' . $articol_id);
    }

    public function create_secondary_reply(Request $req) {
        $newSecondaryReply = new Reply();
        $newNotification = new Notification();

        $reply_id = self::generateReplyId();
        $comment_id = $req->comment_id;
        $articol_id = $req->post_id;
        $user_id = $req->user_id;
        $content = $req->content;
        $upload_date = Carbon::now();
        $author = session('login');
        $recipient = '@' . $req->recipient_login . ' ';
        $mainReply_id = $req->main_reply_id;
        $recipient_id = $req->recipient_id;

        $newSecondaryReply -> id = $reply_id;
        $newSecondaryReply -> comment_id = $comment_id;
        $newSecondaryReply -> articol_id = $articol_id;
        $newSecondaryReply -> user_id = $user_id;
        $newSecondaryReply -> content = $content;
        $newSecondaryReply -> upload_date = $upload_date;
        $newSecondaryReply -> author = $author;
        $newSecondaryReply -> recipient = $recipient;
        $newSecondaryReply -> mainReply_id = $mainReply_id;
        $newSecondaryReply -> save();

        if($recipient_id != session('id')) {
            $newNotification -> user_id = $user_id;
            $newNotification -> recipient_id = $recipient_id;
            $newNotification -> post_id = $articol_id;
            $newNotification -> reply_id = $reply_id;
            $newNotification -> title = $author . ' has replied to one of your comments';
            $newNotification -> content = $content;
            $newNotification -> image = session('photo');
            $newNotification -> creation_date = $upload_date;
            $newNotification -> was_seen = 0;
            $newNotification -> save();
        }

        return redirect('/thread/' . $articol_id);
    }

    public function delete_number(Request $req) {
        $user_id = $req->user_id;
        $id = session('id');
        $posts = Articol::paginate(5);
        $nrComments = DB::table('comments')->join('articols', 'comments.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as cnr'))->groupBy('articols.id')->get();
        $nrReplies = DB::table('replies')->join('articols', 'replies.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as rnr'))->groupBy('articols.id')->get();
        $nrPosts = DB::table('articols')->select(DB::raw('count(*) as pnr'))->get();
        $notifications = Notification::where('recipient_id', '=', $id)->get();
        $notificationsNumber = DB::table('notifications')->select(DB::raw('count(*) as nnr'))->where([['recipient_id', '=', $id], ['was_seen', '=', 0]])->get();
        $random = $req->random;
        foreach($notifications as $notification) {
            $notification -> was_seen = 1;
            $notification -> save();
        }
        $result = 0;
        if(session('ban_until') !== null) {
            $now = Carbon::now();
            $ban = Carbon::parse(session('ban_until'));
            $result = $ban->lt($now);
        }
        else {
            $result = 1;
        }
        return redirect('/');
        // return view('index', ['uid' => $user_id, 'posts' => $posts, 'nrComments' => $nrComments, 'nrReplies' => $nrReplies, 'nrPosts' => $nrPosts, 'notifications' => $notifications, 'id' => $id, 'random' => $random, 'notificationsNumber' => $notificationsNumber, 'result' => $result]);
    }

    public function show_update_thread(Request $req) {
        if(session('id') == $req->user_id) {
            $thread = Articol::findOrFail($req->id);
            $idd = session('id');
            $notifications = Notification::where('recipient_id', '=', $idd)->orderBy('id', 'desc')->get();
            $notificationsNumber = DB::table('notifications')->select(DB::raw('count(*) as nnr'))->where([['recipient_id', '=', $idd], ['was_seen', '=', 0]])->get();
            $result = 0;
            if(session('ban_until') !== null) {
                $now = Carbon::now();
                $ban = Carbon::parse(session('ban_until'));
                $result = $ban->lt($now);
            }
            else {
                $result = 1;
            }

            return view('updateArticol', ['thread' => $thread, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber, 'result' => $result]);
        }
        
        return redirect('/');
    }

    public function update_thread(Request $req) {
        $id = $req->thread_id;
        $thread = Articol::findOrFail($id);

        $title = $req -> title;
        $content = $req -> content;
        $author = $req -> author;
        $errors = '';

        if($title != '') {
            if($content != '') {
                if($req->hasFile('image')) {
                    $image = $req -> file('image');
                    $imageExtension = $image -> getClientOriginalExtension();
                    if($imageExtension == 'jpeg' || $imageExtension == 'jpg') {
                        unlink(public_path('posts_images/' . $thread->photo));
                        $imageName = uniqid() . "." . $imageExtension;
                        $imageFolder = public_path('posts_images/');
                        $image -> move($imageFolder, $imageName);
                        $thread -> id = $id;
                        $thread -> utilizators_id = session('id');
                        $thread -> title = $title;                       
                        $thread -> content = $content;
                        $thread -> photo = $imageName;
                        $thread -> author = $author;
                        $date = Carbon::now();
                        $thread -> upload_date = $date; 
                        $thread -> save();
                    }
                    else {
                        $errors = '2';
                        return view('updateArticol', ['errors' => $errors, 'thread' => $thread]);
                    }
                }
                else {
                    $errors = '1';
                    return view('updateArticol', ['errors' => $errors, 'thread' => $thread]);
                }
            }
            else {
                $errors = '15';
                return view('updateArticol', ['errors' => $errors, 'thread' => $thread]);
            }
        }
        else {
            $errors = '14';
            return view('updateArticol', ['errors' => $errors, 'thread' => $thread]);
        }

        return redirect('/thread/' . $id);
    }

    public function delete_thread(Request $req) {
        $thread = Articol::findOrFail($req->id);

        if($thread->photo) {
            unlink(public_path('posts_images/' . $thread->photo));
        }

        $notifications = Notification::where('post_id', '=', $thread->id);
        $comments = Comment::where('articol_id', '=', $thread->id);
        $replies = Reply::where('articol_id', '=', $thread->id);
        $notifications->delete();
        $replies->delete();
        $comments->delete();
        $thread->delete();

        return redirect('/');
    }

    public function destroy_thread(Request $req) {
        $thread = Articol::findOrFail($req->id);

        if($thread->photo) {
            unlink(public_path('posts_images/' . $thread->photo));
        }

        $notifications = Notification::where('post_id', '=', $thread->id);
        $comments = Comment::where('articol_id', '=', $thread->id);
        $replies = Reply::where('articol_id', '=', $thread->id);
        $notifications->delete();
        $replies->delete();
        $comments->delete();
        $thread->delete();

        return redirect('/');
    }

    public function del($id) {
        $moreReplies = Reply::where('mainReply_id', '=', $id)->get();

        return $moreReplies;
    }

    public function delete_reply(Request $req) {
        $user_id = $req->user_id;
        $reply_id = $req->reply_id;
        $articol_id = $req->articol_id;

        $bannedReplies = Reply::where('id', '=', $reply_id)->get();     
        foreach($bannedReplies as $bannedReply) {
            $secondaryReplies = Reply::where('mainReply_id', '=', $bannedReply->id)->get();
            $soonToDelete = Reply::where('id', '=', $bannedReply->id)->get();

            if($soonToDelete->isNotEmpty()) {
                $asd = Reply::where('id', '=', $bannedReply->id);
                $asd -> delete();
                $notif = Notification::where('reply_id', '=', $bannedReply->id)->get();
                if($notif->isNotEmpty()) {
                    $notif2 = Notification::where('reply_id', '=', $bannedReply->id);
                    $notif2->delete();
                } 
            }
            
            if($secondaryReplies -> isNotEmpty()) {
                $empty = new Reply();

                foreach($secondaryReplies as $secondaryReply) {
                    $condition = true;
                    $empty = self::del($secondaryReply->id);
                    $toBeDeleted = Reply::findOrFail($secondaryReply->id);
                    $toBeDeleted -> delete();
                    $notiff = Notification::where('reply_id', '=', $secondaryReply->id)->get();
                    if($notiff->isNotEmpty()) {
                        $notiff2 = Notification::where('reply_id', '=', $secondaryReply->id);
                        $notiff2->delete();
                    } 

                    while($condition) {
                        if($empty -> isNotEmpty()) {
                            foreach($empty as $item) {
                                $id = $item->id;
                                $gonnaBeDeleted = Reply::findOrFail($id);
                                $gonnaBeDeleted -> delete();
                                $notifff = Notification::where('reply_id', '=', $id)->get();
                                if($notifff->isNotEmpty()) {
                                    $notifff2 = Notification::where('reply_id', '=', $id);
                                    $notifff2->delete();
                                }  
                                $empty = self::del($id);
                            }        
                        }
                        else {
                            $condition = false;
                        }
                    }       
                }
            }
        }

        return redirect('/thread/' . $articol_id);
    }

    public function delete_comment(Request $req) {
        $comment_id = $req->comment_id;
        $articol_id = $req->articol_id;

        $comment = Comment::where('id', '=', $comment_id);
        $replies = Reply::where('comment_id', '=', $comment_id)->get();

        if(isset($replies)) {
            foreach($replies as $reply) {
                $notification = Notification::where('reply_id', '=', $reply->id);
                if(isset($notification)) {
                    $notification->delete();
                }
                
            }
        }
        
        $repliess = Reply::where('comment_id', '=', $comment_id);
        $notifications = Notification::where('comment_id', '=', $comment_id);
        if(isset($notifications)) {
            $notifications->delete();
        }
        
        $repliess->delete();
        $comment->delete();

        return redirect('/thread/' . $articol_id);
    }

    public function sort_oldest() {
        $users = Utilizator::all();
        $posts = DB::table('articols')->orderBy('created_at', 'asc')->paginate(5);
        $nrComments = DB::table('comments')->join('articols', 'comments.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as cnr'))->groupBy('articols.id')->get();
        $nrReplies = DB::table('replies')->join('articols', 'replies.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as rnr'))->groupBy('articols.id')->get();
        $nrPosts = DB::table('articols')->select(DB::raw('count(*) as pnr'))->get();
        $idd = session('id');
        $notifications = Notification::where('recipient_id', '=', $idd)->orderBy('id', 'desc')->get();
        $notificationsNumber = DB::table('notifications')->select(DB::raw('count(*) as nnr'))->where([['recipient_id', '=', $idd], ['was_seen', '=', 0]])->get();
        $result = 0;
        if(session('ban_until') !== null) {
            $now = Carbon::now();
            $ban = Carbon::parse(session('ban_until'));
            $result = $ban->lt($now);
        }
        else {
            $result = 1;
        }

        return view('index', ['users' => $users, 'posts' => $posts, 'nrComments' => $nrComments, 'nrReplies' => $nrReplies, 'nrPosts' => $nrPosts, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber, 'result' => $result]);
    }

    public function sort_newest() {
        $users = Utilizator::all();
        $posts = DB::table('articols')->orderBy('created_at', 'desc')->paginate(5);
        $nrComments = DB::table('comments')->join('articols', 'comments.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as cnr'))->groupBy('articols.id')->get();
        $nrReplies = DB::table('replies')->join('articols', 'replies.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as rnr'))->groupBy('articols.id')->get();
        $nrPosts = DB::table('articols')->select(DB::raw('count(*) as pnr'))->get();
        $idd = session('id');
        $notifications = Notification::where('recipient_id', '=', $idd)->orderBy('id', 'desc')->get();
        $notificationsNumber = DB::table('notifications')->select(DB::raw('count(*) as nnr'))->where([['recipient_id', '=', $idd], ['was_seen', '=', 0]])->get();
        $result = 0;
        if(session('ban_until') !== null) {
            $now = Carbon::now();
            $ban = Carbon::parse(session('ban_until'));
            $result = $ban->lt($now);
        }
        else {
            $result = 1;
        }

        return view('index', ['users' => $users, 'posts' => $posts, 'nrComments' => $nrComments, 'nrReplies' => $nrReplies, 'nrPosts' => $nrPosts, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber, 'result' => $result]);
    }

    public function sort_comments_newest(Request $req) {
        $id = $req->id;
        $post = Articol::findOrFail($id);
        $comments = DB::table('comments')->where('articol_id', '=', $id)->orderBy('created_at', 'desc')->get();
        $replies = Reply::where('articol_id', '=', $id)->get();
        $users = Utilizator::all();
        $nrComments = DB::table('comments')->join('articols', 'comments.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as cnr'))->groupBy('articols.id')->get();
        $nrReplies = DB::table('replies')->join('articols', 'replies.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as rnr'))->groupBy('articols.id')->get();
        $idd = session('id');
        $notifications = Notification::where('recipient_id', '=', $idd)->orderBy('id', 'desc')->get();
        $notificationsNumber = DB::table('notifications')->select(DB::raw('count(*) as nnr'))->where([['recipient_id', '=', $idd], ['was_seen', '=', 0]])->get();
        $result = 0;
        if(session('ban_until') !== null) {
            $now = Carbon::now();
            $ban = Carbon::parse(session('ban_until'));
            $result = $ban->lt($now);
        }
        else {
            $result = 1;
        }

        return view('articol', ['post' => $post, 'users' => $users, 'comments' => $comments, 'replies' => $replies, 'nrComments' => $nrComments, 'nrReplies' => $nrReplies, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber, 'result' => $result]);
    }

    public function sort_comments_oldest(Request $req) {
        $id = $req->id;
        $post = Articol::findOrFail($id);
        $comments = DB::table('comments')->where('articol_id', '=', $id)->orderBy('created_at', 'asc')->get();
        $replies = Reply::where('articol_id', '=', $id)->get();
        $users = Utilizator::all();
        $nrComments = DB::table('comments')->join('articols', 'comments.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as cnr'))->groupBy('articols.id')->get();
        $nrReplies = DB::table('replies')->join('articols', 'replies.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as rnr'))->groupBy('articols.id')->get();
        $idd = session('id');
        $notifications = Notification::where('recipient_id', '=', $idd)->orderBy('id', 'desc')->get();
        $notificationsNumber = DB::table('notifications')->select(DB::raw('count(*) as nnr'))->where([['recipient_id', '=', $idd], ['was_seen', '=', 0]])->get();
        $result = false;
        $result = 0;
        if(session('ban_until') !== null) {
            $now = Carbon::now();
            $ban = Carbon::parse(session('ban_until'));
            $result = $ban->lt($now);
        }
        else {
            $result = 1;
        }

        return view('articol', ['post' => $post, 'users' => $users, 'comments' => $comments, 'replies' => $replies, 'nrComments' => $nrComments, 'nrReplies' => $nrReplies, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber, 'result' => $result]);
    }

    public function about() {
        $id = session('id');
        $notifications = Notification::where('recipient_id', '=', $id)->orderBy('id', 'desc')->get();
        $notificationsNumber = DB::table('notifications')->select(DB::raw('count(*) as nnr'))->where([['recipient_id', '=', $id], ['was_seen', '=', 0]])->get();

        return view('about', ['notifications' => $notifications, 'notificationsNumber' => $notificationsNumber]);
    }

    public function search(Request $req) {
        $users = Utilizator::all();
        $posts = Articol::search(request('search'))->paginate();
        $nrComments = DB::table('comments')->join('articols', 'comments.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as cnr'))->groupBy('articols.id')->get();
        $nrReplies = DB::table('replies')->join('articols', 'replies.articol_id', '=', 'articols.id')->select(DB::raw('articols.id as aid, count(*) as rnr'))->groupBy('articols.id')->get();
        $nrPosts = DB::table('articols')->select(DB::raw('count(*) as pnr'))->where('title', 'like', '%' . $req->search . '%')->get();
        $idd = session('id');
        $notifications = Notification::where('recipient_id', '=', $idd)->orderBy('id', 'desc')->get();
        $notificationsNumber = DB::table('notifications')->select(DB::raw('count(*) as nnr'))->where([['recipient_id', '=', $idd], ['was_seen', '=', 0]])->get();

        return view('index', ['posts' => $posts, 'nrComments' => $nrComments, 'nrReplies' => $nrReplies, 'nrPosts' => $nrPosts, 'notifications' => $notifications, 'id' => $idd, 'notificationsNumber' => $notificationsNumber, 'users' => $users]);
    }

    public function ban_comment(Request $req) {
        $select = $req->ban;
        $user_id = $req->banned_user_id;

        $date = Carbon::now();

        $user = Utilizator::findOrFail($user_id);
        switch($select) {
            case(1):
                $user->ban_until = $date->addMinutes(30);
                $user->save();
                break;
            case(2):
                $user->ban_until = $date->addHour();
                $user->save();
                break;
            case(3):
                $user->ban_until = $date->addHours(2);
                $user->save();
                break;
            case(4):
                $user->ban_until = $date->addDay();
                $user->save();
                break;
            case(5):
                $user->ban_until = $date->addDays(2);
                $user->save();
                break;
            case(6):
                $user->ban_until = $date->addWeek();
                $user->save();
                break;
            case(7):
                $user->ban_until = $date->addMonth();
                $user->save();
                break;
            case(8):
                $user->ban_until = $date->addYear();
                $user->save();
                break;
            case(9):
                $user->ban_until = $date->addYears(10);
                $user->save(); 
                break;
        }

        $comment_id = $req->comment_id;
        $articol_id = $req->articol_id;
        $author = $req->comment_author;

        $comments = Comment::where('author', 'like', $author)->get();
        //deleting replies notifications
        foreach($comments as $comment) {
            $replies = Reply::where('comment_id', '=', $comment->id)->get();
            foreach($replies as $reply) {
                $notification = Notification::where('reply_id', '=', $reply->id);
                $notification->delete();
            }
        }

        //deleting replies
        foreach($comments as $comment) {
            $replies = Reply::where('comment_id', '=', $comment->id);
            $replies->delete();
        }

        //deleting comment notifications
        foreach($comments as $comment){
            $notification = Notification::where('comment_id', '=', $comment->id);
            $notification->delete();
        }

        //deleting posts with comments, replies and notifications
        $articols = Articol::where('author', 'like', $author)->get();
        foreach($articols as $articol) {
            $comments = Comment::where('articol_id', '=', $articol->id);
            $replies = Reply::where('articol_id', '=', $articol->id);
            $notifications = Notification::where('post_id', '=', $articol->id);
            $comments->delete();
            $replies->delete();
            $notifications->delete();
        }
        $articolls = Articol::where('author', 'like', $author);
        $articolls->delete();

        //deleting comments
        $commentts = Comment::where('author', 'like', $author);
        $commentts->delete();

        return self::show_thread($articol_id);
    }

    public function ban_post1(Request $req) {
        $user_id = $req -> banned_user_id;
        $articol_id = $req -> articol_id;
        $select = $req->ban;
        $author = $req->author;

        $user = Utilizator::findOrFail($user_id);
        $articols = Articol::where('author', 'like', $author);
        
        foreach($articols as $articol) {
            $comments = Comment::where('articol_id', '=', $articol->id);
            $replies = Reply::where('articol_id', '=', $articol->id);
            $notifications = Notification::where('post_id', '=', $articol->id);

            $notifications->delete();
            $replies->delete();
            $comments->delete();
        }
        $articols->delete();

        $date = Carbon::now();

        switch($select) {
            case(1):
                $user->ban_until = $date->addMinutes(30);
                $user->save();
                break;
            case(2):
                $user->ban_until = $date->addHour();
                $user->save();
                break;
            case(3):
                $user->ban_until = $date->addHours(2);
                $user->save();
                break;
            case(4):
                $user->ban_until = $date->addDay();
                $user->save();
                break;
            case(5):
                $user->ban_until = $date->addDays(2);
                $user->save();
                break;
            case(6):
                $user->ban_until = $date->addWeek();
                $user->save();
                break;
            case(7):
                $user->ban_until = $date->addMonth();
                $user->save();
                break;
            case(8):
                $user->ban_until = $date->addYear();
                $user->save();
                break;
            case(9):
                $user->ban_until = $date->addYears(10);
                $user->save(); 
                break;
        }

        return self::show_threads();
    }

    public function ban_post2(Request $req) {
        $user_id = $req -> banned_user_id;
        $articol_id = $req -> articol_id;
        $select = $req->ban;
        $author = $req->author;

        $user = Utilizator::findOrFail($user_id);
        $articols = Articol::where('author', 'like', $author)->get();

        foreach($articols as $articol) {
            $comments = Comment::where('articol_id', '=', $articol->id);
            $replies = Reply::where('articol_id', '=', $articol->id);
            $notifications = Notification::where('post_id', '=', $articol->id);

            $notifications->delete();
            $replies->delete();
            $comments->delete();
        }
        $articolls = Articol::where('author', 'like', $author);
        $articolls -> delete();

        $date = Carbon::now();

        switch($select) {
            case(1):
                $user->ban_until = $date->addMinutes(30);
                $user->save();
                break;
            case(2):
                $user->ban_until = $date->addHour();
                $user->save();
                break;
            case(3):
                $user->ban_until = $date->addHours(2);
                $user->save();
                break;
            case(4):
                $user->ban_until = $date->addDay();
                $user->save();
                break;
            case(5):
                $user->ban_until = $date->addDays(2);
                $user->save();
                break;
            case(6):
                $user->ban_until = $date->addWeek();
                $user->save();
                break;
            case(7):
                $user->ban_until = $date->addMonth();
                $user->save();
                break;
            case(8):
                $user->ban_until = $date->addYear();
                $user->save();
                break;
            case(9):
                $user->ban_until = $date->addYears(10);
                $user->save(); 
                break;
        }

        return self::show_threads();
    }

    public function ban_reply(Request $req) {
        $select = $req->repban;
        $user_id = $req->banned_user_id;
        $reply_id = $req->comment_id;
        $articol_id = $req->articol_id;
        $author = $req->comment_author;

        $bannedReplies = Reply::where('author', 'like', $author)->get();
        foreach($bannedReplies as $bannedReply) {
            $secondaryReplies = Reply::where('mainReply_id', '=', $bannedReply->id)->get();
            $soonToDelete = Reply::where('id', '=', $bannedReply->id)->get();

            if($soonToDelete->isNotEmpty()) {
                $asd = Reply::where('id', '=', $bannedReply->id);
                $asd -> delete();
                $notif = Notification::where('reply_id', '=', $bannedReply->id)->get();
                if($notif->isNotEmpty()) {
                    $notif2 = Notification::where('reply_id', '=', $bannedReply->id);
                    $notif2->delete();
                } 
            }
            
            if($secondaryReplies -> isNotEmpty()) {
                $empty = new Reply();

                foreach($secondaryReplies as $secondaryReply) {
                    $condition = true;
                    $empty = self::del($secondaryReply->id);
                    $toBeDeleted = Reply::findOrFail($secondaryReply->id);
                    $toBeDeleted -> delete();
                    $notiff = Notification::where('reply_id', '=', $secondaryReply->id)->get();
                    if($notiff->isNotEmpty()) {
                        $notiff2 = Notification::where('reply_id', '=', $secondaryReply->id);
                        $notiff2->delete();
                    } 

                    while($condition) {
                        if($empty -> isNotEmpty()) {
                            foreach($empty as $item) {
                                $id = $item->id;
                                $gonnaBeDeleted = Reply::findOrFail($id);
                                $gonnaBeDeleted -> delete();
                                $notifff = Notification::where('reply_id', '=', $id)->get();
                                if($notifff->isNotEmpty()) {
                                    $notifff2 = Notification::where('reply_id', '=', $id);
                                    $notifff2->delete();
                                }  
                                $empty = self::del($id);
                            }        
                        }
                        else {
                            $condition = false;
                        }
                    }       
                }
            }
        }
        
        $comments = Comment::where('author', 'like', $author)->get();
        if($comments->isNotEmpty()) {
            foreach($comments as $comment) {
                $reps = Reply::where('comment_id', '=', $comment->id)->get();
                foreach($reps as $rep) {
                    $notifications = Notification::where('reply_id', '=', $rep->id);
                    $notifications->delete();
                }
            }
            foreach($comments as $comment) {
                $reps = Reply::where('comment_id', '=', $comment->id);
                $reps->delete();
            }
            foreach($comments as $comment) {
                $notifications = Notification::where('comment_id', '=', $comment->id);
                $notifications -> delete();
            }
        }
        $commentss = Comment::where('author', 'like', $author);
        $commentss->delete();

        $articols = Articol::where('author', 'like', $author)->get();
        if($articols->isNotEmpty()) {
            foreach($articols as $articol) {
                $notif = Notification::where('post_id', '=', $articol->id);
                $comms = Comment::where('articol_id', '=', $articol->id);
                $replies = Reply::where('articol_id', '=', $articol->id);
                $notif->delete();
                $comms->delete();
                $replies->delete();
            }
        }
        $articolls = Articol::where('author', 'like', $author);
        $articolls->delete();

        $date = Carbon::now();
        $user = Utilizator::findOrFail($user_id);

        switch($select) {
            case(1):
                $user->ban_until = $date->addMinutes(30);
                $user->save();
                break;
            case(2):
                $user->ban_until = $date->addHour();
                $user->save();
                break;
            case(3):
                $user->ban_until = $date->addHours(2);
                $user->save();
                break;
            case(4):
                $user->ban_until = $date->addDay();
                $user->save();
                break;
            case(5):
                $user->ban_until = $date->addDays(2);
                $user->save();
                break;
            case(6):
                $user->ban_until = $date->addWeek();
                $user->save();
                break;
            case(7):
                $user->ban_until = $date->addMonth();
                $user->save();
                break;
            case(8):
                $user->ban_until = $date->addYear();
                $user->save();
                break;
            case(9):
                $user->ban_until = $date->addYears(10);
                $user->save(); 
                break;
        }

        return self::show_thread($articol_id);
    }
}