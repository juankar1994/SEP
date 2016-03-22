var sepControllers = angular.module('sepControllers', []);

sepControllers.controller('loginCtrl', function ($scope) {
 });

sepControllers.controller('cargaEvaluadoresCtrl',function($scope,$http){
    $scope.metodo_carga = 'Manual';
    $scope.evaluador = {};
    $scope.cargarEvaluador = function (){
        console.log($scope.evaluador.nombre + $scope.evaluador.apellido1);
    }
    
    $scope.cargarEvaluador= function(){
        $http.post("http://127.0.0.1/insertEvaluador.php",{
            nombre : $scope.evaluador.nombre,
            apellido1 : $scope.evaluador.apellido1,
            apellido2 : $scope.evaluador.apellido2,
            telefono: $scope.evaluador.telefono,
            correoElectronico: $scope.evaluador.correo,
        }).success(function (response) {
            console.log(response);
        });
    };
});

sepControllers.controller('cargaProyectosCtrl',function($scope){
    $scope.metodo_carga = 'Manual'
});


