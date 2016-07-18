(function(App) {
    var ctrl = new App.Definition("PageController", ['$scope', '$http', '$uibModal', 'page', function($scope, $http, $modal, page) {
        $scope.page = page;
        $scope.editor = {
            options: {
                plugins : 'link image lists charmap'
            }
        };
        $scope.savePage = function(cb) {
            var payload = JSON.stringify($scope.page);
            $http.post(App.baseUrl+'/api/pages.json', payload).then(function() {
                if(angular.isFunction(cb)) {
                    cb($scope.page);
                }
            });
        };
        
        $scope.editor_url = App.baseUrl+"/backend/page_editor";
    }]);
    var pages = new App.State("pages", {
        url: "/pages",
        abstract: true,
        template: '<ui-view></ui-view>'
    });
    var create = new App.State("pages.new", {
        controller: "PageController",
        templateUrl: "js/templates/pages/modal.html",
        resolve: {
            "page" : { title: "New Page", content: "" }
        }
    });
    var edit = new App.State("pages.edit", {
        url: "/:slug",
        controller: "PageController",
        templateUrl: "js/templates/pages/form.html",
        resolve: {
            "page" : ['$http', '$stateParams', function($http, $stateParams) {
                return $http.get(App.baseUrl+"/api/pages/"+$stateParams.slug+".json").then(function(res){
                    return res.data;
                });
            }]
        }
    });
    
    App.controllers.push(ctrl);
    App.states.push(pages);
    App.states.push(create);
    App.states.push(edit);
})(App);
    