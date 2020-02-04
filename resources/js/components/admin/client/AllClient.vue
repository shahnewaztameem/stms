<template>
<div class="col-md-10">
    <div v-if="!clients.length" class="text-center" style="overflow:hidden">
      <b-spinner variant="info" style="width: 4rem; height: 4rem;" label="Text Centered"></b-spinner>
    </div>

    <div v-else>
        <h2 class="text-center">All Clients List</h2>
        <div role="separator" class="dropdown-divider"></div>
        <div v-if="success" class="alert alert-success container" id="div3">
            <strong>Success!</strong> {{success}}
        </div>
        <MyDataTable :users = "clients"/>
    </div>

</div>
</template>

<script>

import MyDataTable from '../MyDataTable';

export default {
    components:{
        MyDataTable,
    },
    data(){
        return {
            success: '',
            clients: [],
        }
    },
    created(){
        this.getAllClients();
    },
    methods:{
        getAllClients(){
        axios.get('/api/admin/clients')
            .then((res)=>{
            this.clients = res.data.data
            })
            .catch((err)=>console.log(err))
        },
      }
    }
</script>

<style>

</style>