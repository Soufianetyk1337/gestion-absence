<template>
   <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
         
                <img class="img-fluid" src="img/logo.jpeg" alt="EST Sidi bennour">
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <a href="https://www.facebook.com/ESTsb.go/" target="_blank">
                        <img class="img-fluid" src="https://cdn1.iconfinder.com/data/icons/social-media-2285/512/Colored_Facebook3_svg-512.png" alt="Facebook" style="height:35px;">
                      </a>


                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <a href="https://www.twitter.com/" target="_blank">
                        <img class="img-fluid" src="https://cdn2.iconfinder.com/data/icons/social-media-2285/512/1_Twitter3_colored_svg-512.png" alt="Facebook" style="height:35px;">
                      </a>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                         <a href="mailto:test@gmail.com" target="_blank">
                        <img class="img-fluid" src="https://cdn2.iconfinder.com/data/icons/social-icons-color/512/gmail-512.png" alt="Facebook" style="height:35px;">
                      </a>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
            <!-- /.widget-user -->
          
        </div>  
    </div>
        <div class="row justify-content-center">

          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{this.$parent.totalStudents}}</h3>

                <p>Students</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <a href="/student" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{this.$parent.totalTeachers}}</h3>

                <p>Teachers</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="/teacher" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{this.$parent.totalUsers}}</h3>

                <p>Admin</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <a href="/users" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{this.$parent.totalModules}}</h3>

                <p>Modules</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-pie"></i>
              </div>
              <a href="/modules" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
        
        </div>


    </div> 
 
</template>

<script>
    export default {
         data(){
        return{
        }
      },
    created(){
      this.$parent.getAll();
    }
    }
</script>
