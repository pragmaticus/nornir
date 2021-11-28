<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Pois</h1>
<ul>
    @foreach ($pois as $poi)
        <li>{{ $poi->name }}</li>
    @endforeach
</ul>
</body>
</html>
