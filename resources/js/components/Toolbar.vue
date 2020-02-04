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

          <b-nav-item-dropdown text="Users" :class="toggleAdminUserClass" right>
            <b-dropdown-item to="/admin/all-user">All Users</b-dropdown-item>
            <b-dropdown-item to="/admin/add-user">Add User</b-dropdown-item>
          </b-nav-item-dropdown>

          <b-nav-item-dropdown text="Clients" :class="toggleAdminClientClass" right>
            <b-dropdown-item to="/admin/all-client">All Clients</b-dropdown-item>
            <b-dropdown-item to="/admin/add-client">Add Client</b-dropdown-item>
          </b-nav-item-dropdown>

          <b-nav-item-dropdown text="Tasks" :class="toggleAdminTaskClass" right>
            <b-dropdown-item href="#">All Tasks</b-dropdown-item>
            <b-dropdown-item href="#">Add Task</b-dropdown-item>
          </b-nav-item-dropdown>

          <b-nav-item-dropdown right>
            <!-- Using 'button-content' slot -->
            <template v-slot:button-content>
              <b-img v-bind="mainProps" rounded="circle" alt="Circle image"></b-img>
            </template>
            <b-dropdown-item href="#">{{ name }}</b-dropdown-item>
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
      mainProps: { blank: true, blankColor: '#777', width: 30, height: 30, class: 'm1' },
      adminUserRoute: ['/admin/all-user', '/admin/add-user'],
      adminClientrRoute: ['/admin/all-client', '/admin/add-client'],
      adminTaskRoute: ['/admin/all-tasks', '/admin/add-task'],
    }
  },
  computed: {
    login(){
      return User.loggedIn();
    },
    name(){
      return User.name();
    },
    toggleAdminUserClass(){
      return this.adminUserRoute.indexOf(this.$route.path) > -1 ? 'activeRoute' : '';
    },
    toggleAdminClientClass(){
      return this.adminClientrRoute.indexOf(this.$route.path) > -1 ? 'activeRoute' : '';
    },
    toggleAdminTaskClass(){
      return this.adminTaskRoute.indexOf(this.$route.path) > -1 ? 'activeRoute' : '';
    },
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
.activeRoute{
  border-bottom: 3px solid #00baff;
}
</style>