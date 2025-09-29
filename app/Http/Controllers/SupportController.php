<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SupportController extends Controller
{
    public function sendMessages(Request $request)
    {
        $replyMessage = Validator::make($request->all(),[
            'message'      => 'required|string',
            'attachment'   => 'nullable|file|max:4096',
        ]);

        if($replyMessage->fails())
        {
            Toastr::error($replyMessage->getMessageBag());
            return redirect()->back();
        }

        Conversation::create([
            'body'=>$request->message,
            'user_id'=>auth()->user()->id,
            'candidate_id'=>$request->candidate_id

        ]);

        Toastr::success('Reply sent successfully');
        return redirect()->back();

    }

    public function viewList()
    {
        $conversations = $this->getAllConverstaions();

        $singleConversation=[];
        return view('support.messageList', compact('conversations','singleConversation'));
    }

    public function viewMessages($candidate_id)
    {
        $singleConversation = Conversation::where('candidate_id', $candidate_id)
            ->with('candidate:id,first_name,last_name,photo')
            ->orderBy('id', 'asc')
            ->get();

        foreach($singleConversation as $conversation){
            if(!$conversation->is_seen){
                Conversation::where('candidate_id', $candidate_id)->update(['is_seen' => true]);
                break;
            }
        }

        $conversations = $this->getAllConverstaions();
        return view('support.messageList', compact('conversations','singleConversation'));
    }


    public function getAllConverstaions()
    {
        $sub = Conversation::query()
        ->select('conversations.id', 'conversations.candidate_id', 'conversations.body', 'conversations.created_at', 'conversations.is_seen')
        ->selectRaw('ROW_NUMBER() OVER (PARTITION BY conversations.candidate_id ORDER BY conversations.created_at DESC, conversations.id DESC) as rn');


        $rows = DB::table('candidates as cand')
            ->joinSub($sub, 'lc', function ($join) {
                $join->on('cand.id', '=', 'lc.candidate_id');
            })
            ->where('lc.rn', 1) // only latest per candidate
            ->select(
                'cand.id as candidate_id',
                'cand.first_name',
                'cand.last_name',
                'cand.photo',
                'lc.is_seen',
                'lc.body as last_message_body',
                'lc.created_at as last_message_created_at'
            )
            ->get();

        return $rows;
    }

}
