@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Mis Videos</strong></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach($videos as $video)
                    <div class="image-videos-container">
                        <div class="image-container">
                            <img src="{{route('get.image', $video->image_path)}}" width="246" height="138"alt="video">
                        </div>
                        <div class="video-options">
                            <strong class="video-play-title">{{$video->title}}</strong>
                            <p class="text-video">{{$video->user()->get()->all()[0]->username}}</p>
                            <p>{{$video->created_at->diffForHumans()}}</p>
                            <p>{{str_limit($video->description, 120, '...')}}</p>

                            <a href="{{route('play.video',$video->id)}}" class="btn btn-play">Ver</a>
                            <a href="{{route('edit.video', $video->id)}}" class="btn btn-slate">Editar</a>
                            @include('partials.delete-video', [$video->id])
                        </div>
                    </div>
                    @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
