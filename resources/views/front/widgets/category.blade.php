@isset($categories)
<div class="col-md-3">
    <div class="card">
        <div class="card-header">Kategoriler</div>
        <div class="">
            <ul class="list-group">
                @foreach($categories as $category)
                <a href="{{route('category',$category->slug)}}">
                    <li class="list-group-item  @if(Request::segment(2) == $category->slug) active @endif">{{$category->name}}
                        <span class="badge bg-primary float-end  ">{{ $category->articleCount() }}</span>
                    </li>
                </a>
                @endforeach
            </ul>
        </div>
    </div>

</div>

@endisset
