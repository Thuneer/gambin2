<!-- Media details -->
<div id="page-builder-popup" class="popup popup--full">

    <div class="popup__overlay"></div>

    <div class="popup__main">

        <div class="pb">

            <div class="pb__left">
                <div class="pb-sidebar">

                    <div class="pb-header">
                        <div data-pophide="page-builder-popup" class="pb-header__icon fas fa-chevron-left"></div>
                        <div class="pb-header__text">Edit Front page</div>
                    </div>

                    <div class="pb-controls">
                        <div class="pb-controls__menu">
                            <button class="pb-controls__item pb-controls__item--active" data-tab="0">Articles
                            </button>
                            <button class="pb-controls__item" data-tab="1">Elements</button>
                        </div>
                        <div class="pb-controls__actions">
                            <div class="pb-controls__icon pb-controls__icon--refresh fas fa-sync-alt"></div>
                            <div class="pb-controls__icon pb-controls__icon--search fas fa-search"></div>
                            <select class="pb-controls__select" name="" id="">
                                <option value="">Sort by</option>
                                <option value="">Title asc</option>
                                <option value="">Title desc</option>
                                <option value="">Sport</option>
                            </select>
                        </div>
                    </div>

                    <div class="pb-articles"></div>

                    <div id="potato" class="pb-elements potato">
                        <div class="pb-elements__container">
                            <div id="element-header" class="pb-elements__item pb-elements__item--row">
                                <span class="pb-elements__icon fas fa-font"></span>
                                <div class="pb-elements__text">Header</div>
                            </div>
                        </div>
                        <div class="pb-elements__container">
                            <div id="element-paragraph" class="pb-elements__item pb-elements__item--row">
                                <span class="pb-elements__icon fas fa-font"></span>
                                <div class="pb-elements__text">Paragraph</div>
                            </div>
                        </div>
                        <div class="pb-elements__container">
                            <div id="element-image" class="pb-elements__item pb-elements__item--row">
                                <span class="pb-elements__icon fas fa-image"></span>
                                <div class="pb-elements__text">Image</div>
                            </div>
                        </div>
                        <div class="pb-elements__container">
                            <div id="element-box" class="pb-elements__item pb-elements__item--row">
                                <span class="pb-elements__icon fas fa-box-open"></span>
                                <div class="pb-elements__text">Box</div>
                            </div>
                        </div>


                    </div>

                    <div class="pb-element">

                        <div class="pb-element__header">
                            <i class="pb-element__header-icon fas fa-times"></i>
                            Change Element Styles
                        </div>

                        <div class="pb-element__container">

                            <div class="pb-element__group" data-active="pb-element__size--active">
                                <div class="pb-element__title">Type</div>
                                <div id="pb-element-type"></div>
                            </div>

                            <!-- TEXT -->
                            <div id="text-selection" class="pb-element__group">
                                <div class="pb-element__title">Text</div>
                                <textarea class="pb-element__text" name="Text1" rows="4"
                                          placeholder="Text goes here..."></textarea>
                            </div>


                            <!-- BACKGROUND COLOR -->
                            <div id="background-color-selection" class="pb-element__group"
                                 data-active="pb-element__color--active">
                                <div class="pb-element__title">Background Color</div>
                                <div id="bgc-white"
                                     class="pb-element__circle pb-element__circle--white pb-element__color--active"
                                     data-value="bg-white"></div>
                                <div id="bgc-red" class="pb-element__circle pb-element__circle--red"
                                     data-value="bg-red"></div>
                                <div id="bgc-green" class="pb-element__circle pb-element__circle--green"
                                     data-value="bg-green"></div>
                                <div id="bgc-blue" class="pb-element__circle pb-element__circle--blue"
                                     data-value="bg-blue"></div>
                                <div id="bgc-purple" class="pb-element__circle pb-element__circle--purple"
                                     data-value="bg-purple"></div>
                                <div id="bgc-black" class="pb-element__circle pb-element__circle--black"
                                     data-value="bg-black"></div>
                            </div>

                            <!-- TEXT COLOR -->
                            <div id="color-selection" class="pb-element__group" data-active="pb-element__color--active">
                                <div class="pb-element__title">Text Color</div>
                                <div id="co-black"
                                     class="pb-element__circle pb-element__circle--black pb-element__color--active"
                                     data-value="color-black"></div>
                                <div id="co-grey" class="pb-element__circle pb-element__circle--grey"
                                     data-value="color-grey"></div>
                                <div id="co-white" class="pb-element__circle pb-element__circle--white"
                                     data-value="color-white"></div>
                                <div id="co-red" class="pb-element__circle pb-element__circle--red"
                                     data-value="color-red"></div>
                            </div>

                            <!-- FONT SIZE -->
                            <div id="font-size-selection" class="pb-element__group"
                                 data-active="pb-element__size--active">
                                <div class="pb-element__title">Font Size</div>
                                <div id="fs-xs" class="pb-element__circle pb-element__size--active"
                                     data-value="font-size-xs">XS
                                </div>
                                <div id="fs-s" class="pb-element__circle" data-value="font-size-s">S</div>
                                <div id="fs-m" class="pb-element__circle" data-value="font-size-m">M</div>
                                <div id="fs-l" class="pb-element__circle" data-value="font-size-l">L</div>
                                <div id="fs-xl" class="pb-element__circle" data-value="font-size-xl">XL</div>
                            </div>

                            <!-- FONT WEIGHT -->
                            <div id="font-weight-selection" class="pb-element__group"
                                 data-active="pb-element__size--active">
                                <div class="pb-element__title">Font Weight</div>
                                <div id="fw-s" class="pb-element__circle pb-element__size--active"
                                     data-value="font-weight-s">S
                                </div>
                                <div id="fw-m" class="pb-element__circle" data-value="font-weight-m">M</div>
                                <div id="fw-l" class="pb-element__circle" data-value="font-weight-l">L</div>
                            </div>

                            <!-- IMAGE SIZE -->
                            <div id="image-height-selection" class="pb-element__group"
                                 data-active="pb-element__size--active">
                                <div class="pb-element__title">Image Height</div>
                                <div id="ih-s" data-value="image-height-s" class="pb-element__circle pb-element__size--active">S</div>
                                <div id="ih-m" data-value="image-height-m" class="pb-element__circle">M</div>
                                <div id="ih-l" data-value="image-height-l" class="pb-element__circle">L</div>
                                <div id="ih-xl" data-value="image-height-xl" class="pb-element__circle">XL</div>
                            </div>

                            <!-- ACTIONS -->
                            <div id="actions-selection" class="pb-element__group"
                                 data-active="pb-element__size--active">
                                <div class="pb-element__title">Actions</div>
                                <div id="delete-element" class="pb-element__circle fas fa-trash-alt"></div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="pb__right">

                <div class="pb-delete">
                    <i class="far fa-trash-alt"></i>
                </div>

                <div class="container articles">

                    <div class="articles__new-container">
                        <button class="articles__new"><i class="articles__new-icon fas fa-plus"></i> Add new row
                        </button>
                    </div>

                </div>

            </div>

        </div>


    </div>

</div>