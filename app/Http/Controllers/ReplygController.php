<?php

namespace App\Http\Controllers;

use App\Commentg;
use App\Replyg;
use App\Tagcg;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReplygController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create($cid)
    {
        if (Auth::user()->can('communication_global')){
            $c = Commentg::find($cid);
            $u = User::find($c->user_id);
            $c['user_name'] = $u->name;
            $c['user_image'] = $u->image;
            $users = null;
            $tags = Tagcg::where('comment_id', $cid)->get();
            if (count($tags) > 0){
                foreach ($tags as $t){
                    $users[] = User::find($t->user_id);
                }
            }
            $replies = Replyg::where('commentg_id', $cid)->get();
            if (count($replies) > 0){
                foreach ($replies as $r){
                    $u = User::find($r->user_id);
                    $r['user_name'] = $u->name;
                    $r['user_image'] = $u->image;
                }
            }
            return view('comment_global.reply', compact('c', 'tags', 'users', 'replies'));
        } else {
            abort(403);
        }
    }


    public function store(Request $request, $cid)
    {
        if (Auth::user()->can('communication_global')){
            $this->validate($request, [
                'reply' => 'required',
            ]);
            $r = new Replyg;
            $r->user_id = Auth::id();
            $r->branch_id = Auth::user()->branch_id;
            $r->commentg_id = $cid;
            $r->replyg = $request->reply;
            if ($request->hasFile('file')) {
                $f = $request->file;
                $f_name = time() . $f->getClientOriginalName();
                $a = $f->move('uploads/replies', $f_name);
                $d = 'uploads/replies/' . $f_name;
                $r->file = $d;
            }
            $r->save();
            Session::flash('ReplygCreateSuccess', "The Reply has been posted successfully.");
            return redirect()->route('commentg');
        } else {
            abort(403);
        }
    }


    public function downloadReplyFile($rid)
    {
        if (Auth::user()->can('communication_global')){
            $r = Replyg::find($rid);
            $ext = pathinfo($r->file, PATHINFO_EXTENSION);
            $name = 'reply_file.'.$ext;
            return response()->download($r->file, $name);
        } else {
            abort(403);
        }
    }


    public function edit($rid)
    {
        if (Auth::user()->can('communication_global')){
            $reply = Replyg::find($rid);
            return view('comment_global.editReply', compact('reply'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $rid)
    {
        if (Auth::user()->can('communication_global')){
            $this->validate($request, [
                'reply' => 'required',
            ]);
            $r = Replyg::find($rid);
            $r->replyg = $request->reply;
            if ($request->hasFile('file')) {
                if ($r->file){
                    unlink($r->file);
                }
                $f = $request->file;
                $f_name = time() . $f->getClientOriginalName();
                $a = $f->move('uploads/replies', $f_name);
                $d = 'uploads/replies/' . $f_name;
                $r->file = $d;
            }
            $r->update();
            Session::flash('ReplygUpdateSuccess', "The Reply has been posted successfully.");
            return redirect()->route('commentg');
        } else {
            abort(403);
        }
    }


    public function destroy($rid)
    {
        if (Auth::user()->can('communication_global')){
            $r = Replyg::find($rid);
            if ($r->file != null){
                unlink($r->file);
            }
            $r->delete();
            Session::flash('ReplygDeleteSuccess', "The Reply has been deleted successfully.");
            return redirect()->route('commentg');
        } else {
            abort(403);
        }
    }
}
