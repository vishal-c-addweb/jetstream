<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use App\Models\Chat;
use App\Models\ChatWords;

use App\Events\MessageSent;
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
        return Chat::where(function ($q) use ($id) {
            $q->whereIn('sender_id', [ $id, auth()->id() ])->whereIn('receiver_id', [ $id, auth()->id() ]);
        })->get();
    }
    /**
    * Insert messages in database.
    *hy
    * @return redirect to chat page.
    */
    public function store(Request $request,$id){

        $senderId = auth()->user()->id;
        $receiverId = $id;
        $chatWord = ChatWords::where('word',$request->message)->where('sender_id',$senderId)->where('receiver_id',$receiverId)->first();
        if($chatWord){
            $chatWord->count+=1;
            $chatWord->save();
        }
        elseif(ChatWords::where('word',$request->message)->first())
        {
            $chatWord = new ChatWords();
            $chatWord->sender_id = $senderId;
            $chatWord->receiver_id = $receiverId;
            $chatWord->word = $request->message;
            $chatWord->count = 1;
            $chatWord->save();
        }
        if($request->file == ''){
            $content = $request->message;
            $file = '';
        }
        elseif($request->message == ''){
            $content = '';
            $file = $request->file;
        }
        $message = Chat::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $id,
            'message' => $content,
            'file' => $file,
            'time' => Carbon::today(),
            'status' => 0 ,
        ]);
        
        broadcast(new ChatMessage($message))->toOthers();
        
        return ['status'=>'success','chatdata'=>$message];
    }
}
