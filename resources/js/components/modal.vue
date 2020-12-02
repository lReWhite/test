<template>
<v-row justify="center">
    <v-dialog v-model="isBook" max-width="290">
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
                    <v-btn color="green darken-1" @click="isBooking()">
                        Отмена
                    </v-btn>
                </v-card-actions>
            </form>
        </v-card>
    </v-dialog>

    <v-dialog v-model="isDelet" max-width="290">
        <v-card>
            <form>
                <v-card-title class="headline">Внимание</v-card-title>
                <v-card-text>
                    Удалить данную книгу?
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" @click="isDelet = false">
                        Отмена
                    </v-btn>
                    <v-btn color="green darken-1" @click="deleteBook()">
                        Удалить
                    </v-btn>
                </v-card-actions>
            </form>
        </v-card>
    </v-dialog>

    <v-dialog v-model="isEditBook">
        <v-card>
            <form>
                <v-card-title class="headline">Редактировать книгу</v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col>
                            <v-row style="justify-content: center;">
                                <img style="width: 250px;" :src="book.imageSrc || defaultSrc" alt="">
                            </v-row>
                            <v-row>
                                <input type="file" id="file" ref="file" v-on:change="handleFileUpload()" />
                                <!-- <v-file-input accept="image/*" label="Добавьте обложку" id="file" ref="file" v-on:change="handleFileUpload()"></v-file-input> -->
                            </v-row>
                            <v-row>

                                <select v-model.trim="$v.book.section_id.$model " class="select-sect">
                                    <option value="" disabled hidden>Выберите категорию</option>
                                    <option v-for="(item,i) in sections" :key="i" :value="item.id">
                                        {{item.name}}
                                    </option>
                                </select>
                                <div class="error" v-if="!$v.book.section_id.required">Обязательное поле.</div>
                            </v-row>
                        </v-col>
                        <v-col>
                            <!-- <v-text-field label="sas" v-model="book.imgSrc"></v-text-field> -->
                            <v-text-field label="Название" v-model.trim="$v.book.name.$model"></v-text-field>
                            <div class="error" v-if="!$v.book.name.required">Обязательное поле.</div>
                            <div class="error" v-if="!$v.book.name.minLength">Минимум {{ $v.book.name.$params.minLength.min }} символов.</div>
                            <div class="error" v-if="!$v.book.name.maxLength">Максимум {{ $v.book.name.$params.maxLength.max }} символов.</div>

                            <v-text-field label="Автор" v-model.trim="$v.book.author.$model"></v-text-field>
                            <div class="error" v-if="!$v.book.author.required">Обязательное поле.</div>
                            <div class="error" v-if="!$v.book.author.minLength">Минимум {{ $v.book.author.$params.minLength.min }} символов.</div>
                            <div class="error" v-if="!$v.book.author.maxLength">Максимум {{ $v.book.author.$params.maxLength.max }} символов.</div>

                            <v-menu v-model="menu2" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="290px">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model.trim="$v.book.publishing.$model" label="Picker without buttons" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                                </template>
                                <v-date-picker v-model="$v.book.publishing.$model" @input="menu2 = false"></v-date-picker>
                            </v-menu>
                            <div class="error" v-if="!$v.book.publishing.required">Обязательное поле.</div>

                            <v-textarea color="teal" v-model.trim="$v.book.description.$model">
                                <template v-slot:label>
                                    <div>
                                        Описание
                                    </div>
                                </template>
                            </v-textarea>
                            <div class="error" v-if="!$v.book.description.required">Обязательное поле.</div>
                            <div class="error" v-if="!$v.book.description.minLength">Минимум {{ $v.book.description.$params.minLength.min }} символов.</div>
                            <div class="error" v-if="!$v.book.description.maxLength">Максимум {{ $v.book.description.$params.maxLength.max }} символов.</div>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" @click="isEding()">
                        Отмена
                    </v-btn>
                    <v-btn color="green darken-1" @click="saveEdit()" :disabled="submitStatus === 'PENDING'">
                        Сохранить
                    </v-btn>
                    <p class="typo__p" v-if="submitStatus === 'OK'">Thanks for your submission!</p>
                    <p class="typo__p" v-if="submitStatus === 'ERROR'">Please fill the form correctly.</p>
                    <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>
                </v-card-actions>
            </form>
        </v-card>
    </v-dialog>

    <v-dialog v-model="isAddBook">
        <v-card>
            <form>
                <v-card-title class="headline">Добавить новую книгу</v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col>
                            <v-row style="justify-content: center;">
                                <img style="width: 250px;" :src="book.imageSrc || defaultSrc" alt="">
                            </v-row>
                            <v-row>
                                <input type="file" id="file" ref="file" v-on:change="handleFileUpload()" />
                                <!-- <v-file-input accept="image/*" label="Добавьте обложку" id="file" ref="file" v-on:change="handleFileUpload()"></v-file-input> -->
                            </v-row>
                            <v-row>

                                <select v-model.trim="$v.book.section_id.$model " class="select-sect">
                                    <option value="" disabled hidden>Выберите категорию</option>
                                    <option v-for="(item,i) in sections" :key="i" :value="item.id">
                                        {{item.name}}
                                    </option>
                                </select>
                                <div class="error" v-if="!$v.book.section_id.required">Обязательное поле.</div>
                            </v-row>
                        </v-col>
                        <v-col>
                            <!-- <v-text-field label="sas" v-model="book.imgSrc"></v-text-field> -->
                            <v-text-field label="Название" v-model.trim="$v.book.name.$model"></v-text-field>
                            <div class="error" v-if="!$v.book.name.required">Обязательное поле.</div>
                            <div class="error" v-if="!$v.book.name.minLength">Минимум {{ $v.book.name.$params.minLength.min }} символов.</div>
                            <div class="error" v-if="!$v.book.name.maxLength">Максимум {{ $v.book.name.$params.maxLength.max }} символов.</div>

                            <v-text-field label="Автор" v-model.trim="$v.book.author.$model"></v-text-field>
                            <div class="error" v-if="!$v.book.author.required">Обязательное поле.</div>
                            <div class="error" v-if="!$v.book.author.minLength">Минимум {{ $v.book.author.$params.minLength.min }} символов.</div>
                            <div class="error" v-if="!$v.book.author.maxLength">Максимум {{ $v.book.author.$params.maxLength.max }} символов.</div>

                            <v-menu v-model="menu2" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="290px">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model.trim="$v.book.publishing.$model" label="Picker without buttons" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                                </template>
                                <v-date-picker v-model="$v.book.publishing.$model" @input="menu2 = false"></v-date-picker>
                            </v-menu>
                            <div class="error" v-if="!$v.book.publishing.required">Обязательное поле.</div>

                            <v-textarea color="teal" v-model.trim="$v.book.description.$model">
                                <template v-slot:label>
                                    <div>
                                        Описание
                                    </div>
                                </template>
                            </v-textarea>
                            <div class="error" v-if="!$v.book.description.required">Обязательное поле.</div>
                            <div class="error" v-if="!$v.book.description.minLength">Минимум {{ $v.book.description.$params.minLength.min }} символов.</div>
                            <div class="error" v-if="!$v.book.description.maxLength">Максимум {{ $v.book.description.$params.maxLength.max }} символов.</div>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" @click="isAddBooking()">
                        Отмена
                    </v-btn>
                    <v-btn color="green darken-1" @click="saveForm()" :disabled="submitStatus === 'PENDING'">
                        Добавить
                    </v-btn>
                    <p class="typo__p" v-if="submitStatus === 'OK'">Thanks for your submission!</p>
                    <p class="typo__p" v-if="submitStatus === 'ERROR'">Please fill the form correctly.</p>
                    <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>
                </v-card-actions>
            </form>
        </v-card>
    </v-dialog>

    <v-dialog v-model="isAddSection">
        <v-card>
            <form>
                <v-card-title class="headline">Добавить новый раздел</v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col :class="{ 'form-group--error': $v.section.name.$error }">
                            <v-text-field label="Название" v-model.trim="$v.section.name.$model"></v-text-field>
                            <div class="error" v-if="!$v.section.name.required">Обязательное поле.</div>
                            <div class="error" v-if="!$v.section.name.minLength">Минимум {{ $v.section.name.$params.minLength.min }} символов.</div>
                            <div class="error" v-if="!$v.section.name.maxLength">Максимум {{ $v.section.name.$params.maxLength.max }} символов.</div>
                            <v-textarea color="teal" v-model.trim="$v.section.description.$model">
                                <template v-slot:label>
                                    <div>
                                        Описание
                                    </div>
                                </template>
                            </v-textarea>
                            <div class="error" v-if="!$v.section.description.required">Обязательное поле.</div>
                            <div class="error" v-if="!$v.section.description.minLength">Минимум {{ $v.section.description.$params.minLength.min }} символов.</div>
                            <div class="error" v-if="!$v.section.description.maxLength">Максимум {{ $v.section.description.$params.maxLength.max }} символов.</div>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" @click="isAddSectioning()">
                        Отмена
                    </v-btn>
                    <v-btn color="green darken-1" @click="saveFormSection()" :disabled="submitStatus === 'PENDING'">
                        Добавить
                    </v-btn>
                    <p class="typo__p" v-if="submitStatus === 'OK'">Thanks for your submission!</p>
                    <p class="typo__p" v-if="submitStatus === 'ERROR'">Please fill the form correctly.</p>
                    <p class="typo__p" v-if="submitStatus === 'PENDING'">Sending...</p>
                </v-card-actions>
            </form>
        </v-card>
    </v-dialog>
