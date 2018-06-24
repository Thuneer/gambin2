<div class="form__group form__group--card">
    <label class="form__label" for="">Categories</label>

    <div class="post-categories">
        <div class="post-categories__add">
            <input class="post-categories__input" type="text" placeholder="Add category...">
            <button class="post-categories__btn"><i class="fas fa-plus"></i></button>
        </div>
        <div class="post-categories__list">

            @foreach($categories as $category)

                <div class="post-categories__item">
                    <input id="{{ $category->name }}" name="categories[{{ $category->id }}]"
                           type="checkbox" @if($post['categories']) @foreach($post->categories as $cat) @if($cat->id == $category->id) checked @endif @endforeach @endif>
                    <label for="{{ $category->name }}">{{ $category->name }}</label>
                </div>

            @endforeach

        </div>
    </div>

</div>