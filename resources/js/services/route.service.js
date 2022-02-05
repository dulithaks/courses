class RouteService {
    static baseUrl = "http://127.0.0.1:8000/api/";

    createCommentUrl(postId) {
        return RouteService.baseUrl + `posts/${postId}/comments`
    }

    getLoginUrl() {
        return RouteService.baseUrl + `login`
    }

    getCommentsUrl(postId) {
        return RouteService.baseUrl + `posts/${postId}/comments`
    }

    getPostsUrl(form, page) {
        let url = RouteService.baseUrl + 'posts?page=' + page;
        return  url += form.term ? '&term=' + form.term.trim() : '';
    }

    getMyPostsUrl(form, user, page) {
        return this.getPostsUrl(form, page) + '&userId=' + user.id;
    }

    getPendingPostsUrl(form, filter, page) {
        return this.getPostsUrl(form, page) + '&filter=' + filter;
    }

    getCreatePostUrl() {
        return RouteService.baseUrl + `posts`
    }

    getRegisterUrl() {
        return RouteService.baseUrl + `register`
    }

    getPostApproveUrl(postId) {
        return RouteService.baseUrl + `posts/${postId}/approve`
    }

    getPostRejectUrl(postId) {
        return RouteService.baseUrl + `posts/${postId}/reject`
    }

    getPostDeleteUrl(postId) {
        return RouteService.baseUrl + `posts/${postId}`
    }
}

export default new RouteService();
