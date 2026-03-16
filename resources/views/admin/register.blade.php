<!DOCTYPE html>
<html>
<head>

<title>Admin Register</title>

</head>

<body>

<h2>Create Admin Account</h2>

@if(session('success'))
<p style="color:green;">{{ session('success') }}</p>
@endif

<form method="POST" action="/admin/register">

@csrf

<label>Full Name</label>
<br>
<input type="text" name="full_name" required>
<br><br>

<label>Email</label>
<br>
<input type="email" name="email" required>
<br><br>

<label>Password</label>
<br>
<input type="password" name="password" required>
<br><br>

<button type="submit">Register Admin</button>

</form>

<br>

<a href="/admin/login">Back to Login</a>

</body>
</html>