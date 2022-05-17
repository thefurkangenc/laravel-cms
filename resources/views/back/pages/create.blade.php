@extends('back.layouts.master')
@section('title','Sayfa Oluştur')

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
    <form action="{{route('admin.page.create.post')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form group mt-1 mb-1">
            <label>Başlık</label>
            <input type="text" value="{{old('title')}}" name="title" class="form-control mt-1 mb-1" required>
        </div>

        <div class="form group mt-1 mb-1">
            <label>Fotoğraf</label>
            <input type="file" name="image" class="form-control mt-1 mb-1" required>
        </div>
        <div class="form group mt-1 mb-1">
            <label>Başlık</label>
            <textarea name="content" id="editor" class="form-control" cols="30" rows="10">{{old('content')}}</textarea>
        </div>
        <button class="btn btn-primary btn-block mt-2 mb-2 p-2">sayfayi Oluştur</button>
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
