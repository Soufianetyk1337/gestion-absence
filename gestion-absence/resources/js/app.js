import VueRouter from 'vue-router';
import moment from 'moment';
import VueProgressBar from 'vue-progressbar'
import Swal from 'sweetalert2'



require('./bootstrap');
window.Vue = require('vue');
import {Form ,HasError,AlertError} from 'vform';
Vue.use(VueRouter);
Vue.use(VueProgressBar , {
	color:'rgb(143,255,199)',
	failedColor:'red',
	height:'3px'
})

Vue.prototype.$Indexes =[];
new Vue({
  beforeCreate: function () {
    console.log(this.$Indexes);
  }
})
window.Fire = new Vue();
window.Form = Form;
window.Swal = Swal;
Vue.component(HasError.name,HasError);
Vue.component(AlertError.name,AlertError);

let routes = [
{path:'/dashboard' , component:require('./components/Dashboard.vue').default},
{path:'/profile' , component:require('./components/Profile.vue').default},
{path:'/users' , component:require('./components/Users.vue').default},
{path:'/attendance' , component:require('./components/Attendance.vue').default},
{path:'/student' , component:require('./components/Student.vue').default},
{path:'/teacher' , component:require('./components/Teachers.vue').default},
{path:'/module' , component:require('./components/Modules.vue').default},

];


const router  = new VueRouter({
	mode:'history',
	routes
});
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('search', require('./components/Search.vue').default);
Vue.component('pagination' , require('laravel-vue-pagination'));
Vue.filter('capitalize',(text) => text.charAt(0).toUpperCase() + text.slice(1)); 
Vue.filter('formatDate',(created) => moment(created).format('MMMM Do YYYY'));

const app = new Vue({
    el: '#App',
    router,
    data:{
        search: '',
        totalStudents :'',
        totalUsers :'',
        totalModules :'',
        totalTeachers :'',
    },
    methods:{
        searchFor(){
            Fire.$emit('searching')
        },
        getStudents(){
                axios.get("api/student")
                .then(({data}) =>(this.totalStudents = data.total))
            },
        getUsers(){
                axios.get("api/user")
                .then(({data}) =>(this.totalUsers = data.total))
            },
        getModules(){
                axios.get("api/module")
                .then(({data}) =>(this.totalModules = data.total))
            },
            getTeachers(){
                axios.get("api/teacher")
                .then(({data}) =>(this.totalTeachers = data.total))
            },
            getAll(){
                this.getUsers();
        this.getStudents();
        this.getTeachers();
        this.getModules();

            }

    },

    created(){
        //this.getAll();
    }
});





/*
<passport-clients></passport-clients>
<passport-authorized-clients></passport-authorized-clients>
<passport-personal-access-tokens></passport-personal-access-tokens>
*/