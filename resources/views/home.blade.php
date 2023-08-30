<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Поиск</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
	<h1>Поиск</h1>
	<form id="search_form">
		<input id="search_text" type="text" name="search" placeholder="Введите поисковый запрос">
		<input id="search" type="submit" value="Найти">
	</form>
    <div id="results">
        {{-- @isset($posts)
            @foreach ($posts as $post)
                <div>
                    <h3>{{$post['title']}}</h3>
                    <p>{{$post['body']}}</p> 
                </div>
            @endforeach
        @endisset --}}
	</div>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
</body>
</html>