var sepControllers = angular.module('sepControllers', []);



sepControllers.controller('loginCtrl', function($scope, $location,$http, $rootScope,$window){
	$scope.verificarPass = function(){
		var correo = '';
		var pass = "";
		$scope.nombre='';
		$scope.apellido1='';
		$scope.apellido2='';

		$http.get('http://sep.comxa.com/php/login.php', {
    			params: {correo: $scope.username, pass: $scope.password}
 			}).then(function successCallback(response) {
			    $scope.nombre =response['data']['nombre'];
			    $scope.apellido1 =response['data']['apellido1'];
			    $scope.apellido2 =response['data']['apellido2'];

			    $rootScope.nombre= $scope.nombre;
			    $rootScope.apellido1= $scope.apellido1;
			    $rootScope.apellido2= $scope.apellido2;

			    if($scope.nombre != null){
			    	//$rootScope.loggedIn = true;
                    sessionStorage.setItem('user',JSON.stringify({'nombre':$scope.nombre,'apellido1':$scope.apellido1,'apellido2':$scope.apellido2,'correo':$scope.username}));
					sessionStorage.setItem('loggedIn',JSON.stringify(true));
					$window.location.href = '/administrador.html#/proyectos';
                    
				}
			  }, function errorCallback(response) {
			    // called asynchronously if an error occurs
			    // or server returns response with an error status.
			    console.log(response['data']);
			  });
	}

	$rootScope.logOut=function(){
		sessionStorage.removeItem('loggedIn');
		$location.path('/');
	};
    
    console.log("Ingrese al sistema");
});


sepControllers.controller('cargaEvaluadoresCtrl',function($scope,$http,$filter,csvFactory){
    $scope.ferias = {};
    $scope.metodo_carga = 'Manual';
    $scope.evaluador = {
        nombre: '' ,
        apellido1: '',
        apellido2: '',
        telefono: '',
        feria: '',
        correo:'',
        file: ''
    };
    $scope.evaluadorReset = $scope.evaluador;
    $scope.cargarEvaluador = function (){
        console.log($scope.evaluador.nombre + $scope.evaluador.apellido1);
    }
    
    $scope.getFerias = function($scope){
        $http.get("http://sep.comxa.com/php/getFerias.php").
            success(function(response) {
                $scope.ferias = response["data"];
            });    
    }
    
    
    $scope.cargarEvaluador= function(){
        $.post("http://sep.comxa.com/php/insertEvaluador.php",{
                'nombre': $scope.evaluador.nombre,
                'apellido1': $scope.evaluador.apellido1,
                'apellido2': $scope.evaluador.apellido2,
                'telefono': $scope.evaluador.telefono,
                'feria': $scope.evaluador.feria,
                'correoElectronico': $scope.evaluador.correo
        }).done(function(response){
            console.log(response);
            $scope.resetDatos();
        });
    };
    
    $scope.cargarEvaluadores = function(){
        $scope.processData($scope.content,';');
        console.log($scope.evaluadores);
        $.post("http://sep.comxa.com/php/insertEvaluadores.php",{
                'evaluadores': $scope.evaluadores,
                'feria': $scope.evaluador.feria
        }).done(function(response){
            console.log(response);
            $scope.resetDatos();
        }).error(function(response){
            console.log(response);
        });
    }
    
    $scope.resetDatos = function(){
        $scope.$apply(function(){
            $scope.evaluador = {
                nombre: '' ,
                apellido1: '',
                apellido2: '',
                telefono: '',
                feria: '',
                correo:''
            };
            $scope.evaluadores = []; 
        });
    };
    
    
    $scope.readFile = function($fileContent){
        $scope.content = $fileContent;
    };
    
    $scope.processData = function(text,splitted){
        $scope.evaluadores = csvFactory.processData(text,splitted);
    };
    
    $scope.getFerias($scope);
    
});

