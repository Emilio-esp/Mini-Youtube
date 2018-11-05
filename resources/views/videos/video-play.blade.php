@extends('layouts.app')

@section('content')

<div class="col-xs-12">
    <div class="panel panel-default">
        <div class="panel-body container-all">
            <div class="container-video-and-comments">
                <div class="video-play-container">
                    <div class="video-box-container">
                        <video id="video-player" controls class="video-box" autoplay>
                            <source src="{{route('get.video', $video->video_path)}}">
                            
                        </video>
                        <div class="div-control-reproduccion">
                            
                        </div>
                        <div class="controls-video">
                            <button 
                                id="btn-play"
                                class="btn-control"
                                onclick="document.getElementById('video-player').play()"
                            >
                                <span class="icon-control fa fa-play"></span>
                            </button>
                            <button 
                                id="btn-pause"
                                class="btn-control"
                                onclick="document.getElementById('video-player').pause()"
                            >
                                <span class="icon-control fa fa-pause"></span
                                ></button>
                            <button 
                                id="btn-"
                                class="btn-control"
                                onclick="document.getElementById('demo').play()"
                            >
                                <span class="icon-control fa fa-step-forward"
                                ></span></button>
                            <button 
                                id="btn-"
                                class="btn-control"
                                onclick="document.getElementById('demo').play()"
                            >
                                <span class="icon-control fa fa-"></span></bu
                                tton>
                        </div>
                    </div>
                    <h1 class="video-play-title">{{$video->title}}</h1>
                    <hr>
                </div>
                <div>
                    <div class="new-comment">
                        <div class="avatar-container">
                            <div>
                                <img 
                                    class="img-avatar"
                                    src="{{route('get.avatar', $video->user()->get()->all()[0]->avatar)}}" 
                                    width="48"
                                    height="48"
                                    alt="{{$video->user()->get()->all()[0]->avatar}}"
                                >
                            </div>
                            <div class="text-info">
                                <strong class="text-username">{{$video->user()->get()->all()[0]->username}}</strong><br>
                                <p>Publicado {{$video->created_at->format('j \d\e M, Y')}}</p>
                                <p class="text-description">{{$video->description}}</p>
                            </div>
                        </div>
                        <hr>
                            <p class="cant-coments">{{$comments->count(). ' comentarios'}}</p>
                        @if(!Auth::guest())
                        <div class="avatar-container">
                            <div>
                                    @if( Auth::user()->avatar != null)
                                    <img 
                                        class="img-avatar"
                                        src="{{route('get.avatar', Auth::user()->avatar)}}" 
                                        width="48"
                                        height="48"
                                        alt="{{$video->user()->get()->all()[0]->avatar}}"
                                    >
                                    @else
                                    <div class="img-avatar-letter">
                                        <p>{{str_limit(Auth::user()->username,1,'')}}</p>
                                    </div>    
                                    @endif
                            </div>
                            <div class="do-comment">
                                <form action="{{route('create.comment')}}" method="POST">
                                    {{csrf_field()}}
                                    <input type="text" name="video_id" value="{{$video->id}}" hidden>
                                    <input 
                                        name="body"
                                        type="text" 
                                        size="80" 
                                        placeholder="Añadir un comentario publico..."
                                    >
                                    <button class="btn">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Comentar</button>
                                </form>
                            </div>
                        </div>    
                        @endif
                    </div>
                    <div class="coments-container">
                        @forelse($comments as $comment)
                            <div class="avatar-container">
                                <div>
                                    @if( $comment->user()->get()->all()[0]->avatar != null)
                                    <img 
                                        class="img-avatar"
                                        src="{{route('get.avatar', $comment->user()->get()->all()[0]->avatar)}}" 
                                        width="48"
                                        height="48"
                                        alt="{{$comment->user()->get()->all()[0]->avatar}}"
                                    >
                                    @else
                                    <div class="img-avatar-letter">
                                        <p>{{str_limit($comment->user()->get()->all()[0]->username,1,'')}}</p>
                                    </div>    
                                    @endif
                                </div>
                                <div class="comment">
                                    <strong 
                                        class="text-username"
                                    >
                                        {{$comment->user()->get()->all()[0]->username}}
                                    </strong>
                                        {{$comment->created_at->diffForHumans()}}
                                    <br>
                                    <p class="comment-body">{{$comment->body}}</p>
                                </div>
                            </div>
                        @empty
                            <h3>No Hay Comentarios</h3>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="next-video-container">
                @forelse($moreVideos as $video)
                <div class="next-video-play">
                    <div>
                        <a href="{{route('play.video', $video->id)}}" class="image-container">
                            <img src="{{route('get.image', $video->image_path)}}" width="168" height="94"alt="video">
                        </a>
                    </div>
                    <a href="" class="video-title margin-title">
                        <strong class="">{{$video->title}}</strong>
                        <p class="text-video">{{$video->user()->get()->all()[0]->username}}</p>
                        <p>{{$video->created_at->diffForHumans()}}</p>
                    </a>
                </div>
                @empty
                <div class="next-video-play">
                    <h6>No hay mas Videos</h6>
                </div>   
                @endforelse

            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('#btn-play').hide();
        
        $('#btn-play').on('click',function(){
            play();
        });

        $('#btn-pause').on('click', function(){
            pause();
        });

        $('.div-control-reproduccion').bind('click', function(){

            if ($('#btn-play')[0].style.display == 'none') {
                $('#video-player')[0].pause();
                pause();
            }else{    
                $('#video-player')[0].play();
                play();
            }
        });

        // $('.div-control-reproduccion').bind('dblclick', function(){
        //     console.log('dobleclcik');
            
        //     $('#video-player').fullscreen();
        // });

        function play() {
            $('#btn-play').hide();
            $('#btn-pause').show();
        }

        function pause(){
            $('#btn-pause').hide();
            $('#btn-play').show();
        }
    });
</script>
@endsection