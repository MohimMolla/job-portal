<template>
  <div class="card card-outline card-info">
    <div class="card-body">
      <table id="datatable" class="table text-sm table-bordered table-striped">
        <thead>
          <tr>
            <th width="40%">Name</th>
            <th width="30%">Created</th>
            <th width="20%" class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(skill, idx) in categories.data" :key="idx">
            <td>{{ skill.name }}</td>
            <td>{{ formatTime(skill.created_at) }}</td>
            <td class="text-center">
              <button class="mr-1 btn btn-success btn-sm" @click="emitForm(skill)">
                <i class="fa fa-edit"></i>
              </button>
              <button class="btn btn-danger btn-sm" @click="deleteRecord(skill.id)">
                <i class="fa fa-trash"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="mt-2 pagination-container">
        <pagination :data="categories" @pagination-change-page="getResults"></pagination>
      </div>
    </div>
  </div>
</template>

<script>
  const Swal = require('sweetalert2')
  const toastr = require('toastr')
  const routes = window.app.url
  const moment = require('moment')

  export default {
    name: 'skillTable',
    data() {
      return {
        categories: {},
      }
    },
    methods: {
      fetchingAllskill() {
        axios.get(routes.paginate).then(data => (this.categories = data.data))
      },
      getResults(page = 1) {
        axios.get(`${routes.paginate}?page=${page}`).then(response => {
          this.categories = response.data
        })
      },
      formatTime(time) {
        return moment(time).fromNow()
      },
      emitForm(skill) {
        Event.$emit('fillForm', skill)
      },
      deleteRecord(id) {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!',
        }).then(result => {
          if (result.isConfirmed) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            window.axios.delete(`${routes.delete}/${id}`, {token})
              .then(resp => {
                toastr.success(resp.data.message);
                Event.$emit('load_skill');
              })
              .catch(err => {
                console.error(err);
                Swal.fire("Something went wrong, please try again!")
              })
          }
        })
      },
    },
    computed: {},
    created() {
      this.fetchingAllskill()
      Event.$on('load_skill', () => {
        this.fetchingAllskill()
      })
    },
    mounted() {},
  }
</script>

<style></style>
