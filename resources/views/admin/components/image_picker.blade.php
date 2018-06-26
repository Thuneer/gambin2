<div id="imagePicker" class="popup popup--full">


    <div class="popup__overlay"></div>

    <div class="popup__main">

        <div class="picker">


                <i data-pophide="imagePicker" class="picker__exit fas fa-times"></i>
                <div class="picker-top">

                <span class="picker-top__search">
                    <input placeholder="Search media..." class="picker-top__input" type="text">
                    <button class="picker-top__search-btn"><i class="fas fa-search"></i></button>
                    <button class="picker-top__clear-btn"><i class="fas fa-times"></i></button>
                </span>
                    <i id="gridBtn" data-list="0" class="picker-top__icon picker-top__icon--grid picker-top__icon--active fas fa-th"></i>
                    <i id="listBtn" data-list="1" class="picker-top__icon picker-top__icon--list fas fa-th-list"></i>

                </div>
                <div class="picker-sidebar">

                    <div class="picker-logo">
                        <i class="picker-logo__icon fas fa-image"></i>
                        <div class="picker-logo__text">Image Picker</div>
                    </div>

                    <button id="libraryTabBtn" class="picker-sidebar__btn picker-sidebar__btn--active" data-tab="library">Library</button>
                    <button id="uploadTabBtn" class="picker-sidebar__btn" data-tab="upload">Upload images</button>
                </div>

                <div class="picker__body">

                    <img class="picker__loading" src="/img/loading.gif" alt="">

                    <div class="picker__empty">
                        <i class="picker__empty-icon fas fa-exclamation-circle"></i>
                        <span class="picker__empty-text">No images found</span>
                    </div>


                    <div class="picker__library">

                        <div class="picker-grid"></div>

                        <div class="picker-list"></div>

                    </div>

                    <div class="picker__upload">
                        <form action="/file-upload"
                              class="dropzone"
                              id="imagePickerDropzone"></form>
                    </div>

                </div>

                <div class="picker__footer">
                    <span class="picker__footer-selected"></span>
                    <button data-pophide="imagePicker" class="button">Close</button>
                    <button data-pophide="imagePicker" class="picker__select-btn button button--primary" disabled>Select image</button>
                </div>


        </div>

    </div>

</div>
