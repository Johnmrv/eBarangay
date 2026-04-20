<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eBarangay Admin</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f8fafc;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --text-main: #334155;
            --text-light: #64748b;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --success: #16a34a;
            --danger: #dc2626;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --radius-md: 8px;
            --radius-lg: 12px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background-color: var(--bg-color);
            color: var(--text-main);
        }

        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            position: fixed;
            height: 100vh;
            padding-top: 30px;
            box-shadow: var(--shadow-md);
            z-index: 100;
        }

        .sidebar h3 {
            color: #ffffff;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .sidebar a {
            display: block;
            color: #cbd5e1;
            padding: 15px 25px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar a:hover {
            background-color: var(--sidebar-hover);
            color: #ffffff;
            border-left: 3px solid var(--primary);
        }

        .main {
            margin-left: 250px;
            padding: 40px;
            min-height: 100vh;
        }
        
        h2 {
            margin-top: 0;
            font-size: 24px;
            font-weight: 600;
            color: var(--sidebar-bg);
            margin-bottom: 24px;
        }
        h3 {
            font-weight: 600;
        }

        .card {
            background: var(--card-bg);
            padding: 24px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        table th {
            background-color: #f1f5f9;
            color: var(--text-light);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        table td {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-main);
            font-size: 14px;
            vertical-align: middle;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        table tr {
            transition: background 0.15s ease;
        }

        table tr:hover td {
            background-color: #f8fafc;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        textarea,
        select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: var(--text-main);
            background-color: #ffffff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: var(--radius-md);
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
        }

        button:hover {
            background-color: var(--primary-hover);
        }

        button:active {
            transform: scale(0.98);
        }

        hr {
            border: none;
            height: 1px;
            background-color: var(--border-color);
            margin: 30px 0;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3>eBarangay</h3>
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