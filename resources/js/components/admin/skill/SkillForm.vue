<template>
  <form @submit.prevent="handleSubmit">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit"></i> {{ editMode ? "Update" : "Create" }} new Skill</h3>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label for="name" class="col-form-label text-primary">Skill Name</label>
          <input
            type="text"
            id="name"
            class="form-control"
            :class="{ 'is-invalid': errors.name }"
            v-model="name"
            autofocus
          />
          <span v-if="errors.name" class="invalid-feedback">
            <strong>{{ errors.name }}</strong>
          </span>
        </div>
        <div class="mb-3">
          <label for="description" class="col-form-label text-primary">Description</label>
          <textarea
            name="description"
            id="description"
            class="form-control"
            :class="{ 'is-invalid': errors.description }"
            v-model="description"
          ></textarea>
          <span v-if="errors.description" class="invalid-feedback">
            <strong>{{ errors.description }}</strong>
          </span>
        </div>
        <div class="mb-1 row">
          <div class="d-flex justify-content-between align-items-center col-12">
            <button title="Save" class="btn btn-success"><i class="fa fa-save"></i> {{ editMode ? "Update" : "Save" }}</button>
            <button v-if="editMode" type="button" class="btn btn-danger" @click="enableCreateMode">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
  const routes = window.app.url
  const toastr = require('toastr')
  export default {
    name: 'skillForm',
    data() {
      return {
        name: null,
        description: null,
        id: null,
        editMode: false,
        errors: {
          name: null,
          description: null,
        },
      }
    },
    methods: {
      handleSubmit() {
        if (this.name) {
          const data = {
            name: this.name,
            description: this.description,
            token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          }

          if (!this.editMode) {
            window.axios
              .post(routes.store, data)
              .then(resp => {
                toastr.success(resp.data.message);
                this.clearForm()
                Event.$emit('load_skill')
              })
              .catch(err => {
                if (err.response.status == 422) {
                  let {
                    data: {
                      message,
                      errors: { name },
                    },
                  } = err.response
                  toastr.error(message);
                  this.errors.name = name[0]
                  this.name = ''
                }
                return
              })
          }

          if (this.editMode) {
            window.axios
              .put(`${routes.update}/${this.id}`, data)
              .then(resp => {
                this.errorMessage = null
                this.successMessage = resp.data.message
                this.clearForm()
                Event.$emit('load_skill')
              })
              .catch(err => {
                if (err.response.status == 422) {
                  let {
                    data: {
                      message,
                      errors: { name },
                    },
                  } = err.response
                  this.successMessage = null
                  this.errorMessage = message
                  this.errors.name = name[0]
                  this.name = ''
                }
                return
              })
          }
        }

        this.errors.name = null

        if (!this.name) {
          this.errors.name = 'Name field cannot be empty'
        }
      },
      fillEditForm(item) {
        this.editMode = true
        this.id = item.id
        this.name = item.name
        this.description = item.description
      },
      clearForm() {
        this.editMode = false
        this.name = ''
        this.description = ''
        this.id = ''
      },
      enableCreateMode() {
        this.clearForm()
        this.errors.name = null
      },
    },
    created() {
      Event.$on('fillForm', skill => {
        this.fillEditForm(skill)
      })
    },
    mounted() {},
  }
</script>

<style></style>
