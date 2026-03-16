<!DOCTYPE html>
<html>
<head>

<title>eBarangay Admin</title>

<style>

body{
font-family:Arial;
margin:0;
background:#f4f6f9;
}

.sidebar{
width:220px;
background:#2c3e50;
position:fixed;
height:100%;
padding-top:20px;
}

.sidebar a{
display:block;
color:white;
padding:12px;
text-decoration:none;
}

.sidebar a:hover{
background:#34495e;
}

.main{
margin-left:220px;
padding:20px;
}

.card{
background:white;
padding:20px;
margin:10px;
display:inline-block;
width:200px;
box-shadow:0 2px 5px rgba(0,0,0,0.1);
}

table{
width:100%;
border-collapse:collapse;
background:white;
}

table th, table td{
padding:10px;
border-bottom:1px solid #ddd;
}

</style>

</head>

<body>

<div class="sidebar">

<h3 style="color:white;text-align:center;">eBarangay</h3>

<a href="/admin/dashboard">Dashboard</a>
<a href="/admin/complaints">Complaints</a>
<a href="/admin/announcements">Announcements</a>
<a href="/admin/logout">Logout</a>

</div>

<div class="main">

@yield('content')

</div>

</body>
</html>