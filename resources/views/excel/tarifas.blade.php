<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body>
        <tr>
            <th>Título</th>
            <th>Abreviatura</th>
            <th>Estado</th>
        </tr>

        @foreach($rows as $item)
            @php
            $row_titulo = $item->titulo;
            $row_abrev = $item->abrev;
            $row_estado = $item->estado;
            @endphp
            <tr>
                <td>{{ $row_titulo }}</td>
                <td>{{ $row_abrev }}</td>
                <td>{{ $row_estado ? 'Activo' : 'No Activo' }}</td>
            </tr>
        @endforeach
    </body>
</html>