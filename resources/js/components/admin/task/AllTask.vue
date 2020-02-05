<template>
  <div class="col-md-10">
             
    <div v-if="!tasks.length" class="text-center" style="overflow:hidden">
      <b-spinner variant="info" style="width: 4rem; height: 4rem;" label="Text Centered"></b-spinner>
    </div>

     <div v-else>
      <div v-if="success" class="alert alert-success container" id="div3">
        <strong>Success!</strong> {{ success }}
      </div>

      <div v-for="(task, index) in tasks" :key="index" class="card mb-2">
        <div class="card-header">
        <div class="row">
          <div class="col-9">
          <blockquote class="blockquote mb-0">
            <h3>{{ task.title }} <small class="text-muted posted-text"> Posted {{ task.created_at }}</small></h3>
            
                
            <footer v-if="task.users.length" class="blockquote-footer"><cite>{{ task.users[0].name }}</cite></footer>
            
          </blockquote>
          </div>
          <div class="col-3">
          <center>
            <button @click="viewTask(task.slug)" class="add-btn h1 text-success" data-toggle="tooltip" data-placement="bottom" title="View Task">
                <b-icon-eye-fill></b-icon-eye-fill>
            </button>

            <button @click="editTask(task.slug)" class="edit-btn h1 text-info" data-toggle="tooltip" data-placement="bottom" title="Edit Task">
                <b-icon-pencil></b-icon-pencil>
            </button>

            <button @click="deleteTask(task.id)" class="edit-btn h1 text-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Task">
                <b-icon-trash-fill></b-icon-trash-fill>
            </button>

          </center>
          </div>
        </div>
        </div>
        <div class="card-body">
          <p class="card-text">{{ task.details }}</p>

          
          <div v-if="task.task_files.length">
          <div role="separator" class="dropdown-divider"></div>
            <p class="card-text"><strong>Attached Files: </strong></p>
            <ul class="list-group">
             
                <li v-for="(file, index) in task.task_files" :key="index" class="list-group-item list-group-item-default">
                  <div class="row">
                    <div class="col-10">
                        <a :href=" file.file_url " target="_blank">{{ file.file_url }}</a>
                    </div>
                    <div class="col-2">
                      <center>

                        <!-- <a href="#" @click="deleteFile(file.id)" class="edit-btn" data-toggle="tooltip" data-placement="bottom" title="Edit Feedback">
                            <i class="fa fa-edit" style="font-size: 1.3rem"></i>
                        </a> -->
                      </center>
                    </div>
                  </div>
                </li>
               
            </ul>
            <div role="separator" class="dropdown-divider"></div>
         </div>
          

         <button v-if="task.users.length > 1" @click="notifyClient(task.id)" class="btn btn-primary">Notify Client</button>

        </div>
      </div>

      <div class="mt-3">
         <b-pagination
           v-model="currentPage"
           :total-rows="rows"
           :per-page="perPage"
           @input="updatePage()"
           align="center"
         ></b-pagination>
      </div>
   </div>
  </div>
</template>

<script>
export default {
 data(){
  return {
   tasks: [],
   success: '',
   currentPage: 1,
   perPage: 5,
   paginate: []
  }
 },
 computed:{
  rows(){
   return this.paginate.total
  }
 },
 created(){
  this.getAllTasks();

 },
 methods: {
  getAllTasks(){
   axios.get(`/api/admin/tasks?page=${this.currentPage}`)
    .then(res => {
     this.tasks = res.data.data;
     this.paginate = res.data.meta;
    })
    .catch(err => console.log(err))
  },
  viewTask(slug){
   this.$router.push({name: 'viewtask-admin', params: {slug}});
  },
  editTask(slug){
   this.$router.push({name: 'edittask-admin', params: {slug}});
  },
  deleteTask(id){
   axios.delete(`/api/admin/delete-task/${id}`)
    .then(res => this.getAllTasks())
    .catch(err => console.log(err))
  },
  deleteFile(id){

  },
  notifyClient(id){
    axios.get(`/api/admin/notify-client/${id}`)
    .then(res => {
     this.success = res.data.success;
    })
    .catch(err => console.log(err))
  },
  updatePage(){
   this.getAllTasks();
  }
 }
}
</script>

<style>

</style>