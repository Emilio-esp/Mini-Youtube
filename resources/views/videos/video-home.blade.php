@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Videos Recientes</strong></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                <div class="videos-container">
                    @foreach($videos as $video)
                        <a href="{{route('play.video',$video->id)}}" class="video-container">
                            <input id="video_id" name="video_id" type="text" value="{{$video->id}}" hidden>
                            <img src="{{route('get.image', $video->image_path)}}" width="210" height="118"alt="video">
                            <strong class="video-title">{{$video->title}}</strong>
                            <p class="text-video">{{$video->user()->get()->all()[0]->username}}</p>
                            <p>{{$video->created_at->diffForHumans()}}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
