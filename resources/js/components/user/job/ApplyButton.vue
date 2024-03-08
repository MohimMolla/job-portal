<template>
  <div class="my-2">
    <button
      data-backdrop="static"
      data-keyboard="false"
      data-toggle="modal"
      data-target="#applyModal"
      class="px-5 btn btn-primary"
    >
      <i class="fas fa-handshake mr-2" aria-hidden="true"></i>
      Apply
    </button>
    <div class="modal" tabindex="-1" id="applyModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Apply to {{ company }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="handleSubmit">
            <div class="modal-body">
              <div class="mx-2 row">
                <div class="col-12">
                  <h5>Contact Info</h5>
                  <div class="row">
                    <div class="col-lg-1 col-md-2 col-sm-2">
                      <img
                        :src="setUserImage()"
                        width="50"
                        height="50"
                        class="img-fluid img-circle img-bordered"
                        alt="Image"
                      />
                    </div>
                    <div class="col-lg-11 col-md-10 col-sm-10">
                      <div>
                        <div class="username">{{ username }}</div>
                        <div class="jobrole">{{ jobrole }}</div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="mb-3">
                        <label class="text-secondary" for="email">Email <span class="required">*</span></label>
                        <input
                          id="email"
                          type="email"
                          name="email"
                          class="form-control"
                          readonly
                          required
                          v-model="currentEmail"
                        />
                      </div>
                      <div class="mb-1">
                        <label class="text-secondary" for="email">Phone <span class="required">*</span></label>
                        <input
                          id="phone"
                          type="text"
                          name="phone"
                          class="form-control"
                          v-model="currentPhone"
                          ref="phone"
                          required
                          autofocus
                        />
                      </div>

                      <div class="mb-3">
                        <h4>Resume</h4>
                        <label>Please include a resume</label>
                        <div v-if="!resumeCancelled" class="row">
                          <div class="resume-box d-flex justify-content-around aign-items-center">
                            <div class="resume-left">PDF</div>
                            <div class="resume-middle">
                              <div>
                                {{ `${resume.split('.')[0]}` }}
                              </div>
                              <a :href="`/storage/cv/${resume}`" class="download-btn" download="">
                                <i class="mr-2 fas fa-download"></i> Download
                              </a>
                            </div>
                            <button type="button" class="delete-btn" @click="resumeCancelled = !resumeCancelled">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        </div>
                        <div v-if="resumeCancelled" class="row">
                          <div class="col-12">
                            <div
                              v-if="hasResume"
                              class="border rounded p-2 d-flex justify-content-between aign-items-center"
                            >
                              <div>
                                {{ `${resume.split('.')[0]}` }}
                              </div>
                              <div class="d-flex justify-content-between aign-items-center">
                                <div class="mr-2">
                                  <a href="#" @click="chooseResume">Choose</a>
                                </div>
                                <div>
                                  <a :href="`/storage/cv/${resume}`" class="download-btn bg-light-cyan" download="">
                                    <i class="fas fa-download"></i>
                                  </a>
                                </div>
                              </div>
                            </div>
                            <div class="mt-1">
                              <label class="btn btn-outline-primary" for="resume">Upload a resume</label>
                              <input
                                type="file"
                                name="resume"
                                ref="resume"
                                id="resume"
                                @change="handleResumeUpload"
                                class="d-none"
                                accept=".docx, .doc, .pdf, .jpg, .jpeg"
                              />
                              <p class="text-secondary m-0">DOC, DOCX, PDF, JPEG, JPG</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Submit application</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  const route = window.app.url;
  const toastr = require('toastr');
  export default {
    data() {
      return {
        currentEmail: '',
        currentPhone: '',
        resumeCancelled: false,
        currentResume: '',
      };
    },
    props: {
      company: String,
      username: String,
      jobrole: String,
      email: String,
      resume: String,
      phone: String,
      image: String,
    },
    methods: {
      setUserImage() {
        // /storage/avatar/${image}
        if (this.image == 'avatar.jpg') {
          return `/img/${this.image}`;
        } else {
          return `/storage/avatar/${this.image}`;
        }
      },
      handleResumeUpload() {
        this.currentResume = this.$refs.resume.files[0];
        console.log(this.currentResume);
      },
      chooseResume() {
        this.currentResume = '';
        this.resumeCancelled = !this.resumeCancelled;
      },
      handleSubmit() {
        if (this.currentPhone.length < 10) {
          toastr.error('Phone is required');
          this.$refs.phone.focus();
        }

        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const formData = new FormData();

        if (this.resumeCancelled) {
          console.log(this.currentResume.name, typeof this.currentResume.name == 'undefined');
          if (typeof this.currentResume.name == 'undefined') {
            toastr.error('Resume field is required');
            return;
          } else {
            formData.append('resume', this.currentResume);
          }
        }

        formData.append('email', this.currentEmail);
        formData.append('phone', this.currentPhone);
        formData.append('token', token);

        window.axios
          .post(route.jobApply, formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          })
          .then(resp => {
            if (resp.data.success) {
              toastr.success('Applied for ' + this.company, resp.data.message);
              setTimeout(() => {
                window.location.href = '/';
              }, 2000);
            }
          })
          .catch(err => {
            console.error(err);
            toastr.error(err.response.data.message);
          });
      },
    },
    mounted() {
      this.currentEmail = this.email;
      this.currentPhone = this.phone;

      if (this.resume.length > 0) {
        this.resumeCancelled = false;
      } else {
        this.resumeCancelled = true;
      }
    },
    computed: {
      hasResume() {
        if (this.resume.length > 0) {
          return true;
        }
      },
    },
    watch: {},
  };
</script>

<style scoped>
  .required {
    color: magenta;
  }
  .resume-box {
    position: relative;
    box-sizing: border-box;
  }

  .resume-box .resume-left {
    background: #ff0018;
    padding: 1rem 0.5rem;
    color: white;
    font-weight: bold;
    border-radius: 5px 0 0 5px;
  }

  .resume-box .resume-middle {
    position: relative;
    background: #fff;
    padding: 1rem 0.5rem;
    border-radius: 0 5px 5px 0;
    border: 1px solid #ccc;
  }

  .resume-box .download-btn {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    justify-content: center;
    align-items: center;
    height: 100%;
    background: #ccc;
    opacity: 0.9;
    color: #666;
    font-weight: 400;
    display: none;
  }
  .resume-middle:hover .download-btn {
    display: flex;
  }
  .resume-left:hover .download-btn {
    display: flex;
  }
  .resume-box .delete-btn {
    background: white;
    border: none;
    outline: none;
    font-size: 1.3rem;
    position: absolute;
    top: 13px;
    right: 15px;
    width: 30px;
    height: 30px;
    border-radius: 15px;
    text-align: center;
    justify-content: center;
    align-items: center;
    display: flex;
  }

  .delete-btn:hover {
    background: #ccc;
  }
</style>
