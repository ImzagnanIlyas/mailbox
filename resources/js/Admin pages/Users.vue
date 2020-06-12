<template>
    <div>
        <!-- <v-toolbar dark flat color="grey-lighten">
            <v-toolbar-title>Users</v-toolbar-title>
            <v-divider
                    class="mx-2"
                    inset
                    vertical
            ></v-divider>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="700px">
                <v-btn slot="activator" color="primary" dark class="mb-2">New Item</v-btn>
                <template v-slot:activator="{ on }"><v-btn v-on="on" color="primary" dark class="mb-2">New</v-btn></template>
                <v-card>
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 >
                                    <v-text-field v-model="editedItem.name" label="Name"></v-text-field>
                                </v-flex>
                                <v-flex xs12 >
                                    <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
                                </v-flex>

                                <v-flex xs12 >
                                    <v-text-field v-model="editedItem.password" label="password"></v-text-field>
                                </v-flex>

                                <v-flex xs12>
                                    <h3>Roles</h3>
                                    <v-select
                                            v-model="editedItem.role"
                                            :items="allRoles"
                                            label="Roles"
                                            item-text="name"
                                            return-object
                                            chips
                                    ></v-select>
                                </v-flex>

                                <v-flex xs12>
                                    <v-select
                                            v-model="editedItem.permissions"
                                            :items="allPermissions"
                                            label="Permissions"
                                            item-text="name"
                                            return-object
                                            multiple
                                            chips
                                    ></v-select>
                                </v-flex>

                            </v-layout>
                        </v-container>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                        <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar> -->

        <template>
        <v-data-table
            :headers="headers"
            :items="tableData"
            class="elevation-1"
        >
            <template v-slot:top>
            <v-toolbar flat color="dark">
                <v-toolbar-title>Users</v-toolbar-title>
                <v-divider
                class="mx-4"
                inset
                vertical
                ></v-divider>
                <v-spacer></v-spacer>
                <v-dialog v-model="dialog" max-width="800px">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                    color="primary"
                    dark
                    class="mb-2"
                    v-bind="attrs"
                    v-on="on"
                    >New Item</v-btn>
                </template>
                <v-card>
                    <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                    <v-container>
                        <v-row>
                        <v-col cols="12" sm="6" md="4">
                            <v-text-field v-model="editedItem.name" label="Name"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                            <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                            <v-text-field v-model="editedItem.post" label="Post"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                            <v-text-field v-model="editedItem.type" label="Type"></v-text-field>
                        </v-col>
                        <v-col cols="12" sm="6" md="4">
                            <v-text-field v-model="editedItem.password" label="Password"></v-text-field>
                        </v-col>

                        <v-flex xs12>
                            <h3>Roles and permissions</h3>
                            <v-select
                                    v-model="editedItem.role"
                                    :items="allRoles"
                                    label="Roles"
                                    item-text="name"
                                    return-object
                                    chips
                            ></v-select>
                        </v-flex>

                        <v-flex xs12>
                            <v-select
                                    v-model="editedItem.permissions"
                                    :items="allPermissions"
                                    label="Permissions"
                                    item-text="name"
                                    return-object
                                    multiple
                                    chips
                            ></v-select>
                        </v-flex>

                        </v-row>
                    </v-container>
                    </v-card-text>

                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                    </v-card-actions>
                </v-card>
                </v-dialog>
            </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
            <v-icon
                small
                class="mr-2"
                @click="editItem(item)"
            >
                fas fa-pencil-alt
            </v-icon>
            <v-icon
                small
                @click="deleteItem(item)"
            >
                fas fa-trash
            </v-icon>
            </template>
            <template v-slot:no-data>
            <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>
        </v-data-table>
        </template>

        <!-- <ul>
            <li v-for="user in tableData">
                {{ user.name }}
                {{Date(user.created_at)}}
                <v-icon small class="mr-2" @click="editItem(user)">
                    fas fa-pencil-alt
                </v-icon>
            </li>

        </ul> -->

        <!-- <v-data-table :headers="headers" :items="tableData" class="elevation-1">
            <template slot="items" slot-scope="props">
                <td>{{ props.item.name }}</td>
                <td class="text-xs-right">{{ props.item.email }}</td>
                <td class="text-xs-right" v-if="props.item.role.name">{{ props.item.role.name }}</td>
                <td class="text-xs-right" v-else>n/a</td>
                <td class="text-xs-right">{{ props.item.created_at }}</td>
                <td class="justify-center layout px-0">
                    <v-icon small class="mr-2" @click="editItem(props.item)">
                        fas fa-user-circle
                    </v-icon>
                    <v-icon small @click="deleteItem(props.item)">
                        fas fa-user-circle
                    </v-icon>
                </td>
            </template>
            <template slot="no-data">
                <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>
        </v-data-table> -->
    </div>
