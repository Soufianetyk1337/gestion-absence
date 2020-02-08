<template>
   <div class="container">
    <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                  <button class="btn-success" @click="openModal">Add New Administrateur<i class="fas fa-user-plus"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Full Name</th> 
                      <th>email</th>
                      <th>CIN</th>
                      <th>Type</th>
                      <th>Registered At</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                        <td>{{user.id}} </td>
                        <td>{{user.name | capitalize}} {{user.last_name | capitalize}}</td>
                        <td>{{user.email}}</td>
                        <td>{{user.CIN}}</td>
                        <td>{{user.type}}</td>
                        <td>{{user.created_at | formatDate}}</td>
                      <td>
                         <button class="btn btn-info btn-warning btn-md" @click="editModal(user)"><i class="fas fa-edit fa-fw"></i></button>
                         <button class="btn btn-info btn-danger btn-md" @click="deleteUser(user.id)"><i class="fas fa-trash "></i></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="users" @pagination-change-page="getResults">
                  
                </pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
<div class="modal" tabindex="-1" role="dialog" id="addNew">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-show="!editMode" class="modal-title">Add new user</h5>
        <h5 v-show="editMode" class="modal-title">Edit user info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editMode? updateUser() : createUser()">
      <div class="modal-body">
         <div class="form-group">
             <input v-model="form.name" type="text" name="name" placeholder="Name" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
              <has-error :form="form" field="name"></has-error>
         </div>

         <div class="form-group">
             <input v-model="form.last_name" type="text" name="last_name" placeholder="Last Name" 
            class="form-control" :class="{'is-invalid': form.errors.has('last_name')}">
              <has-error :form="form" field="last_name"></has-error>
         </div>

         <div class="form-group">
             <input v-model="form.email" type="email" name="email" placeholder="Email Adress" 
            class="form-control" :class="{'is-invalid': form.errors.has('email')}">
              <has-error :form="form" field="email"></has-error>
         </div>



         <div class="form-group">
             <input v-model="form.password" type="password" name="password" placeholder="Password" 
            class="form-control" :class="{'is-invalid': form.errors.has('password')}">
              <has-error :form="form" field="password"></has-error>
         </div>


         <div class="form-group">
             <input v-model="form.CIN" type="text" name="CIN" placeholder="CIN" 
            class="form-control" :class="{'is-invalid': form.errors.has('CIN')}">
              <has-error :form="form" field="CIN"></has-error>
         </div>
         <div class="form-group">
            <input type="file" @change="getImage" name="image">
          </div>
         <div class="form-group">
              <select class="browser-default custom-select" v-model="form.type" id="type" 
              :class="{'is-invalid':form.errors.has('type')}">
                  <option value="admin">Admin</option>
            </select> 
         </div>
        
         <!--<div class="form-group">
                <input v-model="form.photo" 
                type="text" 
                name="photo" placeholder="Filliere" 
            class="form-control" :class="{'is-invalid':form.errors.has('photo')}">
              <has-error :form="form" field="photo"></has-error>   
         </div> -->

    </div>
      <div class="modal-footer">
        <button v-show="!editMode" type="submit" class="btn btn-success">Create</button>
        <button v-show="editMode" type="submit" class="btn btn-warning">Update</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
  </form>
    </div>
  </div>
</div>
    </div> 
</template>

<script>
    export default {
        data(){
            return {
                editMode:false,
                data : {},
                total:{},
                users : {}, 
                teachers:{},
                form: new Form({
                    id:'',
                    name:'',
                    last_name:'',
                    email:'',
                    password:'',
                    CIN:'',
                    type:'',
                    image:'',
                })
            }
        },
        methods:{
            getImage(e){
              let file =e.target.files[0];
               let reader = new FileReader();
              reader.readAsDataURL(file)
               
               reader.onloadend = (file) => {
                console.log(reader.result);
                  this.form.image = reader.result;
               } 
          },
          getResults(page = 1){
            axios.get('api/user?page='+page)
            .then( response  =>  {this.users = response.data
            });
            },
          getTotal(){
            axios.get("api/user")
                .then(({data}) =>(this.total = data.data))
          },
            updateUser(){
                this.$Progress.start();
                this.form.put('api/user/'+this.form.id)
                .then( () => {
                    $('#addNew').modal('hide');
                    Swal.fire(
                          'Update!',
                          'User information has been Updated.',
                          'success'
                        )
                    this.$Progress.finish();
                    Fire.$emit('userCreated');
                })
                .catch( () => {
                    this.$Progress.fail();
                });

            },
            openModal(){
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            editModal(user){
                this.editMode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);               
            },
            deleteUser(id){
                Swal.fire({
                      title: 'Are you sure?',
                      text: "You won't be able to revert this!",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, delete it!'
                    })
                .then((result) => {
                        this.form.delete('api/user/'+ id)
                        .then( () => {
                        Swal.fire(
                          'Deleted!',
                          'Your file has been deleted.',
                          'success'
                        )
                        Fire.$emit('userCreated');
                        })
                    .catch( () => {
                        Swal.fire("Failed","Something went wrong.","warning");
                    });
                    })
            },
            createUser(){
                this.$Progress.start();
                this.form.post('api/user')
                .then(() => {                    
                Fire.$emit('userCreated');
                $('#addNew').modal('hide');
                Swal.fire({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000,
                      icon: 'success',
                      title: 'User created successfully'
                });
                this.$Progress.finish();
                })
                .catch( ()=> {

                })
            },
            getUsers(){
                axios.get("api/user")
                .then(({data}) =>(
                  this.users = data
                ))
            }
        },
        created(){
            this.getUsers();
            Fire.$on('userCreated' , () => this.getUsers());
        } 
    }
</script>
