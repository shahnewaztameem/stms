<template>
   <div class="col-md-8">
    <div class="card">
     <div class="card-body">
      <h3 class="text-center my-3">
       Add User
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

      <form @submit.prevent="addUser()">
       <div class="form-group">
         <input type="text" class="form-control" placeholder="Enter name" v-model="form.name">
       </div>
       <div class="form-group">
         <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email-address" v-model="form.email">
       </div>
       <div class="form-group">
         <input type="password" class="form-control" v-model="form.password" placeholder="Password">
       </div>
       <div class="form-group">
         <input type="password" class="form-control" v-model="form.password_confirmation" id="password" placeholder="Re-type Password">
       </div>
       <button type="submit" class="btn btn-primary">Create User</button>
      </form>
     </div>
    </div>
   </div>
</template>

<script>
export default {
    name: 'EditUser',
    data(){
        return {
            success: '',
            error: '',
            validErr: "",
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            }
        }
    },
    created(){
        // this.getDetails();
    },
    methods: {
        addUser(){
          axios.post('/api/admin/store-user', this.form)
              .then((res)=>{
                  this.error = "";
                  this.validErr = "";
                  this.success = `User (${this.form.name}) is added successfully`;
                  this.form.name = '';
                  this.form.email = '';
                  this.form.password = '';
                  this.form.password_confirmation = '';
              })
              .catch((err)=>{
                  this.error = err.response.data.message;
                  this.validErr = err.response.data.errors;
              })
        }
    }
}
</script>

<style>

</style>