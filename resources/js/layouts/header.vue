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
        <v-autocomplete clearable v-if="isSearch"></v-autocomplete>
    </v-toolbar>
</div>
</template>

<script>
//  import store from "../store";
export default {
   
    data: () => ({
        isSearch: false,
    }),
    computed : {
      isLoggedIn : function(){ return this.$store.getters.isLoggedIn}
    },
    methods: {
      logout: function () {
        this.$store.dispatch('logout')
        .then(() => {
          this.$router.push('/login')
        })
      }
    },
}
</script>

<style>
.full {
    height: 56px;
}
</style>
