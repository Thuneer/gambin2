<?php

namespace App\Http\Controllers;

use App\Message;
use App\Thread;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kalnoy\Nestedset\Collection;

class MessageController extends Controller
{


    public function index() {

        $threads = Thread::where('user_id_1', '=', Auth::id())->orWhere('user_id_2', '=', Auth::id())->with('messages', 'user1.images', 'user2.images')->get();

        $users = new Collection();

        $e = User::role('editor')->get();
        $a = User::role('administrator')->get();
        $sa = User::role('super admin')->get();
        $o = User::role('owner')->get();

        $users = $users->merge($e);
        $users = $users->merge($a);
        $users = $users->merge($sa);
        $users = $users->merge($o);

        return view('admin.messages.index', compact('threads','users'));

    }

    public function conversation($id)
    {

        $thread = Thread::where('id', '=', $id)->with('messages.user', 'user1.images', 'user2.images')->first();

        if (!$thread) {

        }

        return view('admin.messages.conversation', compact('thread'));
    }

    public function newConversation(Request $request) {

        $user_id = $request->input('user');

        if (User::find($user_id)) {

            if (Thread::where('user_id_1', '=', Auth::id())->where('user_id_2', '=', $user_id)->first() || Thread::where('user_id_2', '=', Auth::id())->where('user_id_1', '=', $user_id)->first()) {

                return redirectWithStatus('error','Something went wrong, please try again.',
                    '/admin/conversations', $request);
            } else {
                $thread = new Thread();
                $thread->user_id_1 = Auth::user()->id;
                $thread->user_id_2 = $user_id;
                $thread->save();

                return redirectWithStatus('success','New conversations created successfully.',
                    '/admin/conversations', $request);
            }

        } else {

            return redirectWithStatus('error','Something went wrong, please try again.',
                '/admin/conversations', $request);

        }

    }

    public function newMessage(Request $request, $id) {

        $thread = Thread::find($id);

        if (!$thread) {
            return redirectWithStatus('error','Something went wrong, please try again.',
                '/admin/conversations', $request);
        }

        $message_text = $request->input('message');

        $message = new Message();
        $message->text = $message_text;
        $message->user_id = Auth::user()->id;
        $message->thread_id = $thread->id;
        $message->save();

        return redirectWithStatus('success','Message added successfully.','/admin/conversations/' . $id, $request);

    }
}
