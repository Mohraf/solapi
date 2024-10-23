<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email</title>
</head>
<body>
<div>
    <h4>Welcome {{ $user->username }}</h4>
    <p>Email sending ...</p>
    {{ json_encode($params) }}
</div>
</body>
</html>
