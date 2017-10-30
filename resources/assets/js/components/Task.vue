<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button @click="initAddTask()" class="btn btn-primary btn-xs pull-right">
                            + Add New Task
                        </button>
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-responsive">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(task, index) in tasks">
                                <td>{{ index + 1 }}</td>
                                <td>{{ task.name }}</td>
                                <td>{{ task.description }}</td>
                                <td>
                                    <button @click="initUpdate(index)" class="btn btn-success btn-xs">Edit</button>
                                    <button @click="deleteTask(index)" class="btn btn-danger btn-xs">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="add-task-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <h4 class="modal-title">Add New Task</h4>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   placeholder="Task Name"
                                   class="form-control"
                                   v-model="task.name">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description"
                                      id="description"
                                      cols="30"
                                      rows="5"
                                      placeholder="Task Description"
                                      class="form-control"
                                      v-model="task.description"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="createTask" class="btn btn-primary">Submit</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" id="update-task-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <h4 class="modal-title">Update Task</h4>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="name-edit">Name:</label>
                            <input id="name-edit"
                                   type="text"
                                   placeholder="Task Name"
                                   class="form-control"
                                   v-model="update_task.name">
                        </div>
                        <div class="form-group">
                            <label for="description-edit">Description:</label>
                            <textarea id="description-edit"
                                      cols="30"
                                      rows="5"
                                      class="form-control"
                                      placeholder="Task Description"
                                      v-model="update_task.description"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="updateTask" class="btn btn-primary">Submit</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
</template>

<style>
    .panel-heading {
        min-height: 45px;
    }
</style>

<script>
    export default {
        data() {
            return {
                task: {
                    name: '',
                    description: ''
                },
                update_task: [],
                errors: [],
                tasks: []
            }
        },
        mounted() {
            this.readTasks();
        },
        methods: {
            initAddTask() {
                this.errors = [];

                $('#add-task-modal').modal('show');
            },
            createTask() {
                axios.post('/task', this.task)
                    .then(response => {
                        this.reset();

                        this.tasks.push(response.data.task);

                        $('#add-task-modal').modal('hide');
                    })
                    .catch(error => {
                        this.errors = [];

                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }

                        if (error.response.data.errors.description) {
                            this.errors.push(error.response.data.errors.description[0]);
                        }
                    });
            },
            reset() {
                this.task.name = '';
                this.task.description = '';
            },
            readTasks() {
                axios.get('/task')
                    .then(response => {
                        this.tasks = response.data.tasks
                    });
            },
            initUpdate(index) {
                this.errors = [];
                $('#update-task-modal').modal('show');
                this.update_task = this.tasks[index];
            },
            updateTask() {
                axios.patch('/task/' + this.update_task.id, this.update_task)
                    .then(response => {
                        $('#update-task-modal').modal('hide');
                    })
                    .catch(error => {
                        this.errors = [];

                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }

                        if (error.response.data.errors.description) {
                            this.errors.push(error.response.data.errors.description[0]);
                        }
                    });
            },
            deleteTask(index) {
                let conf = confirm("Do you ready want to delete this task?");

                if (conf === true) {

                    axios.delete('/task/' + this.tasks[index].id)
                        .then(response => {

                            this.tasks.splice(index, 1);

                        }).catch(error => {

                            console.log(response.data.errors);
                        });
                }
            }
        }
    }
</script>
