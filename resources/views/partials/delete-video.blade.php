<form action="{{route('delete.video',$video->id)}}" method="POST" style="display:inline-block;">
    {{csrf_field()}}
    {{method_field('DELETE')}}
    <button class="btn btn-see">Borrar</button>
</form>