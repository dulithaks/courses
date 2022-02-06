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

      const response = await fetch('http://127.0.0.1/api/course/assign', {
        method: "post",
        body: {
          user_id: this.form.user.id,
          course_id: this.form.course.id,
          status: 0
        },
      });

      const responseData = await response.json();

      if (response.status === 200) {
        toastr.success('Success.');
        this.form.user = null
        this.form.course = null
      }

      if (response.status === 422) {
        responseData.message ? toastr.error(responseData.message) : toastr.error('Invalid data!');
      }

      if (response.status === 500) {
        responseData.message ? toastr.error(responseData.message) : toastr.error('Something went wrong!');
      }
    },
  }
}
</script>
