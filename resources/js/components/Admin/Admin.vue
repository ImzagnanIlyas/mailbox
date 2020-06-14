<template>
    <v-app id="inspire">

        <v-navigation-drawer clipped v-model="drawer" app>
            <v-list rounded>

                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="title">{{ user.name }}</v-list-item-title>
                        <v-list-item-subtitle>{{ user.post }}</v-list-item-subtitle>
                    </v-list-item-content>


                </v-list-item>

                <v-divider></v-divider>

                <v-list-item color="teal" class="text-decoration-none" exact to="/admin">
                    <v-list-item-icon>
                        <v-icon>fas fa-tachometer-alt</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Dashboard</v-list-item-title>
                </v-list-item>

                <v-list-item color="teal" class="text-decoration-none" exact to="/admin/users">
                    <v-list-item-icon>
                        <v-icon>fas fa-users</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Users Management</v-list-item-title>
                </v-list-item>

                <v-list-item color="teal" class="text-decoration-none" exact to="/admin/roles">
                    <v-list-item-icon>
                        <v-icon>fas fa-lock</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Roles</v-list-item-title>
                </v-list-item>

                <v-list-item color="teal" class="text-decoration-none" exact to="/admin/permissions">
                    <v-list-item-icon>
                        <v-icon>fas fa-key</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Permissions</v-list-item-title>
                </v-list-item>

                <v-list-item color="teal" class="text-decoration-none" exact to="/admin/activities">
                    <v-list-item-icon>
                        <v-icon>fa-chart-line</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Activities</v-list-item-title>
                </v-list-item>

                <v-list-item color="teal" class="text-decoration-none" exact to="/admin/settings">
                    <v-list-item-icon>
                        <v-icon>fas fa-user-circle</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Profile</v-list-item-title>
                </v-list-item>

            </v-list>
        </v-navigation-drawer>

        <v-app-bar color="teal" dark app clipped-left>
            <v-row no-gutters>
                <v-col>
                    <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
                </v-col>

                <v-col lg="2">
                    <v-btn @click="logout" class="ma-2" outlined color="white"><v-icon>fas fa-sign-out-alt</v-icon>Log out</v-btn>
                </v-col>
            </v-row>
        </v-app-bar>

        <v-content>
            <v-container class="fill-height" fluid>
                <v-layout justify-center>
                    <v-flex shrink>
                        <router-view></router-view>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>

    </v-app>
</template>

<script>
  export default {
    // props: {
    //   source: String,
    // },
    props: ["user"],
    data: () => ({
      drawer: null,
    }),
    created () {
      this.$vuetify.theme.dark = false
    },
    methods: {
    logout() {
      axios.post("/logout").then(response => window.location.reload());
    }
    }
  }
</script>
