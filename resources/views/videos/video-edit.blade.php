@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <h3>Editar Video</h3>

                <div class="panel-body">
                    <form 
                        action="{{route('update.video', $video->id)}}" 
                        method="POST" 
                        enctype="multipart/form-data" 
                        class="col-xs-10 col-xs-offset-1">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <div class="form-group">
                            <label for="title" class="">Titulo</label>
                            <input type="text" class="form-control" name="title" value="{{$video->title}}">
                        </div>    
                        <div class="form-group">
                            <label for="description" class="">Descripción</label>
                            <textarea 
                                type="text" 
                                class="form-control" 
                                name="description" 
                                rows="4" 
                            >{{$video->description}}</textarea>
                        </div>    

                        <div class="form-group">
                            <label for="cover" class="">Imagen de Cover</label>
                            <img 
                                src="{{route('get.image', $video->image_path)}}" 
                                width="360" height="180"
                                alt="{{$video->image_path}}"
                                class="image-edit"
                            ><br><br>
                            <input type="file" class="form-control" name="image">
                        </div>    

                        <div class="form-group">
                            <label for="video" class="">Archivo de Video</label>
                            <video controls autoplay width="380" height="200" class="image-edit">
                                <source src="{{route('get.video', $video->video_path)}}"> 
                            </video>
                            <br><br>
                            <input type="file" class="form-control" name="video" >
                        </div>   
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Editar Video</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection