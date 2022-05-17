@extends('back.layouts.master')
@section('title',$page->title)

@section('content')
<div class="card-body">
    @if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $err)
        <li>
            {{ $err }}
        </li>
        @endforeach
    </div>
    @endif
    <form action="{{route('admin.page.edit.post',$page->id)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="form group mt-1 mb-1">
            <label>Başlık</label>
            <input type="text" value="{{$page->title}}" name="title" class="form-control mt-1 mb-1" required>
        </div>

        <div class="form group mt-1 mb-1">
            <label>Fotoğraf</label>
            <br>
            <img src="{{$page->image}}" style="width:250px; height:150px;" class="img-responsive mt-2 mb-2 rounded shadow  img-thumbnail" alt="">
            <input type="file" name="image" class="form-control mt-1 mb-1" >
        </div>
        <div class="form group mt-1 mb-1">
            <label>Başlık</label>
            <textarea name="content" id="editor" class="form-control" cols="30" rows="10">{!! $page->content !!}</textarea>
        </div>
        <button class="btn btn-primary btn-block mt-2 mb-2 p-2">Makaleyi Güncelle</button>
    </form>
</div>
@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editor').summernote({
            'height': 300,
        });
    });
</script>
@endsection
