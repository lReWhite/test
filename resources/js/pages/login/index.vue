<template>
<div class="content">

    <v-content class="is-login" v-if="isLogin">
        <div class="title-wraper">
            Авторизация
        </div>
        <div class="iput-wraper">
            <v-text-field label="логин" v-model="user.name"></v-text-field>
            <v-text-field label="пароль" v-model="user.password"></v-text-field>
            <v-row style="justify-content: space-between;">
                <v-btn color="info" @click="login()">Логин</v-btn>
                <v-btn color="info" @click="isLogin = false">Регистрация</v-btn>
            </v-row>
        </div>
    </v-content>

    <v-content class="is-login" v-if="!isLogin">
        <div class="title-wraper">
            Регистрация
        </div>
        <div class="iput-wraper">
            <v-text-field label="логин" v-model="userReg.name"></v-text-field>
            <v-text-field label="пароль" v-model="userReg.email"></v-text-field>
              <v-text-field label="Имя" v-model="userReg.password"></v-text-field>
            <v-row style="justify-content: space-between;">
                <v-btn color="info" @click="isLogin = true">Логин</v-btn>
                <v-btn color="info" @click="reg">Регистрация</v-btn>
            </v-row>
        </div>
    </v-content>
</div>
</template>

<script>
export default {
    data: () => ({
        isLogin: true,
        user:{
            email:'',
            password:'',
        },
        userReg: {
            email:'',
            password:'',
            name:'',
            role:'',
        }
    }),
    methods: {
        
        login() {
            // this.$v.$touch()
            // if (this.$v.book.$invalid) {
            //     this.submitStatus = 'ERROR'
            // } else {
                var app = this;
                axios.post('api/auth/login', app.user)
                    .then(function (resp) {
                        clearForm();
                        // console.log(app.book)
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        // alert("Could not load sections");
                    });
            // }

        },

        reg() {
            // this.$v.$touch()
            // if (this.$v.book.$invalid) {
            //     this.submitStatus = 'ERROR'
            // } else {
                var app = this;
                axios.post('api/auth/reg', app.userReg)
                    .then(function (resp) {
                        clearForm();
                        // console.log(app.book)
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        // alert("Could not load sections");
                    });
            // }

        },
    }
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
