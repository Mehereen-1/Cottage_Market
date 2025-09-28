<!DOCTYPE html>
<html>
<head>
    <title>Demo Admin</title>
</head>
<body>
<h1>Admin Panel (Demo)</h1>

<h2>Pending Sellers</h2>
<ul>
    @foreach($pendingSellers as $s)
        <li>{{ $s->name }} ({{ $s->email }}) 
            <button>Approve</button>
        </li>
    @endforeach
</ul>

<h2>Pending Products</h2>
<ul>
    @foreach($pendingProducts as $p)
        <li>{{ $p->title }} by {{ $p->user }} 
            <button>Approve</button> ({{ $p->status }})
        </li>
    @endforeach
</ul>

<a href="/demo-home">Back Home</a>
</body>
</html>
