<form method="GET" class="per-page">
    <div class="per-page__text">Items per page:</div>
    <button class="per-page__btn btn dropdown-toggle" type="button" id="dropdownMenuButton"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        @if (isset($per_page)) {{ $per_page }} @else 15 @endif
    </button>

    <input name="per-page" id="per" type="hidden">
    @if(isset($search) && !empty($search->toHtml()))<input name="search" id="fdfd" type="hidden" value="{{ $search }}"> @endif
    @if(isset($list) && !empty($list->toHtml()))<input name="list" type="hidden" value="{{ $list }}"> @endif

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @if ($per_page != '10')<li onclick="$('#per').val('10'); $('.per-page').submit();" class="dropdown-item" href="#">10</li>@endif
        @if ($per_page != '15')<li onclick="$('#per').val('15'); $('.per-page').submit();" class="dropdown-item" href="#">15</li>@endif
        @if ($per_page != '20')<li onclick="$('#per').val('20'); $('.per-page').submit();" class="dropdown-item" href="#">20</li>@endif
        @if ($per_page != '30')<li onclick="$('#per').val('30'); $('.per-page').submit();" class="dropdown-item" href="#">30</li>@endif
        @if ($per_page != '50')<li onclick="$('#per').val('50'); $('.per-page').submit();" class="dropdown-item" href="#">50</li>@endif
        @if ($per_page != '100')<li onclick="$('#per').val('100'); $('.per-page').submit();" class="dropdown-item" href="#">100</li>@endif
    </div>
</form>