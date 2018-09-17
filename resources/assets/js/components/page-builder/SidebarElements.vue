<template>
    <draggable v-model="things" :options="options" id="potato" class="pb-elements potato" :move="here">

        <div v-for="thing in things" class="pb-elements__container">
            <div id="element-text" class="pb-elements__item pb-elements__item--row">
                <span class="pb-elements__icon fas fa-font"></span>
                <div class="pb-elements__text">{{ thing.value }}</div>
            </div>
        </div>

        <!--
        <div class="pb-elements__container">
            <div id="element-image" class="pb-elements__item pb-elements__item--row">
                <span class="pb-elements__icon fas fa-image"></span>
                <div class="pb-elements__text">Image</div>
            </div>
        </div>
-->
    </draggable>
</template>

<script>

    import draggable from 'vuedraggable'

    export default {
        data() {
            return {
                things: [
                    {

                        type: 'text',
                        value: 'Header texty'
                    },
                    {

                        type: 'text',
                        value: 'Header tdsfadsfsdexty'
                    }
                ],
                options: {
                    group: {name: 'elementsDrop', pull: 'clone', put: false},
                    sort: false
                }
            }
        },
        methods: {
            here: function (event) {
                console.log(event);
            }
        },
        mounted() {

        },
        components: {
            draggable,
        },
    }
</script>