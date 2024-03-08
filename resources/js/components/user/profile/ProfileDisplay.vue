<template>
  <div class="row">
    <div class="col-md-4">
      <!-- Profile Image -->
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img
              :src="imgStr"
              alt="User profile picture"
              width="100"
              height="100"
              class="profile-user-img img-fluid img-circle"
            />
          </div>
          <h3 class="text-center profile-username">{{ name }}</h3>
          <p class="text-center text-muted">{{ jobrole }}</p>
          <p class="text-center text-muted">{{ jobTypeName }}</p>
          <p class="text-center text-muted">{{ experienceLabel }}</p>
        </div>
        <!-- ./card-body -->
      </div>
      <!-- ./card -->
      <!-- About Me Box -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">About Me</h3>
        </div>
        <!-- ./card-header -->
        <div class="card-body">
          <strong><i class="mr-1 fa fa-book"></i> Education</strong>

          <p class="text-muted">{{ education }}</p>

          <strong><i class="mr-1 fas fa-map-marker-alt"></i>Job Locations</strong>

          <p class="text-muted">{{ locationNames }}</p>

          <hr />

          <strong><i class="mr-1 fas fa-pencil-alt"></i> Skills</strong>

          <p class="text-muted">{{ skillNames }}</p>

          <hr />

          <strong><i class="mr-1 far fa-file-alt"></i> About</strong>

          <p class="text-muted" v-html="setAbout">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.
          </p>
        </div>
        <!-- ./card-body -->
      </div>
      <!-- ./card -->
    </div>

    <div class="col-md-8">
      <div class="card">
        <div class="p-2 card-header">
          <ul class="nav nav-pills">
            <li class="nav-item">
              <a
                href="#"
                @click.prevent="showProfileTab()"
                :class="{ 'nav-link': true, active: profileTabVisible }"
                data-toggle="tab"
                >Update Profile</a
              >
            </li>
            <li class="nav-item">
              <a href="#" @click.prevent="showPasswordTab()" :class="{ 'nav-link': true, active: passwordTabVisible }"
                >Change Password</a
              >
            </li>
          </ul>
          <!-- ./nav.nav-pills -->
        </div>
        <!-- ./card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div :class="{ 'tab-pane': true, active: profileTabVisible }">
              <!-- Edit Profile -->
              <form @submit.prevent="handleProfileForm" class="form-horizontal">
                <div class="mb-3 row">
                  <label for="name" class="col-sm-2 col-form-label">Full Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="name" id="name" class="form-control" v-model="name" />
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                  <div class="col-sm-10">
                    <input type="text" name="phone" id="phone" class="form-control" v-model="phone" />
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="jobrole" class="col-sm-2 col-form-label">Current Job Role</label>
                  <div class="col-sm-10">
                    <input type="text" name="jobrole" id="jobrole" class="form-control" v-model="jobrole" />
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="image" class="col-sm-2 col-form-label">Upload Image</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <div class="custom-file">
                        <input
                          type="file"
                          name="image"
                          :class="{ 'is-invalid': errors.image, 'custom-file-input': true }"
                          id="image"
                          ref="image"
                          @change="handleImageUpload()"
                          accept="image/*"
                        />
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                    <div class="text-secondary help-text">The File should be 1 MB or lower.</div>
                    <div class="invalid-msg" v-if="errors.image">
                      {{ errors.image }}
                    </div>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="education" class="col-sm-2 col-form-label">Education</label>
                  <div class="col-sm-10">
                    <input type="text" name="education" id="education" class="form-control" v-model="education" />
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="location" class="col-sm-2 col-form-label">Job Locations</label>
                  <div class="col-sm-10">
                    <multi-select2
                      :class="['select2 form-control']"
                      multiple
                      :options="locations"
                      data-placeholder="Select Multiple Job Locations"
                      v-model="selectedLocations"
                    >
                      <option disabled value="">Select one</option>
                    </multi-select2>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="skills" class="col-sm-2 col-form-label">Skill</label>
                  <div class="col-sm-10">
                    <multi-select2
                      :class="['select2 form-control']"
                      multiple
                      :options="skills"
                      data-placeholder="Select Multiple Skills"
                      v-model="selectedSkills"
                    >
                      <option disabled value="">Select one</option>
                    </multi-select2>
                  </div>
                </div>

                <div class="mb-3 row">
                  <label for="job_type" class="col-sm-2 col-form-label">Job Type</label>
                  <div class="col-sm-10">
                    <select2
                      :class="['select2 form-control']"
                      :options="jobTypes"
                      data-placeholder="Select Any Job Types"
                      v-model="selectedJobType"
                      required
                    >
                      <option disabled value="">Select one</option>
                    </select2>
                  </div>
                </div>

                <div class="mb-3 row">
                  <label for="experience" class="col-sm-2 col-form-label">Experience</label>
                  <div class="col-sm-10">
                    <select2
                      id="experience"
                      :class="['select2 form-control']"
                      :options="experiences"
                      data-placeholder="Select Experience you have"
                      v-model="selectedExperience"
                    >
                      <option disabled value="">Select one</option>
                    </select2>
                  </div>
                </div>

                <div class="mb-3 row">
                  <label for="about" class="col-sm-2 col-form-label">About</label>
                  <div class="col-sm-10">
                    <textarea name="about" id="about" class="form-control" v-model="about" rows="5"></textarea>
                  </div>
                </div>

                <div class="mb-3 row">
                  <label for="cv" class="col-sm-2 col-form-label">Upload CV</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <div class="custom-file">
                        <input
                          type="file"
                          name="cv"
                          class="custom-file-input"
                          :class="{ 'is-invalid': errors.cv }"
                          id="cv"
                          ref="cv"
                          @change="handleCVUpload()"
                          accept=".docx, .doc, .pdf, .jpg, .jpeg"
                        />
                        <label class="custom-file-label" for="cv">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                    <div class="invalid-msg" v-if="errors.cv">
                      {{ errors.cv }}
                    </div>
                    <div class="text-secondary help-text">The File should be 1 MB or lower.</div>
                  </div>
                </div>

                <div class="mb-3 row">
                  <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-success">Submit</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- ./tab-pane -->
            <div :class="{ 'tab-pane': true, active: passwordTabVisible }">
              <form
                @submit.prevent="handlePasswordForm"
                class="form-horizontal"
                spellcheck="false"
                autocorrect="false"
                autocapitalize="false"
              >
                <div class="mb-3 row">
                  <label for="password" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input
                      :type="setPasswordType"
                      name="password"
                      id="password"
                      :class="{ 'form-control': true, 'is-invalid': errors.password }"
                      autofocus
                      autocomplete="current-password"
                      v-model="passowrd"
                      required
                    />
                    <span v-if="errors.password" class="invalid-feedback">
                      {{ errors.password }}
                    </span>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="confirm_password" class="col-sm-2 col-form-label">Password</label>
                  <div class="col-sm-10">
                    <input
                      :type="setPasswordType"
                      name="password_confirmation"
                      id="confirm_password"
                      class="form-control"
                      autocomplete="current-password"
                      v-model="confirmPassword"
                      required
                    />
                  </div>
                </div>
                <div class="mb-3 row">
                  <div class="col-12">
                    <div class="custom-control custom-checkbox">
                      <input
                        @change="showPassword = !showPassword"
                        class="custom-control-input"
                        type="checkbox"
                        id="toggle-password"
                      />
                      <label for="toggle-password" class="custom-control-label">Show Password</label>
                    </div>
                  </div>
                </div>

                <div class="mb-3 row">
                  <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-success">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- ./tab-content -->
        </div>
        <!-- ./card-body -->
      </div>
      <!-- ./card -->
    </div>
  </div>
  <!-- ./row -->
