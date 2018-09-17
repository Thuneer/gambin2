<template>
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
            <div id="image-size-selection" class="pb-element__group"
                 data-active="pb-element__size--active">
                <div class="pb-element__title">Image Size</div>
                <div class="pb-element__circle pb-element__size--active">S</div>
                <div class="pb-element__circle">M</div>
                <div class="pb-element__circle">L</div>
            </div>

            <!-- ACTIONS -->
            <div id="actions-selection" class="pb-element__group"
                 data-active="pb-element__size--active">
                <div class="pb-element__title">Actions</div>
                <div id="delete-element" class="pb-element__circle fas fa-trash-alt"></div>
            </div>
        </div>

    </div>
</template>

<script>


    export default {
        mounted() {

        }
    }
</script>
