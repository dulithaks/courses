<template>

    <div class="main-content container bg-light min-vh-100 px-0 shadow">
        <div class="mt-2 w-100 px-2">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import AuthService from './services/auth.service';

export default {
    data() {
        return {
            form: {
                email: '',
                password: '',
            },
            errors: [],
            get userFirstName() {
                const user = JSON.parse(localStorage.getItem('user'));
                return user.first_name || 'User';
            },
            get authUserAdmin () {
                return AuthService.isAuthUserAdmin();
            }
        }
    },
    methods: {
        async logout() {
            AuthService.logout(this.$router);
        }
    }
}
</script>
