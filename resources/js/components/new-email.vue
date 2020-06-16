<template>
<div>
    <div id="newEmail" class="text-gray-400 text-uppercase px-3 px-lg-3 py-4 font-weight-bold small headings-font-family">
        <button v-b-modal.new-email-modal type="button" class="btn btn-primary shadow"><i class="fas fa-edit"></i><span id="legend" class="ml-2">Nouveau message</span></button>
    </div>

    <b-modal
        id="new-email-modal"
        size="xl"
        centered title="Nouveau message"
        header-bg-variant="primary"
        header-text-variant="light"
        header-class="py-1"
        footer-class="py-1"
        @shown="createEmail"
        @hidden="afterHidden"
    >
        <template v-slot:default="{  }">
            <b-toast
            id="draft-toast"
            toaster="b-toaster-top-center"
            no-close-button
            auto-hide-delay="2000"
            variant="secondary"
            body-class="text-center"
            >
                {{ draftToastText }}
            </b-toast>
            <b-toast
            id="send-toast"
            toaster="b-toaster-top-center"
            no-close-button
            auto-hide-delay="2000"
            variant="secondary"
            body-class="text-center"
            >
                {{ sendToastText }}
            </b-toast>
            <b-toast
            id="no-receiver-toast"
            toaster="b-toaster-top-center"
            no-close-button
            auto-hide-delay="2000"
            variant="danger"
            body-class="text-center"
            solid
            >
                Vous devez indiquer au moins un destinataire.
            </b-toast>
            <form>
                <div class="form-row p-0">
                    <label for="to" class="col-2 col-sm-1 col-form-label">À </label>
                    <div class="col-10 col-sm-11">
                        <b-form-group>
                            <b-form-tags v-model="receiversTags" class="mb-1">
                                <template v-slot="{ tags, disabled, addTag, removeTag }">
                                    <ul v-if="tags.length > 0" class="list-inline d-inline-block mb-2">
                                        <li v-for="tag in tags" :key="tag" class="list-inline-item">
                                            <b-form-tag
                                                @remove="removeOption(tag, removeTag)"
                                                :title="tag"
                                                :disabled="disabled"
                                            >
                                                {{ tag }}
                                            </b-form-tag>
                                        </li>
                                    </ul>
                                    <b-dropdown size="sm" variant="outline-secondary" block menu-class="w-100 bg-secondary text-light">
                                        <template v-slot:button-content>
                                            Rechercher un email
                                        </template>
                                        <b-dropdown-form @submit.stop.prevent="() => {}">
                                            <b-form-group
                                            label-for="tag-search-input"
                                            label="Recherche"
                                            label-cols-md="auto"
                                            class="mb-0"
                                            label-size="sm"
                                            :description="searchDesc"
                                            :disabled="disabled"
                                            >
                                                <b-form-input
                                                v-model="search"
                                                id="tag-search-input"
                                                type="search"
                                                size="sm"
                                                autocomplete="off"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-dropdown-form>
                                        <b-dropdown-divider></b-dropdown-divider>
                                        <b-dropdown-group id="dropdown-group-1" style="height: 150px; overflow: auto">
                                            <b-dropdown-item-button
                                            v-for="option in availableOptions"
                                            :key="option"
                                            @click="onOptionClick({ option, addTag })"
                                            >
                                                {{ option }}
                                            </b-dropdown-item-button>
                                        </b-dropdown-group>
                                        <b-dropdown-text v-if="availableOptions.length === 0">
                                            Aucun e-mail n'est disponible pour sélectionner
                                        </b-dropdown-text>
                                    </b-dropdown>
                                </template>
                            </b-form-tags>
                        </b-form-group>
                    </div>
                </div>
                <div class="form-row p-0">
                    <label for="cc" class="col-2 col-sm-1 col-form-label">CC</label>
                    <div class="col-10 col-sm-11">
                        <!-- <input type="email" class="form-control" id="cc" placeholder="Type email"> -->
                        <b-form-group>
                            <b-form-tags v-model="ccTags" class="mb-1">
                                <template v-slot="{ tags, disabled, addTag, removeTag }">
                                    <ul v-if="tags.length > 0" class="list-inline d-inline-block mb-2">
                                        <li v-for="tag in tags" :key="tag" class="list-inline-item">
                                            <b-form-tag
                                                @remove="removeOptionCC(tag, removeTag)"
                                                :title="tag"
                                                :disabled="disabled"
                                            >
                                                {{ tag }}
                                            </b-form-tag>
                                        </li>
                                    </ul>

                                <b-dropdown size="sm" variant="outline-secondary" block menu-class="w-100 bg-secondary text-light">
                                    <template v-slot:button-content>
                                        Rechercher un email
                                    </template>
                                    <b-dropdown-form @submit.stop.prevent="() => {}">
                                        <b-form-group
                                        label-for="tag-search-input"
                                        label="Recherche"
                                        label-cols-md="auto"
                                        class="mb-0"
                                        label-size="sm"
                                        :description="searchDescCC"
                                        :disabled="disabled"
                                        >
                                            <b-form-input
                                            v-model="searchCC"
                                            id="tag-search-input"
                                            type="search"
                                            size="sm"
                                            autocomplete="off"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-dropdown-form>
                                    <b-dropdown-divider></b-dropdown-divider>
                                    <b-dropdown-group id="dropdown-group-1" style="height: 150px; overflow: auto">
                                        <b-dropdown-item-button
                                        v-for="option in availableOptionsCC"
                                        :key="option"
                                        @click="onOptionClickCC({ option, addTag })"
                                        >
                                            {{ option }}
                                        </b-dropdown-item-button>
                                    </b-dropdown-group>
                                    <b-dropdown-text v-if="availableOptionsCC.length === 0">
                                        Aucun e-mail n'est disponible pour sélectionner
                                    </b-dropdown-text>
                                </b-dropdown>
                                </template>
                            </b-form-tags>
                        </b-form-group>
                    </div>
                </div>
                <div class="form-row mb-4">
                    <label for="object" class="col-2 col-sm-1 col-form-label">Objet </label>
                    <div class="col-10 col-sm-11">
                        <input v-model="object" type="text" class="form-control" id="object">
                    </div>
                </div>
                <vue-editor id="store" v-model="content" style="max-height: 300px; overflow: auto"/>
                <file-upload @updateFiles="files = $event"></file-upload>
                <small>Les attachements ne sont pas sauvegardés avec le brouillon</small>
            </form>
        </template>

        <template v-slot:modal-footer="{  }">
            <div class="w-100 d-flex justify-content-between">
                <button @click="sendEmail" type="button" class="btn btn-primary shadow"><i class="fas fa-paper-plane text-light"></i><span class="ml-2">Envoyer</span></button>
                <button @click="deleteDraft" type="button" class="bg-transparent border-0 p-2 ml-2"><i class="fas fa-trash fa-lg text-dark"></i></button>
            </div>
        </template>
    </b-modal>

