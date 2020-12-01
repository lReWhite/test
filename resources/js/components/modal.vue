<template>
<v-row justify="center">
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

                                <select v-model="book.section_id " class="select-sect">
                                    <option value="" disabled hidden>Выберите категорию</option>
                                    <option v-for="(item,i) in sections" :key="i" :value="item.id">
                                        {{item.name}}
                                    </option>
                                </select>
                            </v-row>
                        </v-col>
                        <v-col>
                            <!-- <v-text-field label="sas" v-model="book.imgSrc"></v-text-field> -->
                            <v-text-field label="Название" v-model="book.name"></v-text-field>
                            <v-text-field label="Автор" v-model="book.author"></v-text-field>
                            <v-menu v-model="menu2" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="290px">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model="book.publishing" label="Picker without buttons" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                                </template>
                                <v-date-picker v-model="book.publishing" @input="menu2 = false"></v-date-picker>
                            </v-menu>
                            <v-textarea color="teal" v-model="book.description">
                                <template v-slot:label>
                                    <div>
                                        Описание <small>(optional)</small>
                                    </div>
                                </template>
                            </v-textarea>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" @click="isAddBook = false">
                        Отмена
                    </v-btn>
                    <v-btn color="green darken-1" @click="saveForm()">
                        Добавить
                    </v-btn>
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
                        <v-col>
                            <v-text-field label="Название" v-model="section.name"></v-text-field>
                            <v-textarea color="teal" v-model="section.description">
                                <template v-slot:label>
                                    <div>
                                        Описание <small>(optional)</small>
                                    </div>
                                </template>
                            </v-textarea>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" @click="isAddSection = false">
                        Отмена
                    </v-btn>
                    <v-btn color="green darken-1" @click="saveFormSection()">
                        Добавить
                    </v-btn>
                </v-card-actions>
            </form>
        </v-card>
    </v-dialog>
</v-row>
</template>

<script>
import Content from '../pages/content';
export default {

    data: () => ({
        sections: [],
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
        defaultSrc: 'https://png.pngtree.com/png-clipart/20190118/ourlarge/pngtree-book-hand-drawn-book-five-books-open-png-image_447137.jpg',
    }),

    watch: {
        isAddBook: function () {
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
    },
    methods: {

        handleFileUpload() {
            this.imageSrc = this.$refs.file.files[0];
        },

        saveFormSection() {
            event.preventDefault();
            var app = this;
            var newSection = app.section;
            axios.post('/api/v1/section', newSection)
                .then(function (resp) {
                    app.isAddSection = false
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not create your company");
                });
        },

        saveForm() {
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
