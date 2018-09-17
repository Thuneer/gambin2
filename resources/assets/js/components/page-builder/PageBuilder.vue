<template>
    <!-- Media details -->
    <div id="page-builder-popup" class="popup popup--show popup--full">

        <div class="popup__overlay"></div>

        <div class="popup__main">

            <div class="pb">

                <div class="pb__left">
                    <page-builder-sidebar></page-builder-sidebar>
                </div>

                <div class="pb__right">
                    <page-builder-articles></page-builder-articles>
                </div>

            </div>

        </div>

    </div>
</template>

<script>

    import Sidebar from './Sidebar'
    import Articles from './Articles'

    export default {
        components: {
          Sidebar,
          Articles
        },
        mounted() {

        }
    }
</script>
