@extends('back.layouts.master')
@section('title','Makalaler')

@section('content')
<div class="">
 <div class="card shadow mb-4">
  <div class="card-header py-3">
   <div class="row">
    <div class="m-0 col-md-6 font-weight-bold text-primary"><span>{{$articles->count()}}</span> Makale bulundu</div>
    <div align="right" class="m-0 col-md-6  float-right text-warning "><a href="{{route('admin.trashedArticles')}}" class="fa fa-trash text-danger text-decoration-none "> Silinen Makaleler</a></div>

   </div>
  </div>
  <div class="card-body">
   <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
     <thead>
      <tr>
       <th>Resim</th>
       <th>Başlık</th>
       <th>Kategori</th>
       <th>Hit</th>
       <th>Oluşturulma Tarihi</th>
       <th>Durum</th>
       <th>İşlem</th>
      </tr>
     </thead>
     <tfoot>
      <tr>
       <th>Resim</th>
       <th>Başlık</th>
       <th>Kategori</th>
       <th>Hit</th>
       <th>Oluşturulma Tarihi</th>
       <th>Durum</th>
       <th>İşlem</th>
      </tr>
     </tfoot>
     <tbody>

      @isset($articles)
      @foreach ($articles as $article )
      <tr>
       <td>
        <img class="float-center" style="height:50px; width:50px;" src="{{$article->image}}" alt="">
       </td>
       <td>{{ $article->title }}</td>

       <td>{{ $article->getCategory->name }}</td>
       <td>{{ $article->hit }}</td>
       <td>{{ $article->created_at->diffForHumans() }}</td>

       <td>
        <input class="status" data-id="{{$article->id}}" type="checkbox" @if($article->status == 1) checked @endif data-toggle="toggle" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger">
       </td>
       <td>
        <a target="_blank" href="{{route('detailBlog',[$article->getCategory->slug,$article->slug])}}" title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"> </i></a>
        <a href="{{route('admin.makaleler.edit',$article->id)}}" title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-pen"> </i></a>
        <a href="{{route('admin.delete',$article->id)}}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-times"> </i></a>

       </td>
      </tr>
      @endforeach
      @endisset
     </tbody>
    </table>
   </div>
  </div>
 </div>
</div>

@endsection
@section('css')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('js')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
 $(function() {
  $('.status').change(function(el) {

   id = $(this)[0].getAttribute('data-id');
   statu = $(this).prop('checked');
   $.get("{{route('admin.switch')}}", {
    id: id,
    statu: statu
   }, function(data, status) {

   });
  });
 });
</script>

@endsection
