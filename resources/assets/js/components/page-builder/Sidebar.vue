<template>
    <div class="pb-sidebar">

        <div class="pb-header">
            <div data-pophide="page-builder-popup" class="pb-header__icon fas fa-chevron-left"></div>
            <div class="pb-header__text">Edit Front page</div>
        </div>

        <div class="pb-controls">
            <div class="pb-controls__menu">
                <button class="pb-controls__item" data-tab="0"
                        :class="{'pb-controls__item--active': showArticles}"
                        @click="setTabMode('articles')">Articles</button>
                <button class="pb-controls__item" data-tab="1"
                        :class="{'pb-controls__item--active': showElements}"
                        @click="setTabMode('elements')">Elements</button>
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

        <page-builder-sidebar-articles v-show="showArticles"></page-builder-sidebar-articles>

        <page-builder-sidebar-elements v-show="showElements"></page-builder-sidebar-elements>

        <page-builder-element-options v-show="showElementOptions"></page-builder-element-options>

    </div>
</template>

<script>

    import SidebarArticles from './SidebarArticles'
    import SidebarElements from './SidebarElements'

    export default {
        data: function () {
            return {
                showArticles: true,
                showElements: false,
                showElementOptions: false,
            }
        },
        methods: {
            setTabMode: function (mode) {

                if (mode === 'articles') {
                    this.showArticles = true;
                    this.showElements = false;
                    this.showElementOptions = false;
                } else if (mode === 'elements') {
                    this.showArticles = false;
                    this.showElements = true;
                    this.showElementOptions = false;
                }

            }
        },
        components: {
            SidebarArticles,
            SidebarElements
        },
        mounted() {

        }
    }
</script>