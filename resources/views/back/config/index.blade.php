@extends('back.layouts.master')
@section('title','Sayfa Yönetimi')

@section('content')
<div class="">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="m-0 col-md-6 font-weight-bold text-primary">@yield('title')</div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('admin.ayar.update')}}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Site başlığı</label>
                            <input type="text" name="title" value="{{$config->title}}" class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Site Aktiflik Durumu</label>
                            <select name="active" id="active" class="form-control">
                                <option @if($config->active == 1) selected @endif value="1">Açık</option>
                                <option @if($config->active == 2) selected @endif value="2">Kapalı</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Site Logo</label>
                            <input type="file" name="logo" class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Site Favicon</label>
                            <input type="file" name="favicon" class="form-control" >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Facebook</label>
                            <input type="text" name="facebook" value="{{$config->facebook}}" class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                            <label for="">Twitter</label>
                            <input type="text" name="twitter" value="{{$config->twitter}}" class="form-control" >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Linkedin</label>
                            <input type="text" name="linkedin" value="{{$config->linkedin}}" class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                            <label for="">Github</label>
                            <input type="text" name="github" value="{{$config->github}}" class="form-control" >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Youtube</label>
                            <input type="text" name="youtube" value="{{$config->youtube}}" class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                            <label for="">İnstagram</label>
                            <input type="text" name="instagram" value="{{$config->instagram}}" class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success container-fluid mt-2 mb-2 shadow">Kaydet</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
