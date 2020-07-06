<template>
    <div class="container">
        <div id="crud" class="row justify-content-center">
            <div class="col-11 text-center py-1">
                <h4>Contact list</h4>
            </div>
            <div class="col-11 container">
                <div class="d-flex justify-content-end align-items-center my-3">
                    <input class="form-control mr-2" type="text" placeholder="Search" aria-label="Search" v-model="search" name="search" style="max-width: 350px;" @keyup="searchContact">
                    <button type="button" class="btn btn-primary" @click="newModal">
                        Add New
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Since</th>
                                <td colspan="2"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="contact in contacts.data" :key="contact.id">
                                <td v-text="contact.id" class="text-center"></td>
                                <td v-text="contact.first_name"></td>
                                <td v-text="contact.last_name"></td>
                                <td v-text="contact.email" class="text-center"></td>
                                <td v-text="contact.contact_number" class="text-center"></td>
                                <td v-text="contact.created_at" class="text-center"></td>
                                <td class="text-center">
                                    <a href="#" title="Edit" class="mx-1" @click="editModal(contact)">
                                        <i class="fa fa-edit blue" style="font-size: 1.2rem;"></i>
                                    </a>    
                                    <a href="#" title="Destroy" class="mx-1" @click="deleteContact(contact.slug)">
                                        <i class="fa fa-trash text-danger" style="font-size: 1.2rem;"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="contacts.data <= 0">
                              <td colspan="7" class="text-center">There are no records to show</td>
                            </tr>
                        </tbody>
                    </table>
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
        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Create New Contact</h5>
                    <h5 class="modal-title" v-show="editmode">Update Contact's Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- <form @submit.prevent="createUser"> -->

                <form @submit.prevent="editmode ? updateContacts() : createContacts()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="form.first_name" type="text" name="first_name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('first_name') }">
                            <has-error :form="form" field="first_name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input v-model="form.last_name" type="text" name="last_name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('last_name') }">
                            <has-error :form="form" field="last_name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input v-model="form.email" type="email" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input v-model="form.contact_number" type="phone" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('contact_number') }">
                            <has-error :form="form" field="contact_number"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                editmode: false,
                contacts : [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 2,
                form: new Form({
                    first_name: '',
                    last_name: '',
                    email: '',
                    contact_number: '',
                    slug: '',
                }),
                search: '',
            }
        },
        methods:{
            loadContacts(page) {
                this.$Progress.start();
                var urlcontacts = 'listcontacts?page=' + page;
                axios.get(urlcontacts).then(
                    ({ data }) => ([this.contacts = data.data, this.pagination = data.pagination])
                );
                this.$Progress.finish();
            },
            searchContact() {
                if (this.search) {
                    this.$Progress.start();
                    var urlsearch = 'search?search=' + this.search;
                    axios.get(urlsearch).then(
                        ({ data }) => ([this.contacts = data.data, this.pagination = data.pagination])
                    );
                    this.$Progress.finish();
                } else {
                    this.loadContacts();
                }
            },
            changePage: function(page){
                this.pagination.current_page = page;
                this.loadContacts(page);
            },
            createContacts(){
                this.$Progress.start();
                this.form.post('contacts')
                .then((response)=>{
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });
                    this.$Progress.finish();
                    this.loadContacts();
                })
                .catch(()=>{
                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
                    this.$Progress.fail();
                })
            },
            updateContacts(){
                this.$Progress.start();
                this.form.put('contacts/' + this.form.slug)
                .then((response) => {
                    $('#addNew').modal('hide');
                    this.$Progress.finish();
                    this.loadContacts();
                })
                .catch(() => {
                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
                    this.$Progress.fail();
                });
            },
            deleteContact(slug){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        // Send request to the server
                        if (result.value) {
                            this.form.delete('contacts/' + slug).then(() => {
                                this.loadContacts();
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                );
                            }).catch((data) => {
                                  Swal.fire("Failed!", data.message, "warning");
                            });
                        }
                    })
            },
            editModal(contact){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(contact);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            }
        },
        created() {
            this.loadContacts();
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
            },
        }
    }
</script>