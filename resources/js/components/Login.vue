<template>
  <div class="login-form mx-auto">
    <div class="text-center pt-4 pb-2">
      <h2>Choose a course</h2>
    </div>
    <div class="mb-3">
      <label for="user" class="form-label">User</label>
      <v-select label="name"
                v-model="form.user"
                :options="userList"
      ></v-select>
      <!--      <span v-if="errors.email" class="validation-errors">{{ errors.email }}</span>-->
    </div>
    <div class="mb-3">
      <label for="course" class="form-label">Course</label>
      <v-select label="title"
                v-model="form.course"
                :options="courseList"
      ></v-select>
      <!--      <span v-if="errors.password" class="validation-errors">{{ errors.password }}</span>-->
    </div>
    <div class="mb-3 text-center">
      <button v-on:click.prevent="submit" type="button" class="btn btn-dark w-50">Submit</button>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      form: {
        user: null,
        course: null,
      },
      userList: [],
      courseList: [],
    }
  },

  mounted: function () {
    this.loadAllUsers()
    this.loadAllCourses()
  },

  methods: {
    async loadAllUsers() {
      fetch(`http://127.0.0.1/api/users`)
          .then(res => {
            res.json().then(data => {
              this.userList = data.payload.data
              console.log(this.userList)
            });
          })
    },

    async loadAllCourses() {
      fetch(`http://127.0.0.1/api/courses`)
          .then(res => {
            res.json().then(data => {
              this.courseList = data.payload.data
              console.log(data.payload.data)
            });
          });
    },

    async submit() {
      if (!this.form.user) return toastr.error('Please select a user!')
      if (!this.form.course) return toastr.error('Please choose a course!')


    },
  }
}
</script>
