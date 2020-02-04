<template>
   <div class="col-md-8">
       
    <div v-if="!user" class="text-center" style="overflow:hidden">
    <b-spinner variant="info" style="width: 4rem; height: 4rem;" label="Text Centered"></b-spinner>
    </div>

    <div v-else class="card">
     <div class="card-body">
      <h3 class="text-center my-3">
       Edit User
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

      <form @submit.prevent="updateUser()">
       <div class="form-group">
         <input type="text" class="form-control" name="name" id="email" placeholder="Enter name" v-model="user.name">
       </div>
       <div class="form-group">
         <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email-address" v-model="user.email">
       </div>
       <div class="form-group">
         <input type="password" name="password" class="form-control" id="password" v-model="form.password" placeholder="Password">
       </div>
       <div class="form-group">
         <input type="password" class="form-control" name="password_confirmation" v-model="form.password_confirmation" id="password" placeholder="Re-type Password">
       </div>
       <button type="submit" class="btn btn-primary">Update User</button>
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
            user: '',
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
        this.getDetails();
    },
    methods: {
        getDetails(){
            axios.get(`/api/admin/show-user/${this.$route.params.id}`)
                .then((res)=>{
                    this.user = res.data.data;
                })
                .catch((err)=>console.log(err));
        },
        updateUser(){
            this.form.name = this.user.name
            this.form.email = this.user.email
            let url = this.user.user_type == 2 ? `/api/admin/update-user/${this.user.id}` : `/api/admin/update-client/${this.user.id}`;
            axios.put(url, this.form)
                .then((res)=>{
                    console.log(res.data.user)
                    this.user = res.data.user
                    this.error = "";
                    this.validErr = "";
                    this.success = `User ${this.user.name} is updated successfully`;
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