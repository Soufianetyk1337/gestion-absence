<template>
   <div class="container">
    <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Students Table</h3>

                <div class="card-tools">
                  <button class="btn-success" @click="openModal">Add New Student<i class="fas fa-user-plus"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Image</th>
                      <th>Full Name</th> 
                      <th>email</th>
                      <th>CNE</th>
                      <th>Phone</th>
                      <th>Filliere</th>
                      <th>Annee scolaire</th>
                      <th>DOB</th>
                      <th>Registered At</th>
                    </tr>
                  </thead>
                  <tbody>
                  <tr v-for="student in students.data" :key="student.id">
                        <td>{{student.id}}</td>
                        <td>{{student.first_name | capitalize}} {{student.last_name | capitalize}}</td>
                        <td>{{student.email}}</td>
                        <td>{{student.CNE}}</td>
                        <td>{{student.phone}}</td>
                        <td>{{student.filliere}}</td>
                        <td>{{student.annee_scolaire}}</td>
                        <td>{{student.DOB}}</td>
                        <td>{{student.created_at | formatDate}}</td>
                      <td>
                         <!--<a href="#" @click="editModal(user)">Edit<i class="fas fa-edit fa-fw"></i></a>
                          <a href="#" @click="deleteUser(user.id)"> Delete
                            <i class="fas fa-trash"></i></a> -->
                         <button class="btn btn-info btn-warning btn-md" @click="editModal(student)"><i class="fas fa-edit fa-fw"></i></button>
                         <button class="btn btn-info btn-danger btn-md" @click="deleteUser(student.id)"><i class="fas fa-trash "></i></button>
                         <a href="/profile"><button class="btn btn-info btn-info btn-md"><i class="fas fa-user"></i></button></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="students" @pagination-change-page="getResults">
                  
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
             <input v-model="form.first_name" type="text" name="first_name" placeholder="First Name" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('first_name') }">
              <has-error :form="form" field="first_name"></has-error>
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
             <input v-model="form.phone" type="text" name="phone" placeholder="Phone" 
            class="form-control" :class="{'is-invalid': form.errors.has('phone')}">
              <has-error :form="form" field="phone"></has-error>
         </div>
          <div class="form-group">
            <input type="file" @change="getImage" name="image">
          </div>

         <div class="form-group">
             <input v-model="form.CNE" type="text" name="CNE" placeholder="CNE" 
            class="form-control" :class="{'is-invalid': form.errors.has('CNE')}">
              <has-error :form="form" field="CNE"></has-error>
         </div>
         <div class="form-group">
              <select class="browser-default custom-select" v-model="form.filliere" id="filliere" 
              :class="{'is-invalid':form.errors.has('filliere')}">
                  <option value="gi">Genie Informatique</option>
                  <option value="tm">Technique de Management</option>
            </select> 
         </div>
        <div class="form-group">
             <input v-model="form.DOB" type="date" name="DOB" placeholder="DOB" 
            class="form-control" :class="{'is-invalid': form.errors.has('DOB')}">
              <has-error :form="form" field="DOB"></has-error>
         </div>
         <div class="form-group">
             <input v-model="form.annee_scolaire" type="text" name="annee_scolaire" placeholder="Scholar year" 
            class="form-control" :class="{'is-invalid': form.errors.has('annee_scolaire')}">
              <has-error :form="form" field="annee_scolaire"></has-error>
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
                students:{},
                form: new Form({
                    id:'',
                    first_name:'',
                    last_name:'',
                    email:'',
                    phone:'',
                    image:'',
                    CNE:'',
                    filliere:'',
                    DOB:'',
                    annee_scolaire:''
                })
            }
        },
        methods:{
          getImage(e){
              let file =e.target.files[0];
               let reader = new FileReader();
               reader.readAsDataURL(file)
               
               reader.onloadend = (file) => {
                  this.form.image = reader.result;
               } 
          },
          getResults(page = 1){

            axios.get('api/student?page='+page)
            .then( response  =>  {this.students = response.data
            });
            },
            updateUser(){
                this.$Progress.start();
                this.form.put('api/student/'+this.form.id)
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
            editModal(student){
                this.editMode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(student);               
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
                        this.form.delete('api/student/'+ id)
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
                this.form.post('api/student')
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
                axios.get("api/student")
                .then(({data}) =>(this.students = data))
            }
        },
        created(){
            this.getUsers();
            Fire.$on('userCreated' , () => this.getUsers());
            
        } 
    }
</script>
