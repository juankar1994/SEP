sepApp.factory('csvFactory',function(){
    return{
        //http://demo.sodhanalibrary.com/angular/read_csv.html
        processData : function(allText,splitted) {
            // split content based on new line
            var allTextLines = allText.split(/\r\n|\n/);
            var headers = allTextLines[0].split(splitted);
            var lines = [];

            for ( var i = 1; i < allTextLines.length; i++) {
                // split content based on comma
                var data = allTextLines[i].split(splitted);
                if (data.length == headers.length) {
                    var tarr = {};
                    for ( var j = 0; j < headers.length; j++) {
                        tarr[headers[j]]= data[j] ;
                    }
                    lines.push(tarr);
                }
            }
            return lines;
        }
    };

});


sepApp.factory('sessionFactory',function($window,$location){
    return{
        checkLogin : function(){
            console.log($window.location.href);
            var path = $location.path();
            if (!JSON.parse(sessionStorage.getItem('loggedIn'))){
                $window.location.href = '/index.html';
            }else{
                if($window.location.href.indexOf('index.html') > -1){
                    $window.location.href = '/administrador.html' + '#' + path;
                }
            }
        },
        checkLogOut : function(){
            if (JSON.parse(sessionStorage.getItem('loggedIn'))){
                $window.location.href = '/administrador.html';
                $location.path('/proyectos');
            }else{
                if($window.location.href.indexOf('administrador.html') > -1){
                    $window.location.href = '/index.html';
                }
            }
        },
        logOut : function(){
            sessionStorage.removeItem('loggedIn');
		    $location.path('/');
        }
    };
});

