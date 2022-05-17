@extends('back.layouts.master')
@section('title','Sayfa Yönetimi')

@section('content')
<div class="">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="m-0 col-md-6 font-weight-bold text-primary"><span>{{$pages->count()}}</span> Sayfa bulundu</div>
                <div align="right" class="m-0 col-md-6  float-right text-warning "><a href="{{route('admin.page.trashed')}}" class="fa fa-trash text-danger text-decoration-none "> Silinen Sayfalar</a></div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Sıralama</th>
                            <th>Resim</th>
                            <th>İsim</th>
                            <th>Durum</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sıralama</th>
                            <th>Resim</th>
                            <th>İsim</th>
                            <th>Durum</th>
                            <th>İşlem</th>
                        </tr>
                    </tfoot>
                    <tbody id="orders">
                        @isset($pages)
                        @foreach ($pages as $page )
                        <tr id="page_{{$page->id}}">
                            <td align="center" style="cursor:move; width:3%!important;" class="handle"><i class="fa fa-arrow-down  "></i></td>
                            <td>
                                <img class="float-center" style="height:50px; width:50px;" src="{{$page->image}}" alt="">
                            </td>
                            <td>
                                {{ $page->title}}
                            </td>
                            <td>
                                <input class="status" data-id="{{$page->id}}" type="checkbox" @if($page->status == 1) checked @endif data-toggle="toggle" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger">
                            </td>
                            <td>
                                <a target="_blank" href="{{route('page',$page->slug)}}" title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"> </i></a>
                                <a href="{{route('admin.page.edit',$page->id)}}" title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-pen"> </i></a>
                                <a page-id="{{$page->id}}" title="Sil" class="btn btn-sm btn-danger pagesDelete" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-times"> </i></a>
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
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $('#orders').sortable({
        handle : '.handle',
        update:function(){
            var siralama = $('#orders').sortable('serialize');
            console.log(siralama);

            $.get("{{route('admin.page.orders')}}?"+siralama,function(data, status){});
        }
    });
</script>
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

@endsection




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div align="center">
                    Silmek istediğinize emin misiniz ?
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success " data-dismiss="modal">Close</button>
                <form action="{{route('admin.page.delete')}}" method="POST" class="">
                    @csrf
                    <input type="hidden" id="pageToBeDeletedID" name="id">
                    <button type="submit" class="btn btn-danger ">Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>


