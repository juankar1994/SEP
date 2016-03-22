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
      when('/cargaEvaluadores',{
        templateUrl: 'html/cargaEvaluadores.html',
        controller: 'cargaEvaluadoresCtrl'
      }).
      when('/cargaProyectos',{
        templateUrl: 'html/cargaProyectos.html',
        controller: 'cargaProyectosCtrl'
      }).
      otherwise({
        redirectTo: '/login'
      });
  }]);