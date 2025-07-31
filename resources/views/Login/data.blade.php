<!DOCTYPE html>
<html>
<head>
    <title>Data Login & Presensi</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { padding: 8px 12px; border: 1px solid #ccc; text-align: left; }
    </style>
</head>
<body>
    <h2>Data Login</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logins as $login)
                <tr>
                    <td>{{ $login->id }}</td>
                    <td>{{ $login->Username }}</td>
                    <td>{{ $login->password }}</td>
                    <td>{{ $login->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Data Presensi</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Tanggal</th>
                <th>Jam</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presensis as $presensi)
                <tr>
                    <td>{{ $presensi->id }}</td>
                    <td>{{ $presensi->Username }}</td>
                    <td>{{ $presensi->tanggal }}</td>
                    <td>{{ $presensi->jam }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
