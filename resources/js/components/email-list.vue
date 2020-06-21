<template>
    <section class="content inbox" style="height: 87vh;overflow-y: auto;overflow-x: hidden;">
        <div class="container-fluid px-0">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card action_bar">
                        <div class="body">
                            <div class="row justify-content-between">
                                <div class="col-lg-1 col-md-2 col-3 d-flex align-items-center" style="margin-left: 12px;">
                                    <div class="custom-control custom-checkbox checkbox-lg d-flex justifu-content-center mb-1">
                                        <input v-model="isAllChecked" id="isAllChecked" type="checkbox" class="custom-control-input">
                                        <label for="isAllChecked" class="custom-control-label"></label>
                                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="bg-transparent border-0" style="margin-left: -5px;"><i class="fas fa-sort-down fa-lg text-dark"></i></button>
                                        <div aria-labelledby="dropdownMenuButton" class="dropdown-menu texte-sm">
                                            <a @click="selectAll" role="button" tabindex="0" class="dropdown-item">Tous</a>
                                            <a @click="selectRead" role="button" tabindex="0" class="dropdown-item">Lus</a>
                                            <a @click="selectUnread" role="button" tabindex="0" class="dropdown-item">Non lus</a>
                                            <a @click="selectImportant" role="button" tabindex="0" class="dropdown-item">Importants</a>
                                            <a @click="selectNotImportant" role="button" tabindex="0" class="dropdown-item">Non importants</a>
                                        </div>
                                    </div>
                                    <button @click="getResults(emails.current_page)" v-show="!edit" type="button" class="bg-transparent border-0 ml-2"><i class="fas fa-sync-alt fa-lg text-dark"></i></button>
                                    <div v-if="edit" class="d-flex bg-secondary rounded ml-2">
                                        <div class="d-flex border-right">
                                            <button @click="toggleImportant(0,!true)" type="button" class="bg-transparent border-0 p-2 ml-3"><i class="fas fa-star fa-lg text-white"></i></button>
                                            <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="bg-transparent border-0 p-2 ml-3"><i class="fas fa-tag fa-lg text-white"></i></button>
                                            <div aria-labelledby="dropdownMenuButton" class="dropdown-menu texte-sm bg-secondary">
                                                <a v-for="category in emails.data[0].user.categories" :key="category.id" @click="setCategory(category.id)" role="button" tabindex="0" class="dropdown-item dropdown-item-tag text-white"><i class="fas fa-tag text-white"></i> {{ category.title }}</a>
                                            </div>
                                            <button v-if="isAllRead" @click="setRead(0, false)" type="button" class="bg-transparent border-0 p-2 ml-3"><i class="fas fa-envelope fa-lg text-white"></i></button>
                                            <button v-else @click="setRead(0, true)" type="button" class="bg-transparent border-0 p-2 mx-3"><i class="fas fa-envelope-open-text fa-lg text-white"></i></button>
                                        </div>

                                        <button @click="setArchived" type="button" class="bg-transparent border-0 p-2 ml-2"><i class="fas fa-archive fa-lg text-white"></i></button>
                                        <button @click="setTrashed" type="button" class="bg-transparent border-0 p-2 ml-3"><i class="fas fa-trash fa-lg text-white"></i></button>
                                        <!-- <button type="button" class="bg-transparent border-0 p-2 ml-3"><i class="fas fa-ellipsis-v fa-lg text-white"></i></button> -->
                                    </div>
                                </div>
                                <div id="pagination-div" class="col-lg-3 col-md-2 col-5 d-flex justify-content-end align-items-center mr-3">
                                    <pagination :data="emails" @pagination-change-page="getResults" show-disabled :limit="1"></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="emails-list" class="row clearfix border-top" style="margin-top: -15px;">
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <ul class="mail_list list-group list-unstyled">
                        <li v-for="userEmail in emails.data" :key="userEmail.id" @click="showEmail(userEmail)" :class="[(userEmail.state == 'read' || userEmail.state == 'sent') ? 'read' : 'unread border-primary', (checkedMails.includes(userEmail.id)) ? 'bg-selected' : '']" class="list-group-item" style="cursor: pointer;">
                            <div class="media flex-wrap">
                                <div class="pull-left">
                                    <div class="controls">
                                        <div class="custom-control custom-checkbox d-flex justifu-content-center">
                                            <input :id="'CB'+userEmail.id" :value="userEmail.id" v-model="checkedMails" type="checkbox" class="custom-control-input">
                                            <label :for="'CB'+userEmail.id" class="custom-control-label"></label>
                                            <button type="button" class="bg-transparent border-0" style="margin-top: -5px;"><i @click="toggleImportant(userEmail.id, userEmail.important)" :class="userEmail.important ? 'fas' : 'far'" class="fa-star" :style="(userEmail.important) ? 'color: gold;' : 'color: gray;'"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-auto d-flex align-items-center" style="width: 13vw;">
                                    <span v-if="userEmail.state == 'draft'" class="text-danger">Brouillon</span>
                                    <span v-else-if="userEmail.state == 'sent'">À : {{ userEmail.email.receivers_names }}</span>
                                    <span v-else>{{ userEmail.sender.name }}</span>
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <a role="button" tabindex="0" class="m-r-10">{{ (userEmail.email.object) ? userEmail.email.object : '(aucun objet)' }}</a><span v-if="userEmail.category_id" class="badge bg-secondary text-white ml-1">{{ userEmail.category.title }}</span>
                                        <small class="float-right text-muted"><time class="hidden-sm-down">{{ userEmail.email.send_at_short }}</time></small>
                                    </div>
                                    <p v-if="userEmail.email.content" class="msg">{{ stripHtml(userEmail.email.content).substring(0, 100) }}<span v-show="userEmail.email.content.length > 99">...</span><i v-show="userEmail.email.files" class="fas fa-paperclip ml-3"></i></p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <edit-draft v-if="editDraft" :draft="emailClicked" @modalHidden="afterDraftEdit"></edit-draft>
    </section>
