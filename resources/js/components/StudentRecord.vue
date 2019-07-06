<template>
    <div class="table-responsive">
        <form @submit.prevent="addStudentRecord" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Class Room" v-model="studentRecord.class_room">
            </div>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Teacher's Name"
                       v-model="studentRecord.teachers_name">
            </div>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Student First Name"
                       v-model="studentRecord.student_firstname">
            </div>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Student Last Name"
                       v-model="studentRecord.student_lastname">
            </div>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Gender" v-model="studentRecord.gender">
            </div>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Joined Year" v-model="studentRecord.joined_year">
            </div>

            <button type="submit" class="btn btn-light btn-block">Save</button>

        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link"
                                                                                                href="#"
                                                                                                @click="fetchStudentRecords(pagination.prev_page_url)">Previous</a>
                </li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page
                    }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link"
                                                                                                href="#"
                                                                                                @click="fetchStudentRecords(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Class Room</th>
                <th>Teacher's Name</th>
                <th>Student First Name</th>
                <th>Student Last Name</th>
                <th>Gender</th>
                <th>Joined Year</th>
                <th width="1%"></th>
                <th width="1%"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="student in studentRecords" v-bind:key="student.id">
                <td>{{ student.id }}</td>
                <td>{{ student.class_room }}</td>
                <td>{{ student.teachers_name }}</td>
                <td>{{ student.student_firstname }}</td>
                <td>{{ student.student_lastname }}</td>
                <td>{{ student.gender }}</td>
                <td>{{ student.joined_year }}</td>
                <td><a href="#" @click="editStudent(student)">Edit</a></td>
                <td><a href="#" @click="deleteStudent(student.id)">Delete</a></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                studentRecords: [],
                studentRecord: {
                    id: '',
                    class_room: '',
                    teachers_name: '',
                    student_firstname: '',
                    student_lastname: '',
                    gender: '',
                    joined_year: '',
                },
                student_id: '',
                pagination: {},
                edit: false
            }
        },

        created() {
            this.fetchStudentRecords();
        },

        methods: {
            fetchStudentRecords(page_url) {
                let vm = this;
                page_url = page_url || 'api/student';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.studentRecords = res.data;
                        vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            },
            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev,
                };

                this.pagination = pagination;
            },
            deleteStudent(id) {
                if (confirm('Are you sure?')) {
                    fetch(`api/student/${id}`, {
                        method: 'delete'
                    })
                        .then(res => res.json())
                        .then(data => {
                            alert('Student record removed Successfully!');
                            this.fetchStudentRecords();
                        })
                        .catch(err => console.log(err))
                }
            },
            addStudentRecord(){
                if (this.edit === false){
                    //add
                    fetch('api/student', {
                        method: 'post',
                        body: JSON.stringify(this.studentRecord),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.studentRecord.class_room = '';
                        this.studentRecord.teachers_name = '';
                        this.studentRecord.student_firstname = '';
                        this.studentRecord.student_lastname = '';
                        this.studentRecord.gender = '';
                        this.studentRecord.joined_year = '';
                        alert('Student Record Successfully Added!')
                        this.fetchStudentRecords();
                    })
                    .catch(err => console.log(err));
                } else{
                    //update

                    fetch(`api/student/${this.studentRecord.id}`, {
                        method: 'put',
                        body: JSON.stringify(this.studentRecord),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.studentRecord.class_room = '';
                            this.studentRecord.teachers_name = '';
                            this.studentRecord.student_firstname = '';
                            this.studentRecord.student_lastname = '';
                            this.studentRecord.gender = '';
                            this.studentRecord.joined_year = '';
                            alert('Student Record Successfully Updated!')
                            this.fetchStudentRecords();
                        })
                        .catch(err => console.log(err));
                }
            },
            editStudent(studentRecord){
                console.log(studentRecord)
                this.edit = true;
                this.studentRecord.id = studentRecord.id;
                this.studentRecord.student_id = studentRecord.id;
                this.studentRecord.class_room = studentRecord.class_room;
                this.studentRecord.teachers_name = studentRecord.teachers_name;
                this.studentRecord.student_firstname = studentRecord.student_firstname;
                this.studentRecord.student_lastname = studentRecord.student_lastname;
                this.studentRecord.gender = studentRecord.gender;
                this.studentRecord.joined_year = studentRecord.joined_year;
            }
        },

    }
</script>
