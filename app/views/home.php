<html>
	<head>
		<title>home</title>
	</head>
	<body>

		<h2>{{ $text }}</h2>

		{{ 
			for($i = 0; $i < 8; $i++)
				echo $i;
		}}

	</body>
</html>