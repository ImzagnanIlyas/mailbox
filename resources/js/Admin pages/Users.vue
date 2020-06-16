<template>
    <div>
        <template>
        <v-data-table :headers="headers" :search="search" :items="tableData" class="elevation-1">
            <template v-slot:top>
            <v-toolbar flat color="dark">
                <v-toolbar-title>Users</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                <v-spacer></v-spacer>
                <v-dialog v-model="dialog" max-width="800px">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn :disabled="!valid2" color="primary" dark class="mb-2" v-bind="attrs" v-on="on">Add user</v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                        <v-form ref="form" v-model="valid" lazy-validation>
                        <v-container>
                            <v-row>
                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="editedItem.name" label="Name" :rules="[rules.required]" required></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                                <v-dialog ref="dialog" v-model="modal" :return-value.sync="date" persistent width="290px">
                                    <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model="editedItem.birthday" label="Birthday" readonly v-bind="attrs" v-on="on">
                                    </v-text-field>
                                    </template>
                                    <v-date-picker v-model="editedItem.birthday" scrollable>
                                    <v-spacer></v-spacer>
                                    <v-btn text color="primary" @click="modal = false">Cancel</v-btn>
                                    <v-btn text color="primary" @click="$refs.dialog.save(date)">OK</v-btn>
                                    </v-date-picker>
                                </v-dialog>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                                <v-select v-model="editedItem.gender" :items="['Homme', 'Femme']" label="Gender" data-vv-name="gender" :rules="[rules.required]" required>
                                </v-select>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="editedItem.phone" label="Phone" :rules="[rules.required, rules.phone, rules.phoneMax]" required></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="editedItem.service" label="Service" :rules="[rules.required]" required></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="editedItem.post" label="Post" :rules="[rules.required]" required></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="editedItem.email" label="Email" :rules="emailRules" required></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                                <v-text-field v-model="editedItem.password"
                                label="Password"
                                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                :rules="[rules.required, rules.min]"
                                :type="show1 ? 'text' : 'password'"
                                name="input-10-1"
                                hint="At least 8 characters"
                                @click:append="show1 = !show1"
                                required
                                ></v-text-field>
                            </v-col>

                            <v-col cols="12" sm="6" md="4">
                                <v-select
                                        v-model="editedItem.role"
                                        :items="allRoles"
                                        label="Role"
                                        item-text="name"
                                        return-object
                                        :rules="[rules.required]"
                                        required
                                ></v-select>
                            </v-col>

                            <!-- <v-flex xs12>
                                <h3>Roles and permissions</h3>

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
                                        :rules="[rules.required]"
                                        required
                                ></v-select>
                            </v-flex> -->

                            </v-row>
                            <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                            <v-btn :disabled="!valid" color="success" text @click="validate">Save</v-btn>
                        </v-container>
                        </v-form>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>

                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon small class="mr-2" @click="editItem(item)">fas fa-pencil-alt</v-icon>
                <v-icon small @click="deleteItem(item)">fas fa-trash</v-icon>
            </template>
            <template v-slot:no-data>
                <v-btn color="primary" @click="initialize">Reset</v-btn>
            </template>
        </v-data-table>
        </template>
    </div>
</template>

<script>
  export default {
    props: ["user"],
    data: () => ({
        valid: true,
        valid2: '',
        show1: false,
        rules: {
            required: value => !!value || 'Required.',
            min: v => v.length >= 2 || 'Min 2 characters',
            phoneMax: v => v.length <= 10 || 'Max 10 numbers',
            phone: v => /(06)[0-9]{8}/.test(v) || 'Phone must be valid',
        },
        emailRules: [
            v => !!v || 'E-mail is required',
            v => /.+@.+/.test(v) || 'E-mail must be valid',
        ],
        date: new Date().toISOString().substr(0, 10),
        menu: false,
        modal: false,
        menu2: false,
        dialog: false,
        search: '',
        headers: [
        { text: 'Name', value: 'name'},
        { text: 'Birthday', value: 'birthday'},
        { text: 'Gender', value: 'gender'},
        { text: 'Phone', value: 'phone'},
        { text: 'Service', value: 'service'},
        { text: 'Post', value: 'post'},
        { text: 'Email', value: 'email'},
        { text: 'Role', value: 'role.name'},
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      tableData: [],
      allRoles:[],
      allPermissions:[],
      editedIndex: -1,
      editedItem: {
        name: '',
        birthday: '',
        gender: '',
        phone: '',
        service: '',
        post: '',
        email: ''+'@wehelp.ma',
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
        service: '',
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
      role(){
        return this.user.roles[0].name;
      }
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
        // update: function() {
        //     if(this.user.roles[0].name=="admin") this.valid2 = true;
        // },
        validate () {
            this.$refs.form.validate() && this.save()
        },
        initialize () {
            if(this.user.roles[0].name=="admin"){
                this.valid2 = true;
            } else{
                this.valid2 = false;
            }
            axios.get('/api/users').then(response => {
                this.tableData = response.data.data;
            });
            axios.get('/api/roles').then(response=>this.allRoles=response.data.data);
            axios.get('/api/permissions').then(response=>this.allPermissions=response.data.data);
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
            axios.post('/api/admin/new-user',this.editedItem).then(response=>console.log(response.data));
            }
            this.close()
        },
    },
  }
</script>
