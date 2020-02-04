<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <title>STMS</title>
    <script>
            // rename myToken as you like
            window.myToken =  <?php echo json_encode(['csrfToken' => csrf_token(), ]); ?>
    </script>
    
</head>
<body>
    <div id="app">
        <app-home></app-home>
    </div>
    <script src="{{asset('js/app.js')}}"></script>
</body>
</html>