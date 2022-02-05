<template>
    <div class="login-form mx-auto">
        <div class="text-center pt-4 pb-2">
            <h2>Login</h2>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input v-model="form.email"
                   @input="validateForm"
                   type="email"
                   name="email"
                   class="form-control"
                   placeholder="Enter email"
                   autocomplete="off"
            >
            <span v-if="errors.email" class="validation-errors">{{ errors.email }}</span>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input v-model="form.password"
                   @input="validateForm"
                   type="password"
                   class="form-control"
                   name="password"
                   placeholder="Enter password"
            >
            <span v-if="errors.password" class="validation-errors">{{ errors.password }}</span>
        </div>
        <div class="mb-3 text-center">
            <button v-on:click.prevent="login" type="button" class="btn btn-dark w-50">Login</button>
        </div>
    </div>
</template>

<script>
import {required, email, minLength} from "vuelidate/lib/validators";
import AuthService from './../services/auth.service'
import RouteService from './../services/route.service';

export default {
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            errors: [],
        }
    },
    validations: {
        form: {
            email: {
                required,
                email,
            },
            password: {
                required,
            },
        },
    },
    methods: {
        async login() {
            try {
                this.$v.$touch()
                if (this.$v.$invalid) {
                    return toastr.error('Please fill the login form.');
                }

                const requestOptions = {
                    method: 'POST',
                    headers: AuthService.guestHeader(),
                    body: JSON.stringify(this.form),
                };

                let response = await fetch(RouteService.getLoginUrl(), requestOptions);
                const responseData = await response.json();

                if (response.status === 200) {
                    localStorage.setItem('user', JSON.stringify(responseData.data));
                    await this.$router.push('/');
                }

                if (response.status === 422) {
                    this.formatServerValidationErrors(responseData.errors);
                    responseData.message ? toastr.error(responseData.message) : '';
                }

                response.status === 401 ? toastr.warning('Authorization Required.') : ''

                response.status === 500 ? toastr.error('Something went wrong. Please try again.', 'Oops!') : '';
            } catch (error) {
                console.log(error)
                toastr.error('Something went wrong. Please try again.', 'Oops!')
            }
        },
        validateForm(event) {
                this.$v.form[event.target.name].$touch()
                this.addValidationErrors(event.target.name);
        },
        addValidationErrors(field) {
            console.log(field, this.$v.form[field].required, this.$v.form[field].email, this.$v.form[field].$dirty, this.$v.form[field].$error)

            if (!this.$v.form[field].$error) {
                return this.errors[field] = '';
            }

            if (!this.$v.form[field].required && this.$v.form[field].$dirty) {
                this.errors[field] = `The ${field.replace('_', ' ')} field is required.`;
            }
            else if (!this.$v.form.email.email && this.$v.form.email.$dirty) {
                this.errors[field] = `The ${field.replace('_', ' ')} must be a valid email address.`;
            }
        },
        formatServerValidationErrors(errors) {
            console.log(errors)
            errors = errors || {}
            Object.keys(errors).map(function (key, index) {
                errors[key] = errors[key][0];
            });
            this.errors = errors;
        },
    }
}
</script>
