<template>
    <div>
        <h2>Emails</h2>
        <v-card class="mx-auto">
            <v-card-title>
                <v-col cols="12" class="font-weight-black">
                    Nombre d'emails envoyés: {{mailsnumber}}
                </v-col>
            </v-card-title>
            <!-- <v-card-text>
                <v-row>
                    <v-col cols="10">
                        <p>{{email.sender.name}} - {{email.sender.email}}</p>
                    </v-col>

                    <v-col cols="2" class="text-right">
                        <v-btn icon color="indigo" fab x-small>
                            <v-icon>far fa-star</v-icon>
                        </v-btn>
                        <v-btn icon color="indigo" fab x-small>
                            <v-icon>fas fa-reply</v-icon>
                        </v-btn>
                        <v-btn icon color="indigo" fab x-small>
                            <v-icon>fas fa-ellipsis-v</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
                <v-row>
                    <div class="container">

                    </div>
                </v-row>
            </v-card-text> -->
        </v-card>
        <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
        <v-data-table :headers="headers" :search="search" :items="Object.values(mails)" class="elevation-1">
        </v-data-table>

    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                mails: [],
                search: '',
                headers: [
                    { text: 'ID', value: 'id'},
                    { text: 'User ID', value: 'user_id'},
                    { text: 'Email ID', value: 'email_id'},
                    { text: 'Important', value: 'important'},
                    { text: 'Archived', value: 'archived'},
                    { text: 'Trashed', value: 'trashed'},
                    { text: 'Deleted', value: 'deleted'},
                    { text: 'Sender', value: 'sender.name'},
                    { text: 'Sender phone', value: 'sender.phone'},
                    { text: 'Sender post', value: 'sender.post'},
                ],
            }
        },

        created () {
            this.initialize()
        },
        computed: {
            mailsnumber(){
                let count = 0;
                for (var c in this.mails) {
                    count = count + 1;
                }
                return count;
                // return this.mails.length;
            }
        },
        methods: {
            initialize () {
                axios.get('/api/admin/emails').then(response => {
                    this.mails = response.data;
                });

            }
        }
    }
</script>

<style scoped>
</style>
