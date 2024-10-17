<!DOCTYPE html>
<html>
<head>
    <title>Histórico de Transações</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f8f8;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Histórico de Transações</h1>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Usuário</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historics as $historic)
                <tr>
                    <td>{{ $historic->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($historic->type === 'I')
                            Entrada
                        @elseif($historic->type === 'O')
                            Saída
                        @elseif($historic->type === 'T')
                            Transferência
                        @endif
                    </td>
                    <td>R$ {{ number_format($historic->amount, 2, ',', '.') }}</td>
                    <td>{{ $historic->user->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
