<!-- Popup delete -->
<div id="deletePopup" class="popup">

    <div class="popup__overlay"></div>

    <div class="popup__main">

        <div class="popup__content">

            <div class="popup__header popup__header--danger">
                <h3 class="popup__title">{{ $title }}</h3>
                <div data-pophide="deletePopup" class="popup__close-icon fas fa-times"></div>
            </div>

            <div id="deleteModalText" class="popup__body">
                Are you sure you want to delete this media file?
            </div>

            <div class="popup__footer">
                <button data-pophide="deletePopup" class="button">No, close</button>
                <form method="POST" action="{{ $route }}">
                    @csrf
                    <input name="deleteIds" type="hidden" id="deleteModalIds">
                    <input name="list" type="hidden" value="{{ $list }}">
                    <button id="deleteModalBtn" type="submit" class="button button--danger">Yes, delete</button>
                </form>

            </div>

        </div>

    </div>

</div>