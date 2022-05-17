@if (count($articles) > 0)
<div class="row">

    @foreach ($articles as $article)
    <!-- Post preview-->
    <div class="col-md-6">
        <div class="post-preview">
            <a href="{{route('detailBlog',[$article->getCategory->slug , $article->slug])}}">
                <h6 style="white-space:nowrap; text-overflow:ellipsis;" class="post-title">{{Str::limit($article->title,22)}}</h6>
                <img src="{{$article->image}}" class="card-img" alt="{{$article->title}}">
                <h6 class="post-subtitle">{{Str::limit($article->content,75)}}</h6>
            </a>
            <p class="post-meta">
                <a href="#!"> Kategori : {{ $article->getCategory->name }}</a>
                <span class="float-end">

                    {{ $article->created_at->diffForHumans() }}
                </span>
            </p>
        </div>
    </div>

    @endforeach
</div>
@if($articles->currentPage() > $articles->lastPage())
<div class="alert alert-danger">Böyle bir sayfa yok</div>
@endif

<div align="center" class="d-flex justify-content-center">
    {{ $articles->links('pagination::bootstrap-4') }}
</div>
@else
<div class="alert alert-danger">
    Bu kategoriye ait yazı bulunamadı
</div>

@endif
