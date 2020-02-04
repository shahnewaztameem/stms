<template>
<div class=" mt-2 container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <h3 class="text-center my-3">
                        LOGIN
                    </h3>

                    <div v-if="error.length" class="form-group row">
                        <div class="col-md-8 offset-md-2">
                            <div class="alert alert-danger">
                                <ul>
                                    <!-- @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach -->
                                    {{error}}
                                </ul>
                            </div>
                        </div>
                    </div>


                    <form @submit.prevent="login()">

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <input id="email" type="email" class="form-control" v-model="form.email" required placeholder="Email Address" autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <input id="password" type="password" class="form-control" v-model="form.password" required autocomplete="current-password" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-primary">
                                    Account Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
  export default {
    data: () => {
        return {
            valid: true,
            form: {
              email: '',
              password: '',
            },
            error: [],
        }
    },
    computed: {
      getError(){
        return this.error;
      }
    },
    created(){
      if(User.loggedIn()){
        this.$router.push({name: 'home'});
      }
    },
    methods: {
      validate () {
        if (this.$refs.form.validate()) {
          this.snackbar = true
        }
      },
      reset () {
        this.$refs.form.reset()
        this.error = [];
      },
      login(){
        User.login(this.form)
          .then(res => {
            res == true ? window.location = '/home' : this.error = res.error;
          })
      //  console.log(this.error);
      }
    },
  }
</script>

<style>

</style>