<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Welcome', [
            'tweets' => Tweet::with([
                'user' => function ($query) {
                    $query->select('id', 'name', 'avatar');
                }
            ])->orderBy('created_at', 'desc')->get(),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
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
            'tweet' => 'required',
        ]);

        $tweet = new Tweet();
        if (!is_null($request->file('file'))) {
            $tweet = (new FileService)->addFile($tweet, $request);
        }
        $tweet->tweet = $request->tweet;
        $tweet->user_id = Auth::user()->id;

        $tweet->comments = rand(0, 500);
        $tweet->retweets = rand(0, 500);
        $tweet->likes = rand(0, 500);
        $tweet->analytics = rand(0, 500);

        $tweet->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tweet $tweet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tweetId)
    {
        $tweet = Tweet::find($tweetId);

        if (!$tweet) {
            return redirect('/');
        }

        if (!empty($tweet->file) && Storage::disk('public')->exists(str_replace('/storage/', '', $tweet->file))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $tweet->file));
        }

        $tweet->delete();

        return redirect('/');
    }
}
