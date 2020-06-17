<template>
    <div class="container">
        <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
        <v-card class="mx-auto">
            <v-card-title>
                <v-col cols="7" class="font-weight-black">
                    {{email.email.object}}
                </v-col>

                <v-col class="text-right text-sm">
                    {{email.email.send_at_full}}
                </v-col>
            </v-card-title>
            <v-card-text>
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
                        <!-- <span v-html="email.email.content"></span> -->
                        <vue-editor v-model="content" disabled :editorOptions="editorSettings" class="text-dark"/>
                    </div>
                </v-row>
                <v-row>
                    <v-col v-for="file in files" :key="file.name" cols="auto">
                        <v-card hover shaped width="350px" @click="download(file.path)">
                            <v-row justify="start">
                                <v-col cols="auto ml-4">
                                    <div :class="'fi fi-'+file.type">
                                        <div class="fi-content">{{file.type}}</div>
                                    </div>
                                </v-col>
                                <v-col cols="8" style="margin-left: -25px">
                                    <v-card-title class="pt-0">{{file.name}}</v-card-title>
                                    <v-card-subtitle class="pb-0">{{formatBytes(file.size)}}</v-card-subtitle>
                                </v-col>
                                <v-icon>fas fa-download</v-icon>
                            </v-row>
                        </v-card>
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
import {Vue2Editor, Quill} from "vue2-editor";
export default {
    props: {
        email: Object,
    },
    data() {
        return {
            content: '',
            files: JSON.parse(this.email.email.files),
            editorSettings: {
                modules: {
                    "toolbar": false
                }
            }
        }
    },
    created(){

    },
    mounted() {
        console.log('show-email component mounted.');
        this.content = this.email.email.content;
    },
    methods: {
        download(path){
            window.open('show-email/'+btoa(path), "_self");
        },
        formatBytes(a,b=2){
            if(0===a)return"0 Bytes";
            const c=0>b?0:b,d=Math.floor(Math.log(a)/Math.log(1024));
            return parseFloat((a/Math.pow(1024,d)).toFixed(c))+" "+["Bytes","KB","MB","GB","TB","PB","EB","ZB","YB"][d]
        }
    },
    computed: {

    }
}
</script>
