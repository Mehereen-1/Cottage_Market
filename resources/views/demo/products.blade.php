<!DOCTYPE html>
<html>
<head>
    <title>Demo Products</title>
</head>
<body>
<h1>Products</h1>
<ul>
    @foreach($products as $p)
        <li>
            <strong>{{ $p->title }}</strong> - ${{ $p->price }} 
            @if($p->status != 'approved') <span style="color:red">Pending</span> @endif
            <br>
            {{ $p->description }} <br>
            <img src="{{ $p->image }}" width="100" />
        </li>
    @endforeach
</ul>
<a href="/demo-home">Back Home</a>
</body>
</html>
