<template>
<div>
  <b-navbar toggleable="lg" type="dark" class="navbar navbar-expand-md navbar-light custom-navbar-design bg-white shadow-sm">
    <b-navbar-brand to="/">STMS</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">

        <b-nav-item v-if="!login" to="/login">Login</b-nav-item>
        <b-navbar-nav v-else>
          <b-nav-item to="/admin/all-user">Home</b-nav-item>
          <b-nav-item to="/admin/all-client">Clients</b-nav-item>

          <b-nav-item-dropdown text="Tasks" right>
            <b-dropdown-item href="#">All Tasks</b-dropdown-item>
            <b-dropdown-item href="#">Add Task</b-dropdown-item>
          </b-nav-item-dropdown>

          <b-nav-item-dropdown right>
            <!-- Using 'button-content' slot -->
            <template v-slot:button-content>
              <b-img v-bind="mainProps" rounded="circle" alt="Circle image"></b-img>
            </template>
            <b-dropdown-item href="#">Profile</b-dropdown-item>
            <b-dropdown-item to="/logout">Sign Out</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
  
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</div>
</template>

<script>

export default {
  data(){
    return{
      mainProps: { blank: true, blankColor: '#777', width: 30, height: 30, class: 'm1' }
    }
  },
  computed: {
    login(){
      return User.loggedIn();
    }
  },
  created(){
    EventBus.$on('logout', () => {
      User.logout();
    })
  }
}
</script>

<style lang="scss">
.navbar-brand{
  border: none !important
}
.router-link{
  color: #fff !important;
  text-decoration: none;
}
.router-link-exact-active{
  border-bottom: 3px solid #00baff;
}
</style>