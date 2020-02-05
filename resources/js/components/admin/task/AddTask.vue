<template>
  <div class="col-md-8">

       
    <!-- <div v-if="!users.length || !clients.length" class="text-center" style="overflow:hidden">
      <b-spinner variant="info" style="width: 4rem; height: 4rem;" label="Text Centered"></b-spinner>
    </div> -->

    <div class="card">
     <div class="card-body">
      <h3 class="text-center my-3">
       Create New Task
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

      <form @submit.prevent="addTask">

        <div class="form-group">
          <model-select :options="clientOption"
                        v-model="form.client_name"
                        placeholder="Select Client Name">
                        required
         </model-select>
        </div>

       <!-- <div class="form-group">
          <select v-model="form.client_name" class="form-control select-search" data-live-search="true">
            <option value="">SELECT CLIENT NAME</option>
            <option v-for="(client, index) in clients" :key="index" :value="client.id">{{ client.name }}</option>
          </select>
        </div> -->
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

       <!-- <div class="form-group">
        <select v-model="form.user_name" class="form-control select-search" data-live-search="true">
          <option value="">ASSIGN TO USER</option>
          <option v-for="(user, index) in users" :key="index" :value="user.id">{{ user.name }}</option>
        </select>
      </div> -->

      <!-- <div class="custom-file mb-3">
        <label class="custom-file-label" for="file_upload">Choose file...</label>
        <b-form-file
          placeholder="Choose a file or drop it here..."
          drop-placeholder="Drop file here..."
          multiple
          ref="files" @change="handleFiles()"
        ></b-form-file>
      </div> -->
      <div class="custom-file mb-3">
        <label class="custom-file-label" for="file_upload">{{ fileText }}</label>
        <input type="file" ref="files" @change="handleFiles" class="custom-file-input" id="files" multiple>
      </div>

      <button type="submit" class="btn btn-primary">Create Task</button>
      </form>
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
  addTask(){

    let formData = new FormData();
    formData.append('title', this.form.title);
    formData.append('details', this.form.details);
    formData.append('client_name', this.form.client_name);
    formData.append('user_name', this.form.user_name);

    for (let i = 0; i < this.form.task_files.length; i++) {
     formData.append('task_files[]', this.form.task_files[i])
    }

    const config = {
      headers: { 'content-type': 'multipart/form-data' }
    }
    axios.post('/api/admin/store-task', formData, config)
      .then((res)=>{
            this.error = "";
            this.validErr = "";
            this.success = `Task (${this.form.title}) is added successfully`;
            this.form.client_name = '';
            this.form.user_name = '';
            this.form.title = '';
            this.form.details = '';
            const input = this.$refs.files;
            input.type = 'text';
            input.type = 'file';
            this.form.task_files = [];
      })
      .catch((err)=>{
          this.error = err.response.data.message ? err.response.data.message : err.response.data.error;
          this.validErr = err.response.data.errors;
      })
  }
  }
}
</script>

<style>

</style>