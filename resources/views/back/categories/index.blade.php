@extends('back.layouts.master')
@section('title','Kategoriler')

@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="card card-shadow">
            <div class="card-header">
                Yeni Kategori Oluştur
            </div>
            <div class="card-body">
                <div id="errorList" class="alert alert-danger" style="display: none;"></div>
                <form action="" method="POST" id="insertForm">
                    @csrf
                    <input type="text" class="form-control" name="categoryNameToAdd" id="" placeholder="Kategori Adı">
                    <input type="submit" id="submitBtn" id="post" class="btn btn-info container-fluid mt-2 mb-2">
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card card-shadow">
            <div class="card-header">
                @yield('title')
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="alert" style="display:none;"></div>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Adı</th>
                                <th>Yazı Sayısı</th>
                                <th>Durum</th>
                                <th>Git</th>
                                <th>İşlemer</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Adı</th>
                                <th>Yazı Sayısı</th>
                                <th>Durum</th>
                                <th>Git</th>
                                <th>İşlemer</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @isset($categories)
                            @foreach ($categories as $category)
                            <tr>
                                <td>{{$category->name}}</td>
                                <td>{{$category->articleCount()}}</td>
                                <td>
                                    <input class="status" data-id="{{$category->id}}" type="checkbox" @if($category->status == 1) checked @endif data-toggle="toggle" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger">
                                </td>
                                <td align="center"><a target="_blank" href="{{route('category',$category->slug)}}"><i class="fa fa-link text-info"></i></a></td>
                                <td>
                                    <a class="btn btn-sm btn-success edit container-fluid " category-id="{{$category->id}}" data-toggle="modal" data-target="#editModal" title="Düzenle"><i class="fa fa-edit"></i></a>
                                    <a class="btn btn-sm btn-danger delete container-fluid mt-1" category-id="{{$category->id}}" category-name="{{$category->name}}" category-count="{{$category->articleCount()}}" data-toggle="modal" data-target="#deleteModal" title="Sil"><i class="fa fa-times"></i></a>
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
</div>
<div class="alert alert-danger print-error-msg" style="display:none">
    <ul></ul>
</div>
@endsection
@section('css')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
@endsection
@section('js')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
    $(document).ready(function() {



        $("#insertForm").submit(function(e) {
            document.getElementById('submitBtn').disabled = true;
            e.preventDefault();
            var _token = $("input[name='_token']").val();
            var categoryName = $("input[name='categoryNameToAdd']").val();
            $.ajax({
                url: "{{ route('admin.insertCategory') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    categoryName: categoryName
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        $('#errorList').hide();
                        alertify.notify(data.success, 'success', 5)
                        var table = $('.data-table')
                        document.getElementById('submitBtn').disabled = false;
                    } else {
                        printErrorMsg(data.error);
                        document.getElementById('submitBtn').disabled = false;
                    }
                }
            });
        });





        function printErrorMsg(msg) {
            var errorList = document.getElementById('errorList');
            errorList.innerHTML = null;
            msg.forEach(function(e) {
                console.log(errorList);
                errorList.innerHTML += e + "<hr>";
                errorList.style.display = 'block';
            })
        }
    });





    $(function() {
        $('.status').change(function(el) {
            id = $(this)[0].getAttribute('data-id');
            statu = $(this).prop('checked');
            $.get("{{route('admin.changeCategoryStatus')}}", {
                id: id,
                statu: statu
            }, function(data, status) {
                if (data == 0) {
                    let alert = document.getElementById('alert');
                    alert.className = "alert alert-danger";
                    alert.innerHTML = "Bir Hata Oluştu";
                    alert.style.display = "block";
                    setTimeout(() => {
                        alert.style.display = "none";
                    }, 2500);
                    console.log(alert);
                }
            });
        });
    });



    $('.edit').click(function() {
        id = $(this)[0].getAttribute('category-id');
        $.ajax({
            type: "GET",
            url: "{{route('admin.getData')}}",
            data: {
                id: id
            },
            success: function(data) {
                console.log(data);
                $('editModal').modal();
                $('#name').val(data.name);
                $('#slug').val(data.slug);
                $('#categoryID').val(data.id);
            },
            error: function(err) {
                console.log(err);
            }
        });
    });
    $('.delete').click(function() {
        id = $(this)[0].getAttribute('category-id');
        count = $(this)[0].getAttribute('category-count');
        name = $(this)[0].getAttribute('category-name');
        if (id == 1) {
            $('#articleAlert').html(name + ' Kategorisi Silinemez. Silinen Kategorilere ait yazılar buraya depolanacaktır.');
            $('#body').show();
            $('#deleteButton').hide();
        } else {
            $('#deleteButton').show();
            $('#deleteID').val(id);
            $('#articleAlert').html('');
            $('#body').hide();
            if (count > 0) {
                $('#body').show();
                $('#articleAlert').html(name + ' kategorisine ait ' + count + ' makale bulunmaktadır. Silmek İstediğinize Emin misiniz?')
            }
        }





    })
</script>
@endsection






<!-- Modal -->
<div class="modal fade shadow " id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Kategori Düzenle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <form action="{{route('admin.category.update')}}" method="POST">
                        @csrf
                        <label>Kategori Adı</label>
                        <input type="text" class="form-control" name="categoryName" id="name">
                        <label>Kategori Slug</label>
                        <input type="text" class="form-control" name="categorySlug" id="slug">
                        <input type="hidden" name="categoryID" id="categoryID">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                <button type="submit" class="btn btn-success">Kaydet</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade shadow mt-5" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Kategoriyi Sil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="body" class="modal-body">
                <div class="alert alert-warning" id="articleAlert"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Kapat</button>
                <form action="{{route('admin.category.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="deleteID">
                    <button id="deleteButton" type="submit" class="btn btn-danger">Sil</button>
                </form>
            </div>
            </form>
        </div>
    </div>
</div>
