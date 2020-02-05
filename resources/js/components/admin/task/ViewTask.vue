<template>
<div>
                
    <div v-if="!task" class="text-center" style="overflow:hidden">
      <b-spinner variant="info" style="width: 4rem; height: 4rem;" label="Text Centered"></b-spinner>
    </div>

    <div v-else>
     <div v-if="success" class="alert alert-success container" id="div3">
       <strong>Success!</strong> {{ success }}
     </div>


      <div class="card mb-3">
       <div class="card-body">

        <blockquote class="blockquote mb-0">
         <h3>{{ task.title }}<small class="text-muted posted-text"> Posted {{ task.created_at }}</small>
         </h3>
        </blockquote>

        <div role="separator" class="dropdown-divider"></div>

         <p class="card-text">{{ task.details }}</p>

         <div role="separator" class="dropdown-divider"></div>
         
         <div v-if="task.users">
           <div v-for="(user, index) in task.users" :key="index">
            
            <div v-if="user.user_type == 1">
             <p class="card-text"><strong>Task Owner Info: </strong></p>
             <p class="card-text"><strong>Client Name:</strong> {{ user.name }}</p>
             <p class="card-text"><strong>Client Email:</strong> {{ user.email }}</p>
            </div>
            
            <div v-if="user.user_type == 2">
             <div role="separator" class="dropdown-divider"></div>
             <p class="card-text"><strong>Assigned User Info: </strong></p>
             <p class="card-text"><strong>User Name:</strong> {{ user.name }}</p>
             <p class="card-text"><strong>User Email:</strong> {{ user.email }}</p>
            </div>

           </div>
          </div>

          <div v-if="task.feedback">
            <div class="row">
             <div class="col-10">
              <strong>Client Rate :</strong> {{task.feedback.rating}}/5
              <p class="card-text"><strong>Client Comment :</strong>{{ task.feedback.comment }}</p>
             </div>
            </div>
          </div>
          <div role="separator" class="dropdown-divider"></div>
    
       </div>
      </div>

      <div v-if="task.task_files.length">
        <div class="card mb-3">
          <div class="card-body">
              <p class="card-text"><strong>Attached Files: </strong></p>
              <ul class="list-group">

                  <li v-for="(file, index) in task.task_files"
                      :key="index"
                      class="list-group-item list-group-item-default">
                    <div class="row">
                      <div class="col-10">
                          <a href="#" target="_blank">{{ file.file_url }}</a>
                      </div>
                      <div class="col-2">
                        <center>
                           <button @click="deleteFile(file.id)" class="edit-btn h1 text-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Task">
                               <b-icon-trash-fill></b-icon-trash-fill>
                           </button>
                        </center>
                      </div>
                    </div>
                   <div role="separator" class="dropdown-divider"></div>
                  </li>
              </ul>
          </div>
        </div>
      </div>
    </div>
</div>
</template>

<script>
export default {
 data(){
  return {
   task: '',
   success: '',
  }
 },
 created(){
  this.getTask();
 },
 methods: {
  getTask(){
   axios.get(`/api/admin/view-task/${this.$route.params.slug}`)
    .then(res => {
     this.task = res.data.data
    })
    .catch(err => console.log(err))
  },
  deleteFile(id){
   axios.delete(`/api/admin/delete-file/${id}`)
    .then(res => this.getTask())
    .catch(err => console.log(err))
  }
 }
}
</script>

<style>

</style>