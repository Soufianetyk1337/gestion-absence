<template>
    <div class="container">
    	  <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"v-if="this.show"> {{users[0].first_name}} {{users[0].last_name }}'s Profile</h1>
            <h1 v-else class="m-0 text-dark">Search a student</h1>
          </div><!-- /.col -->
         </div><!-- /.row -->
         <div class="container" v-if="this.show == true">
        <div class="row justify-content-center">
         <div class="col-md-4">
     	<div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" v-bind:src="'img/' + users[0].image" alt="User profile picture" style="width:128px;height:128px;">
                </div>
                <h3 class="profile-username text-center">{{users[0].first_name}} {{users[0].last_name }}</h3>
                <p class="text-muted text-center" v-if="users[0].filliere == GI">Computer Science</p>
                <p class="text-muted text-center" v-else>Management</p>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Email</b> <a class="float-right">{{users[0].email}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>DOB</b> <a class="float-right">{{users[0].DOB}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>CNE</b> <a class="float-right">{{users[0].CNE}}</a>
                  </li>
                    <li class="list-group-item">
                    <b>Phone</b> <a class="float-right">{{users[0].phone}}</a>
                  </li>
                </ul>
                <a href="mailto:test@gmail.com"><button class="btn btn-block btn-info">Contact</button></a>
              </div>
            </div>
            </div>
        </div><!--row -->
        <div class="row">
        	<div class="card-body">
        		
              <div>
              
              	<div class="row">
              		<div class="col-sm-12">
              		<table id="example2" class="table table-bordered table-hover dataTable">
                <thead>
                <tr>
                	<th>Full Name</th>
                	<th>Module</th>
                	<th>Date</th>
                	<th>Duration</th>
                  <th>Justification</th>
                	<th>Filliere</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users" :key="user.id">
                        <td>{{user.first_name | capitalize}} {{user.last_name | capitalize}}</td>
                        <td>{{user.name}}</td>
                        <td>{{user.date}}</td>
                        <td>{{user.hours}}</td>
                        <td>{{user.justification}}</td>
                        <td>{{user.filliere}}</td>
                      <td>
                         <button class="btn btn-info btn-warning btn-md" @click="editModal(student)"><i class="fas fa-edit fa-fw"></i></button>
                         <button class="btn btn-info btn-danger btn-md" @click="deleteUser(student.id)"><i class="fas fa-trash "></i></button>
                       
                      </td>
                    </tr>
            </tbody>
               
              </table></div></div></div>
            
        	</div>
        </div>
        </div>
    </div> 
</template>

<script>
    export default {
      data(){
        return{
          users :{},
          show: false,
        }
      },
    created(){
      Fire.$on('searching', () => {
        let query = this.$parent.search;
        axios.get('api/findUser?q='+query)
        .then((data) => {
          this.users = data.data;
          this.show = true;
        })
        .catch( () => {
          console.log('error');
        })
      })

    },
    }
</script>
