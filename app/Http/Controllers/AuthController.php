<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilizator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;


class AuthController extends Controller
{
    //sign up 
    public function store(Request $req) {
        $users = Utilizator::all(); 
        $newUser = new Utilizator();

        $login = $req -> login;
        $password = $req -> password;
        $passwordVerification = $req -> passwordVerification;
        $email = $req -> email;
        $encryptedPassword = "";

        $errors = "";

        if($login != "") {
            if($password != "") {
                if($passwordVerification != "") {
                    if($email != "") {
                        if($req -> hasFile('image')) {
                            $image = $req -> file('image');
                            $imageExtension = $image -> getClientOriginalExtension();
                            if($imageExtension == 'jpeg' || $imageExtension == 'jpg') {
                                $imageName = uniqid() . "." . $imageExtension;
                                $imageFolder = public_path('images/');
                                
                                //verifying password
                                //verify password for length
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
                                        return view('signup', ['errors' => $errors]);
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
                                        return view('signup', ['errors' => $errors]);
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
                                        return view('signup', ['errors' => $errors]);
                                    }
                
                                    if($containsCapitalLetters == true && $containsNumbers == true && $containsCharacters == true) {
                                        //verify validation
                                        if($passwordVerification == $password) {
                                            //verifying login
                                            $loginExists = false;
                                            foreach($users as $user) {
                                                if($user -> login == $login) {
                                                    $loginExists = true;
                                                    break;
                                                }
                                            }
                                            if($loginExists == true) {
                                                $errors = "8";
                                                return view('signup', ['errors' => $errors]);
                                            }
                
                                            //verifying email
                                            $emailExists = false;
                                            foreach($users as $user) {
                                                if($user -> email == $email) {
                                                    $emailExists = true;
                                                    break;
                                                }
                                            }
                                            if($emailExists == true) {
                                                $errors = "9";
                                                return view('signup', ['errors' => $errors]);
                                            }
                
                                            if($emailExists == false && $emailExists == false) {
                                                //encryption
                                                //$encryptedPassword = Crypt::encrypt($password);
                
                                                //adding data to db
                                                $image -> move($imageFolder, $imageName);
                                                $newUser -> login = $login;
                                                $newUser -> password = $password;
                                                $newUser -> email = $email;
                                                $newUser -> photo = $imageName;
                                                $newUser -> role = 'user';
                                                $newUser -> save();
                                            }
                                            
                                        }
                                        else {
                                            $errors = "7";
                                            return view('signup', ['errors' => $errors]);
                                        }
                                    }                   
                                }
                                else {
                                    $errors = "3";
                                    return view('signup', ['errors' => $errors]);
                                }
                            }
                            else {
                                $errors = "2";
                                return view('signup', ['errors' => $errors]);
                            }
                        }
                        else {
                            $errors = "1";
                            return view('signup', ['errors' => $errors]);
                        }
                    }
                    else {
                        $errors = "13";
                        return view('signup', ['errors' => $errors]);
                    }
                }
                else {
                    $errors = "12";
                    return view('signup', ['errors' => $errors]);
                }
            }
            else {
                $errors = "11";
                return view('signup', ['errors' => $errors]);
            }
        }
        else {
            $errors = "10";
            return view('signup', ['errors' => $errors]);
        }

        return redirect('/login');
    }

    //login in
    public function login(Request $req) {
        $users = Utilizator::all(); 

        $isLogged = false;
        $errors = "";
        $login = $req -> login;
        $password = $req -> password;
        $id = 0;

        foreach($users as $user) {
            $storedLogin = $user -> login;
            $storedPassword = $user -> password;
            if($login == $storedLogin && $password == $storedPassword) {
                $id = $user -> id;
                $status = $user -> role;
                $photo = $user -> photo;
                $ban_until = $user->ban_until;
                $isLogged = true;
                $req->session()->put('id', $id);
                $req->session()->put('login', $user->login);
                $req->session()->put('email', $user->email);
                $req->session()->put('role', $status);
                $req->session()->put('photo', $photo);
                $req->session()->put('ban_until', $ban_until);
                break;
            }      
        }

        if($isLogged == false) {
            $errors = "1";
            return view('login', ['errors' => $errors]);
        }

        return redirect('/');
    }    
}