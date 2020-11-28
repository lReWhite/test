<template>
<div class="content">

    <v-content class="is-login" v-if="isLogin">
        <div class="title-wraper">
            Авторизация
        </div>
        <div class="iput-wraper">
            <v-text-field label="логин"></v-text-field>
            <v-text-field label="пароль"></v-text-field>
            <v-row style="justify-content: space-between;">
                <v-btn color="info">Логин</v-btn>
                <v-btn color="info" @click="isLogin = false">Регистрация</v-btn>
            </v-row>
        </div>
    </v-content>

    <v-content class="is-login" v-if="!isLogin">
        <div class="title-wraper">
            Регистрация
        </div>
        <div class="iput-wraper">
            <v-text-field label="логин"></v-text-field>
            <v-text-field label="пароль"></v-text-field>
            <v-row style="justify-content: space-between;">
                <v-btn color="info" @click="isLogin = true">Логин</v-btn>
                <v-btn color="info">Регистрация</v-btn>
            </v-row>
        </div>
    </v-content>
</div>
</template>

<script>
export default {
    data: () => ({
        isLogin: true,
    })
}
</script>

<style>
.title-wraper {
    text-align: -webkit-center;
    font-size: 25px;
    padding-top: 5%;
    padding-bottom: 5%;
    font-weight: bolder;
}

.iput-wraper {
    margin-left: 10%;
    margin-right: 10%;
}
</style>
