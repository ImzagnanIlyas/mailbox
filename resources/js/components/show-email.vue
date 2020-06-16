<template>
    <div>
        <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">

        {{ email }}
    </div>
</template>

<script>
export default {
    props: {
        email: Object,
    },
    data() {
        return {

        }
    },
    mounted() {
        console.log('show-email component mounted.')
    },
}
</script>
