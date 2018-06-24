<div class="form__group form__group--card">
    <label class="form__label" for="">Status </label>

    <input id="draft" type="radio" name="published" value="0" @if($published == '0') checked @endif>
    <label class="form__label form__label--status" for="draft">Draft</label>

    <input id="published" style="margin-left: 15px" type="radio" name="published" value="1" @if($published == '1') checked @endif>
    <label class="form__label form__label--status" for="published">Published</label>
</div>