sepControllers.controller('cargaProyectosCtrl',function($scope,$http,$filter,csvFactory){
    $scope.ferias = {};
    $scope.profesores = {};
    $scope.sedes = {};
    $scope.metodo_carga = 'Automatico';
    $scope.integrante = {
        nombre: '',
        apellido1: '',
        apellido2: '',
        correo: ''
    };
    $scope.profesor = {
        nombre: '',
        apellido1: '',
        apellido2: '',
        correo: ''
    };
    $scope.proyecto = {
        nombre: '',
        descripcion: '',
        profesor: '',
        integrantes: [],
        tipo: '',
        feria: '',
        stand: '',
        sede: ''
    };
    
    
    $scope.insertarIntegrante = function(){
        $('#insertIntegrante').modal('hide');    
        $scope.proyecto.integrantes.push($scope.integrante);
        $scope.integrante = {
            nombre: '', 
            apellido1: '',
            apellido2: '',
            correo: ''
        };
    }
    
    $scope.insertarProfesor = function(){
        $.post("http://sep.comxa.com/php/insertProfesor.php",{
                'nombre': $scope.profesor.nombre,
                'correo': $scope.profesor.correo,
                'apellido1': $scope.profesor.apellido1,
                'apellido2': $scope.profesor.apellido2
        }).done(function(response){
            console.log(response);
            $scope.resetDatos($scope);
            $scope.getProfesores($scope);
            $('#insertProfesor').modal('hide');
        });
    }
     
    $scope.getFerias = function($scope){
        $http.get("http://sep.comxa.com/php/getFerias.php").
            success(function(response) {
                $scope.ferias = response["data"];
            });    
    }
    
    $scope.getProfesores = function($scope){
        $http.get("http://sep.comxa.com/php/getProfesores.php").
            success(function(response) {
                $scope.profesores = response["data"];
            });    
    }
    
    $scope.getSedes = function($scope){
        $http.get("http://sep.comxa.com/php/getSedes.php").
            success(function(response) {
                $scope.sedes = response["data"];
            });    
    }
    
    $scope.cargarProyecto = function(){
        console.log($scope.proyecto);
        $.post("http://sep.comxa.com/php/insertProyecto.php",{
                'nombre': $scope.proyecto.nombre,
                'descripcion': $scope.proyecto.descripcion,
                'profesor': $scope.proyecto.profesor,
                'integrantes': $scope.proyecto.integrantes,
                'tipo': $scope.proyecto.tipo,
                'feria': $scope.proyecto.feria,
                'stand': $scope.proyecto.stand,
                'sede': $scope.proyecto.sede
        }).done(function(response){
            console.log(response);
            $scope.resetDatos($scope);
        }).error(function(response){
            console.log(response);
        });
    };
    
    
    $scope.cargarProyectos = function(){
        $scope.processDataProyectos($scope.contentProyectos,';');
        $scope.processDataIntegrantes($scope.contentIntegrantes,';');
        console.log($scope.integrantes,$scope.proyectos);
        $scope.unificarProyectoIntegrantes($scope.proyectos,$scope.integrantes);
        console.log($scope.proyectos);
        $.post("http://sep.comxa.com/php/insertProyectos.php",{
                'proyectos': $scope.proyectos,
                'feria': $scope.proyecto.feria,
                'tipo': $scope.proyecto.tipo
        }).done(function(response){
            console.log(response);
            $scope.resetDatos($scope);
        }).error(function(response){
            console.log(response);
        });
    }
    
    $scope.resetDatos = function($scope){
        $scope.integrante = {
            nombre: '',
            apellido1: '',
            apellido2: '',
            correo: ''
        };
        $scope.profesor = {
            nombre: '',
            apellido1: '',
            apellido2: '',
            correo: ''
        };        
        $scope.proyecto = {
            nombre: '',
            descripcion: '',
            profesor: '',
            integrantes: [],
            tipo: '',
            feria: '',
            stand: '',
            sede: ''
        };
    };
    
    
    $scope.readFileIntegrantes = function($fileContent){
        $scope.contentIntegrantes = $fileContent;
    };
    
    $scope.readFileProyectos = function($fileContent){
        $scope.contentProyectos = $fileContent;
    };
    
    $scope.processDataIntegrantes = function(text,splitted){
        $scope.integrantes = csvFactory.processData(text,splitted);
    };
    
    $scope.processDataProyectos = function(text,splitted){
        $scope.proyectos = csvFactory.processData(text,splitted);
    };
    
    $scope.unificarProyectoIntegrantes = function(proyectos, integrantes){
        angular.forEach(proyectos, function (proyecto) {
            proyecto['Integrantes'] = [];
            angular.forEach(integrantes,function(integrante){
                if(proyecto['Numero_Proyecto'] == integrante['Numero_Proyecto']){
                    proyecto['Integrantes'].push(integrante);
                }
            });
        });
    }
    
    
    
    $scope.newIntegrante= function(){
        $('#insertIntegrante').modal('show');
    };
    
    $scope.remove = function(array,index){
        array.splice(index,1);
    };
    
    $scope.newProfesor= function(){
        $('#insertProfesor').modal('show');
    };
    
    //Llamadas iniciales
    $scope.getFerias($scope);
    $scope.getProfesores($scope);
    $scope.getSedes($scope);
    
    
});

