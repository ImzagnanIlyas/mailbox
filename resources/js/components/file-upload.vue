<template>
<div>
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">

    <div class="form-row justify-content-center">
        <div class="col-10 col-sm-11">
            <v-file-input
            v-model="files"
            chips
            multiple
            counter
            show-size

            outlined
            rounded
            dense

            clear-icon="fas fa-times"
            prepend-icon="fas fa-paperclip mr-1"
            >
            </v-file-input>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            files: null,
        }
    },

    watch: {
        files: function () {
           this.$emit('updateFiles', this.files);
        }
    }
}
</script>

