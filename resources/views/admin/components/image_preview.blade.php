<div class="form__group @if($type == 'card') form__group--card @endif">

    <label class="form__label" for=""> {{ $title }}</label>

    <div class="image-picker-preview" data-popshow="{{ $id }}"

         @if(count($item['images']) > 0) style="background-color: {{ $item['images'][0]->color }}" @elseif($type == 'media') style="background-color: {{ $item->color }}" @endif>

        <i class="image-picker-preview__add @if(count($item['images']) > 0 || $type == 'media') image-picker-preview__add--hide @endif fas fa-plus"></i>

        <i class="image-picker-preview__remove fas fa-times"></i>

        <input type="hidden" id="image-picker-id" name="image" @if(count($item['images']) > 0) data-path="{{ $item['images'][0]->path_thumbnail }}" data-id="{{ $item['images'][0]->id }}" @elseif($type == 'media') data-path="{{ $item->path_thumbnail }}" data-id="{{ $item->id }}" @endif>

    </div>

    @if ($errors->has('image'))
        <div class="form__error">
            <strong>{{ $errors->first('image') }}</strong>
        </div>
    @endif

</div>