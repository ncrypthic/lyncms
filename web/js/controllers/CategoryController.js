(function(App) {
    var ctrl = new App.Definition("CategoryController", ['$scope', function($scope) {
        
    }]);
    var category = new App.State("category", {
        url: "/categories",
        abstract: true,
        controller: "CategoryController",
        template: '<ui-view></ui-view/>'
    });
    var list = new App.State("category.list", {
        url: "/",
        templateUrl: 'js/templates/categories/index.html'
    });
    
    App.controllers.push(ctrl);
    App.states.push(category);
    App.states.push(list);
})(App);
    