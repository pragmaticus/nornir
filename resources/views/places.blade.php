<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Places</h1>
<ul>
    @foreach ($places as $place)
        <li>{{ $place }}</li>
    @endforeach
</ul>
</body>
</html>