</div>
</template>

<script>
import fileUpload from './file-upload.vue'
export default {
    components: {
        'file-upload': fileUpload
    },
    data() {
        return {
            options: [],
            ids: [],

            search: '',
            receiversTags: [],
            receivers: [],

            searchCC: '',
            ccTags: [],
            cc: [],

            object: "",
            content: "",
            files: [],

            email: {},
            user_email: {},

            draftToastText: "Enregistrement en cours ...",
            sendToastText: "Envoi en cours ...",
        }
    },

    mounted() {
        console.log('new-email component mounted.')
        this.getOptions()
    },

    methods:{
        onOptionClick({ option, addTag }) {
            addTag(option)
            this.search = ''
            this.receivers.push(this.ids[this.options.indexOf(option)]);
        },
        removeOption(tag, removeTag){
            this.receivers.splice(this.receiversTags.indexOf(tag),1);
            removeTag(tag);
        },

        onOptionClickCC({ option, addTag }) {
            addTag(option)
            this.search = ''
            this.cc.push(this.ids[this.options.indexOf(option)]);
        },
        removeOptionCC(tag, removeTag){
            this.cc.splice(this.ccTags.indexOf(tag),1);
            removeTag(tag);
        },

        getOptions(){
            axios.get('/new-email')
            .then(res => {
                for (var user of res.data) {
                    this.options.push(user.name+' - '+user.email);
                    this.ids.push(user.id);
                }
            })
            .catch(err => {
                console.error(err);
            })
        },

        createEmail(){
            axios.post('/new-email')
            .then(res => {
                this.email = res.data[0];
                this.user_email = res.data[1];
            })
            .catch(err => {
                console.error(err);
            })
        },

        updateEmail(){
            this.$bvToast.show('draft-toast');
            setTimeout(function(){ this.draftToastText = "Brouillon enregistré" }.bind(this), 1000);
            setTimeout(function(){ this.draftToastText = "Enregistrement en cours ..." }.bind(this), 3000);

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            }

            let formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('fonction', 'draft');
            // formData.append('receivers', this.receivers);
            for( var i = 0; i < this.receivers.length; i++ ){
                let x = this.receivers[i];
                formData.append('receivers[' + i + ']', x);
            }
            //formData.append('cc', this.cc);
            for( var i = 0; i < this.cc.length; i++ ){
                let x = this.cc[i];
                formData.append('cc[' + i + ']', x);
            }
            formData.append('object', this.object);
            formData.append('content', this.content);

            // for( var i = 0; i < this.files.length; i++ ){
            //     let x = this.files[i];
            //     console.log(x);
            //     formData.append('attachments[' + i + ']', x);
            // }


            axios.post('/new-email/'+this.email.id, formData, config)
            .then(res => {
                this.email = res.data;
            })
            .catch(err => {
                console.error(err);
            })
        },

        sendEmail(){
            if (this.receivers.length == 0 && this.cc.length == 0) {
                this.$bvToast.show('no-receiver-toast');
                return 0;
            }
            // this.draftToastText = "Envoi en cours ..."
            this.$bvToast.show('send-toast');
            setTimeout(function(){ this.sendToastText = "Email envoyé" }.bind(this), 1000);

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            }

            let formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('fonction', 'send');
            formData.append('user_email', this.user_email.id);

            // formData.append('receivers', this.receivers);
            for( var i = 0; i < this.receivers.length; i++ ){
                let x = this.receivers[i];
                formData.append('receivers[' + i + ']', x);
            }
            //formData.append('cc', this.cc);
            for( var i = 0; i < this.cc.length; i++ ){
                let x = this.cc[i];
                formData.append('cc[' + i + ']', x);
            }
            formData.append('object', this.object);
            formData.append('content', this.content);
            for( var i = 0; i < this.files.length; i++ ){
                let x = this.files[i];
                // console.log(x);
                formData.append('attachments[' + i + ']', x);
            }


            axios.post('/new-email/'+this.email.id, formData, config)
            .then(res => {
                console.log(res.data);
            })
            .catch(err => {
                console.error(err);
            })

            setTimeout(function(){ this.$bvModal.hide('new-email-modal') }.bind(this), 2000);
        },

        deleteDraft(){
            axios.delete('/new-email/'+this.user_email.id)
            .then(res => {
                console.log(res.data)
            })
            .catch(err => {
                console.error(err);
            })
            this.$bvModal.hide('new-email-modal')
        },

        afterHidden(){
            $('#render').click();
        },


    },

    computed: {
        criteria() {
            // Compute the search criteria
            return this.search.trim().toLowerCase()
        },
        availableOptions() {
            const criteria = this.criteria
            // Filter out already selected options
            var options = this.options.filter(opt => this.receiversTags.indexOf(opt) === -1)
            options = options.filter(opt => this.ccTags.indexOf(opt) === -1)
            if (criteria) {
            // Show only options that match criteria
            return options.filter(opt => opt.toLowerCase().indexOf(criteria) > -1);
            }
            // Show all options available
            return options
        },
        searchDesc() {
            if (this.criteria && this.availableOptions.length === 0) {
            return 'Aucun e-mail ne correspond à vos critères de recherche'
            }
            return ''
        },

        criteriaCC() {
            // Compute the search criteria
            return this.searchCC.trim().toLowerCase()
        },
        availableOptionsCC() {
            const criteria = this.criteriaCC
            // Filter out already selected options
            var options = this.options.filter(opt => this.ccTags.indexOf(opt) === -1)
            options = options.filter(opt => this.receiversTags.indexOf(opt) === -1)
            if (criteria) {
            // Show only options that match criteria
            return options.filter(opt => opt.toLowerCase().indexOf(criteria) > -1);
            }
            // Show all options available
            return options
        },
        searchDescCC() {
            if (this.criteriaCC && this.availableOptionsCC.length === 0) {
            return 'Aucun e-mail ne correspond à vos critères de recherche'
            }
            return ''
        },
    },

    watch: {
        receivers: function() {
            setTimeout(function(){ this.updateEmail() }.bind(this), 3000);
        },
        cc: function() {
            setTimeout(function(){ this.updateEmail() }.bind(this), 3000);
        },
        object: function() {
            setTimeout(function(){ this.updateEmail() }.bind(this), 3000);
        },
        content: function() {
            setTimeout(function(){ this.updateEmail() }.bind(this), 3000);
        },
        files: function() {
           setTimeout(function(){ this.updateEmail() }.bind(this), 3000);
        },
    },
}
</script>

