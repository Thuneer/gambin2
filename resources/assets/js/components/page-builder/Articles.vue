<template>
    <div>
        <div class="pb-delete">
            <i class="far fa-trash-alt"></i>
        </div>

        <div class="articles__new-container">
            <button class="articles__new"><i class="articles__new-icon fas fa-plus"></i> Add new row
            </button>
        </div>

        <draggable :list="articles" :options="rowOptions" :move="here"
                   class="container articles">

            <div v-for="row in articles" :key="row.id" class="row articles__row">
                <div class="pb-row-controls">
                    <div class="pb-row-controls__icon pb-row-controls__icon--drag fas fa-arrows-alt"></div>
                    <div class="pb-row-controls__icon pb-row-controls__icon--menu fas fa-bars"></div>
                    <div class="pb-row-controls__icon pb-row-controls__icon--delete fas fa-trash-alt"></div>
                </div>

                <draggable :list="row.columns" :options="columnOptions" :move="here"
                           style="display: flex;width: 100%">

                    <div v-for="column in row.columns" class="articles__column col-md-6">

                        <div v-if="!column['article']" :key="column.id" class="articles-hand">
                            <div><i class="articles-hand__icon far fa-hand-point-down"></i></div>
                            <p class="articles-hand__text">Drop article here</p>
                        </div>

                        <div class="pb-column-controls">
                            <div class="pb-column-controls__icon pb-column-controls__icon--drag fas fa-arrows-alt"></div>
                            <div class="pb-column-controls__icon pb-column-controls__icon--menu fas fa-bars"></div>
                            <div class="pb-column-controls__icon pb-column-controls__icon--delete fas fa-trash-alt"></div>
                        </div>

                        <draggable :list="column.articles" :options="containerOptions" class="articles__item articles__droppable" :move="here">

                            <div v-for="a in column.articles" class="articles__container articles__element--bg-white">

                                <draggable :list="a.elements"
                                           class="articles__droppable articles__droppable--container"
                                           :options="elementsOptions" :move="here">

                                    <div v-for="element in a.elements" :key="a.id">

                                        <h2 v-if="element.type === 'text'"
                                            class="articles__element articles__element--bg-white articles__element--color-black articles__element--font-size-l articles__element--font-weight-l">
                                            {{ element.value }}
                                        </h2>

                                        <div v-if="element.type === 'image'"
                                             class="articles__img-container articles__element">
                                            <img class="articles__img" :src="element.value" alt="">
                                        </div>

                                    </div>


                                </draggable>
                            </div>

                        </draggable>

                    </div>
                </draggable>

            </div>

        </draggable>
    </div>
</template>

<script>

    import draggable from 'vuedraggable'

    export default {
        data() {
            return {
                articles: [
                    {
                        id: 345345,
                        title: 'one',
                        columns: [
                            {
                                id: 3,
                                title: 'one one',
                                articles: [
                                    {
                                        elements: [
                                            {
                                                type: 'image',
                                                value: '/uploads/2018/09/07/1536353532-5b92e4fcc3e37-21-9-lg.jpg'
                                            },
                                            {
                                                type: 'text',
                                                value: 'Header text12312'
                                            },
                                        ]
                                    }
                                ],


                            },
                            {
                                id: 6,
                                title: 'fgh wer',
                                articles: [
                                    {
                                        elements: [
                                            {
                                                type: 'image',
                                                value: '/uploads/2018/09/07/1536353532-5b92e4fcc3e37-21-9-lg.jpg'
                                            },
                                            {
                                                type: 'text',
                                                value: 'Header text12312'
                                            },
                                        ]
                                    }
                                ],

                            }
                        ]
                    }
                ],
                rowOptions: {
                    handle: '.pb-row-controls__icon--drag',
                    animation: 200
                },
                columnOptions: {
                    handle: '.pb-column-controls__icon--drag',
                    animation: 200
                },
                containerOptions: {
                    group: {name: 'articleDrop', pull: true, put: true},
                    handle: '.articles__container',
                    filter: '.pb-column-controls',
                    animation: 200,
                    disabled: false,
                },
                elementsOptions: {
                    group: {name: 'elementsDrop', pull: true, put: true},
                    animation: 200,
                    disabled: false
                }
            }
        },
        methods: {
            coal: function (event) {

                console.log(event);
                console.log(this.articles);
            },
            thing: function (event) {
                console.log(event);
            },
            here: function (event) {
                console.log(event.relatedContext);
                console.log(this.articles);
            }
        },
        mounted() {

        },
        components: {
            draggable,
        },
    }
</script>