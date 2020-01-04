<?php

namespace App\Http\Controllers;

use App\Commentg;
use App\Replyg;
use App\Tagcg;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CommentgController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        if (Auth::user()->can('communication_global')){
            $bid = Auth::user()->branch_id;
            $comments = Commentg::where('branch_id', $bid)->orderBy('updated_at', 'DESC')->paginate(3);
            if (count($comments) > 0){
                foreach ($comments as $c){
                    $u = User::find($c->user_id);
                    $c['user_name'] = $u->name;
                    $c['user_image'] = $u->image;
                }
            }
            $tags = Tagcg::where('branch_id', $bid)->get();
            $users = [];
            $us = User::where('branch_id', $bid)->where('id', '!=', Auth::id())->get();
            foreach ($us as $uu){
                if ($uu->can('communication_global')){
                    $users[] = $uu;
                }
            }
            $replies = Replyg::all();
            if (count($replies) > 0){
                foreach ($replies as $r){
                    $u = User::find($r->user_id);
                    $r['user_name'] = $u->name;
                    $r['user_image'] = $u->image;
                }
            }
            // get all taged Comment
            $tcomments = null;
            $tcs = Tagcg::where('user_id', Auth::id())->where('seen', 0)->get();
            if (count($tcs) > 0){
                foreach ($tcs as $t){
                    $tcomments[] = Commentg::find($t->comment_id);
                }
            }
            return view('comment_global.index', compact('users', 'comments', 'tags', 'replies', 'tcomments'));
        } else {
            abort(403);
        }
    }


    public function store(Request $request)
    {
        if (Auth::user()->can('communication_global')){
            $this->validate($request, [
                'comment' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $bid = Auth::user()->branch_id;
                $c = new Commentg;
                $c->user_id = Auth::id();
                $c->branch_id = $bid;
                $c->commentg = $request->comment;
                if ($request->hasFile('file')) {
                    $f = $request->file;
                    $f_name = time() . $f->getClientOriginalName();
                    $a = $f->move('uploads/comments', $f_name);
                    $d = 'uploads/comments/' . $f_name;
                    $c->file = $d;
                }
                $c->save();
                if ($request->filled('tags')){
                    foreach ($request->tags as $id){
                        $t = new Tagcg;
                        $t->comment_id = $c->id;
                        $t->branch_id = $bid;
                        $t->user_id = $id;
                        $t->save();
                        $user = User::find($id);
                        $user->tag = $user->tag + 1 ;
                        $user->update();
                    }
                }
                DB::commit();
                $success = true;
            } catch (\Exception $e) {
                $success = false;
                DB::rollback();
            }
            if ($success) {
                Session::flash('CommentgCreateSuccess', "The Comment has been posted successfully.");
                return redirect()->back();
            } else {
                Session::flash('unsuccess', "Something went wrong :(");
                return redirect()->back();
            }
        } else {
            abort(403);
        }
    }


    public function downloadCommentFile($cid){
        if (Auth::user()->can('communication_global')){
            $c = Commentg::find($cid);
            $ext = pathinfo($c->file, PATHINFO_EXTENSION);
            $name = 'comment_file.'.$ext;
            return response()->download($c->file, $name);
        } else {
            abort(403);
        }
    }


    public function show($cid)
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
            // change seen
            $tag = Tagcg::where('comment_id', $cid)->where('user_id', Auth::id())->first();
            if ((($tag->seen)*1) == 0){
                // not seen
                $tag->seen = 1;
                $tag->update();
                // change tag in userTable
                $ru = Auth::user();
                if ((($ru->tag)*1) > 0){
                    $ru->tag = $ru->tag - 1;
                    $ru->update();
                }
            }
            return view('comment_global.reply', compact('c', 'tags', 'users', 'replies'));
        } else {
            abort(403);
        }
    }


    public function edit($cid)
    {
        if (Auth::user()->can('communication_global')){
            $c = Commentg::find($cid);
            return view('comment_global.edit', compact('c'));
        } else {
            abort(403);
        }
    }


    public function update(Request $request, $cid)
    {
        if (Auth::user()->can('communication_global')){
            $this->validate($request, [
                'comment' => 'required',
            ]);
            $c = Commentg::find($cid);
            $c->commentg = $request->comment;
            if ($request->hasFile('file')) {
                if ($c->file){
                    unlink($c->file);
                }
                $f = $request->file;
                $f_name = time() . $f->getClientOriginalName();
                $a = $f->move('uploads/comments', $f_name);
                $d = 'uploads/comments/' . $f_name;
                $c->file = $d;
            }
            $c->update();
            Session::flash('CommentgUpdateSuccess', "The Comment has been updated successfully.");
            return redirect()->route('commentg');
        } else {
            abort(403);
        }
    }


    public function destroy($cid)
    {
        if (Auth::user()->can('communication_global')){
            $c = Commentg::find($cid);
            $replies = Replyg::where('commentg_id', $cid)->get();
            foreach ($replies as $r){
                if ($r->file != null){
                    unlink($r->file);
                }
                $r->delete();
            }
            if ($c->file != null){
                unlink($c->file);
            }
            $tagcgs = Tagcg::where('comment_id', $cid)->get();
            if (count($tagcgs) > 0) {
                foreach ($tagcgs as $tg) {
                    if ((($tg->seen)*1) == 0){
                        $u = User::find($tg->user_id);
                        if ((($u->tag)*1) > 0) {
                            $u->tag = $u->tag - 1;
                        }
                        $u->update();
                        $tg->delete();
                    }
                }
            }
            $c->delete();
            Session::flash('CommentgDeleteSuccess', "The Comment has been deleted successfully.");
            return redirect()->route('commentg');
        } else {
            abort(403);
        }
    }
}
