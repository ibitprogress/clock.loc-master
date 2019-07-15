<template>
    <div id="imagesForm">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile" multiple v-on:change="onImageChange">
                    <label class="custom-file-label" for="customFile">Додати зображення</label>
                </div>
            </div>
        </div>
        <div class="row">
            <template v-for="image in images">
                <div class="col-4 col-sm-3 col-lg-2 mt-5">
                        <div class="btn-group btn-block justify-content-md-center" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-success btn-sm col-4" v-if="image.uuid != logoUUID" v-on:click="setLogo(image.uuid)">
                                <i class="fas fa-star"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm col-4" v-on:click="deleteImage(image.image_id)">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    <div class="text-center mt-1">
                        <img class="img-fluid mx-auto" :src="imagesPath + image.uuid" alt="Card image cap">
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                images: this.imagesData,
                imageData: [],
                logoUUID: this.logo
            }
        },
        props:["imagesData", "logo", "updateUrl", "setLogoUrl", "imagesPath"],
        methods: {
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                for (const key of Object.keys(files)) {
                    this.createImage(files[key]);
                };
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.imageData = e.target.result;
                    vm.uploadImage();
                };
                reader.readAsDataURL(file);
            },
            uploadImage(){
                let updateUrl = this.updateUrl;
                axios.post(updateUrl, {"image": this.imageData,})
                    .then(response => {
                        this.images.push(response.data);
                        runToastmessage("Зображення успішно завантажені");
                    })
                    .catch(function (error) {
                        console.log(error.response.data.error);
                        runToastmessage(error.response.data.error, "error");
                    });
            },
            setLogo(imageUUID){
                let url = this.setLogoUrl;
                axios.post(url, {"uuid": imageUUID,})
                    .then(response => {
                        this.logoUUID = response.data.logo_uuid;
                        runToastmessage("Успішно змінений логотип товару");
                    })
                    .catch(function (error) {
                        console.log(error.response.data.error);
                        runToastmessage(error.response.data.error, "error");
                    });
            },
            deleteImage(imageId){
                let url = this.updateUrl;
                let sendData = {
                    imageId: imageId,
                    _method: "DELETE"
                    }
                axios.post(url, sendData)
                    .then(response => {
                        this.images = response.data;
                        runToastmessage("Товар успішно видалено");
                    })
                    .catch(function (error) {
                        console.log(error.response.data.error);
                        runToastmessage(error.response.data.error, "error");
                    });
            }
        }
    }
</script>
<style scoped>
    #imagesForm{
        margin-top: 1.2em;
    }
</style>