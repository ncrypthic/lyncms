/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Namespace
var App = (function(ng) {
    function Definition(name, init) {
        this.name = name;
        this.init = init;
    };
    Definition.prototype = {
        name: "",
        init: ['$scope', function($scope){}]
    };
    function State(path, config) {
        this.path = path;
        this.config = config;
    };
    State.prototype = {
        path: null,
        config: {}
    }
    
    function App() {};
    App.prototype = {
        Definition: Definition,
        State: State,
        controllers: [],
        services: [],
        states: [],
        baseUrl: $("[data-baseurl]").attr('data-baseurl')
    };
    var $app = new App();

    angular.element(document).ready(function() {
        var module = ng.module('app.cms', ['ui.router', 'ui.tinymce', 'ui.bootstrap', 'ngSanitize']);
        module.config(['$stateProvider', function($provider) {
            $app.states.forEach(function(def) {
                $provider.state(def.path, def.config);
            });
        }]);
        module.config(['$interpolateProvider', function($interpolate) {
            $interpolate.startSymbol('{[{');
            $interpolate.endSymbol('}]}');
        }]);
        module.controller('FrontController', ['$scope', '$http', '$uibModal', function($scope, $http, $uibModal) {
            $scope.isPagesCollapsed = true;
            $scope.pages = [];
            $scope.prompt = {
                title: '',
                message: ''
            };
            $http.get($app.baseUrl+"/api/pages.json").then(function(res) {
                $scope.pages = res.data;
            });
            $scope.$on('$stateChangeStart', function(e, toState, toParams){
                angular.element('.create-ui-logo, .create-ui-toolbar-wrapper, .midgardNotifications-container').remove();
            });
            $scope.createPage = function(e) {
                e.preventDefault();
                e.stopPropagation();
                var modalInstance = $uibModal.open({
                    animation: $scope.animationsEnabled,
                    templateUrl: 'js/templates/dashboard/new_page.html',
                    controller: 'PageController',
                    resolve: {
                        page: { title: '', content: '' }
                    }
                });

                modalInstance.result.then(function (page) {
                    $scope.pages.push(page);
                });
            };
            $scope.removePage = function(e, index) {
                e.preventDefault();
                e.stopPropagation();
                var selectedPage = $scope.pages[index];
                $scope.prompt.title = "Remove Page Confirmation";
                $scope.prompt.message = "Are you sure you want to remove '"+selectedPage.title+"' page?";
                var modalInstance = $uibModal.open({
                    animation: $scope.animationsEnabled,
                    templateUrl: 'js/templates/dashboard/modal.html',
                    scope: $scope
                });

                modalInstance.result.then(function() {
                    $http.delete($app.baseUrl+"/api/pages/"+selectedPage.title+".json").then(function() {
                        $scope.pages.splice(index, 1);
                    });
                });
            };
        }]);
        $app.controllers.forEach(function(def) {
            module.controller(def.name, def.init);
        });
        $app.services.forEach(function(def) {
            module.services(def.name, def.init);
        });
        angular.bootstrap(document, ['app.cms']);
    });

    return $app;
})(angular);