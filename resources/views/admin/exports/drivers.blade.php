<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registered Drivers PDF</title>
    <style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #444;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #eee;
    }

    h2 {
        text-align: center;
        margin-bottom: 0;
    }

    small {
        display: block;
        text-align: center;
        margin-top: 4px;
    }
    </style>
</head>

<body>

    <h2>Registered Drivers</h2>
    <small>Exported on {{ now()->format('d M Y, h:i A') }}</small>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Truck Type</th>
                <th>Registered At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($drivers as $index => $driver)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $driver->full_name }}</td>
                <td>{{ $driver->email }}</td>
                <td>{{ $driver->phone }}</td>
                <td>{{ $driver->truck_type }}</td>
                <td>{{ $driver->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>