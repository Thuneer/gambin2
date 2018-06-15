<p class="list__amount">
    @if($items->hasMorePages()) {{ ($items->perPage() * $items->currentPage()) - ($items->count() - 1 ) }} - {{ $items->perPage() * $items->currentPage() }}
    /
    @elseif(count($items) !== 0) {{ ($items->perPage() * ($items->currentPage() - 1)) + 1   }}
    /  @endif
    {{ $items->total()  }} @if(count($items) === 1) {{ $single }} @else  {{ $plural }} @endif</p>