    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="keyword" content="">
        <link rel="shortcut icon" href="img/favicon.png">

        <title>{{ $title }} - {{ Config::get('customConfig.names.siteName')}}</title>

        <!-- Bootstrap core CSS -->


        {!! Html::style('css/bootstrap.min.css') !!}
        {!! Html::style('css/bootstrap-reset.css') !!}
        {!! Html::style('fonts/font-awesome/css/font-awesome.css') !!}

        <!--right slidebar-->
        {!! Html::style('css/slidebars.css') !!}

        <!-- Custom styles for this template -->
        {!! Html::style('css/style.css') !!}
        {!! Html::style('css/style-responsive.css') !!}

        @yield('style')
        {!! Html::style('css/custom.css') !!}

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
