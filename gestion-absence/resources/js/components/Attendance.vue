<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11">
                <div class="card">
                    <div class="card-header d-flex p-0">
                        <ul class="nav nav-pills ml-auto p-2">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tab_1" data-toggle="tab" v-on:click="reset()">Add Absence</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab_2" data-toggle="tab">Search for a student</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" v-on:click="formToggle()"><i class="fas fa-minus-square"></i></a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <form @submit.prevent="editMode? updateAbsence() : createAbsence()" id='form'>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Student Id" v-model="form.student_id" :class="{'is-invalid': form.errors.has('student_id')}" value="form.student_id">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Module Id" v-model="form.module_id" :class="{'is-invalid': form.errors.has('module_id')}" value="form.module_id">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="justification" v-model="form.justification" :class="{'is-invalid': form.errors.has('justification')}" value="form.justification">
                                        </div>
                                        <div class="form-group">
                                            <input type="date" class="form-control" placeholder="Date" v-model="form.date" :class="{'is-invalid': form.errors.has('date')}" value="form.date">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="hours" v-model="form.hours" :class="{'is-invalid': form.errors.has('hours')}" value="form.hours">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Type" v-model="form.type" :class="{'is-invalid': form.errors.has('type')}" value="form.type">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button v-show="!editMode" type="submit" class="btn btn-primary btn-md">Add attendance</button>
                                        <button type="submit" v-show="editMode" class="btn btn-warning btn-md">Edit attendance</button>
                                    </div>
                                </form>
                            </div>
                            <!-- Search form -->
                            <div class="tab-pane" id="tab_2">
                                <div class="row">
                                    <form>
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="First name">
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="First name">
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="First name">
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="First name">
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="First name">
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="Last name">
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-outline-primary btn-md">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- ./card -->
            </div>
            <!-- /.col -->
        </div>
        <!--Row-->
        <div class="row">
            <div class="card-body table-responsive p-0 mt-5">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student_id</th>
                            <th>Module_id</th>
                            <th>Justification</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="absence in absences.data" :key="absence.id">
                            <td>{{absence.id}}</td>
                            <td>{{absence.student_id}}</td>
                            <td>{{absence.module_id}}</td>
                            <td>{{absence.justification}}</td>
                            <td>{{absence.type}}</td>
                            <td>{{absence.date}}</td>
                            <td>{{absence.hours}}</td>
                            <td>
                                <button class="btn btn-info btn-warning btn-md" @click="editAbsence(absence)"><i class="fas fa-edit fa-fw"></i></button>
                                <button class="btn btn-info btn-danger btn-md" @click="deleteAbsence(absence.id)"><i class="fas fa-trash "></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <pagination :data="absences" @pagination-change-page="getResults">
                </pagination>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            isActive: false,
            editMode: false,
            absences: {},
            modules: {},
            form: new Form({
                id: '',
                justification: '',
                hours: '',
                type: '',
                date: '',
                module_id: '',
                student_id: '',
            })
        }
    },
    methods: {
        getResults(page = 1) {

            axios.get('api/attendance?page=' + page)
                .then(response => {
                    this.absences = response.data
                });
        },
        updateAbsence() {
            this.$Progress.start();
            this.form.put('api/attendance/' + this.form.id)
                .then(() => {
                    Swal.fire(
                        'Update!',
                        'Absence information has been Updated.',
                        'success'
                    )
                    this.$Progress.finish();
                    Fire.$emit('absence Created');
                    this.reset();
                })
                .catch(() => {
                    this.$Progress.fail();
                });

        },
        reset() {
            this.form.reset();
            this.editMode = false;
        },
        deleteAbsence(id) {

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
                    this.form.delete('api/attendance/' + id)
                        .then(() => {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            Fire.$emit('absenceCreated');
                        })
                        .catch(() => {
                            Swal.fire("Failed", "Something went wrong.", "warning");
                        });
                })
        },
        editAbsence(absence) {
            this.isActive = true;
            this.formToggle();
            this.editMode = true;
            this.form.reset();
            this.form.fill(absence);
        },
        formToggle() {
            if (this.isActive) {
                document.getElementById('form').style.display = 'block';
                this.isActive = !this.isActive;
            } else {
                document.getElementById('form').style.display = 'none';
                this.isActive = !this.isActive;
            }
        },
        createAbsence() {
            this.$Progress.start();
            this.form.post('api/attendance')
                .then(() => {
                    Fire.$emit('absenceCreated');

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'success',
                        title: 'Absence added successfully'
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                })
        },
        getAbsences() {
            axios.get("api/attendance")
                .then(({ data }) => (this.absences = data))

        }
    },
    created() {
        this.getAbsences();
        Fire.$on('absenceCreated', () => this.getAbsences());
    }
}

</script>
