<template>
<v-app>
    <v-main>
        <Header />
        <router-view :key="$route.params.id" />
        <Footer />
    </v-main>
</v-app>
</template>

<script>
import Header from './header'
import Footer from './footer'
export default {
    name: "app",
    components: {
        Header,
        Footer,
    },
    data: () => ({
        user: ''
    }),
    mounted() {
       
    },

}

// 
</script>

<style>
.content {
    overflow-x: hidden;
    height: calc(100vh - 120px);
    overflow-y: auto;
    margin-top: 1%;
}

.user-cols {
    margin-left: 1%;
}

.v-card {
    padding: 5%;
    margin-bottom: 2%;
}

.v-pagination__item:focus {
    border: none;
    outline: none;
}
</style>
