<!DOCTYPE html>
<html>
<head>
    <title>My Diaries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>My Diaries</h2>
    <a href="{{ route('diary.create') }}" class="btn btn-primary mb-3">Add New Diary</a>
    <a href="/" class="btn btn-primary mb-3">Go to home</a>


    @foreach($diaries as $diary)
        <div class="card mb-2">
            <div class="card-body">
                <h4>{{ $diary->title }}</h4>
                <p>Difficulty: {{ $diary->difficulty }}</p>
                <a href="{{ route('diary.show', $diary->id) }}" class="btn btn-info">View</a>
            </div>
        </div>
    @endforeach
</div>
</body>
</html>
