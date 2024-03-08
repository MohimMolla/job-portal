<template>
  <div class="mb-3 input-group">
    <div class="input-group-prepend">
      <span class="bg-white input-group-text border-right-none">
        <i class="fas fa-map-marker-alt"></i>
      </span>
    </div>
    <input
      type="text"
      v-model="searchStr"
      name="location"
      class="form-control border-left-none"
      placeholder="Search by city"
      autocomplete="off"
      @focus="onFocus"
      @keydown.down="onArrowDown"
      @keydown.up="onArrowUp"
      @keydown.enter="onEnter"
    />
    <!-- <div v-if="searching">Searching...</div> -->
    <div v-show="isOpen" class="job-search-wrap">
      <ul class="job-search-container">
        <li
          @click="openSearchLink(result)"
          v-for="(result, key) in results"
          :key="key"
          :class="{ 'is-active': key === arrowCounter }"
        >
          {{ result }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
const route = window.app.url;

export default {
  data() {
    return {
      searchStr: '',
      isOpen: false,
      results: [],
      search: null,
      searching: false,
      arrowCounter: 0,
    };
  },
  methods: {
    openSearchLink(result) {
      const link = route.search + '?city=' + encodeURIComponent(result) + '&term=' + this.searchStr;
      window.location.href = link;
    },
    onFocus() {
      if (this.searchStr.length > 0) {
        this.checkSearchStr(this.searchStr);
      }
    },
    onArrowDown() {
      if (this.arrowCounter < this.results.length - 1) {
        this.arrowCounter = this.arrowCounter + 1;
      } else {
        this.arrowCounter = 0;
      }
    },
    onArrowUp() {
      if (this.arrowCounter >= 1) {
        this.arrowCounter = this.arrowCounter - 1;
      } else {
        this.arrowCounter = this.results.length - 1;
      }
    },
    onEnter() {
      this.search = this.results[this.arrowCounter];
      // console.log(this.search);
      this.isOpen = false;
      this.arrowCounter = -1;
      this.openSearchLink(this.search);
    },
    handleClickOutside(evt) {
      if (!this.$el.contains(evt.target)) {
        this.isOpen = false;
        this.arrowCounter = -1;
      }
    },
    checkSearchStr: window._.debounce(function (term) {
      this.results = [];
      this.searching = true;
      axios
        .get(route.ajaxSearch + `?city=${term}`)
        .then(resp => {
          this.searching = false;
          this.results = Array.from(new Set(resp.data.map(el => el)));
          if (this.results.length > 0) {
            this.isOpen = true;
          }
          // console.log(resp);
        })
        .catch(err => {
          if (err.response.status == 404) {
            this.isOpen = false;
          }
        });
    }, 300),
  },
  computed: {},
  mounted() {
    document.addEventListener('click', this.handleClickOutside);
  },
  destroyed() {
    document.addEventListener('click', this.handleClickOutside);
  },
  watch: {
    searchStr(newVal) {
      this.checkSearchStr(newVal);
    },
  },
};
</script>

<style scoped>
ul {
  margin: 0;
  padding: 0;
  font-size: 1rem;
}
.input-group {
  position: relative;
}
input {
  border: none;
}
.job-search-wrap {
  position: absolute;
  width: 100%;
  min-height: 7vh;
  max-height: 50vh;
  z-index: 9999999;
  background: #fff;
  top: 38px;
  box-shadow: 1px 2px 5px 0px rgba(100, 100, 100, 0.5);
  border-radius: 0 0 5px 5px;
  overflow-y: auto;
}
.input-group-text {
  border: none;
}

.is-active {
  background: #d3d3d2 !important;
}

.job-search-container li {
  display: block;
  cursor: pointer;
  font-size: 1.1rem;
  color: #666;
  padding: 0.6rem 1rem;
}

.job-search-container li:hover,
.job-search-container li:focus,
.job-search-container li:active {
  background: #d3d3d2 !important;
}
</style>
