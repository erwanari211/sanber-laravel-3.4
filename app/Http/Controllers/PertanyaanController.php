<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = Thread::with('user')->withCount('replies')->latest()->paginate(10);
        return view('pertanyaan.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pertanyaan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $thread = new Thread;
        $thread->user_id = auth()->user()->id;
        $thread->title = request('title');
        $thread->content = request('content');
        $thread->save();

        session()->flash('successMessage', 'Pertanyaan telah tersimpan');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($threadId)
    {
        $thread = Thread::with('user', 'replies')->withCount('replies')->findOrFail($threadId);
        return view('pertanyaan.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit($threadId)
    {
        $thread = Thread::with('user', 'replies')->findOrFail($threadId);
        if ($thread->user_id !== auth()->user()->id) {
            return abort(403);
        }
        return view('pertanyaan.edit', compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $threadId)
    {
        $thread = Thread::with('user', 'replies')->findOrFail($threadId);
        if ($thread->user_id !== auth()->user()->id) {
            return abort(403);
        }

        request()->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $thread->title = request('title');
        $thread->content = request('content');
        $thread->save();

        session()->flash('successMessage', 'Pertanyaan telah diperbarui');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($threadId)
    {
        $thread = Thread::with('user', 'replies')->findOrFail($threadId);
        if ($thread->user_id !== auth()->user()->id) {
            return abort(403);
        }

        $thread->replies()->delete();
        $thread->delete();

        session()->flash('successMessage', 'Pertanyaan telah dihapus');
        return redirect()->back();
    }
}
