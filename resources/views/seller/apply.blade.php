<!DOCTYPE html>
<html>
<head><title>Apply Seller</title></head>
<body>
    <h1>Apply to Become a Seller</h1>

    <form method="POST" action="{{ route('apply.seller') }}">
        @csrf
        <textarea name="message" placeholder="Why do you want to be a seller?"></textarea><br>
        <button type="submit">Submit Application</button>
    </form>

    <a href="/">Back Home</a>
</body>
</html>
