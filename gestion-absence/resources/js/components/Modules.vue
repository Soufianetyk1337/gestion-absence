<template>
    <div class="container">
    	  <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Modules</h1>
          </div><!-- /.col -->
         </div><!-- /.row -->
        <div class="row justify-content-center">
        <div class="tab-pane" id="tab_2">
                    <div class="row">
          <form @submit.prevent="editMode? updateModule() : createModule()">
            <div class="row">
              <div class="col">
                <input type="text" class="form-control" placeholder="Module name" v-model="form.name" value="form.name" :class="{'is-invalid': form.errors.has('name')}">
                <has-error :form="form" field="name"></has-error>
              </div>
              <div class="col">
                 <textarea rows="1" cols="50" placeholder="Module description"
                 v-model="form.description" :class="{'is-invalid': form.errors.has('description')}" value="form.description"> </textarea> 
                 <has-error :form="form" field="description"></has-error>
              </div>
              <div class="col">
                <button type="submit" class="form-control btn btn-outline-success" placeholder="First name" v-show="!editMode">Add Module</button>
                <button type="submit" class="form-control btn btn-outline-primary" placeholder="First name" v-show="editMode">Edit Module</button>
              </div>
              </div>
          </form>
              </div>
              </div>
        </div>
      <div class="card-body table-responsive p-0 mt-5">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Module name</th> 
                      <th>Description</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="module in modules.data" :key="module.id">
                        <td>{{module.id}}</td>
                        <td>{{module.name}}</td>
                        <td>{{module.description}}</td>
                      <td>
                         <button class="btn btn-info btn-warning btn-md" @click="editForm(module)"><i class="fas fa-edit fa-fw"></i></button>
                         <button class="btn btn-info btn-danger btn-md" @click="deleteModule(module.id)"><i class="fas fa-trash "></i></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                <pagination :data="modules" @pagination-change-page="getResults">
                  
                </pagination>
              </div>
    </div> 
</template>

<script>
    export default {
      data(){
        return{
          editMode: false,
          modules:{},
          form: new Form({
                    id:'',
                    name:'',
                    description:''
                })
            }
        },
      
      methods:{
        getResults(page = 1){

            axios.get('api/module?page='+page)
            .then( response  =>  {this.modules = response.data
            });
            },
        deleteModule(id){
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
                        this.form.delete('api/module/'+ id)
                        .then( () => {
                        Swal.fire(
                          'Deleted!',
                          'Your file has been deleted.',
                          'success'
                        )
                        Fire.$emit('moduleCreated');
                        })
                    .catch( () => {
                        Swal.fire("Failed","Something went wrong.","warning");
                    });
                    })
        },
        createModule(){
          this.$Progress.start();
                this.form.post('api/module')
                .then(() => {                    
                Fire.$emit('moduleCreated');
                $('#addNew').modal('hide');
                Swal.fire({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000,
                      icon: 'success',
                      title: 'Module created successfully'
                });
                this.$Progress.finish();
                this.form.reset();
                this.getModules();
                })
                .catch( ()=> {
                  this.$Progress.fail();
                })
        },
        updateModule(){
           this.$Progress.start();
                this.form.put('api/module/'+this.form.id)
                .then( () => {
                    $('#addNew').modal('hide');
                    Swal.fire(
                          'Update!',
                          'User information has been Updated.',
                          'success'
                        )
                    this.$Progress.finish();
                    Fire.$emit('moduleCreated');
                    this.editMode = false;
                    this.form.reset();
                })
                .catch( () => {
                    this.$Progress.fail();
                });
        },
        editForm(mod){
          this.editMode = true;
          this.form.reset();
          this.form.fill(mod); 
        },
        getModules(){
                axios.get("api/module")
                .then(({data}) =>(this.modules = data))
                
            },
      },
       created(){
            this.getModules();
            this.form.reset();
            Fire.$on('moduleCreated' , () => this.getModules());
        } 
    }
</script>
