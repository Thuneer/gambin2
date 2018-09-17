<template>
    <draggable v-model="articles1" class="pb-articles" :options="options" :move="here">

        <div class="pb-articles__container" v-for="a in articles1">
            <p>sdfsdfsdf</p>
        </div>
    </draggable>
</template>

<script>

    import draggable from 'vuedraggable'

    export default {
        data() {
            return {

                articles1: [
                    {
                        elements: [
                            {
                                type: 'text',
                                value: 'Header text'
                            },
                            {
                                type: 'image',
                                value: '/uploads/2018/09/07/1536353532-5b92e4fcc3e37-21-9-lg.jpg'
                            },
                        ]

                    }
                ],
                options: {
                    group: {name: 'articleDrop', pull: 'clone', put: false},
                    sort: false

                }
            }
        },
        methods: {
            getArticles: function () {

                window.axios.get('/admin/articles/1')
                    .then(response => {
                        //this.articles1 = response.data;
                    })
                    .catch(e => {

                    })

            },
            here: function (event) {
                console.log(event);
            }
        },
        components: {
            draggable,
        },
    }
</script>
