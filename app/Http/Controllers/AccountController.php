<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Utilizator;
use App\Models\Articol;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Notification;
use App\Models\Follow;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function show($id) {
        $user = Utilizator::findOrFail($id);
        $threads = Articol::where('utilizators_id', '=', $id)->paginate(5, ['*'], 'posts');
        $comments = Comment::where('user_id', '=', $id)->paginate(5, ['*'], 'comments');
        $replies = Reply::where('user_id', '=', $id)->paginate(5, ['*'], 'replies');
        $nrPostari = DB::table('articols')->join('utilizators', 'articols.utilizators_id', '=', 'utilizators.id')->select(DB::raw('utilizators.id as uid, count(*) as pnr'))->where('utilizators.id', '=', $id)->groupBy('utilizators.id')->get();
        $nrComments = DB::table('comments')->join('utilizators', 'comments.user_id', '=', 'utilizators.id')->select(DB::raw('utilizators.id as uid1, count(*) as cnr'))->groupBy('utilizators.id')->get();
        $nrReplies = DB::table('replies')->join('utilizators', 'replies.user_id', '=', 'utilizators.id')->select(DB::raw('utilizators.id as uid2, count(*) as rnr'))->groupBy('utilizators.id')->get();
        $nrFollowing = DB::table('follows')->select(DB::raw('count(*) as fnr, subscriber_id as uid3'))->where('subscriber_id', '=', $id)->groupBy('subscriber_id')->get();
        $nrFollowers = DB::table('follows')->select(DB::raw('count(*) as fsnr'))->where('followed_id', '=', $id)->groupBy('followed_id')->get();
        $idd = session('id');
        $notifications = Notification::where('recipient_id', '=', $idd)->orderBy('id', 'desc')->get();
        $notificationsNumber = DB::table('notifications')->select(DB::raw('count(*) as nnr'))->where([['recipient_id', '=', $idd], ['was_seen', '=', 0]])->get();
        $isFollowing = Follow::where([['followed_id', '=', $id], ['subscriber_id', '=', $idd]])->get();
        $contentCreators = DB::table('utilizators')->join('follows', 'follows.followed_id', '=', 'utilizators.id')->select(DB::raw('utilizators.login as login, utilizators.id as id'))->where('follows.subscriber_id', '=', $id)->paginate(5, ['*'], 'contentCreators');

        return view('account', ['id' => $user->id, 'login' => $user->login, 'email' => $user->email, 'photo' => $user->photo, 'role' => $user->role , 'threads' => $threads, 'comments' => $comments, 'replies' => $replies, 
            'nrPostari' => $nrPostari, 'nrComments' => $nrComments, 'nrReplies' => $nrReplies, 'register_date' => $user->created_at, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber, 
            'isFollowing' => $isFollowing, 'contentCreators' => $contentCreators, 'nrFollowing' => $nrFollowing, 'bio' => $user->bio, 'nrFollowers' => $nrFollowers]);
    }

    public function show_update() {       
        if(session()->has('id')) {
            $user = Utilizator::findOrFail(session('id'));
            $idd = session('id');
            $notifications = Notification::where('recipient_id', '=', $idd)->orderBy('id', 'desc')->get();
            $notificationsNumber = DB::table('notifications')->select(DB::raw('count(*) as nnr'))->where([['recipient_id', '=', $idd], ['was_seen', '=', 0]])->get();
            return view('updateUser', ["id" => $user->id, 'login' => $user->login, 'email' => $user->email, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber]);
        }

        return redirect('/');
    }

    public function update(Request $req) {
        if(session()->has('id')) {
            $user = Utilizator::findOrFail(session('id'));

            $login = $req -> login;
            $password = $req -> password;
            $passwordVerification = $req -> passwordVerification;
            $errors = "";
            $idd = session('id');
            $notifications = Notification::where('recipient_id', '=', $idd)->orderBy('id', 'desc')->get();
            $notificationsNumber = DB::table('notifications')->select(DB::raw('count(*) as nnr'))->where([['recipient_id', '=', $idd], ['was_seen', '=', 0]])->get();

            if($login != "") {
                if($password != "") {
                    if($passwordVerification != "") {
                                $passwordLength = Str::length($password);
                                if($passwordLength >= 8) {
                                    $capitalLetters = ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'Z', 'X', 'C', 'V', 'B', 'N', 'M'];
                                    $numbers = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
                                    $characters = ['!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '_', '+', '=', '/'];
                                    $containsCapitalLetters = false;
                                    $containsNumbers = false;
                                    $containsCharacters = false;
                                    
                                    //verify for capital letters
                                    for($i = 0; $i < $passwordLength; $i++) {
                                        if($containsCapitalLetters == false) {
                                            for($j = 0; $j < count($capitalLetters); $j++) {
                                                if($password[$i] == $capitalLetters[$j]) {
                                                    $containsCapitalLetters = true;
                                                    break;
                                                }
                                            }
                                        }
                                        else {
                                            break;
                                        }
                                    }
                                    if($containsCapitalLetters == false) {
                                        $errors = "4";
                                        return view('updateUser', ['errors' => $errors, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber]);
                                    }
                        
                                    //verify for numbers
                                    for($i = 0; $i < $passwordLength; $i++) {
                                        if($containsNumbers == false) {
                                            for($j = 0; $j < count($numbers); $j++) {
                                                if($password[$i] == $numbers[$j]) {
                                                    $containsNumbers = true;
                                                    break;
                                                }
                                            }
                                        }
                                        else {
                                            break;
                                        }
                                    }
                                    if($containsNumbers == false) {
                                        $errors = "5";
                                        return view('updateUser', ['errors' => $errors, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber]);
                                    }
                        
                                    //verify for characters
                                    for($i = 0; $i < $passwordLength; $i++) {
                                        if($containsCharacters == false) {
                                            for($j = 0; $j < count($characters); $j++) {
                                                if($password[$i] == $characters[$j]) {
                                                    $containsCharacters = true;
                                                    break;
                                                }
                                            }
                                        }
                                        else {
                                            break;
                                        }
                                    }
                                    if($containsCharacters == false) {
                                        $errors = "6";
                                        return view('updateUser', ['errors' => $errors, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber]);
                                    }

                                    if($containsCapitalLetters == true && $containsNumbers == true && $containsCharacters == true) {
                                        $loginExists = true;
                                        $users2 = Utilizator::all();
                                        foreach($users2 as $user2) {
                                            if($user2->login == $login) {
                                                if($user2->id == $user->id) {
                                                    $loginExists = false;
                                                    break;
                                                }
                                                else {
                                                    $loginExists = true;
                                                    break;
                                                }
                                            }
                                            else {
                                                $loginExists = false;
                                            }                                         
                                        }
                                        if($loginExists == false) {                                           
                                                if($password == $passwordVerification) {
                                                        $user->login = $login;
                                                        $user->password = $password;
                                                        $user->role = session('role');

                                                        $user->save();
                                                        session()->pull('login');
                                                        $req->session()->put('login', $login);

                                                        $posts = Articol::where('utilizators_id', '=', session('id'))->get();
                                                        foreach($posts as $post) {
                                                            $post->author = $login;
                                                            $post->save();
                                                        }

                                                        return redirect('/account/' . session('id'));
                                                }
                                                else {
                                                    $errors = "7";
                                                    return view('updateUser', ['errors' => $errors, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber]);
                                                }
                                        }
                                        else {
                                           $errors = "8";
                                            return view('updateUser', ['errors' => $errors, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber]);
                                        }
                                    }
                                }
                                else {
                                    $errors = "3";
                                    return view('updateUser', ['errors' => $errors, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber]);
                                }     
                    }
                    else {
                        $errors = "12";
                        return view('updateUser', ['errors' => $errors, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber]);
                    }   
                }
                else {
                    $errors = "11";
                    return view('updateUser', ['errors' => $errors, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber]);
                }  
            }  
            else {
                $errors = "10";
                return view('updateUser', ['errors' => $errors, 'notifications' => $notifications, 'notificationsNumber' => $notificationsNumber]);
            }   
        }  
        else {
            redirect('/');
        }

    }

    public function make_admin(Request $req) {
        $user_id = $req->id;
        $user = Utilizator::findOrFail($user_id);

        $user->role = 'admin';
        $user->save();
                                                        
        return redirect('/account/' . $user_id);
    }

    public function follow(Request $req) {
        $followed_id = $req->followed_id;
        $subscriber_id = $req->subscriber_id;

        $follow = new Follow();
        $follow->followed_id = $followed_id;
        $follow->subscriber_id = $subscriber_id;
        $follow->save();

        return redirect('/account/' . $followed_id);
    }

    public function unfollow(Request $req) {
        $followed_id = $req->followed_id;
        $subscriber_id = $req->subscriber_id;

        $follow = Follow::where([['followed_id', '=', $followed_id], ['subscriber_id', '=', $subscriber_id]]);
        $follow->delete();

        return redirect('/account/' . $followed_id);
    }

    public function add_bio(Request $req) {
        $id = $req->user_id;
        $bio = $req->bio;
        $user = Utilizator::findOrFail($id);
        $user->bio = $bio;
        $user->save();

        return redirect('/account/' . $id);
    }

    public function change_photo(Request $req) {
        $id = $req->user_id;
        $user = Utilizator::findOrFail($id);

            if($req->hasFile('image')) {
                $image = $req->file('image');
                $img_ext = $image->getClientOriginalExtension();
                if($img_ext == 'jpeg' || $img_ext == 'jpg') {
                    unlink(public_path('images/' . $user->photo));
                    $img_name = uniqid() . '.' . $img_ext;
                    $img_folder = public_path('images/');
                    $image->move($img_folder, $img_name);

                    $user->photo = $img_name;
                    $user->save();

                    $notifications = Notification::where('user_id', '=', $id)->get();
                    foreach($notifications as $notification) {
                        $notification->image = $img_name;
                        $notification->save();
                    }

                    session()->pull('photo');
                    $req->session()->put('photo', $img_name);
                }
                else {
                    return redirect('/account/' . $id);
                }
            }
            else {
                return redirect('/account/' . $id);
            }
        
        return redirect('/account/' . $id);
    }
}