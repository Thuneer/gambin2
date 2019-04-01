<p class="list-amount">

    @if($items->hasMorePages())
        <span class="list-amount__bold">
        {{ ($items->perPage() * $items->currentPage()) - ($items->count() - 1 ) }} - {{ $items->perPage() * $items->currentPage() }}
    </span>
    of
    @elseif(count($items) !== 0)
        <span class="list-amount__bold">
        {{ ($items->perPage() * ($items->currentPage() - 1)) + 1   }}
            </span>
    of
    @endif

    <span class="list-amount__total">
    {{ $items->total() }}
        </span>

     @if(count($items) === 1) {{ $single }} @else  {{ $plural }} @endif

</p>