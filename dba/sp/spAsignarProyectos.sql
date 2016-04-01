
DROP PROCEDURE IF EXISTS asignarEvaluadores;

CREATE PROCEDURE asignarEvaluadores
(IN idEval int)
BEGIN


INSERT INTO Evaluacion
(idProyecto, idEvaluador, estado)
SELECT 
    idProyecto, idEval, 0
FROM
    (SELECT 
        p.idProyecto,
            IF(idTipo = 1, 5, 3) AS cantidadMaxima,
            IFNULL(a.cA, 0) AS cantidadAsignados,
            r.correoElectronico as correoProfesor,
            idFeria
    FROM
        Proyectos p
    LEFT JOIN (SELECT 
        idProyecto, COUNT(idProyecto) AS cA
    FROM
        Evaluacion
    GROUP BY idProyecto) a ON p.idProyecto = a.idProyecto
    INNER JOIN profesor r ON r.idProfesor = p.idProfesor) b
WHERE
    b.correoProfesor != (SELECT 
            correoElectronico
        FROM
            Evaluador
        WHERE
            idevaluador = idEval
        LIMIT 1)
        AND
        b.idFeria = (SELECT 
            idFeria
        FROM
            Evaluador
        WHERE
            idevaluador = idEval
        LIMIT 1)
        AND cantidadMaxima > cantidadAsignados
ORDER BY cantidadAsignados ASC
LIMIT 5;


END