<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Authentification</title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="{{ route('submitLogin') }}" method="POST">
                        {{ csrf_field() }}

                        <fieldset>
                            <div class="form-group">
                                <input class="form-control"
                                       placeholder="E-mail" name="email" type="email" value="{{ old('email') }}" autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password"
                                       name="password" type="password" value="" required>
                            </div>
                            <div class="checkbox">
                                <label><input name="remember" type="checkbox" value="Remember Me">Remember Me</label>
                            </div>
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="Login">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/sb-admin-2.js"></script>

</body>

</html>
