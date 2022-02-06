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
    </div>
    <div class="mb-3">
      <label for="course" class="form-label">Course</label>
      <v-select label="title"
                v-model="form.course"
                :options="courseList"
      ></v-select>
    </div>
    <div class="mb-3 text-center">
      <button v-on:click.prevent="submit" type="button" class="btn btn-dark w-50">Submit</button>
    </div>
  </div>
</template>

<script>
import AuthService from './../services/auth.service'

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
            res.json().then(data => this.userList = data.payload);
          })
    },

    async loadAllCourses() {
      fetch(`http://127.0.0.1/api/courses`)
          .then(res => {
            res.json().then(data => this.courseList = data.payload);
          });
    },

    async submit() {
      if (!this.form.user) return toastr.error('Please select a user!')
      if (!this.form.course) return toastr.error('Please choose a course!')

      const formData = {
        user_id: this.form.user.id,
        course_id: this.form.course.id,
        status: 0
      }

      const comp = this

      axios({
        method: "post",
        url: "http://127.0.0.1/api/course/assign",
        data: formData,
        headers: AuthService.guestHeader(),
      })
          .then(function (response)  {
            toastr.success('Success.')
            comp.form.course = null
            comp.form.user = null
          })
          .catch(function (response) {
            response.message ? toastr.error(response.message) : toastr.error('Something went wrong!');
          });
    },
  }
}
</script>
