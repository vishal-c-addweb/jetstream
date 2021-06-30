<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;
use App\Models\Chat;
use App\Events\ChatMessage;

class ChatsController extends Controller
{
    /**
    * Diplay chat of user.
    *
    * @return redirect to chat page.
    */
    public function index(){
        $user = auth()->user();
        return view('user.chat',['user'=>$user]);
    }
    /**
    * Diplay messages of user.
    *
    * @return Messages.
    */
    public function fetchMessages(){

        return Message::with('user')->get();
    }
    /**
    * Insert messages in database.
    *hy
    * @return redirect to chat page.
    */
    public function sendMessage(Request $request){

        $message = auth()->user()->messages()->create([
            'message' => $request->message
        ]);
        
        broadcast(new MessageSent($message->load('user')))->toOthers();
        
        return ['status'=>'success'];
    }
    /**
    * Diplay messages of user.
    *
    * @return Messages.
    */
    public function fetchMessage($id){
        $user_id = auth()->user()->id; //3 //1
        return Chat::where('receiver_id',$id)->orwhere('receiver_id',$user_id)->where('sender_id',$user_id)->orwhere('sender_id',$id)->orderBy('created_at','Asc')->with('user')->get();
    }
    /**
    * Insert messages in database.
    *hy
    * @return redirect to chat page.
    */
    public function store(Request $request,$id){

        $message = Chat::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $id,
            'message' => $request->message,
            'file' => '',
            'time' => Carbon::today(),
            'status' => 0 ,
        ]);
        
        broadcast(new ChatMessage($message->load('user')))->toOthers();
        
        return ['status'=>'success'];
    }
}
