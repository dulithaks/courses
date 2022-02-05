import Login from "./components/Login";
import NotFound from "./components/NotFound";

export const routes = [
    {
        name: 'notfound',
        path: '*',
        component: NotFound
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
];
