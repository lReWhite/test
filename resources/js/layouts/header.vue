<template>
<div class="full">
    <v-toolbar color="cyan" dark>
        <v-app-bar-nav-icon></v-app-bar-nav-icon>
        <div class="login" v-if="!isLoggedIn">
            <a href="/login">Login</a>
        </div>
        <span v-if="isLoggedIn"> | <a @click="logout">Logout</a></span>
        <v-spacer></v-spacer>
        <v-toolbar-title>Application</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon @click="isSearch = !isSearch">
            <v-icon>mdi-magnify</v-icon>
        </v-btn>
        <input type="text" v-model="keywords" v-if="isSearch">
        <ul v-if="res">
            <li v-for="result in res" :key="result.id" @click="isShow(result.id)" >{{result.name}}</li>
        </ul>

    </v-toolbar>
    
        <v-dialog v-model="isShowBook" max-width="290">
        <v-card>
            <form>
                <v-card-title class="headline"></v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col>
                            <v-img :src="'../storage/'+ book.img_src"></v-img>
                        </v-col>
                        <v-col>
                            <v-row>
                                Назвине книги {{book.name}}
                            </v-row>
                            <v-row>
                                Ее автор {{book.author}}
                            </v-row>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" @click="isShowBook=false">
                        Отмена
                    </v-btn>
                </v-card-actions>
            </form>
        </v-card>
    </v-dialog>
</div>
</template>

<script>

export default {
    components: {
    },
    data: () => ({
        isSearch: false,
        isShowBook: false,
        keywords: '',
        res: [],
        book: '',
    }),
    computed: {
        isLoggedIn: function () {
            return this.$store.getters.isLoggedIn
        }
    },
    watch: {
        keywords(after, before) {
            this.fetch();
        }
    },

    methods: {
        isShow(id){
          this.isShowBook=true;
            var app = this;
            axios.get('/api/v1/book/' + id)
                .then(function (resp) {
                    app.book = resp.data;
                    console.log(app.book)
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load sections");
                });
        },
        logout: function () {
            this.$store.dispatch('logout')
                .then(() => {
                    this.$router.push('/login')
                })
        },
        fetch() {
            var app = this
            axios.get('/api/v1/search', {
                    params: {
                        keywords: this.keywords
                    }
                })
                .then(function (resp) {
                    app.res = resp.data
                })
                .catch(error => {});
        }
    },
}
</script>

<style>
.full {
    height: 56px;
}
</style>
