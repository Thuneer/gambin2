<div class="form__group form__group--card">
    <label class="form__label" for="">Status </label>

    <input id="draft" type="radio" name="status" value="draft" @if($status == 'draft') checked @endif>
    <label class="form__label form__label--status" for="draft">Draft</label>

    <input id="published" style="margin-left: 15px" type="radio" name="status" value="published" @if($status == 'published') checked @endif>
    <label class="form__label form__label--status" for="published">Published</label>
</div>