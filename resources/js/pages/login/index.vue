<template>
<div class="content">

    <v-content class="is-login" v-if="isLogin">
        <div class="title-wraper">
            Авторизация
        </div>
        <div class="iput-wraper">

            <v-text-field label="логин" v-model.trim="$v.user.email.$model"></v-text-field>
            <div v-if="!$v.user.email.email">Введите Email</div>
            <v-text-field label="пароль" v-model.trim="$v.user.password.$model"></v-text-field>
            <div class="error" v-if="!$v.user.password.minLength">Минимум {{ $v.user.password.$params.minLength.min }} символов.</div>
            <v-row style="justify-content: space-between;">
                <v-btn color="info" @click="login()" :disabled="submitStatus === 'PENDING'">Логин</v-btn>
                <v-btn color="info" @click="isLogin = false">Регистрация</v-btn>
                <p class="typo__p" v-if="submitStatus === 'OK'">Thanks for your submission!</p>
                <p class="typo__p" v-if="submitStatus === 'ERROR'">Please fill the form correctly.</p>
                <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>
            </v-row>
        </div>
    </v-content>

    <v-content class="is-login" v-if="!isLogin">
        <div class="title-wraper">
            Регистрация
        </div>
        <div class="iput-wraper">
            <v-text-field label="логин" v-model="userReg.email"></v-text-field>
            <div v-if="!$v.userReg.email.required">Обязательнео поле</div>
            <div v-if="!$v.userReg.email.email">Введите Email</div>
            <v-text-field label="пароль" v-model="userReg.password"></v-text-field>
            <div v-if="!$v.userReg.password.required">Обязательнео поле</div>
            <div class="error" v-if="!$v.userReg.password.minLength">Минимум {{ $v.user.password.$params.minLength.min }} символов.</div>
            <v-text-field label="Имя" v-model="userReg.name"></v-text-field>
            <div v-if="!$v.userReg.name.required">Обязательнео поле</div>
            <v-row style="justify-content: space-between;">
                <v-btn color="info" @click="isLogin = true">Логин</v-btn>
                <v-btn color="info" @click="reg()" :disabled="submitStatus === 'PENDING'">Регистрация</v-btn>
                <p class="typo__p" v-if="submitStatus === 'OK'">Thanks for your submission!</p>
                <p class="typo__p" v-if="submitStatus === 'ERROR'">Please fill the form correctly.</p>
                <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>
            </v-row>
        </div>
    </v-content>
</div>
</template>

<script>

import {
    required,
    minLength,
    maxLength,
    email
} from 'vuelidate/lib/validators'
export default {
    data: () => ({
        submitStatus: '',
        isLogin: true,
        user: {
            email: '',
            password: '',
        },
        userReg: {
            email: '',
            password: '',
            name: '',
            role: '',
        }
    }),
    validations: {
        user: {
            email: {
                required,
                email
            },
            password: {
                required,
                minLength: minLength(6),
            },
        },
        userReg: {
            email: {
                required,
                email
            },
            password: {
                required,
                minLength: minLength(6),
            },
            name: {
                required,
            },
        }
    },

    methods: {

        clearForm() {
            this.user.email = '';
            this.user.password = '';
            this.userReg.email = '',
            this.userReg.password = '',
            this.userReg.name = ''

        },
        login() {
            if (this.$v.user.$invalid) {
                this.submitStatus = 'ERROR'
            } else {
                this.$store.dispatch('login', this.user)
                    .then(() => this.$router.push('/'))
                    .catch(err => console.log(err))
            }

        },

        reg() {
            var app = this;
            if (this.$v.userReg.$invalid) {
                this.submitStatus = 'ERROR'
            } else {
                this.$store.dispatch('register', this.userReg)
                    .then(function (resp) {
                        console.log(resp)
                        if (resp.data.message == "Successfully registration!") {
                             app.isLogin = !app.isLogin;
                             app.clearForm();
                        }

                    })
                    .catch(function (resp) {
                        console.log(resp);
                    });
            }
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
