<template>
  <div class="main-div">
     <b-img src="https://picsum.photos/1024/400/?image=41" fluid alt="Responsive image" class="home-img"></b-img>
     <section class="project-text">
         <h1 class="text-center">Simple Task Management System</h1>
     </section>
  </div>
</template>

<script>
export default {

}
</script>

<style>
    .home-img{
        height: 89vh;
        min-height: 500px;
        overflow-y: hidden !important;
    }
    .main-div{
        position: relative;

    }
    .project-text{
        position: absolute;
        width: 100%;
        color: #ffffff;
        top: 35%
    }
</style>