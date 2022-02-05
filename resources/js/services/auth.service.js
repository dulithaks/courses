class AuthService {
    isAuthUser() {
        let user = JSON.parse(localStorage.getItem('user'));
        console.log(user)
        if (user && user.api_token) {
            return user.api_token ? true : false;
        } else {
            return false;
        }
    }

    isAuthUserAdmin() {
        let user = JSON.parse(localStorage.getItem('user'));
        return user && user.api_token && user.role == 'admin' ? true : false;
    }

    user() {
        let user = JSON.parse(localStorage.getItem('user'));
        return user || null;
    }

    logout(router) {
        localStorage.removeItem('user');
        router.push({name: 'login'})
    }

    authHeader() {
        let user = JSON.parse(localStorage.getItem('user'));
        if (user && user.api_token) {
            console.log(user.api_token)

            return {
                'Accept': 'application/json',
                'Access-Control-Allow-Origin': '*',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + user.api_token
            }
        } else {
            return {};
        }
    }

    guestHeader() {
        return {
            'Accept': 'application/json',
            'Access-Control-Allow-Origin': '*',
            'Content-Type': 'application/json',
        }
    }

    unauthorized(router) {
        localStorage.removeItem('user');
        toastr.warning('Authorization Required.')
        router.push({name: 'login'})
    }
}

export default new AuthService();
