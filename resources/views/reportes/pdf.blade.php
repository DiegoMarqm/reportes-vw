<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte PDF</title>
    <style>
        body {
            font-family: sans-serif;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Reporte: No. Folio - {{ $reporte->numFolio }}</h1>

    <h3>Información General</h3>
    <table>
        <tr><th>Folio</th><td>{{ $reporte->numFolio }}</td></tr>
        <tr><th>Departamento</th><td>{{ $reporte->departamento }}</td></tr>
        <tr><th>Calificación</th><td>{{ $reporte->calificacion }}</td></tr>
        <tr><th>Fecha de Queja</th><td>{{ $reporte->fechaQueja }}</td></tr>
        <!-- Añade más filas según sea necesario -->
    </table>

    <h3>Información del Cliente</h3>
    <table>
        <tr><th>Nombre</th><td>{{ $reporte->nomCliente }}</td></tr>
        <tr><th>Celular</th><td>{{ $reporte->celularCliente }}</td></tr>
        <tr><th>Email</th><td>{{ $reporte->emailCliente }}</td></tr>
        <!-- Añade más filas según sea necesario -->
    </table>

    <!-- Añade secciones para Vehículo, Reclamación y Resolución -->
</body>
</html>
