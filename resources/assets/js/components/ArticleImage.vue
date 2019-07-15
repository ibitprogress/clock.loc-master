<template>
    <div id="articleImage">
        <div class="text-center">
            <img class="img-fluid mx-auto border rounded" v-if="image != ''" :src="imagePath + image" alt="Card image cap">
            <img class="img-fluid mx-auto border rounded" v-else :src="noImageUrl" alt="Card image cap">
        </div>
        <div class="form-group custom-file mt-3">
            <input type="file" class="custom-file-input btn btn-primary" id="customFile" multiple v-on:change="onImageChange">
            <label class="custom-file-label" for="customFile">Додати зображення</label>
        </div>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                image: "",
                imagePath: "/storage/logos/",
                noImageUrl: "/images/no_image.png",
                imageData: null,
            }
        },
        props:["articleImageCreateUrl", "inputImage"],
        methods: {
            onImageChange(e) {
                let file = e.target.files[0];
                let formData = new FormData();
                formData.append('image', file);
                axios.post(this.articleImageCreateUrl, formData)
                    .then(response => {
                        console.log(response.data);
                        this.image = response.data;
                        this.emitImage(this.image);
                        runToastmessage("Зображення успішно завантажені");
                    })
                    .catch(function (error) {
                        console.log(error.response.data.error);
                        runToastmessage(error.response.data.error, "error");
                    });
            },
            emitImage(image){
                this.$emit('changeImage', image);
            }
        },
        created() {
            this.image = this.inputImage;

        },
    }
</script>
<style scoped>
    #articleImage img {
    }
</style>