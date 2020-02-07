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
            
            <div v-if="user.user_type == 2">
             <p class="card-text"><strong>Assigned User Info: </strong></p>
             <p class="card-text"><strong>User Name:</strong> {{ user.name }}</p>
             <p class="card-text"><strong>User Email:</strong> {{ user.email }}</p>
            </div>

           </div>
          </div>

          <div v-if="task.feedback">
            <div role="separator" class="dropdown-divider"></div>
            <div class="row">
             <div class="col-10">
              <strong>You Rate :</strong> {{task.feedback.rating}}/5
              <p class="card-text"><strong>You Comment :</strong>{{ task.feedback.comment }}</p>
             </div>
             <div class="col-2">
              <button @click="deleteFeedback(task.feedback.id)"
                class="edit-btn h1 text-danger"
                data-toggle="tooltip"
                data-placement="bottom"
                title="Delete Task">
                 <b-icon-trash-fill></b-icon-trash-fill>
               </button>
             </div>
            </div>
          </div>
    
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
                             
                          </center>
                        </div>
                      </div>
                    </li>
                </ul>
            </div>
          </div>
        </div>

       <div v-if="!task.feedback">
          <div class="card mb-3">
            <div class="card-body">

             <blockquote class="blockquote mb-0">
              <h3 class="text-center">
               Give Feedback
              </h3>
             </blockquote>

             <div v-if="error" class="form-group row">
                 <div class="col-md-8 offset-md-2">
                     <div class="alert alert-danger">
                         <ul>
                            <li>{{ error }}</li>
                         </ul>
                     </div>
                 </div>
             </div>

             <div role="separator" class="dropdown-divider"></div>

             <div class="col-10 offset-1">
              <form @submit.prevent="addFeedback">
               <div class="form-group">
                <div class="row">
                 <div class="col-2"><label class="h5" for="radio-validation">Rate:* </label></div>
                 <div class="col-10">
                  <b-form-radio-group v-model="star" :options="options" :state="state" name="radio-validation">
                   <b-form-invalid-feedback :state="state">Please select one</b-form-invalid-feedback>
                  </b-form-radio-group>
                 </div>
                </div>
               </div>

               <div class="form-group">
                <div class="row">
                 <div class="col-2"><label class="h5" for="comment">Comment: </label></div>
                 <div class="col-10">
                  <textarea class="form-control" v-model="comment" id="comment" cols="30" rows="3" placeholder="Enter Comment"></textarea>
                 </div>
                </div>
                
               </div>

               <div role="separator" class="dropdown-divider"></div>

               <div class="form-group row mb-0">
                <div class="col-md-4 offset-md-4 text-center">
                  <span v-if="!loading">
                   <button type="submit" class="btn btn-primary">
                       Submit Feedback
                   </button>
                 </span>
                 <span v-else>
                   <b-button variant="primary" disabled>
                       <b-spinner small type="grow"></b-spinner>
                       Loading....
                   </b-button>
                 </span>
                </div>
               </div>

              </form>
             </div>
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
   errorFound: '',
   star: null,
   options: [
     { text: 'Very bad', value: '1' },
     { text: 'Poor', value: '2' },
     { text: 'OK', value: '3' },
     { text: 'Good', value: '4' },
     { text: 'Excellent', value: '5' },
   ],
   comment: '',
   loading: false
  }
 },
 computed: {
   state() {
     return Boolean(this.star)
   }
 },
 created(){
  this.getTask();
 },
 methods: {
  getTask(){
   axios.get(`/api/client/view-task-client/${this.$route.params.slug}`)
    .then(res => {
     this.task = res.data.data
    })
    .catch(err => console.log(err))
  },
  addFeedback(){
   this.loading = true;
   axios.post(`/api/client/store-feedback/${this.task.id}`, 
    {
     star: this.star,
     comment: this.comment,
    })
    .then(res => this.getTask())
    .catch(err => console.log(err))
  },
  deleteFeedback(id){
   axios.delete(`/api/client/delete-feedback/${id}`)
    .then(res => this.getTask())
    .catch(err => console.log(err))
  }
 }
}
</script>