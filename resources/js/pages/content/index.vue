<template>
<div class="content">
    <v-row>
        <v-col cols="4" md="4" class="user-cols">
            <v-row style="margin-bottom:2%">
                <button @click="$refs.mod.isAddSection = true">Добавить новый раздел</button>
            </v-row>
            <v-row>
                <v-expansion-panels class="section" focusable v-for="(item,i) in sections" :key="i">
                    <v-expansion-panel>
                        <v-expansion-panel-header @click="getBook(item.id)">{{item.name}}</v-expansion-panel-header>
                        <v-expansion-panel-content>
                            {{item.description}}
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-row>

        </v-col>

        <v-col>
            <v-row class="button-wraper">
                <button @click="$refs.mod.isAddBook = true">Добавить новую книгу</button>
            </v-row>
            <v-row>
                <v-col cols="12" v-for="(item,i) in books" :key="i">
                    <v-card class="card-book white--text">
                        <v-layout row>
                            <v-flex xs7>
                                <v-card-title primary-title>
                                    <div>
                                        <div class="headline">{{item.name}}</div>
                                        <div>{{item.author}}</div>
                                        <div>{{item.publishing}}</div>
                                    </div>
                                </v-card-title>
                            </v-flex>
                            <v-flex xs5>
                                <v-img :src="'storage/'+item.img_src" height="125px" contain></v-img>
                            </v-flex>
                        </v-layout>
                        <v-divider light></v-divider>
                        <button @click="$refs.mod.isDelete(item.id)"> Удалить</button>
                    </v-card>
                </v-col>
            </v-row>
            <div class="text-xs-center">
                <v-pagination v-model="page" :length="length" circle></v-pagination>
            </div>
        </v-col>
    </v-row>
    <Modal ref="mod" />
</div>
</template>

<script>
import Modal from '../../components/modal';
export default {
    components: {
        Modal,
    },
    data: function () {
        return {
            page: 1,
            books: [],
            sections: [],
            sectionId: null,
            length: null
        }
    },
    methods: {
        getBook(id) {
            this.sectionId = id;
            var app = this;
            axios.get('/api/v1/books/' + app.sectionId +'/' + app.page )
                .then(function (resp) {
                    console.log(resp)
                    app.books = resp.data.books;
                    app.length = resp.data.lenth;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load books");
                });
            console.log(id)
        },
    },

    watch: {
        page: function () {
            var app = this;
            axios.get('/api/v1/books/' + app.sectionId +'/' + app.page )
                .then(function (resp) {
                    console.log(resp.data.lenth)
                    app.books = resp.data.books;
                    app.length = resp.data.lenth;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load books");
                });
        },
    },

    mounted() {
        var app = this;
        axios.get('/api/v1/section')
            .then(function (resp) {
                app.sections = resp.data;
            })
            .catch(function (resp) {
                console.log(resp);
                alert("Could not load books");
            });
    },
}
</script>

<style>
.section {
    margin: 2%;
}

button:focus {
    outline: none;
    border: none;
}

.button-wraper {
    justify-content: flex-end;
    padding-right: 5%;
}

.card-book {
    margin-right: 2%;
    background-color: #00bcd4 !important;
    border-color: #00bcd4 !important;
}
</style>
