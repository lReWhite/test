<template>
<div class="full">
    <v-toolbar color="cyan" dark>
        <v-app-bar-nav-icon></v-app-bar-nav-icon>
        <div class="login">
            <a href="/login">Login</a>
        </div>
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
export default {
    data: () => ({
        isSearch: false,
    })
}
</script>

<style>
.full {
    height: 56px;
}
</style>