<style scoped>
    .col,
.col-1,
.col-2,
.col-3,
.col-4,
.col-5,
.col-6,
.col-7,
.col-8,
.col-9,
.col-10,
.col-11,
.col-12,
.col-auto,
.col-lg,
.col-lg-1,
.col-lg-2,
.col-lg-3,
.col-lg-4,
.col-lg-5,
.col-lg-6,
.col-lg-7,
.col-lg-8,
.col-lg-9,
.col-lg-10,
.col-lg-11,
.col-lg-12,
.col-lg-auto,
.col-md,
.col-md-1,
.col-md-2,
.col-md-3,
.col-md-4,
.col-md-5,
.col-md-6,
.col-md-7,
.col-md-8,
.col-md-9,
.col-md-10,
.col-md-11,
.col-md-12,
.col-md-auto,
.col-sm,
.col-sm-1,
.col-sm-2,
.col-sm-3,
.col-sm-4,
.col-sm-5,
.col-sm-6,
.col-sm-7,
.col-sm-8,
.col-sm-9,
.col-sm-10,
.col-sm-11,
.col-sm-12,
.col-sm-auto,
.col-xl,
.col-xl-1,
.col-xl-2,
.col-xl-3,
.col-xl-4,
.col-xl-5,
.col-xl-6,
.col-xl-7,
.col-xl-8,
.col-xl-9,
.col-xl-10,
.col-xl-11,
.col-xl-12,
.col-xl-auto {
 width:100%;
 padding:0px;
}
</style>



