<template>
    <div>
        <form method="POST" id="articleForm" action="/admin/articles-detail">
            <input type="hidden" name="_token" :value="csrf">
            <input type="hidden" name="article_id" value="1">
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="language">Мова</label>
                            <select id="language" class="form-control" v-model="language">
                                <option value="uk" selected>Українська</option>
                                <option value="ru">Російська</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="publish" v-model="publish">
                                <label class="form-check-label" for="publish">
                                    Публікувати
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 offset-2">
                        <article-image v-bind:article-image-create-url="articleImageCreateUrl"
                                       v-bind:input-image="image"
                                       v-on:changeImage="image = $event">
                        </article-image>
                    </div>
                </div>
            </div>
            <div class="form-group col-12">
                <label for="name">Назва статті</label>
                <input id="name" type="text" class="form-control" name="name" v-model="name" @input="createSlug(name)">
            </div>

            <div class="form-group col-12">
                <label for="slug">URL сторінки</label>
                <input id="slug" type="text" class="form-control" name="slug" v-model="slug" disabled>
            </div>

            <div class="form-group col-12">
                <label for="previewText">Короткий опис статті</label>
                <textarea id="previewText" class="form-control" name="previewText" rows="5" v-model="previewText"></textarea>
            </div>

            <div class="form-group col-12">
                <textarea id="text-editor" name="content" class="form-control" v-model="detailText"></textarea>
            </div>

            <div class="form-row my-3 col-6">
                <div class="col">
                    <button type="submit" class="btn btn-primary w-100" v-if="update == false">Створити</button>
                </div>
                <div class="col">
                    <button class="btn btn-success w-100" v-if="update == true">Редагувати</button>
                </div>
                <div class="col">
                    <button class="btn btn-danger w-100" v-if="update == true">Видалити</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                update: false,
                articleId: null,
                name: null,
                slug: null,
                language: "uk",
                publish: false,
                previewText: "",
                detailText: "",
                image: "",
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        props: ["articleData", "updateUrl", "imagePath", "articleCreateUrl", "articleDetailCreateUrl", "articleImageCreateUrl"],
        methods: {
            createSlug(name){
                this.slug = url_slug(name);
            },
            sendUpdate: function () {
                let updateUrl = this.updateUrl;
                axios({
                    method: 'post',
                    url: updateUrl,
                    data: {
                        _method: 'PUT',
                        articleId: this.articleId,
                        name: this.name,
                        slug: this.slug,
                        image: this.image,
                        language: this.language,
                        publish: this.publish,
                        detailText: this.detailText,
                    }
                })
                    .then(response => {
                        if (response.data.length != 0) {
                            let resetData = response.data;
                            this.resetData(resetData);
                            runToastmessage("Зміни успішно внесені в базу даних");
                        };

                    })
                    .catch(function (error) {
                        let errors = error.response.data.errors;
                        console.log(errors)
                        for (let key in errors) {
                            runToastmessage(errors[key][0], "error");
                        }
                    });
            },
            showDeleteModal: function () {
                $('#deleteModal').modal('show');
            },
            sendDestroy: function () {
                $('#deleteModal').modal('hide');
                let destroyUrl = this.updateUrl;
                axios({
                    method: 'post',
                    url: destroyUrl,
                    data: {
                        _method: 'DELETE',
                    }
                })
                    .then(response => {
                        if (response.data.length != 0) {
                            window.location.href = "/admin/clocks"
                        };

                    })
                    .catch(function (error) {
                        let errors = error.response.data.errors;
                        console.log(errors)
                        runToastmessage("Невідома помилка", "error");
                    });

            },
            resetData: function (data) {
                if (data !== undefined) {
                    this.update = true;
                    this.articleId = data.article_id;
                    this.name = data.name;
                    this.slug = data.slug;
                    this.image = data.image;
                    this.language = data.language;
                    this.publish = data.publish;
                    this.detailText = data.detail_text;
                };
            },
        },
        created() {
            let data = this.articleData
            this.resetData(data);

        },
        mounted() {
            //CKEditor
            var self = this;
            CKEDITOR.replace('content', {
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=' + this.csrf,
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token=' + this.csrf,
                on: {
                    'change': function (event) {
                        self.detailText = event.editor.getData();
                        self.updateContent = true;
                    }
                }
            }).setData(self.detailText);
        }


    }
</script>

<style scoped>
    form {
        margin-top: 1.2em;
    }
</style>
