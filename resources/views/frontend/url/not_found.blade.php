<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Short-Your-URL</title>
    <!-- Favicons -->
    <link href="{{asset('frontend')}}/assets/img/url_shorter.png" rel="icon">
    <link href="{{asset('frontend')}}/assets/img/url_shorter.png" rel="apple-touch-icon">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <style>
        .error-page {padding: 40px 15px;text-align: center;}
        .error-actions {margin-top:15px;margin-bottom:15px;}
        .error-actions .btn { margin-right:10px; }
        .error404 {    font-size :100px !important;color: red }
    </style>

</head>
<body>


<div class="error-page">
    <h2>Oops!</h2>
    <h1 class="error404"> 404 </h1>
    <h2>Not Found</h2>
    <div class="error-details">
        Sorry, an error has occured. Requested page not found!
    </div>

    <hr>

    <div class="error-actions">
        <a href="{{url('/')}}" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
            Home </a><a href="http://nasimredoy.xyz" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact </a>
    </div>
</div>





</body>
</html>
