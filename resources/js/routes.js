import Login from "./components/Home";
import NotFound from "./components/NotFound";

export const routes = [
    {
        name: 'notfound',
        path: '*',
        component: NotFound
    },
    {
        name: 'home',
        path: '/',
        component: Login
    },
];
