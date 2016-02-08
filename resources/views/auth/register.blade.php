<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>{{ $title }} - {{ Config::get('customConfig.names.siteName') }}</title>

    {!! Html::style('css/bootstrap.min.css') !!}
    {!! Html::style('css/bootstrap-reset.css') !!}
    {!! Html::style('fonts/font-awesome/css/font-awesome.css') !!}
    {!! Html::style('css/style.css') !!}
    {!! Html::style('css/style-responsive.css') !!}
    @yield('style')
    {!! Html::style('css/custom.css') !!}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    {!! HTML::script('js/html5shiv.js') !!}
    {!! HTML::script('js/respond.min.js') !!}
    <![endif]-->
</head>

<body class="login-body">
<div class="container">
    {!! Form::open(array('route' => 'user.store', 'method' => 'post', 'class' => 'form-signin')) !!}
    <h2 class="form-signin-heading">Sign Up now</h2>
    <div class="login-wrap">
        @include('includes.alert')
        {!! Form::text('name', '', array('class' => 'form-control', 'placeholder' => 'Full Name', 'autofocus')) !!}
        {!! Form::text('email', '', array('class' => 'form-control', 'placeholder' => 'Email Address', 'autofocus')) !!}
        {!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) !!}
        {!! Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirm Password')) !!}

        <label class="checkbox">
		                <span class="pull-right">
		                    <a data-toggle="modal" href="{{route('login')}}"> Already a member ?</a>
		                </span>
        </label>
        {!! Form::submit('Log in', array('class' => 'btn btn-lg btn-login btn-block')) !!}
    </div>




    {!! Form::close() !!}

</div>

<!-- js placed at the end of the document so the pages load faster -->
{!! Html::script('js/jquery.js') !!}
{!! Html::script('js/bootstrap.min.js') !!}

</body>
</html>
