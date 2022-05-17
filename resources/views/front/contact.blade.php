@extends('front.layouts.master')
@section('title','İletişim')
@section('bg','https://wallpaperaccess.com/full/332211.jpg')
@section('content')


<p>Want to get in touch? Fill out the form below to send me a message and I will get back to you as soon as possible!</p>
<div class="col-md-9">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error )
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>

    @endif
    <div class="mt-2">
        <form method="POST" action="{{route('contact.post')}}">
            @csrf
            <div class="form-group">
                <label for="">Ad Soyad</label>
                <input type="text" value="{{old('name')}}" class="form-control" name="name" placeholder="Ad Soyad">
            </div>
            <div class="form-group">
                <label for="">Mail</label>
                <input type="text" class="form-control" value="{{old('email')}}" name="email" id="email" placeholder="Mailiniz">
            </div>
            <div class="form-group">
                <label for="topic">Konu</label>
                <select name="topic" id="topic" class="form-control">
                    <option value="istek" @if(old('topic')=='istek' ) selected @endif>İstek</option>
                    <option value="destek" @if(old('topic')=='destek' ) selected @endif>Destek</option>
                    <option value="genel" @if(old('topic')=='genel' ) selected @endif>Genel</option>
                </select>
            </div>
            <textarea name="message" class="form-control mt-3 mb-3" id="" cols="30" rows="10">{{old('message')}}</textarea>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
<div class="col-md-3 mt-3">
    <div class="card">
        <div class="card-body">
            <div class="card-header ">
                Adres:
            </div>
            <div class="card-body">
                Bla Bla Bla;
            </div>
        </div>
    </div>
</div>


@endsection
