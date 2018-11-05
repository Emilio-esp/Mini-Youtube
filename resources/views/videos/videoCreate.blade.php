@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <h3>Subir un Video</h3>

                <div class="panel-body">
                    <form 
                        action="{{route('video.store')}}" 
                        method="POST" 
                        enctype="multipart/form-data" 
                        class="col-xs-10 col-xs-offset-1">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="title" class="">Titulo</label>
                            <input type="text" class="form-control" name="title" placeholder="Nombre del Video" value="{{old('title')}}">
                        </div>    
                        <div class="form-group">
                            <label for="description" class="">Descripción</label>
                            <textarea type="text" class="form-control" name="description" rows="4" placeholder="Nombre del Video">
                            </textarea>
                        </div>    
                        <div class="form-group">
                            <label for="cover" class="">Imagen de Cover</label>
                            <input type="file" class="form-control" name="image">
                        </div>    
                        <div class="form-group">
                            <label for="video" class="">Archivo de Video</label>
                            <input type="file" class="form-control" name="video" >
                        </div>   
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Subir Video</button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection