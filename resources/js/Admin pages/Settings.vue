<template>
    <div>
        <v-card>
            <v-card-title>
                <span class="headline">My profile</span>
            </v-card-title>
            <v-card-text>
                <v-form>
                    <v-container>
                    <v-row>
                        <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="user.name"
                            label="Name"
                            outlined
                            shaped
                        ></v-text-field>
                        </v-col>

                        <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="user.birthday"
                            label="Birthday"
                            outlined
                            shaped
                        ></v-text-field>
                        </v-col>

                        <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="user.email"
                            label="E-mail"
                            outlined
                            shaped
                        ></v-text-field>
                        </v-col>

                        <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="user.gender"
                            label="Gender"
                            outlined
                            shaped
                        ></v-text-field>
                        </v-col>

                        <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="user.phone"
                            label="Phone"
                            outlined
                            shaped
                        ></v-text-field>
                        </v-col>

                        <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="user.post"
                            label="Post"
                            outlined
                            shaped
                        ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="user.service"
                            label="Service"
                            outlined
                            shaped
                        ></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="user.roles[0].name"
                            label="Role"
                            outlined
                            shaped
                        ></v-text-field>
                        </v-col>
                    </v-row>
                    </v-container>
                </v-form>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
    export default {
        props: ["user"],
        data: () => ({

        }),
    };
</script>