</template>

<script>
//   export default {
//     data: () => ({
//       dialog: false,
//       headers: [
//         {text: 'Name', value: 'name'},
        // {text: 'Birthday', value: 'birthday'},
        // {text: 'Gender', value: 'gender'},
        // {text: 'Phone', value: 'phone'},
        // {text: 'Type', value: 'type'},
        // {text: 'Post', value: 'post'},
        // {text: 'Email', value: 'email'},
        // {text: 'Role', value: 'role.name'},
        // {text: 'Created at', value: 'created_at'},
        // {text: 'Actions', value: '', sortable: false},
//       ],
//       tableData: [],
//       editedIndex: -1,
//       allRoles:[],
//       allPermissions:[],
//       editedItem: {
        // name: '',
        // birthday: '',
        // gender: '',
        // phone: '',
        // type: '',
        // post: '',
        // email: '',
        // password: '',
        // role:{},
        // permissions:[],
        // created_at: '',
//       },
//       defaultItem: {
//         name: '',
//         birthday: '',
//         gender: '',
//         phone: '',
//         type: '',
//         post: '',
//         email: '',
//         password: '',
//         role:{},
//         permissions:[],
//         created_at: '',
//       },
//     }),
//     computed: {
//       formTitle() {
//         return this.editedIndex === -1 ? 'New Item' : 'Edit Item';
//       },
//     },
//     watch: {
//       dialog(val) {
//         val || this.close();
//       },
//     },
//     created() {
//       this.initialize();
//     },
//     methods: {
//       initialize() {
        // axios.get('/api/users').then(response => {
        //   this.tableData = response.data.data;
        // });
//         // axios.get('/api/roles').then(response=>this.allRoles=response.data.data);
//         // axios.get('/api/permissions').then(response=>this.allPermissions=response.data.data);
//       },
//       editItem(item) {
//         this.editedIndex = this.tableData.indexOf(item);
//         this.editedItem = Object.assign({}, item);
//         this.dialog = true;
//       },
//       deleteItem(item) {
//         const index = this.tableData.indexOf(item);
//         confirm('Are you sure you want to delete this item?') && this.tableData.splice(index, 1);
//         axios.delete('/api/users/'+item.id).then(response=>console.log(response.data))
//       },
//       close() {
//         this.dialog = false;
//         setTimeout(() => {
//           this.editedItem = Object.assign({}, this.defaultItem);
//           this.editedIndex = -1;
//         }, 300);
//       },
//       save() {
//         if (this.editedIndex > -1) {
//           Object.assign(this.tableData[this.editedIndex], this.editedItem);
//           axios.put('/api/users/'+this.editedItem.id,this.editedItem).then(response=>console.log(response.data));
//         } else {
//           this.tableData.push(this.editedItem);
//           axios.post('api/users',this.editedItem).then(response=>console.log(response.data));
//         }
//         this.close();
//       },
//     },
//   };



  export default {
    data: () => ({
      dialog: false,
      headers: [
        { text: 'Name', value: 'name'},
        { text: 'Birthday', value: 'birthday'},
        { text: 'Gender', value: 'gender'},
        { text: 'Phone', value: 'phone'},
        { text: 'Type', value: 'type'},
        { text: 'Post', value: 'post'},
        { text: 'Email', value: 'email'},
        { text: 'Role', value: 'role.name'},
        { text: 'Created at', value: 'created_at'},
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      tableData: [],
      editedIndex: -1,
      editedItem: {
        name: '',
        birthday: '',
        gender: '',
        phone: '',
        type: '',
        post: '',
        email: '',
        password: '',
        role:{},
        permissions:[],
        created_at: '',
      },
      defaultItem: {
        name: '',
        birthday: '',
        gender: '',
        phone: '',
        type: '',
        post: '',
        email: '',
        password: '',
        role:{},
        permissions:[],
        created_at: '',
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
        axios.get('/api/users').then(response => {
            this.tableData = response.data.data;
        });
      },

      editItem (item) {
        this.editedIndex = this.tableData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        const index = this.tableData.indexOf(item)
        confirm('Are you sure you want to delete this item?') && this.tableData.splice(index, 1);
        axios.delete('/api/users/'+item.id).then(response=>console.log(response.data));
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.tableData[this.editedIndex], this.editedItem);
          axios.put('/api/users/'+this.editedItem.id,this.editedItem).then(response=>console.log(response.data));
        } else {
          this.tableData.push(this.editedItem);
          axios.post('api/users',this.editedItem).then(response=>console.log(response.data));
        }
        this.close()
      },
    },
  }


</script>
