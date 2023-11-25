<!DOCTYPE html>
<html>
<head>
    <title>Your User Has Been Created</title>
</head>
<body>
    <h1>Hello, {{ $data['name'] }}!</h1>
    <p>Your user has been created. Please proceed to http://127.0.0.1:8000/firstlogin/{{ $data['name'] }} to reset your password.</p>
</body>
</html>