sepControllers.controller('proyectosCtrl',function($scope,$rootScope,$http,$filter,$location){
    $scope.ferias = {};
    $rootScope.idProyecto = '';
    $scope.proyectos = [];
    $scope.proyectosPorPagina = 12;
    $scope.paginaActual = 1;
    
    $scope.getProyectos = function($scope){
        $http.get("http://sep.comxa.com/php/getProyectos.php").
            success(function(response) {
                $scope.proyectos = response["data"];
                console.log($scope.proyectos);
            });    
    }
    
    $scope.verProyecto = function(idProyecto){
        $rootScope.idProyecto = idProyecto;
        $location.path('proyecto');
    }

    $scope.getFerias = function($scope){
        $http.get("http://sep.comxa.com/php/getFerias.php").
            success(function(response) {
                $scope.ferias = response["data"];
            });    
    }
    
    //Llamadas iniciales
    $scope.getFerias($scope);
    $scope.getProyectos($scope);
});


sepControllers.controller('proyectoCtrl',function($scope,$rootScope,$http,$filter,$location){
    $scope.verProyecto = function(){
        $http.get("http://sep.comxa.com/php/getProyecto.php", {
    			params: {idProyecto: $rootScope.idProyecto}
 			}).then(function successCallback(response) {
                $scope.proyecto = response['data']['data'];
                console.log($scope.proyecto);
                if(response["data"]["success"] == '0'){
                    console.log('entre')
                    $location.path('proyectos');    
                }
			  }, function errorCallback(response) {
                $location.path('verProyectos');
            });
    };
    
    $scope.verProyecto();
});



sepControllers.controller('activacionEvaluadoresCtrl',function($scope,$http,$filter){
    $scope.evaluadores = [];
    $scope.evaluadoresPorPagina = 6;
    
    $scope.activarEvaluador = function(idEvaluador){
        console.log("Entre");
        $.post("http://sep.comxa.com/php/asignarEvaluador.php",{
                    'idEvaluador': idEvaluador
            }).done(function(response){
                console.log(response);
            }).error(function(response){
                console.log(response);
            });
    }
    
    $scope.getEvaluadores = function(){
        console.log("CAMBIO");
        $http.get("http://sep.comxa.com/php/getEvaluadores.php", {
    			params: {idFeria: $scope.idFeria}
 			}).then(function successCallback(response) {
                $scope.evaluadores = response['data']['data'];
                console.log($scope.evaluadores);
			  }, function errorCallback(response) {
            });
    }
    
    $scope.getFerias = function($scope){
        $http.get("http://sep.comxa.com/php/getFerias.php").
            success(function(response) {
                $scope.ferias = response["data"];
            });    
    }
   
    $scope.getFerias($scope); 
});


sepControllers.controller('perfilAdmiCtrl',function($scope){
    $scope.uploadUser = function($scope){
        $scope.user = JSON.parse(sessionStorage.getItem('user'));
    }
    
    $scope.uploadUser($scope);
    console.log($scope.user);
    
});


sepControllers.controller('controlFeriaCtrl',function($scope){
});


sepControllers.controller('creacionFeriaCtrl',function($scope){
    $scope.feria = {
        nombre: '' ,
        anno: '' ,
        periodo: ''
    };
    $scope.feriaReset = $scope.feria;
    
    $scope.resetDatos = function(){
        $scope.$apply(function(){
            $scope.feria = {
                nombre: '' ,
                anno: '' ,
                periodo: ''
            };
        });
    }
    
    $scope.crearFeria= function(){
        console.log($scope.feria);
        $.post("http://sep.comxa.com/php/insertFeria.php",{
                'nombre': $scope.feria.nombre,
                'anno': $scope.feria.anno,
                'periodo': $scope.feria.periodo
        }).done(function(response){
            console.log(response);
            $scope.resetDatos();
        });
    };
    
    
});


