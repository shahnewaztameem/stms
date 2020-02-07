<template>
  <div>        
    <div v-if="!user.length" class="text-center" style="overflow:hidden">
      <b-spinner variant="info" style="width: 4rem; height: 4rem;" label="Text Centered"></b-spinner>
    </div>
  </div>
</template>

<script>
export default {
 data(){
  return {
   user: '',
   err: '',
  }
 },
 created() {
  console.log(`/api/auth/login-from-notification/${this.$route.params.slug}`)
  this.getUser()
 },
 methods: {
  getUser(){
   axios.get(`/api/auth/login-from-notification/${this.$route.params.slug}`)
    .then(res => {
     if (User.loggedIn()) {
      User.logout();
     }
     this.loginAndRedirect();
    })
    .catch(err => {})
  },
  loginAndRedirect(){}
 }
}
</script>