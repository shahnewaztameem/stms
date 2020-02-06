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
            
                
            <!-- <footer v-if="task.users.length" class="blockquote-footer"><cite>{{ task.users[0].name }}</cite></footer> -->
            
          </blockquote>
          </div>
          <div class="col-3">
          <center>
            <button @click="viewTask(task.slug)" class="add-btn h1 text-success" data-toggle="tooltip" data-placement="bottom" title="View Task">
                <b-icon-eye-fill></b-icon-eye-fill>
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
                      </center>
                    </div>
                  </div>
                </li>
               
            </ul>
            <div role="separator" class="dropdown-divider"></div>
         </div>

        </div>
      </div>

      <!-- <div class="mt-3">
         <b-pagination
           v-model="currentPage"
           :total-rows="rows"
           :per-page="perPage"
           @input="updatePage()"
           align="center"
         ></b-pagination>
      </div> -->
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
   axios.get('/api/client/all-tasks')
    .then(res => {
     this.tasks = res.data.data.tasks;
     // this.paginate = res.data.meta;
    })
    .catch(err => console.log(err))
  },
  viewTask(slug){
   this.$router.push({name: 'viewtask-client', params: {slug}});
  },
  updatePage(){
   this.getAllTasks();
  }
 }
}
</script>

<style>

</style>