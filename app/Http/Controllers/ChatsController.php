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

use Illuminate\Support\Facades\Crypt;

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
        if($request->file()){
            
            $request->validate([
                'file' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf,pptx,video,zip,mp3,mp4|max:2048',
            ]);

            $content = '';
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $generated_new_name = time() . '.' . $file->getClientOriginalExtension();
            $request->file->move('assets/uploads', $file_name);
         
        }
        elseif($request->file == '' && $request->message != ''){
            $content = Crypt::encryptString($request->message);
            $file_name = '';    
        }
        $message = Chat::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $id,
            'message' => $content,
            'file' => $file_name,
            'time' => Carbon::today(),
            'status' => 0 ,
        ]);
        
        broadcast(new ChatMessage($message))->toOthers();
        
        return ['status'=>'success','chatdata'=>$message];
    }
    /**
    * Diplay messages of sender_id.
    *
    * @return Messages.
    */
    public function lastMessage($id){
        return Chat::where('sender_id',$id)->orwhere('receiver_id',$id)->get();
    }
}
