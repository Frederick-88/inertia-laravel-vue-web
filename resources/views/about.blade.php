<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
</head>
<body>
    <p>This is an about page</p>
    <a href="/">Back to Home </a>

    @foreach ($messageList as $message)
        {{ $message->text }}
    @endforeach
</body>
</html>