sepControllers.controller('registroEvaluacionCtrl',function($scope,$http,$filter){
    $scope.ferias = {};
    $scope.rubricas = {};
	$scope.idFeria = "";
	$scope.valores = [];
	$scope.idRubricas = [];
    $scope.comentario = "";
    $scope.idEvaluador = "";
    
	$scope.getFerias = function($scope){
        $http.get("http://sep.comxa.com/php/getFerias.php").
            success(function(response) {
                $scope.ferias = response["data"];
            });    
    };
    
	$scope.llamarProyectos =function(){
        $http.get("http://sep.comxa.com/php/obtenerProyectos.php", {
    			params: {idFeria: $scope.idFeria}
 			}).then(function successCallback(response) {
                $scope.idProyecto = "";
                $scope.proyectos = response['data']['data'];
                console.log($scope.proyectos);
			  }, function errorCallback(response) {
            });
    };

	$scope.llamarProfesores =function(){
        $http.get("http://sep.comxa.com/php/getProyEval.php", {
    			params: {idProyecto: $scope.idProyecto}
 			}).then(function successCallback(response) {
                $scope.evaluadores = response['data']['data'];
			  }, function errorCallback(response) {
                console.log(response);
            });
    };

    $scope.llamarRubricas = function(){
        $http.get("http://sep.comxa.com/php/obtenerRubricas.php", {
    			params: {idProyecto: $scope.idProyecto,
                        'idEvaluador' : $scope.idEvaluador}
 			}).then(function successCallback(response) {
                $scope.rubricas = response['data']['data'];
                $scope.idEvaluacion = $scope.rubricas[0]['idEval'];
                for(var i=0; i < $scope.rubricas.length; i++){
		 				$scope.idRubricas[i] = $scope.rubricas[i].idRubricaEvaluacion;
		 				$scope.valores[i]=50;
    			}
			  }, function errorCallback(response) {
                console.log(response);
            });  		

    };  
  
	$scope.enviar =function(){
        $scope.rubels = [];
            for(var i=0; i < $scope.rubricas.length; i++){
                var rubel = {};
                rubel.valor= $scope.valores[i];
                rubel.idRubrica= parseInt($scope.idRubricas[i], 10);
                $scope.rubels.push(rubel);
            }
        $.post("http://sep.comxa.com/php/enviarCalificacion.php",{
                    'rubels' : $scope.rubels,
                    'idEvaluacion' : $scope.idEvaluacion,
                    'comentario' : $scope.comentario
            }).done(function(response){
                    console.log(response);
                    $scope.respuestas = response["data"];
                    $scope.$apply();

            });
    };
    
    $scope.resetDatos = function(){
        $scope.idFeria = "";
        $scope.idProyecto = "";
        $scope.proyectos = [];
        $scope.idEvaluador = "";
        $scope.evaluadores = [];
        $scope.valores = [];
        $scope.$apply();
    }

    $scope.getFerias($scope);
 

});

sepControllers.controller('administradorCtrl',function($scope,$http){
	$scope.administradores={};
    $scope.administrador = {
        nombre: '' ,
        apellido1: '' ,
        apellido2: '',
        correoElectronico: '',
        contrasenia: '',
        idAdministrador:''
    };
    $scope.administradorReset = $scope.administrador;
    
    $scope.resetDatos = function(){
        $scope.$apply(function(){
            $scope.administrador = {
                nombre: '' ,
        		apellido1: '' ,
		        apellido2: '',
		        correoElectronico: '',
		        contrasenia: ''
            };
        });
    }

     $scope.comprobarContrasenia = function($clave1, $clave2){
        if ($clave1 == $clave2){
        	$scope.insertarAdministrador();
        }else{
        	alert("Las contraseñas no coinciden"); 	
        }    
    }
    
    $scope.getAdministradores = function(){
        $http.get('http://sep.comxa.com/php/getAdministradores.php').
            success(function(response) {
                $scope.administradores = response["data"];
            });    
    }
    
    $scope.insertarAdministrador= function(){
        console.log($scope.administrador);
        $.post('http://sep.comxa.com/php/insertarAdministrador.php',{
                'nombre': $scope.administrador.nombre,
                'apellido1': $scope.administrador.apellido1,
                'apellido2': $scope.administrador.apellido2,
                'correoElectronico':$scope.administrador.correoElectronico,
                'contrasenia': $scope.administrador.contrasenia
        }).done(function(response){
            console.log(response);
            $scope.resetDatos();
        }).error(function(response){
            console.log(response);
            $scope.resetDatos();
        });
    }

     $scope.eliminarAdministrador = function($parametro){
     	$scope.correoElectronico= $parametro;
     	console.log($scope.correoElectronico);
        $.post('http://sep.comxa.com/php/eliminarAdministrador.php',{
                'correoElectronico':$scope.correoElectronico
        }).done(function(response){
            console.log(response);
            $scope.getAdministradores();
            $scope.resetDatos();
        }).error(function(response){
            console.log(response);
            $scope.resetDatos();
        });
	}

	$scope.editAdministrador = function(administrador){
		$('#editAdmi').modal('show');
		$scope.administrador = administrador;
	};

	$scope.actualizarAdministrador = function(){
        console.log($scope.administrador);
        $.post('http://sep.comxa.com/php/actualizarAdministrador.php',{
                'idAdministrador': $scope.administrador.idAdministrador,
                'nombre': $scope.administrador.nombre,
                'apellido1': $scope.administrador.apellido1,
                'apellido2': $scope.administrador.apellido2,
                'correoElectronico':$scope.administrador.correoElectronico,
                'contrasenia': $scope.administrador.contrasenia
        }).done(function(response){
            console.log(response);
            $scope.resetDatos();
        }).error(function(response){
            console.log(response);
            $scope.resetDatos();
        });
    };
    
    $scope.getAdministradores();
});









