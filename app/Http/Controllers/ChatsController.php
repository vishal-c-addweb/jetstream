<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use App\Models\Chat;
use App\Models\ChatWords;
use App\Models\ChatUser;
use App\Models\ChatGroup;
use App\Models\ChatGroupUser;
use App\Models\ChatConversation;

use App\Events\MessageSent;
use App\Events\ChatMessage;
use App\Events\GroupMessage;

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
    *
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
    * Diplay last messages.
    *
    * @return Messages.
    */
    public function lastMessage($id){
        return Chat::where('sender_id',$id)->orwhere('receiver_id',$id)->get();
    }
    /**
    * Diplay Group.
    *
    * @return Groups.
    */
    public function chatGroups($id){
        $chatGroup = ChatGroup::with('user')->where('id',$id)->first();
        $chatGroupUser = ChatGroupUser::with('user')->where('group_id',$id)->get();
        $user = User::all();
        return view('user.chatgroup',compact('chatGroup','chatGroupUser','user'));
    }
    /**
    * Store Group name and user id.
    *
    * @$request for requesting data from form.
    * 
    * @return redirect chatuser.
    */
    public function storeChatGroup(Request $request){

        $groupName = $request->groupname;
        $chatGroup = new ChatGroup();
        $chatGroup->name = $groupName;
        $chatGroup->created_by = auth()->user()->id;
        if(ChatGroup::where('name',$groupName)->first())
        {
            session()->flash('message', 'Group Already exists!.');
            return redirect(route('chats'));
        }
        else{
            $chatGroup->save();
        }
        
        $groupId = $chatGroup->id;

        for($i = 0; $i < count($request->userid); $i++)  {
            $chatGroupUser = new ChatGroupUser;
            $chatGroupUser->group_id = $groupId;
            $chatGroupUser->user_id = $request->userid[$i];
            $chatGroupUser->save();
        }
        $chatGroupUser = new ChatGroupUser;
        $chatGroupUser->group_id = $groupId;
        $chatGroupUser->user_id = auth()->user()->id;
        $chatGroupUser->save();
        
        return redirect(route('chats'));
    }
    /**
    * Store new group member.
    *
    * @$request for requesting data from form.
    * 
    * @return redirect chatuser.
    */
    public function storeGroupMember(Request $request){

        $groupId = $request->groupid;

        for($i = 0; $i < count($request->userid); $i++)  {
            $chatGroupUser = new ChatGroupUser;
            $chatGroupUser->group_id = $groupId;
            $chatGroupUser->user_id = $request->userid[$i];
            if(ChatGroupUser::where('group_id',$groupId)->where('user_id',$request->userid[$i])->first()){
                session()->flash('message', 'User Already Added!.');
                return back(); 
            }
            else{
                $chatGroupUser->save();
            }   
        }
        return back();
    }
    /**
    * Diplay group messages.
    *
    * @return Messages.
    */
    public function groupMessages($id){
        return ChatConversation::where('group_id',$id)->with('user')->get();
    } 
    /**
    * Insert group messages in database.
    *
    * @return redirect to chat page.
    */
    public function storeGroupMessages(Request $request,$id){

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

        $message =  ChatConversation::create([
            'message' => $content,
            'file' => $file_name,
            'user_id' => auth()->user()->id,
            'group_id' => $id,
        ]);
        
        broadcast(new GroupMessage($message->load('user')))->toOthers();
        
        return ['message'=>$message];
    }
    /**
    * Diplay last group messages.
    *
    * @return Messages.
    */
    public function lastGroupMessage(){
        return ChatConversation::with('user')->get();
    }
}