</template>

<script>
import Draft from './edit-draft.vue'
export default {
    components: {
        'edit-draft': Draft
    },
    data: function () {
        return {
            section: this.$route.path,
            emails: {},

            isAllChecked : false,
            checkedMails : [],

            edit: false,
            isAllRead : true,

            editDraft: false,
            emailClicked : {},
            editDraftKey: 0,
        }
    },

    mounted() {
        console.log('email-list component mounted.');
        console.log(this.$route);
        this.getResults();

        // if(this.$route.query.q) document.getElementById("emails-list").innerHTML = document.getElementById("emails-list").innerHTML.replace('technologie',"<span class='font-weight-bold text-primary'>"+this.$route.query.q+"</span>");
    },

    methods:{

        // get emails
        getEmails(){
            axios.get('/email')
            .then(res => {
                this.emails = res.data;
            })
            .catch(err => {
                console.error(err);
            })
        },

        // pagination function
        getResults(page = 1) {
            var url = (this.$route.query.q) ? '/email?section='+this.section+'&q='+this.$route.query.q+'&page='+page : '/email?section='+this.section+'&page='+page ;
            if (this.$route.query.q) {
                url = '/email?section='+this.section+'&q='+this.$route.query.q+'&page='+page;
            }else if(this.$route.query.c){
                url = '/email?section='+this.section+'&c='+this.$route.query.c+'&page='+page;
            }else{
                url = '/email?section='+this.section+'&page='+page;
            }
            axios.get(url)
            .then(res => {
                this.emails = res.data;
                this.endEdit();
            })
            .catch(err => {
                console.error(err);
            })
        },

        stripHtml(html){
            var tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
        },

        showEmail(userEmail){
            if (this.section == '/draft') {
                this.emailClicked = userEmail;
                this.editDraft = true;
            }else{
                if(userEmail.state == 'received') this.setRead(userEmail.id, true);
                this.$emit('showEmail', userEmail);
            }
        },

        afterDraftEdit(){
            this.editDraft = false;
            this.getResults(this.emails.current_page);
        },
        /**
        ==============================
            Select functions
        ==============================
         */

        selectAll() {
            this.checkedMails = [];
            this.isAllChecked = true;
            for (var email of this.emails.data) {
                this.checkedMails.push(email.id);
            }
        },
        selectRead(){
            var all = true;
            this.checkedMails = [];
            for (var email of this.emails.data) {
                if (email.state == 'read') {
                    this.checkedMails.push(email.id);
                }else{
                    all = false;
                }
            }
            this.isAllChecked = all;
            $('#isAllChecked').prop('indeterminate', (this.checkedMails.length) ? true : false);
        },
        selectUnread(){
            var all = true;
            this.checkedMails = [];
            for (var email of this.emails.data) {
                if (email.state == 'received') {
                    this.checkedMails.push(email.id);
                }else{
                    all = false;
                }
            }
            this.isAllChecked = all;
            $('#isAllChecked').prop('indeterminate', (this.checkedMails.length) ? true : false);
        },
        selectImportant(){
            var all = true;
            this.checkedMails = [];
            for (var email of this.emails.data) {
                if (email.important) {
                    this.checkedMails.push(email.id);
                }else{
                    all = false;
                }
            }
            this.isAllChecked = all;
            $('#isAllChecked').prop('indeterminate', (this.checkedMails.length) ? true : false);
        },
        selectNotImportant(){
            var all = true;
            this.checkedMails = [];
            for (var email of this.emails.data) {
                if (!email.important) {
                    this.checkedMails.push(email.id);
                }else{
                    all = false;
                }
            }
            this.isAllChecked = all;
            $('#isAllChecked').prop('indeterminate', (this.checkedMails.length) ? true : false);
        },

        /**
        ==============================
            Edit functions
        ==============================
        */

        toggleImportant(emailId ,state){
            emailId = emailId ? emailId : this.checkedMails; // if emailId=0 is a multiple select then array 'checkedMails' passed, else one mail are selected
            axios.put('/email/toggleImportant',{
                state: !state,
                ids: emailId
            })
            .then(res => {
                // this.emails = res.data;
                this.getResults(this.emails.current_page);
            })
            .catch(err => {
                console.error(err);
            })
            this.endEdit();
        },
        setCategory(categoryId){
            axios.put('/email/setCategory',{
                categoryId: categoryId,
                ids: this.checkedMails
            })
            .then(res => {
                // this.emails = res.data;
                this.getResults(this.emails.current_page);
            })
            .catch(err => {
                console.error(err);
            })
            this.endEdit();
        },
        setRead(emailId ,state){
            emailId = emailId ? emailId : this.checkedMails; // if emailId=0 is a multiple select then array 'checkedMails' passed, else one mail are selected
            axios.put('/email/setRead',{
                state: state,
                ids: emailId
            })
            .then(res => {
                // this.emails = res.data;
                this.getResults(this.emails.current_page);
            })
            .catch(err => {
                console.error(err);
            })
            this.endEdit();
        },
        setArchived(){
            axios.put('/email/setArchived',{
                ids: this.checkedMails
            })
            .then(res => {
                // this.emails = res.data;
                this.getResults(this.emails.current_page);
            })
            .catch(err => {
                console.error(err);
            })
            this.endEdit();
        },
        setTrashed(){
            axios.put('/email/setTrashed',{
                ids: this.checkedMails
            })
            .then(res => {
                // this.emails = res.data;
                this.getResults(this.emails.current_page);
            })
            .catch(err => {
                console.error(err);
            })
            this.endEdit();
        },
        endEdit(){
            this.isAllChecked = false;
            $('#isAllChecked').prop('indeterminate', false);
            this.checkedMails = [];
            this.edit = false;
        }



    },

    watch: {
        // à chaque fois que l'attribut checkedMails change, cette fonction s'exécutera
        checkedMails: function () {
            this.edit = (this.checkedMails.length) ? true : false;
            //this.isAllChecked = (this.checkedMails.length == this.emails.data.length) ? true : false;
            for (var email of this.emails.data) {
                //this.isAllRead = ( this.checkedMails.includes(email.id) && email.state == 'received') ? true : false;
                if (this.checkedMails.includes(email.id) && email.state == 'received') {
                    this.isAllRead = false;
                    break;
                }
                this.isAllRead = true;
            }
        },

        isAllChecked: function() {
            this.checkedMails = [];
            if (this.isAllChecked) {
                for (var email of this.emails.data) {
                    this.checkedMails.push(email.id);
                }
            }
        }
    },
}
</script>
