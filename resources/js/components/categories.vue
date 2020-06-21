<template>
<div>
    <li class="sidebar-list-item"><a href="#" data-toggle="collapse" data-target="#pages" aria-expanded="false" aria-controls="pages" :class="($route.query.c) ? 'active' : ''" class="sidebar-link text-muted"><span class="col-2 d-flex p-0 mr-3"><i class="fas fa-th-large m-auto text-gray"></i></span><span id="legend">Mes catégories</span></a>
        <div id="pages" class="collapse" style="max-height: 30vh;overflow: auto;">
        <ul class="sidebar-menu list-unstyled border-left border-primary border-thick">
            <li v-for="category in user.categories" :key="category.id" class="sidebar-list-item" :style="($route.query.c == category.id) ? 'background-color: #dedede' : '' "><a :href="'/category/'+category.title+'?c='+category.id" class="sidebar-link text-muted pl-lg-5"><span class="col-2 d-flex p-0 mr-3"><i id="legend" class="fas fa-square m-auto text-gray"></i></span><span>{{ category.title }}</span></a></li>
            <li class="sidebar-list-item"><a @click="$bvModal.show('new-category-modal')" href="#" class="sidebar-link text-muted pl-lg-5"><span class="col-2 d-flex p-0 mr-3"><i id="legend" class="fas fa-plus m-auto text-gray"></i></span><span>Créer une catégorie</span></a></li>
        </ul>
        </div>
    </li>
    <b-modal
    id="new-category-modal"
    size="sm"
    button-size="sm"
    title="Nouveau catégorie"
    @ok="createCategory"
    >
        <b-form-input
        v-model="name"
        :state="nameState"
        placeholder="Entrer le nom du catégorie"
        trim
        ></b-form-input>
        <b-form-invalid-feedback :force-show="isEmpty">
            <p v-if="name == ''">Taper un nom</p>
            <p v-else>Vous avez déjà utilisé ce nom</p>
        </b-form-invalid-feedback>
    </b-modal>
</div>
</template>

<script>
export default {
    props: {
        userjson: String,
    },
    data() {
        return {
            user: JSON.parse(this.userjson),
            name: '',
            isEmpty: false,
        }
    },
    mounted() {
        console.log('categories component mounted.');
        // console.log(this.user);
    },
    methods: {
        createCategory(bvModalEvt){
            if (this.name == '') {
                this.isEmpty = true;
                bvModalEvt.preventDefault();
            }else{
                axios.post('/create-category',{
                    user_id : this.user.id,
                    title: this.name,
                })
                .then(res => {
                    this.user = res.data;
                })
                .catch(err => {
                    console.error(err);
                })
            }
        }
    },
    computed: {
        nameState() {
            if(this.name == '') return null;
            return (this.user.categories.some(category => category.title == this.name)) ? false : true;
        },
    }
}
</script>

<style>

</style>
