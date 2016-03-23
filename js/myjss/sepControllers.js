var sepControllers = angular.module('sepControllers', []);

sepControllers.controller('loginCtrl', function ($scope) {
 });

sepControllers.controller('cargaEvaluadoresCtrl',function($scope,$http){
    $scope.metodo_carga = 'Manual';
    $scope.evaluador = {
        nombre: '' ,
        apellido1: '',
        apellido2: '',
        telefono: '',
        correo:'',
        file: ''
    };
    $scope.cargarEvaluador = function (){
        console.log($scope.evaluador.nombre + $scope.evaluador.apellido1);
    }
    
    $scope.cargarEvaluador= function(){
        $.post("http://sep.comxa.com/insertEvaluador.php",{
                'nombre': $scope.evaluador.nombre,
                'apellido1': $scope.evaluador.apellido1,
                'apellido2': $scope.evaluador.apellido2,
                'telefono': $scope.evaluador.telefono,
                'correoElectronico': $scope.evaluador.correo
        }).done(function(response){
            console.log(response);
            $scope.resetDatos();
        });
    };
    
    $scope.resetDatos = function(){
        $scope.$apply(function(){
            $scope.evaluador.nombre = null;
            $scope.evaluador.apellido1 = null;
            $scope.evaluador.apellido2 = null;
            $scope.evaluador.telefono = null;
            $scope.evaluador.correo = null;
            $scope.evaluador.file = null;       
        })
    };
    
});

sepControllers.controller('cargaProyectosCtrl',function($scope){
    $scope.metodo_carga = 'Manual'
});



sepControllers.controller('controlFeriaCtrl',function($scope){
});

