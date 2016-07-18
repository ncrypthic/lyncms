(function(App) {
    var ctrl = new App.Definition("DashboardController", ['$scope', function($scope) {
    }]);
    var dashboard = new App.State("dashboard", {
        url: "/",
        templateUrl: 'js/templates/dashboard/index.html',
        resolve: {
            "pages": ['$http', '$q', function($http, $q) {
                return $http.get($app.baseUrl+'/api/pages.json').then(function(res) {
                    return res.data;
                });
            }]
        }
    });
    
    App.controllers.push(ctrl);
    App.states.push(dashboard);
})(App);
    