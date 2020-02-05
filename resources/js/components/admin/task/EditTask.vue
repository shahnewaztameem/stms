<template>
  <div class="col-md-8">

       
    <div v-if="!task" class="text-center" style="overflow:hidden">
      <b-spinner variant="info" style="width: 4rem; height: 4rem;" label="Text Centered"></b-spinner>
    </div>

    <div v-else>
     <div class="card">
      <div class="card-body">
       <h3 class="text-center my-3">
        Edit Task
       </h3>

       <div v-if="success" class="alert alert-success container" id="div3">
         <strong>Success!</strong> {{success}}
       </div>

       <div v-if="error" class="alert alert-danger container" id="div3">
           <strong>Error!</strong> {{error}}
       </div>

       <div v-if="validErr" class="form-group row">
         <div class="col-md-12">
           <div class="alert alert-danger">
             <ul>
                 <li v-for="(err, index) in validErr" :key="index">{{ err[0] }}</li>
             </ul>
           </div>
         </div>
       </div>

       <form @submit.prevent="updateTask">

         <div class="form-group">
           <model-select :options="clientOption"
                         v-model="form.client_name"
                         placeholder="Select Client Name">
                         required
          </model-select>
         </div>

        <div class="form-group">
          <input type="text" class="form-control" v-model="form.title" required placeholder="Enter title">
        </div>

        <div class="form-group">
          <textarea v-model="form.details" class="form-control" cols="30" rows="5" required placeholder="Enter details"></textarea>
        </div>

        <div class="form-group">
          <model-select :options="userOption"
                        v-model="form.user_name"
                        placeholder="Select User Name">
                        required
         </model-select>
        </div>
       <div class="custom-file mb-3">
         <label class="custom-file-label" for="file_upload">{{ fileText }}</label>
         <input type="file" ref="files" @change="handleFiles" class="custom-file-input" id="files" multiple>
       </div>

       <button type="submit" class="btn btn-primary">Update Task</button>
       </form>
      </div>
     </div>

     <div v-if="task.task_files.length" class="mt-3">
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

import { ModelSelect } from 'vue-search-select';

export default {
  components: {ModelSelect},
 data(){
  return {
   form: {
    client_name: '',
    user_name: '',
    title: '',
    details: '',
    task_files: [],
   },
   users: [],
   clients: [],
   task: '',
   error: '',
   validErr: '',
   success: '',
   clientOption: [],
   userOption: [],
  }
 },
 mounted(){
   this.getClients();
   this.getUsers();
   this.getTask();
 },
 computed: {
   getAllClients(){
     this.clients.forEach(element => {
       let op = {
         value: element.id,
         text: element.name,
       }
       this.clientOption.push(op);
     });
   },
   fileText(){
     return this.form.task_files.length ? this.form.task_files.length + ' files selected' : 'Choose file...';
   }
 },
 methods: {
  handleFiles() {
     this.form.task_files = [];
    let uploadedFiles = this.$refs.files.files;

    if (uploadedFiles) {
      
      for(var i = 0; i < uploadedFiles.length; i++) {
          this.form.task_files.push(uploadedFiles[i]);
      }
    }
    console.log(this.form.task_files);
  },
  getClients(){
    axios.get('/api/admin/clients')
      .then(res => {
        this.clients = res.data.data;
        this.formatOptions();
        })
      .catch(err => console.log(err))
  },
  getUsers(){
    axios.get('/api/admin/users')
      .then(res => {
        this.users = res.data.data
        this.formatUserOptions();
        })
      .catch(err => console.log(err))
  },
  formatOptions(){
    this.clients.forEach(element => {
       let op = {
         value: element.id,
         text: element.name,
       }
       this.clientOption.push(op);
     });
  },
  formatUserOptions(){
    this.users.forEach(element => {
       let op = {
         value: element.id,
         text: element.name,
       }
       this.userOption.push(op);
     });
  },
  updateTask(){

    let formData = new FormData();
    formData.append('title', this.form.title);
    formData.append('details', this.form.details);
    formData.append('client_name', this.form.client_name);
    formData.append('user_name', this.form.user_name);

   if (this.form.task_files.length) {
    
    for (let i = 0; i < this.form.task_files.length; i++) {
     formData.append('task_files[]', this.form.task_files[i])
    }
   }
    const config = {
      headers: { 'content-type': 'multipart/form-data' }
    }
    axios.post(`/api/admin/update-task/${this.task.id}`, formData, config)
      .then((res)=>{
            this.error = "";
            this.validErr = "";
            this.success = `Task (${this.form.title}) is added successfully`;
            this.task = res.data.task;
            const input = this.$refs.files;
            input.type = 'text';
            input.type = 'file';
            this.form.task_files = [];
      })
      .catch((err)=>{
          this.error = err.response.data.message ? err.response.data.message : err.response.data.error;
          this.validErr = err.response.data.errors;
      })
  },
  getTask(){
   axios.get(`/api/admin/view-task/${this.$route.params.slug}`)
    .then(res => {
     this.task = res.data.data
     this.form.title = this.task.title;
     this.form.details = this.task.details;
     if (this.task.users.length) {
      this.form.client_name = this.task.users[0].id;
      this.form.user_name = this.task.users[1].id;
     }
     console.log(this.form)
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