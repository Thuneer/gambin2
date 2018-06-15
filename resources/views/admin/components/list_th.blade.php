<th class="list__th @if($type == 'primary') list__primary  @endif" scope="col">
    <form action="{{ $route }}" method="GET">
        <input name="sort-value" type="hidden"
               value="{{ $sort_type == $value && $sort_value == 'asc' ? 'desc' : 'asc' }}">
        <input name="sort-type" type="hidden" value="{{ $value }}">
        @if($per_page != '15')<input type="hidden" name="per-page" value="{{ $per_page }}"> @endif
        @if(isset($search) && !empty($search))<input type="hidden" name="search" value="{{ $search }}"> @endif
        @if(isset($list) && !empty($list))<input type="hidden" name="list" value="{{ $list }}"> @endif
        <button type="submit" class="list__sort-btn">{{ $title }}</button>

        <i class="list__sort-arrow fas fa-chevron-down
        @if ($sort_type != $value) list__sort-arrow--hidden @else list__sort-arrow--active @endif
        @if($sort_value == 'desc' && $sort_type == $value) list__sort-arrow--up @endif"></i>

    </form>
</th>