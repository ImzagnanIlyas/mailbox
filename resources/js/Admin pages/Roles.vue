<template>
    <div>
        <v-toolbar  flat color="grey-lighten">
            <v-toolbar-title>Roles</v-toolbar-title>
            <v-divider
                    class="mx-2"
                    inset
                    vertical
            ></v-divider>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="700px">
                <template v-slot:activator="{ on, attrs }">
                        <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">New Item</v-btn>
                </template>

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
                        <v-btn color="blue" dark @click="close">Cancel</v-btn>
                        <v-btn color="blue" dark @click="save">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar>
        <v-data-table :headers="headers" :items="tableData" class="elevation-1">
            <template v-slot:item.actions="{ item }">
                <v-icon small class="mr-2" @click="editItem(item)">fas fa-pencil-alt</v-icon>
                <v-icon small @click="deleteItem(item)">fas fa-trash</v-icon>
            </template>
        </v-data-table>

        <!-- <v-data-table
                :headers="headers"
                :items="tableData"
                class="elevation-1"
        >
            <template slot="items" slot-scope="props">
                <td>{{ props.item.name }}</td>
                <td style="width: 40%" v-if="props.item.permissions">
                    <v-chip
                            small
                            v-for="(permission,index) in props.item.permissions"
                            color="primary" text-color="white"
                            :key="index"
                    >
                        {{permission.name}}
                    </v-chip>
                </td>
                <td v-else>n/a</td>
                <td class="justify-center layout px-0">
                    <v-icon
                            small
                            class="mr-2"
                            @click="editItem(props.item)"
                    >
                        edit
                    </v-icon>
                    <v-icon
                            small
                            @click="deleteItem(props.item)"
                    >
                        delete
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
  export default {
    data: () => ({
      dialog: false,
      headers: [
        {text: 'Name', value: 'name'},
        {text: 'Guard name', value: 'guard_name'},
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      tableData: [],
      editedIndex: -1,
      allPermissions:[],
      editedItem: {
        name: '',
        created_at: '',
      },
      defaultItem: {
        name: '',
        created_at: '',
      },
    }),
    computed: {
      formTitle() {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item';
      },
    },
    watch: {
      dialog(val) {
        val || this.close();
      },
    },
    created() {
      this.initialize();
    },
    methods: {
      initialize() {
        axios.get('/api/roles').then(response => {
          this.tableData = response.data.data;
        });
        axios.get('/api/permissions').then(response=>this.allPermissions=response.data.data);
      },
      editItem(item) {
        this.editedIndex = this.tableData.indexOf(item);
        this.editedItem = Object.assign({}, item);
        this.dialog = true;
      },
      deleteItem(item) {
        const index = this.tableData.indexOf(item);
        confirm('Are you sure you want to delete this item?') && this.tableData.splice(index, 1);
        axios.delete('/api/roles/'+item.id).then(response=>console.log(response.data))
      },
      close() {
        this.dialog = false;
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem);
          this.editedIndex = -1;
        }, 300);
      },
      save() {

        if (this.editedIndex > -1) {
          Object.assign(this.tableData[this.editedIndex], this.editedItem);
          axios.put('/api/roles/'+this.editedItem.id,this.editedItem).then(response=>console.log(response.data));
        } else {
          this.tableData.push(this.editedItem);
          axios.post('/api/roles', this.editedItem).then(response=>console.log(response.data));
        }
        this.close();
      },
    },
  };
</script>
