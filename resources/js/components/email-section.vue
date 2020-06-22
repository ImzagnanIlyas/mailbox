<template>
    <div>
        <email-list v-show="isList" @showEmail="toggle($event)"></email-list>
        <show-email v-if="!isList" :email="email" @closeEmail="isList = true"></show-email>
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
