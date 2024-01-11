<?php

namespace App\Http\Controllers;

use App\Jobs\SendPasswordResetEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class MailController extends Controller
{

    public function basic_email() {
        // die("okk");
        $data = array('name'=>"Gagan Saini");
        try{
            Mail::send('mail/mail', $data, function($message) {
               $message->to('gagan.saini@yopmail.com', 'Tutorials Point')->subject
                  ('Laravel Basic Testing Mail');
               $message->from('xyz@gmail.com','Gagan Saini');
            });

            echo "Leads details sent to contractor.";
        }catch(Exception $e){
            echo $e->getMessage();
            die("here");
        }
     }

     public function leads_email() {
        $data = array('name'=>"Gagan Saini");
        try{
            Mail::send('mail/mail', $data, function($message) {
               $message->to('gagan.saini@yopmail.com', 'Tutorials Point')->subject
                  ('Laravel Basic Testing Mail');
               $message->from('xyz@gmail.com','Gagan Saini');
            });

            echo "Basic Email Sent. Check your inbox.";
        }catch(Exception $e){
            echo $e->getMessage();
            die("here");
        }
     } 

    public function emailConfirmationMail($email_confirmation_code){
        $user = User::where('email_confirmation_code', $email_confirmation_code)->firstOrFail();
        $user->email_confirmation_code = null;
        $user->email_confirmed = 1;
        $user->status = 1;
        $user->save();

        return redirect()->route('index')->with(['message' => 'E-Mail confirmed succesfully.', 'type' => 'success']);
    }


    public function sendPasswordResetMail(Request $request){
        $user = User::where('email', $request->email)->first();
        if ($user != null){
            $user->password_reset_code = Str::random(67);
            $user->save();
            dispatch(new SendPasswordResetEmail($user));
            return back()->with(['message' => 'Password reset mail sent succesfully','type' => 'success' ]);
        }else{
            return back()->with(['message' => 'Password reset mail sent succesfully','type' => 'success' ]);
        }
    }

    public function passwordResetCallback($password_reset_code){
        $user = User::where('password_reset_code', $password_reset_code)->firstOrFail();

        return view('panel.authentication.password_reset_final', compact('user'));
    }

    public function passwordResetCallbackSave(Request $request){

        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        $user = User::where('password_reset_code', $request->password_reset_code)->firstOrFail();

        $new = $request->password;
        $newC = $request->password_confirmation;

        if ($new == $newC){
            $user->password = Hash::make($new);
            $user->save();
            Auth::login($user);
            return  response()->json([], 200);
        }else{
            return  response()->json([], 449);
        }

    }

}
