@extends('admin.layouts.admin-layout')

@section('content')

<h2>Admin Dashboard</h2>

<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }
    .stat-card {
        background: #ffffff;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }
    .stat-card h3 {
        margin: 0;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-card p {
        margin: 10px 0 0 0;
        font-size: 32px;
        font-weight: 700;
        color: #1e293b;
    }
</style>

<div class="dashboard-grid">
    <div class="stat-card">
        <h3>Total Complaints</h3>
        <p>{{ $totalComplaints }}</p>
    </div>

    <div class="stat-card">
        <h3>Total Residents</h3>
        <p>{{ $totalResidents }}</p>
    </div>

    <div class="stat-card">
        <h3>Pending</h3>
        <p style="color: #f59e0b;">{{ $pending }}</p>
    </div>

    <div class="stat-card">
        <h3>Processing</h3>
        <p style="color: #3b82f6;">{{ $processing }}</p>
    </div>

    <div class="stat-card">
        <h3>Resolved</h3>
        <p style="color: #10b981;">{{ $resolved }}</p>
    </div>
</div>

<div class="card">
    <h3 style="margin-top:0; margin-bottom:20px; color:#1e293b;">Recent Complaints</h3>
    
    <table>
        <tr>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Location</th>
        </tr>

        @foreach($complaintList as $complaint)
        <tr>
            <td style="font-weight:500; color:#1e293b;">{{ $complaint['title'] }}</td>
            <td style="color:#475569;">{{ $complaint['category'] }}</td>
            <td>
                @if(strtolower($complaint['status']) == 'pending')
                    <span style="background:#fef3c7;color:#d97706;padding:4px 10px;border-radius:99px;font-size:12px;font-weight:600;">{{ $complaint['status'] }}</span>
                @elseif(strtolower($complaint['status']) == 'processing')
                    <span style="background:#dbeafe;color:#2563eb;padding:4px 10px;border-radius:99px;font-size:12px;font-weight:600;">{{ $complaint['status'] }}</span>
                @elseif(strtolower($complaint['status']) == 'resolved')
                    <span style="background:#d1fae5;color:#059669;padding:4px 10px;border-radius:99px;font-size:12px;font-weight:600;">{{ $complaint['status'] }}</span>
                @else
                    {{ $complaint['status'] }}
                @endif
            </td>
            <td>
                <a href="{{ $complaint['location'] }}" target="_blank" style="color:#2563eb; text-decoration:none; font-size:13px; font-weight:500;">
                    📍 View
                </a>
            </td>
        </tr>
        @endforeach

    </table>
</div>

@endsection