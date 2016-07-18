(function(App) {
    var ctrl = new App.Definition("ArticleController", ['$scope', '$http', "articles", "article", function($scope, $http, articles, article) {
        $scope.article = article;
        $scope.editor = {
            options: {
                plugins : 'link image lists charmap'
            }
        };
        $scope.articles = articles;
        $scope.saveArticle = function() {
            var payload = JSON.stringify($scope.article);
            if($scope.article.id) {
                $http.put(App.baseUrl+'/api/articles/'+$scope.article.title+'.json', payload);
            } else {
                $http.post(App.baseUrl+'/api/articles.json', payload);
            }
        };
    }]);
    var articles = new App.State("articles", {
        url: "/articles",
        abstract: true,
        template: '<ui-view></ui-view>'
    });
    var list = new App.State("articles.list", {
        url: "/",
        templateUrl: "js/templates/articles/list.html",
        controller: "ArticleController",
        resolve: {
            "articles": ["$http", function($http) {
                return $http.get(App.baseUrl+"/api/articles.json").then(function(res) {
                    return res.data;
                });
            }],
            "article": function() {
                return {
                    title: "",
                    content: ""
                };
            }
        }
    });
    var create = new App.State("articles.create", {
        url: "/create",
        templateUrl: "js/templates/articles/form.html",
        controller: "ArticleController",
        resolve: {
            "articles": ["$http", function($http) {
                return $http.get(App.baseUrl+"/api/articles.json").then(function(res) {
                    return res.data;
                });
            }],
            "article": function() {
                return {
                    title: "",
                    content: ""
                };
            }
        }
    });
    var edit = new App.State("articles.edit", {
        url: "/edit/*id",
        templateUrl: "js/templates/articles/form.html",
        controller: "ArticleController",
        resolve: {
            "articles": ["$http", function($http) {
                return $http.get(App.baseUrl+"/api/articles.json").then(function(res) {
                    return res.data;
                });
            }],
            "article": ["$http", "$stateParams", function($http, $stateParams) {
                return $http.get(App.baseUrl+"/api/articles/"+$stateParams.id+".json").then(function(res) {
                    return res.data;
                });
            }]
        }
    });
    
    App.controllers.push(ctrl);
    App.states.push(articles);
    App.states.push(list);
    App.states.push(create);
    App.states.push(edit);
})(App);
    