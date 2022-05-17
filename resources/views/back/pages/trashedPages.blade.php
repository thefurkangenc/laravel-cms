@extends('back.layouts.master')
@section('title','Sayfa Yönetimi')

@section('content')

@if($pages->count() > 0)
<div class="">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="m-0 col-md-6 font-weight-bold text-primary"><span>{{$pages->count()}}</span> Sayfa bulundu</div>
                <div align="right" class="m-0 col-md-6  float-right text-warning "><a href="{{route('admin.page.index')}}" class="fa fa-recycle text-primary text-decoration-none "> Aktif Sayfalar</a></div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Resim</th>
                            <th>İsim</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Resim</th>
                            <th>İsim</th>
                            <th>İşlem</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @isset($pages)
                        @foreach ($pages as $page )
                        <tr>
                            <td>
                                <img class="float-center" style="height:50px; width:50px;" src="{{$page->image}}" alt="">
                            </td>
                            <td>
                                {{ $page->title }}
                            </td>
                            <td>
                                <a href="{{route('admin.page.recycle',$page->id)}}" class="btn btn-info"><i class="fa fa-recycle" title="Kurtar"></i></a>
                                <a page-id="{{$page->id}}" title="Sil" class="btn btn-danger pagesDelete" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-times"> </i></a>
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
@else
<div class="alert alert-info">Geri dönüşüm kutusu boş <a class="btn-link" href="{{route('admin.page.index')}}">Tüm Sayfalar</a></div>
@endif

@endsection
@section('css')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
@endsection
@section('js')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
    $(function() {
        $('.status').change(function(el) {
            id = $(this)[0].getAttribute('data-id');
            statu = $(this).prop('checked');
            $.get("{{route('admin.page.status')}}", {
                id: id,
                statu: statu
            }, function(data, status) {
                console.log(data);
            });
        });
        $('.pagesDelete').click(function() {
            $('#pageToBeDeletedID').val("");
            id = $(this)[0].getAttribute('page-id');
            $('#pageToBeDeletedID').val(id);
        });

    });
</script>
@if (session()->has('status'))
<script>
    alertify.notify('{{ session()->get("status") }}', 'success', 5)
</script>
@endif
@if(session()->has('result'))
<script>
    alertif.notfiy('{{session()->get("result")}}','success');
</script>
@endif

@endsection




<!-- Modal -->
@if($pages->count() > 0)
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div align="center">
                    Silmek istediğinize emin misiniz ?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success " data-dismiss="modal">Kapat</button>
                <a href="{{route('admin.page.hardDelete',$page->id)}}" class="btn btn-danger">Sil</a>
            </div>
        </div>
    </div>
</div>

@endif
