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
            <li v-for="result in res" :key="result.id" >{{result.name}}</li>
        </ul>

    </v-toolbar>
    
</div>
</template>

<script>

export default {
    components: {
    },
    data: () => ({
        isSearch: false,
        keywords: '',
        res: []
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
                    // app.isEditSectioning()
                })
                // (response =>
                //  app.res = reponse.data

                //  )
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
