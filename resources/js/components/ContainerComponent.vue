<template>
    <div class="container">
        <div id="crud" class="row justify-content-center">
            <div class="col-12 text-center py-1">
                <h1 class="page-header">User List</h1>
            </div>
            <div class="col-9">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Contacts</th>
                                <th scope="col">Since</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users.data" :key="user.id">
                              <td v-text="user.id" class="text-center"></td>
                              <td v-text="user.name"></td>
                              <td v-text="user.contacts" class="text-center"></td>
                              <td v-text="user.created_at" class="text-center"></td>
                            </tr>
                            <tr v-if="users.data <= 0">
                              <td colspan="7" class="text-center">There are no records to show</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="...">
                    <ul class="pagination">
                        <li v-if="pagination.current_page > 1" class="page-item">
                            <a class="page-link" href="#" title="Atras" @click.prevent="changePage(pagination.current_page - 1)">
                                <span>Atras</span>
                            </a>
                        </li>
                        <li v-for="page in pagesNumber"
                            class="page-item" 
                            v-bind:class="[page == isActived ? 'active' : '']">
                            <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
                        </li>
                        <li v-if="pagination.current_page < pagination.last_page" 
                            class="page-item">
                            <a href="#" class="page-link" 
                                @click.prevent="changePage(pagination.current_page + 1)">
                                <span>Siguiente</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                users : {},
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 2,
            }
        },
        methods:{
            loadusers(page) {
                var urlusers = 'api/listusers?page=' + page;
                axios.get(urlusers).then(
                    ({ data }) => ([this.users = data.data, this.pagination = data.pagination])
                );
            },
            changePage: function(page){
                this.pagination.current_page = page;
                this.loadusers(page);
            }
        },
        created() {
            this.loadusers();
        },
        computed: {
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if(from < 1){
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }
                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        }
    }
</script>
