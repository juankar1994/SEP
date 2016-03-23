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
      when('/controlFeria',{
        templateUrl: 'html/controlFeria.html',
        controller: 'controlFeriaCtrl'
      }).
      when('/creacionFeria',{
        templateUrl: 'html/creacionFeria.html',
        controller: 'creacionFeriaCtrl'
      }).
      otherwise({
        redirectTo: '/login'
      });
  }]);