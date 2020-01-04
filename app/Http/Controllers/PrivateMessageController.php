<?php

namespace App\Http\Controllers;

use App\User;
use App\PrivateMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PrivateMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function createNewMessage()
    {
        if (Auth::user()->can('communication_private')) {
            // get only users with role communication_private /////////////////////////////////////////////////////////////
            return view('private_message.createMessage', [
                'users' => User::where('id', '!=', Auth::id())->where('branch_id', Auth::user()->branch_id)->get()
            ]);
        } else {
            abort(403);
        }
    }


    public function sendNewMessage(Request $request)
    {
        if (Auth::user()->can('communication_private')) {
            $request->validate([
                'receiver' => 'required',
                'message' => 'required'
            ]);
            $pm = new PrivateMessage;
            $pm->sender_id = Auth::id();
            $pm->receiver_id = $request->receiver;
            $pm->message_body = $request->message;
            if ($request->hasFile('file')) {
                $file = $request->file;
                $file_name = time() . '_' . $file->getClientOriginalName();
                $file->move('uploads/private_message', $file_name);
                $pm->file = 'uploads/private_message/' . $file_name;
            }
            $pm->save();
            return redirect()->back()->with('success', 'Message sent successfully');
        } else {
            abort(403);
        }
    }


    public function sentMessages()
    {
        if (Auth::user()->can('communication_private')) {
            $sentItems = PrivateMessage::where('sender_id', Auth::id())->where('sent_item_delete', 0)->latest()->paginate(10);
            foreach ($sentItems as $s){
                $s['receiver'] = User::find($s->receiver_id)->name;
            }
            return view('private_message.sentMessages', compact('sentItems'));
        } else {
            abort(403);
        }
    }


    public function sentMessageShow($mid)
    {
        if (Auth::user()->can('communication_private')) {
            $message = PrivateMessage::find($mid);
            $sender = User::find($message->receiver_id);
            $sender_id = $message->sender_id;
            $msg = $message->message_body;
            $file = ($message->file) ?? '';
            $created_at = $message->created_at;
            return view('private_message.sentMessageShow', compact('mid', 'sender', 'sender_id', 'msg', 'file', 'created_at'));
        } else {
            abort(403);
        }
    }


    public function deleteSentMessage($mid)
    {
        if (Auth::user()->can('communication_private')) {
            $pm = PrivateMessage::find($mid);
            if ($pm->inbox_item_delete == 1) {
                if ($pm->file) {
                    unlink($pm->file);
                }
                $pm->delete();
            } else {
                $pm->sent_item_delete = 1;
                $pm->save();
            }
            Session::flash('success', "The Message has been Deleted Successfully !");
            return redirect()->route('message.sent');
        } else {
            abort(403);
        }
    }


    public function downloadMessageFile($mid)
    {
        if (Auth::user()->can('communication_private')) {
            $m = PrivateMessage::find($mid);
            $ext = pathinfo($m->file, PATHINFO_EXTENSION);
            $name = 'message_' . md5(time()) . '.' . $ext;
            return response()->download($m->file, $name);
        } else {
            abort(403);
        }
    }


    public function inbox()
    {
        if (Auth::user()->can('communication_private')) {
            $messages = PrivateMessage::where('receiver_id', Auth::id())->where('inbox_item_delete', 0)->latest()->paginate(10);
            foreach ($messages as $value) {
                $value['sender'] = User::find($value->sender_id)->name;
            }
            return view('private_message.inboxMessages', compact('messages'));
        } else {
            abort(403);
        }
    }


    public function messageShow($mid)
    {
        if (Auth::user()->can('communication_private')) {
            $message = PrivateMessage::where('id', $mid)->where('inbox_item_delete', 0)->first();
            if ($message) {
                $message->status = 'seen';
                $message->save();
            }
            $sender = User::find($message->sender_id);
            $sender_id = $message->sender_id;
            $msg = $message->message_body;
            $file = ($message->file) ?? '';
            $created_at = $message->created_at;
            return view('private_message.messageShow', compact('mid', 'sender', 'sender_id', 'msg', 'file', 'created_at'));
        } else {
            abort(403);
        }
    }


    public function messageReply(Request $request)
    {
        if (Auth::user()->can('communication_private')) {
            $request->validate([
                'message' => 'required'
            ]);
            $pm = new PrivateMessage;
            $pm->sender_id = Auth::id();
            $pm->receiver_id = $request->receiver;
            $pm->message_body = $request->message;
            if ($request->hasFile('file')) {
                $file = $request->file;
                $file_name = time() . '_' . $file->getClientOriginalName();
                $file->move('uploads/private_message', $file_name);
                $pm->file = 'uploads/private_message/' . $file_name;
            }
            $pm->save();
            return redirect()->back()->with('success', 'Message sent successfully');
        } else {
            abort(403);
        }
    }


    public function deleteInboxMessage($mid)
    {
        if (Auth::user()->can('communication_private')) {
            $this->deleteMessage($mid);
            return redirect()->back();
        } else {
            abort(403);
        }
    }

    public function deleteInboxShowMessage($mid)
    {
        if (Auth::user()->can('communication_private')) {
            $this->deleteMessage($mid);
            return redirect()->route('message.inbox');
        } else {
            abort(403);
        }
    }

    private function deleteMessage($mid)
    {
        $pm = PrivateMessage::find($mid);
        if ($pm->sent_item_delete == 1) {
            if ($pm->file) {
                unlink($pm->file);
            }
            $pm->delete();
        } else {
            $pm->inbox_item_delete = 1;
            $pm->save();
        }
    }

}