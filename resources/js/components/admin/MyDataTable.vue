<template>
  <b-container fluid>

      <!-- User Interface controls -->
      <b-row class="mb-2">
        <b-col lg="6" class="my-1">
          <b-form-group
            label="Per page"
            label-cols-sm="6"
            label-cols-md="4"
            label-cols-lg="3"
            label-align-sm="right"
            label-size="sm"
            label-for="perPageSelect"
            class="mb-0"
          >
            <b-form-select
              v-model="perPage"
              id="perPageSelect"
              size="sm"
              :options="pageOptions"
            ></b-form-select>
          </b-form-group>
        </b-col>

        <!-- filter options -->
        <b-col lg="6" class="my-1">
          <b-form-group
            label="Filter"
            label-cols-sm="3"
            label-align-sm="right"
            label-size="sm"
            label-for="filterInput"
            class="mb-0"
          >
            <b-input-group size="sm">
              <b-form-input
                v-model="filter"
                type="search"
                id="filterInput"
                placeholder="Type to Search"
              ></b-form-input>
              <b-input-group-append>
                <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
              </b-input-group-append>
            </b-input-group>
          </b-form-group>
        </b-col>
      </b-row>

      <!-- Main table element -->
      <b-table
        show-empty
        small
        stacked="md"
        :items="items"
        :fields="fields"
        :current-page="currentPage"
        :per-page="perPage"
        :filter="filter"
        :filterIncludedFields="filterOn"
        @filtered="onFiltered"
      >

        <template v-slot:row-details="row">
          <b-card>
            <ul>
              <li>{{row.item.id}}</li>
              <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
            </ul>
          </b-card>
        </template>

        <!-- ACTION BTNS  -->
        <template v-slot:cell(actions)="row">

          <b-button size="sm" @click="row.toggleDetails;editUser(row.item.id)">
            {{ row.detailsShowing ? 'Hide' : 'Edit' }} Details
          </b-button>

          <b-button size="sm" @click="info(row.item, row.index, $event.target)" class="mr-1 btn-danger">
            Delete User
          </b-button>

        </template>
      </b-table>

      <!-- Delete modal -->
      <b-modal :id="infoModal.id" :title="infoModal.title" ok-only @ok="deleteUser(infoModal.userID)" @hide="resetInfoModal">
        <!-- <pre>{{ infoModal.content }}</pre> -->
        <div class="alert alert-danger">
          Do you want to delete?
        </div>
      </b-modal>

      <!-- Pagiantion  -->
      <b-row class="text-center">
        
        <b-col sm="6" class="my-1 offset-sm-3">
          <b-pagination
            v-model="currentPage"
            :total-rows="totalRows"
            :per-page="perPage"
            align="fill"
            size="sm"
            class="my-0"
          ></b-pagination>
        </b-col>
      </b-row>
  </b-container>
</template>

<script>
  export default {
    name: 'MyDataTable',
    props: ['users'],
    data() {
      return {
        items: this.users,
        fields: [
          { key: 'id', label: 'Person ID', sortable: true, sortDirection: 'desc', class: "text-center" },
          { key: 'name', label: 'Person name', sortable: true, sortDirection: 'desc', class: "text-center" },
          { key: 'email', label: 'Person email', sortable: true, class: 'text-center' },
          { key: 'created_at', label: 'Member since', sortable: true, class: 'text-center' },
          { key: 'actions', label: 'Actions', class: "text-center"}
        ],
        totalRows: 1,
        currentPage: 1,
        perPage: 5,
        pageOptions: [5, 10, 25, 50],
        sortBy: '',
        sortDesc: false,
        sortDirection: 'asc',
        filter: null,
        filterOn: [],
        infoModal: {
          id: 'info-modal',
          title: '',
          content: '',
          userID: ''
        }
      }
    },
    computed: {
      sortOptions() {
        // Create an options list from our fields
        return this.fields
          .filter(f => f.sortable)
          .map(f => {
            return { text: f.label, value: f.key }
          })
      }
    },
    mounted() {
      // Set the initial number of items
      this.totalRows = this.items.length
    },
    created(){
      // console.log(this.users, this.items)
      // this.getAllUsers();
    },
    methods: {
      info(item, index, button) {
        this.infoModal.userID = item.id;
        this.infoModal.title = `Delete User: <strong>${item.name}</strong>`
        this.infoModal.content = JSON.stringify(item, null, 2)
        this.$root.$emit('bv::show::modal', this.infoModal.id, button)
      },
      resetInfoModal() {
        this.infoModal.title = ''
        this.infoModal.content = ''
         this.infoModal.userID = ''
      },
      onFiltered(filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        this.totalRows = filteredItems.length
        this.currentPage = 1
      },
      getAllUsers(){
        axios.get('/api/admin/users')
          .then((res)=>{
            console.log(res.data);
            this.items = res.data.data
            this.totalRows = this.items.length
          })
          .catch((err)=>console.log(err))
      },
      deleteUser(id){
        console.log(id);
      },
      editUser(id){
        this.$router.push({name: 'edituser', params: {id}});
      }
    }
  }
</script>