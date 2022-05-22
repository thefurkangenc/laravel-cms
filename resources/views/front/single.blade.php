@extends('front.layouts.master')
 @section('title',$article->title)
@section('bg',$article->image)


@section('content')

<div class="col-md-9">
<h2>{{$article->title}}</h2>

    <p>{!! $article->content !!}</p>
<p class="text-muted mt-5">{{$article->hit}} kez okundu</p>
</div>
@include('front.widgets.category')
@endsection

