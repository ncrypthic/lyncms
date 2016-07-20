/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
(function(App){
    var ctrl = new App.Definition("MediaController", ["$scope", function($scope){
    }]);

    App.controllers.push(ctrl);
    App.states.push(new App.State("media", {
        url: "/media",
        controller: "MediaController",
        templateUrl: App.baseUrl+"/js/templates/media/index.html"
    }));
})(App);