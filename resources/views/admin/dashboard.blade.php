@extends('admin.layouts.admin-layout')

@section('content')

<h2>Admin Dashboard</h2>

<div class="card">
<h3>Total Complaints</h3>
<p>{{ $totalComplaints }}</p>
</div>

<div class="card">
<h3>Total Residents</h3>
<p>{{ $totalResidents }}</p>
</div>

<div class="card">
<h3>Pending</h3>
<p>{{ $pending }}</p>
</div>

<div class="card">
<h3>Processing</h3>
<p>{{ $processing }}</p>
</div>

<div class="card">
<h3>Resolved</h3>
<p>{{ $resolved }}</p>
</div>

<h3>Recent Complaints</h3>

<table>

<tr>
<th>Title</th>
<th>Category</th>
<th>Status</th>
<th>Location</th>
</tr>

@foreach($complaintList as $complaint)

<tr>

<td>{{ $complaint['title'] }}</td>

<td>{{ $complaint['category'] }}</td>

<td>{{ $complaint['status'] }}</td>

<td>{{ $complaint['location'] }}</td>

</tr>

@endforeach

</table>

@endsection