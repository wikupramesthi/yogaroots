<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polls = Poll::orderBy('created_at', 'desc')->get();
        return view('pages.poll.index', compact('polls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'options'  => 'required|array|min:2',
            'options.*' => 'required|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            Poll::create([
                'question' => $request->question,
                'options'  => $request->options,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Polling berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $uuid)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'options'  => 'required|array|min:2',
            'options.*' => 'required|string|max:100',
        ]);

        DB::beginTransaction();
        try {
            $poll = Poll::where('uuid', $uuid)->firstOrFail();
            $poll->update([
                'question' => $request->question,
                'options'  => $request->options,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('poll.list')->with('success', 'Polling berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        DB::beginTransaction();
        try {
            $poll = Poll::where('uuid', $uuid)->firstOrFail();
            $poll->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Polling berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
