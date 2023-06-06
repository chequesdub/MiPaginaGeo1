<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Título de la página</title>
    <link rel="stylesheet" type="text/css" href="clases/html/css/paginado.css">
    <style>
        /* Agrega estilos personalizados aquí */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h2 {
            margin-bottom: 10px;
        }
        p {
            margin: 5px 0;
        }
        .paginador {
            margin-top: 20px;
        }
        .paginador a {
            display: inline-block;
            margin-right: 5px;
            padding: 5px 10px;
            text-decoration: none;
            border: 1px solid #ccc;
            color: #333;
            background-color: #f9f9f9;
        }
        .paginador a.activa {
            font-weight: bold;
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <?php
    include_once "clases/pagina.php";
    class Inicio
    {
        public function template($datos)
        {

            // Número de datos por página
            $datosPorPagina = 3;

            // Página actual
            $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

            // Calcular el número total de páginas
            $totalPaginas = ceil(count($datos) / $datosPorPagina);

            // Calcular el índice inicial y final de los datos a mostrar
            $indiceInicio = ($paginaActual - 1) * $datosPorPagina;
            $indiceFin = $indiceInicio + $datosPorPagina;

            // Obtener los datos a mostrar en la página actual
            $datosPagina = array_slice($datos, $indiceInicio, $datosPorPagina);

            // Mostrar los datos en la página actual
            echo "<h2>Datos:</h2>";
            foreach ($datosPagina as $dato) {
                echo "<p>ID: " . $dato->id . "</p>";
                echo "<p>Email PruebaGIT: " . $dato->email . "</p>";
                echo "<p>Nombre: " . $dato->nombre . "</p>";
                echo "<hr>";
            }

            // Mostrar el paginador con estilos CSS
            echo "<div class='paginador'>";
            for ($i = 1; $i <= $totalPaginas; $i++) {
                echo "<a class='pagina" . ($paginaActual == $i ? " activa" : "") . "' href='?modulo=Inicio&controlador=Inicio&accion=index&pagina=$i'>$i</a>";
            }
            echo "</div>";
        }
    }
    ?>
</body>
</html>