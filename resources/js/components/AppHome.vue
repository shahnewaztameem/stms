<template>
  <div>
      <toolbar></toolbar>
      <router-view></router-view>
  </div>
</template>

<script>
import toolbar from './Toolbar'

export default {
    name: 'AppHome',
    components: {
        toolbar,
    }
}
</script>

<style>

</style>