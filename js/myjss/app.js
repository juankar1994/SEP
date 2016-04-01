var sepApp = angular.module('sepApp', [
  'ngRoute',
  'sepControllers',
  'angularUtils.directives.dirPagination',
  'angular-jwt',
  'angular-storage'
]);

sepApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/login', {
        templateUrl: 'html/login.html',
        controller: 'loginCtrl',
        resolve:{
			load: function (sessionFactory) {
                return sessionFactory.checkLogOut();
            }
		}
      }).
      when('/cargaEvaluadores',{
        templateUrl: 'html/cargaEvaluadores.html',
        controller: 'cargaEvaluadoresCtrl',
        resolve:{
			load: function (sessionFactory) {
                return sessionFactory.checkLogin();
            }
		}
      }).
      when('/cargaProyectos',{
        templateUrl: 'html/cargaProyectos.html',
        controller: 'cargaProyectosCtrl',
        resolve:{
			load: function (sessionFactory) {
                return sessionFactory.checkLogin();
            }
		}
      }).
      when('/controlFeria',{
        templateUrl: 'html/controlFeria.html',
        controller: 'controlFeriaCtrl',
        resolve:{
			load: function (sessionFactory) {
                return sessionFactory.checkLogin();
            }
		}
      }).
      when('/creacionFeria',{
        templateUrl: 'html/creacionFeria.html',
        controller: 'creacionFeriaCtrl',
        resolve:{
			load: function (sessionFactory) {
                return sessionFactory.checkLogin();
            }
		}
      }).
      when('/proyectos',{
        templateUrl: 'html/verProyectos.html',
        controller: 'proyectosCtrl',
        resolve:{
			load: function (sessionFactory) {
                return sessionFactory.checkLogin();
            }
		}
      }).
      when('/proyecto',{
        templateUrl: 'html/proyecto.html',
        controller: 'proyectoCtrl',
        resolve:{
			load: function (sessionFactory) {
                return sessionFactory.checkLogin();
            }
		}
      }).
      when('/activarEvaluadores',{
        templateUrl: 'html/activarEvaluadores.html',
        controller: 'activacionEvaluadoresCtrl',
        resolve:{
			load: function (sessionFactory) {
                return sessionFactory.checkLogin();
            }
		}
      }).
      when('/registroEvaluacion',{
        templateUrl: 'html/registroEvaluacion.html',
        controller: 'registroEvaluacionCtrl',
        resolve:{
			load: function (sessionFactory) {
                return sessionFactory.checkLogin();
            }
		}
      }).
      when('/regAdministrador',{
        templateUrl: 'html/registroAdministrador.html',
        controller: 'administradorCtrl',
        resolve:{
			load: function (sessionFactory) {
                return sessionFactory.checkLogin();
            }
		}
      }).
      when('/perfilAdministrador',{
        templateUrl: 'html/perfilAdministrador.html',
        controller: 'perfilAdmiCtrl',
        resolve:{
			load: function (sessionFactory) {
                return sessionFactory.checkLogin();
            }
		}
      }).
      when('/controlAdmins',{
        templateUrl: 'html/controlAdmins.html',
        controller: 'administradorCtrl',
        resolve:{
			load: function (sessionFactory) {
                return sessionFactory.checkLogin();
            }
		}
      }).
      when('/logout',{
        resolve:{
			load: function (sessionFactory) {
                return sessionFactory.logOut();
            }
		}
      }).
      otherwise({
        redirectTo: '/login',
      });
  }]);