</template>

<script>
  import MultiSelect2 from '../../MultiSelect2.vue';
  const toastr = require('toastr');
  const routes = window.app.url;
  const skills = window.app.skills;
  const locations = window.app.locations;
  const { parse, stringify } = require('../../../helpers/json_helper');
  const jobTypes = window.app.jobTypes;
  const experiences = window.app.experiences;
  export default {
    components: { MultiSelect2 },
    name: 'Profile',
    data() {
      return {
        data: null,
        name: '',
        jobrole: '',
        phone: '',
        education: '',
        imgStr: '',
        newImage: '',
        newCV: '',
        experiences,
        selectedExperience: '',
        experienceLabel: 'Experience',
        locations,
        locationNames: '',
        selectedLocations: [],
        skills,
        selectedSkills: [],
        skillNames: 'Skills',
        jobTypes,
        selectedJobType: '',
        jobTypeName: 'Job Type',
        about: 'About Yourelf',
        passowrd: null,
        confirmPassword: null,
        showPassword: false,
        profileTabVisible: true,
        passwordTabVisible: false,
        errors: {
          password: null,
          name: null,
          jobrole: null,
          education: null,
          location: null,
          skill: null,
          jobType: null,
          about: null,
          cv: null,
          image: null,
        },
      };
    },
    props: {},
    methods: {
      fetchProfile() {
        window
          .axios(routes.showProfile)
          .then(res => {
            this.setUserData(res.data);
            this.setProfileData(res.data.profile);
          })
          .catch(err => {
            console.log(err);
          });
      },
      setUserData(user) {
        this.data = user;
        this.name = user.name;
      },
      setProfileData(profile) {
        this.imgStr = profile.image == 'avatar.jpg' ? '/img/avatar.jpg' : '/storage/avatar/' + profile.image;
        this.jobrole = profile.jobrole;
        this.phone = profile.phone;
        this.education = profile.education;
        let exp = parseInt(profile.experience);
        this.selectedExperience = exp;
        this.experienceLabel = this.experiences.find(el => el.id == exp).text;
        try {
          let skill = parse(profile.skills).map(el => parseInt(el));
          this.selectedSkills = skill;
          this.skillNames = this.skills
            .filter(el => skill.includes(el.id))
            .map(el => el.text)
            .join(', ');
          let location = parse(profile.location).map(el => parseInt(el));
          this.selectedLocations = location;
          this.locationNames = this.locations
            .filter(el => location.includes(el.id))
            .map(el => el.text)
            .join(', ');
          let jobType = parse(profile.job_type);
          this.selectedJobType = jobType;
          this.jobTypeName = this.jobTypes.find(el => el.id == jobType).text;
        } catch (error) {
          console.log(error);
        }
      },
      handleCVUpload() {
        this.newCV = this.$refs.cv.files[0];
      },
      handleImageUpload() {
        this.newImage = this.$refs.image.files[0];
      },
      handleProfileForm() {
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const formData = new FormData();
        formData.append('name', this.name);
        formData.append('jobrole', this.jobrole);
        formData.append('phone', this.phone);
        formData.append('education', this.education);
        formData.append('location', this.selectedLocations);
        formData.append('skills', this.selectedSkills);
        formData.append('job_type', this.selectedJobType);
        formData.append('experience', this.selectedExperience);
        formData.append('about', this.about);
        formData.append('token', token);
        formData.append('cv', this.newCV);
        formData.append('image', this.newImage);

        window.axios
          .post(routes.updateProfile, formData, {
            headers: {
              'Content-Type': 'multipart/form-data',
            },
          })
          .then(resp => {
            toastr.success(resp.data.message, 'Success!');
            this.fetchProfile();
            this.clearForm();
          })
          .catch(err => {
            if (typeof err.response.data.errors.image != 'undefined') {
              this.errors.image = err.response.data.errors.image[0];
            }
            if (typeof err.response.data.errors.cv != 'undefined') {
              this.errors.cv = err.response.data.errors.cv[0];
            }
            toastr.error(err.response.data.errors, err.response.data.message);
            console.log(err.response.data);
          });
      },
      handlePasswordForm() {
        const data = {
          password: this.passowrd,
          password_confirmation: this.confirmPassword,
          token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        };
        axios
          .put(routes.changePassword, data)
          .then(res => {
            toastr.success(res.data.message, 'Success');
            this.clearForm();
            this.clearErrors();
          })
          .catch(err => {
            console.log(err.response.data);
            toastr.error(err.response.data.message);
            if ('errors' in err.response.data) {
              console.log(err.response.data.errors.password[0]);
              this.errors.password = err.response.data.errors.password[0];
            }
            this.checkErrors('password');
          });
      },
      clearForm() {
        this.passowrd = '';
        this.confirmPassword = '';
        this.name = '';
        this.jobrole = '';
        this.education = '';
        this.newImage = '';
        this.newCV = '';
        this.selectedExperience = '';
        this.selectedLocations = [];
        this.selectedSkills = [];
        this.selectedJobType = '';
        this.about = '';
      },
      clearErrors() {
        this.errors = {
          password: null,
          name: null,
          jobrole: null,
          education: null,
          location: null,
          skill: null,
          jobType: null,
          about: null,
          cv: null,
          img: null,
        };
      },
      showProfileTab() {
        this.passwordTabVisible = false;
        this.profileTabVisible = true;
      },
      showPasswordTab() {
        this.profileTabVisible = false;
        this.passwordTabVisible = true;
      },
      checkErrors(name) {
        return this.errors.hasOwnProperty('password');
      },
    },
    created() {},
    updated() {},
    mounted() {
      this.fetchProfile();
    },
    computed: {
      setImage() {
        return this.data ? routes.storage + '/avatar/' + this.data.profile.image : routes.imageAsset + 'img/avatar.jpg';
      },
      setAbout() {
        let about = this.data ? this.data.profile.about : 'About Yourself';
        this.about = about;
        return about;
      },
      setPasswordType() {
        return this.showPassword ? 'text' : 'password';
      },
    },
  };
</script>

<style>
  textarea {
    font-size: 1.1rem !important;
  }
  .invalid-msg {
    color: red;
    background-color: mistyrose;
    border: 1px solid rosybrown;
    border-radius: 5px;
    padding: 0.5rem 1rem;
    margin-top: 0.5rem;
  }
</style>
