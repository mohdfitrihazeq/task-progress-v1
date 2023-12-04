                                                   
<!DOCTYPE html>
<html>
<head>
    <title>Your User Has Been Created</title>
</head>
<body>
    <h1>Hello, {{ $data['name'] }}!</h1>
    <p>Your Task Progress user account has been created successfully . 
Please click on <a href="https://qubit-apps.com/firstlogin/{{ $data['user_name'] }}">here</a> to reset your password to a new password.  
Please do not reply to this auto generated email !
</p>
</body>
</html>