</v-row>
</template>

<script>
import Content from '../pages/content';
import {
    required,
    minLength,
    maxLength
} from 'vuelidate/lib/validators'

export default {

    data: () => ({
        submitStatus: '',
        sections: [],
        errors: [],
        book: {
            name: '',
            author: '',
            publishing: new Date().toISOString().substr(0, 10),
            description: '',
            image: '',
            section_id: ''
        },
        section: {
            name: '',
            description: '',
        },
        sectionSelect: '',
        imageSrc: '',
        isDelet: false,
        isAddBook: false,
        idBook: null,
        isAddSection: false,
        menu2: false,
        isBook: false,
        isEditBook: false,
        defaultSrc: 'https://png.pngtree.com/png-clipart/20190118/ourlarge/pngtree-book-hand-drawn-book-five-books-open-png-image_447137.jpg',
    }),
    validations: {
        section: {
            name: {
                required,
                minLength: minLength(1),
                maxLength: maxLength(150)
            },
            description: {
                required,
                minLength: minLength(1),
                maxLength: maxLength(500)
            }
        },
        book: {
            name: {
                required,
                minLength: minLength(1),
                maxLength: maxLength(150)
            },
            description: {
                required,
                minLength: minLength(1),
                maxLength: maxLength(200)
            },
            author: {
                required,
                minLength: minLength(1),
                maxLength: maxLength(100)
            },
            publishing: {
                required,
            },
            section_id: {
                required
            },
        }

    },

    watch: {
        isAddBook: function () {
            var app = this;
            axios.get('/api/v1/section')
                .then(function (resp) {
                    app.sections = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load sections");
                });
        },
    },
    methods: {

        isEding() {
            this.clearForm();
            this.isEditBook = false;
        },
        isAddBooking() {
            this.clearForm();
            this.isAddBook = false;
        },
        isAddSectioning() {
            this.isAddSection = false;
            this.clearFormSection();
        },
        isBooking() {
            this.isBook = false;
            this.clearForm();
        },

        clearForm() {
            this.book.name = '',
                this.book.author = '',
                this.book.publishing = new Date().toISOString().substr(0, 10),
                this.book.description = '',
                this.book.image = '',
                this.book.section_id = ''
        },
        clearFormSection() {
            this.section.name = '';
            this.section.description = '';
        },

        handleFileUpload() {
            this.imageSrc = this.$refs.file.files[0];
        },

        bookById(id) {
            this.isBook = true;
            this.getByIdBook(id);

        },

        getByIdBook(id) {
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

        editBook(id) {
            this.isEditBook = true;
            this.getByIdBook(id);
            var app = this;
            axios.get('/api/v1/section')
                .then(function (resp) {
                    app.sections = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    // alert("Could not load sections");
                });
        },

        saveEdit() {
            this.$v.$touch()
            if (this.$v.book.$invalid) {
                this.submitStatus = 'ERROR'
            } else {
                var app = this;
                 app.book.image = app.imageSrc;
                axios.post('/api/v1/bookEdit', app.book)
                    .then(function (resp) {
                        app.book = resp.data;
                        alert("Книга изменена");
                        app.isEditBook = false;
                        clearForm();
                        // console.log(app.book)
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        // alert("Could not load sections");
                    });
            }

        },

        saveFormSection() {
            this.$v.$touch()
            if (this.$v.section.$invalid) {
                this.submitStatus = 'ERROR'
            } else {
                this.submitStatus = 'PENDING'
                event.preventDefault();
                var app = this;
                var newSection = app.section;
                axios.post('/api/v1/section', newSection)
                    .then(function (resp) {
                        app.isAddSection = false;
                        clearForm();
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        // alert("Could not create your company");
                    });
            }

        },

        saveForm() {
            this.$v.$touch()
            if (this.$v.book.$invalid) {
                this.submitStatus = 'ERROR'
            } else {
                event.preventDefault();
                var app = this;
                app.book.image = app.imageSrc;

                let formData = new FormData();
                formData.append('section_id', app.book.section_id)
                formData.append('name', app.book.name)
                formData.append('author', app.book.author)
                formData.append('publishing', app.book.publishing)
                formData.append('description', app.book.description)
                formData.append('image', app.book.image)
                axios.post('/api/v1/books', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(function (resp) {
                        app.isAddBook = false

                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your book");
                    });
            }

        },
        isDelete(id) {
            this.isDelet = true;
            this.idBook = id;
        },
        deleteBook() {
            var app = this;
            axios.delete('/api/v1/books/' + app.idBook)
                .then(function (resp) {
                    // app.book.splice(index, 1);
                    app.isDelet = false;
                    alert("Книга удалена");
                })
                .catch(function (resp) {
                    alert("Could not delete company");
                });
            // console.log(id);

        }

    },

};
</script>

<style>
.select-sect {
    margin-top: 5%;
    width: 100%;
    border-bottom: solid;
}

.select-sect:focus {
    outline: none;
}
</style>
