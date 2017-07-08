<!DOCTYPE html>
<html lang="en">

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title') TravelScanner</title>
	<meta name="csrf-token" content="{{ Session::token() }}">

	<meta property="og:url"           content="{{\Request::url()}}" />
	<meta property="og:type"          content="Flight finder" />
	<meta property="og:title"         content="Scanner for Skies " />
	<meta property="og:description"   content="Find and share" />
	<meta property="og:image"         content="http://www.your-domain.com/path/image.jpg" />


	<link href="{{ asset('/assets/css/app.css') }}" rel="stylesheet">	

	<link href='https://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
	<!-- Fonts -->
	<!-- DataTables CSS -->
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.10/integration/bootstrap/3/dataTables.bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/tabletools/2.2.0/css/dataTables.tableTools.min.css">
	<link href="{{ asset('/assets/css/main.css') }}" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	@yield('header')

</head>
<body>

	@yield('content')
	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

	<!-- DataTables -->
	<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.js"></script>
	<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/plug-ins/1.10.10/integration/bootstrap/3/dataTables.bootstrap.js"></script>
	<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/tabletools/2.2.0/js/dataTables.tableTools.min.js"></script>
	<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/colvis/1.1.0/js/dataTables.colVis.min.js"></script>
	<script src="{{ asset('/assets/selectisize.js') }}"></script>
	<script src="{{ asset('/assets/js/app.js') }}"></script>


	<!-- Additional Scripts -->
	@section('javascript')

	@show
</body>
</html>
