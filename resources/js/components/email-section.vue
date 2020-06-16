<template>
    <div>
        <email-list v-if="isList" @showEmail="toggle($event)"></email-list>
        <show-email v-else :email="email"></show-email>
    </div>
</template>

<script>
export default {
    data(){
        return {
            isList: true,
            email: null,
        }
    },

    mounted() {
        console.log('section component mounted.')
    },

    methods: {
        toggle(userEmail){
            this.email = userEmail;
            this.isList = false;
        }
    },
}
</script>
