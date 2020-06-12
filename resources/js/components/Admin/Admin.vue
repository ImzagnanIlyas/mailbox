<template>
  <v-app id="inspire">

    <v-navigation-drawer clipped v-model="drawer" app>
      <v-list dense>
        <v-list-item exact to="/admin">
            <v-list-item-action>
                <v-icon>fas fa-tachometer-alt</v-icon>
            </v-list-item-action>
            <v-list-item-content>
                <v-list-item-title>Dashboard</v-list-item-title>
            </v-list-item-content>
        </v-list-item>

        <v-list-group no-action>
            <v-list-item slot="activator">
                <v-list-item-action>
                <v-icon>fas fa-user-circle</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                <v-list-item-title>User Management</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item to="/admin/users">
                <v-list-item-action>
                <v-icon>fas fa-user-circle</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                <v-list-item-title>Users</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item to="/admin/roles">
                <v-list-item-action>
                <v-icon>fas fa-user-circle</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                <v-list-item-title>Roles</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list-item to="/admin/permissions">
                <v-list-item-action>
                <v-icon>fas fa-user-circle</v-icon>
                </v-list-item-action>
                <v-list-item-content>
                <v-list-item-title>Permissions</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list-group>

        <v-list-item to="/admin/activities">
            <v-list-item-action>
                <v-icon>fa-chart-line</v-icon>
            </v-list-item-action>
            <v-list-item-content>
                <v-list-item-title>Activities</v-list-item-title>
            </v-list-item-content>
            </v-list-item>

            <v-list-item to="/admin/settings">
            <v-list-item-action>
                <v-icon>fa-cog</v-icon>
            </v-list-item-action>
            <v-list-item-content>
                <v-list-item-title>Settings</v-list-item-title>
            </v-list-item-content>
        </v-list-item>

      </v-list>
    </v-navigation-drawer>

    <v-app-bar app clipped-left>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>Application</v-toolbar-title>
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

    <v-footer app>
      <span>&copy; 2020</span>
    </v-footer>

  </v-app>
</template>

<script>
  export default {
    props: {
      source: String,
    },
    data: () => ({
      drawer: null,
    }),
    created () {
      this.$vuetify.theme.dark = true
    },
  }
</script>
