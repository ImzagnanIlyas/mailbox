<template>
    <div class="container">
        <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
        <v-card class="mx-auto " >
            <v-card-title>
                <v-col cols="10">
                    {{email.email.object}}
                </v-col>

                <v-col >
                        - {{email.email.send_at_short}}
                </v-col>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="10">
                        <p>{{email.sender.name}} - {{email.sender.email}}</p>

                    </v-col>


                    <v-col cols="2">
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
                <hr>
                <v-row>
                    <div class="container">
                        <span v-html="email.email.content"></span>
                    </div>
                </v-row>
                <hr>
                <v-row>
                    <v-col>
                        <v-file-input v-model="email.email.files" disabled outlined chips show-size multiple
                        label="Fichiers attachés" placeholder="Pas de fichiers attachés"
                        ></v-file-input>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-btn class="ma-2" outlined color="success">
                    <v-icon small left>fas fa-reply</v-icon> Répondre
                </v-btn>&emsp;
                <v-btn class="ma-2" outlined color="success">
                    <v-icon small left>fas fa-share</v-icon> Transférer
                </v-btn>
            </v-card-actions>
        </v-card>


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
    created(){

    }
}
</script>
