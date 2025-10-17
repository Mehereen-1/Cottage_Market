<!DOCTYPE html>
<html>
<head>
    <title>Create Diary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Add a New Diary</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('diary.store') }}">
        @csrf
        <div class="mb-2">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Difficulty</label>
            <select name="difficulty" class="form-control" required>
                <option>easy</option>
                <option>medium</option>
                <option>hard</option>
            </select>
        </div>

        <div class="mb-2">
            <label>Make Time</label>
            <input type="text" name="make_time" class="form-control">
        </div>

        <div class="mb-2">
            <label>Ingredients</label>
            <textarea name="ingredients" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-2">
            <label>Note (optional)</label>
            <textarea name="note" class="form-control" rows="2"></textarea>
        </div>

        <h5>Directions (steps)</h5>
        <div id="directions-container" class="mb-2">
            <div class="direction-step mb-2">
                <input type="text" name="directions[]" class="form-control" placeholder="Step 1" required>
            </div>
        </div>

        <button type="button" id="add-step" class="btn btn-secondary mb-3">Add Step</button>
        <br>
        <button type="submit" class="btn btn-success">Save Diary</button>
    </form>
</div>

<script>
document.getElementById('add-step').addEventListener('click', function() {
    const container = document.getElementById('directions-container');
    const count = container.querySelectorAll('.direction-step').length + 1;
    const div = document.createElement('div');
    div.classList.add('direction-step', 'mb-2');
    div.innerHTML = `<input type="text" name="directions[]" class="form-control" placeholder="Step ${count}" required>`;
    container.appendChild(div);
});
</script>
</body>
</html>
