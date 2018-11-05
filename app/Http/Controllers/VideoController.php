<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


use App\Video;
use App\User;
use App\Comment;

class VideoController extends Controller
{

    public function index(Request $request)
    {
        $videos = Video::search($request->search)->paginate(12);

        return view('videos.video-home', compact('videos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('videos.videoCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $this->validate($request,[
            'title' => 'required',
            'description' => 'required',
            'video' => 'required | mimetypes:video/avi,video/mp4,video/mpeg','file|max:30000',
            'image' => 'required | mimes:jpeg'
        ]);

        $video = new Video();
        $video->user_id = Auth::user()->id;
        $video->title = $request->title;
        $video->description = $request->description;
        
        $image_path = time().$request->file('image')->getClientOriginalName();
        
        Storage::disk('images')->put($image_path, File::get($request->file('image')));
        
        $video->image_path = $image_path;

        $video_path = time().$request->file('video')->getClientOriginalName();
        Storage::disk('videos')->put($video_path, File::get($request->file('video')));

        $video->video_path = $video_path;

        $video->save();

        return redirect()->route('home')->with('message', "El video ha sido Subido al Servidor");

    }

    function getImage($image){
        $image = Storage::disk('images')->get($image);
        return $image;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function playVideo($video_id)
    {
        $video = Video::findOrFail($video_id);
        $moreVideos = Video::paginate(15)->whereNotIn('id', $video_id);
        $comments = Comment::where('video_id', $video->id)->get();

        return view('videos.video-play', compact('video', 'comments', 'moreVideos'));
    }

    public function getVideo($video_path)
    {
        $video = Storage::disk('videos')->get($video_path);

        return $video;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($video_id)
    {
        $video = Video::findOrFail($video_id);

        return view('videos.video-edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $video_id)
    {
        $validatedData = $this->validate($request,[
            'title' => 'required',
            'description' => 'required',
            'video' => 'mimetypes:video/avi,video/mp4,video/mpeg','file|max:30000',
            'image' => 'mimes:jpeg'
        ]);

        $video = Video::findOrFail($video_id);
        $video->title = $request->title;
        $video->description = $request->description;

        if ($request->file('image')) {
            
            Storage::disk('images')->delete($video->image_path);
            $image_path = time().$request->file('image')->getClientOriginalName();

            Storage::disk('images')->put($image_path, File::get($request->file('image')));

            $video->image_path = $image_path;
        }

        if ($request->file('video')) {
            Storage::disk('videos')->delete($video->path);

            $video_path = time().$request->file('video')->getClientOriginalName();

            Storage::disk('videos')->put($video_path, File::get('video'));

            $video->video_path = $video_path;

        }

        $video->update();

        return redirect()->route('home')->with('message', "Video Editado Correctamente");

    }

    public function createComment(Request $request)
    {
        $comment = new Comment();

        $comment->user_id = Auth::user()->id;
        $comment->video_id = $request->video_id;
        $comment->body = $request->body;

        $comment->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($video_id)
    {
        // dd($video_id);
        $video = Video::findOrFail($video_id);

        Storage::disk('videos')->delete($video->video_path);
        Storage::disk('images')->delete($video->image_path);

        $comments = $video->comments()->get();

        foreach ($comments as $comment) {
            $comment->delete();
        }

        $video->delete();

        return redirect()->back()->with('message', "El video ha sido Eliminado");
    }
}
