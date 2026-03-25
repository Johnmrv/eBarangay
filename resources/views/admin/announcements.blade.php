@extends('admin.layouts.admin-layout')

@section('content')

<h2>Announcements</h2>

@if(session('success'))
<p style="color:green;">{{ session('success') }}</p>
@endif


<h3>Add Announcement</h3>

<form method="POST" action="/admin/announcement">

@csrf

<label>Title</label>

<br>

<input type="text" name="title" required style="width:300px;">

<br><br>

<label>Content</label>

<br>

<textarea name="content" required style="width:400px;height:120px;"></textarea>

<br><br>

<button type="submit">Post Announcement</button>

</form>

<hr>


<h3>Announcement List</h3>

<table>

<tr>

<th>Title</th>
<th>Content</th>
<th>Date</th>

</tr>


@foreach($announcements as $ann)

<tr>

<td>{{ $ann['title'] }}</td>
<td>{{ $ann['content'] }}</td>
<td>{{ $ann['created_at'] }}</td>

<td>
    <form method="POST" action="/admin/announcement/delete" onsubmit="return confirm('Delete this announcement?')">
        @csrf
        <input type="hidden" name="id" value="{{ $ann['$id'] }}">
        <button style="background:red;color:white;border:none;padding:5px 10px;border-radius:5px;">
            Delete
        </button>
    </form>
</td>

</tr>

@endforeach


</table>

@endsection