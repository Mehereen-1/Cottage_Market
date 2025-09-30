<!DOCTYPE html>
<html>
<head><title>Apply Seller</title></head>
<body>
    <h1>Apply to Become a Seller</h1>

    <form method="POST" action="{{ route('apply.seller') }}">
        @csrf
        <input type="number" name="id" placeholder="your id"><br>
        <textarea name="message" placeholder="Why do you want to be a seller?"></textarea><br>
        <label>Commission Rate (%)</label>
            <input type="number" name="commission_rate" min="0" max="100" value="10" required><br>                                  
        <button type="submit">Submit Application</button>
    </form>
 
    <a href="/">Back Home</a>
</body>
</html>
