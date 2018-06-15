<form action="{{ $route }}" method="GET" class="search">
    <input class="search__input" name="search" type="text" value="{{ $search }}" placeholder="{{ $placeholder  }}">
    @if($per_page != '15')<input type="hidden" name="per-page" value="{{ $per_page }}"> @endif
    @if($list)<input type="hidden" name="list" value="{{ $list }}"> @endif
    <button class="search__btn">
        <i class="search__icon icon fas fa-search"></i>
    </button>
</form>