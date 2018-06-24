<div class="form__group form__group--card">
    <label class="form__label" for="">Tags</label>

    <div class="post-tags">
        <div class="post-tags__add">
            <input class="post-tags__input" type="text" placeholder="Add tag...">
            <button class="post-tags__btn"><i class="fas fa-plus"></i></button>
        </div>

        <div class="post-tags__list">

            @foreach($tags as $tag)

                <div class="post-tags__item @foreach($post['tags'] as $t) @if($t->id == $tag->id) post-tags__item--active @endif @endforeach" data-id="{{$tag->id}}">
                    {{ $tag->name }}
                </div>

            @endforeach

        </div>

        <div class="post-tags__container">

            @if($post['tags'])

                @foreach($post['tags'] as $tag)
                    <div class="post-tags__tag">
                        <div class="post-tags__text">{{ $tag->name }}</div>
                        <i class="post-tags__remove fas fa-times"></i>
                        <input type="hidden" name="tags[{{ $tag->id }}]">
                    </div>
                @endforeach

            @else
                <div class="post-tags__empty">No tags selected</div>
            @endif
        </div>

    </div>
</div>
