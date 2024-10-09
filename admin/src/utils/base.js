const base = {
    get() {
        return {
            url : "http://localhost:8080/phpci7firyg/",
            name: "phpci7firyg",
            // 退出到首页链接
            indexUrl: 'http://localhost:8080/phpci7firyg/front/dist/index.html'
        };
    },
    getProjectName(){
        return {
            projectName: "万怡酒店管理系统"
        } 
    }
}
export default base
