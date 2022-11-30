<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tasks</title>
    <script type="text/javascript" src="/public/bootstrap/js/bootstrap.min.js"></script>
    <link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <div class="menu">
        <a href="/">Home</a>
        <a href="/authorization/">Sign in</a>
        <?
        $auth = $_SESSION['auth'] ?? false;
        if( $auth ) {
            ?>
            <a href="/out/">Sign out</a>
            <?
        }
        ?>
    </div>

</head>
<body>