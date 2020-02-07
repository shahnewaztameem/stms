<template>
   <div class="col-md-6">
    <div class="card">
     <div class="card-body">
      <h3 class="text-center my-3">
       Change Password
      </h3>
      
      <div role="separator" class="dropdown-divider"></div>
    
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

      <form @submit.prevent="changePass">
       <div class="form-group">
         <input type="password" class="form-control" v-model="form.password" placeholder="Password">
       </div>
       <div class="form-group">
         <input type="password" class="form-control" v-model="form.password_confirmation" id="password" placeholder="Re-type Password">
       </div>
       <div class="">
        <span v-if="!loading">
          <button type="submit" class="btn btn-primary">
              Change Pass
          </button>
        </span>
        <span v-else>
          <b-button variant="primary" disabled>
              <b-spinner small type="grow"></b-spinner>
              Loading....
          </b-button>
        </span>
       </div>
      </form>
     </div>
    </div>
   </div>
</template>

<script>
export default {
    name: 'ChangePass',
    data(){
        return {
            success: '',
            error: '',
            validErr: "",
            form: {
                password: '',
                password_confirmation: '',
            },
            loading: false,
        }
    },
    created(){
        // this.getDetails();
    },
    methods: {
        changePass(){
         this.loading = true;

          axios.post('/api/client/pass-change', this.form)
              .then((res)=>{
                  this.error = "";
                  this.validErr = "";
                  this.success = `Your Password is changed successfully`;
                  this.form.password = '';
                  this.form.password_confirmation = '';
                  this.loading = false;

              })
              .catch((err)=>{
                  this.error = err.response.data.message;
                  this.validErr = err.response.data.errors;
                  this.loading = false;
              })
        }
    }
}
</script>