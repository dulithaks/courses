class RouteService {
    static baseUrl = "http://127.0.0.1/api/";

    getAllUsersUrl() {
        return RouteService.baseUrl + `users`
    }
}

export default new RouteService();
