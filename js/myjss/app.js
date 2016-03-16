var sepApp = angular.module('sepApp', [
  'ngRoute',
  'sepControllers'
]);

sepApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/login', {
        templateUrl: 'html/login.html',
        controller: 'loginCtrl'
      }).
      when('/contact',{
        templateUrl: 'html/temp.html',
        controller: 'loginCtrl'
      }).
      otherwise({
        redirectTo: '/login'
      });
  }]);