@extends(template.php)

@begin(title)
titolo
@end

@begin(body)

{{ 

	for($i = 0; $i < 10; $i++) 
		echo $i;

}}

<h3>{{ $text }}</h3>

@end
