@extends('admin.layouts.admin-layout')

@section('content')

<h2>Announcements</h2>

@if(session('success'))
<div style="color:#16a34a; background:#f0fdf4; padding:12px 16px; border-radius:8px; border:1px solid #bbf7d0; margin-bottom:20px; font-size:14px;">
    {{ session('success') }}
</div>
@endif

<div class="card" style="max-width: 600px; margin-bottom: 40px;">
    <h3 style="margin-top:0; margin-bottom:20px; color:#1e293b;">Add Announcement</h3>

    <form method="POST" action="/admin/announcement">
        @csrf
        
        <div style="margin-bottom: 16px;">
            <label style="display:block; margin-bottom:8px; font-size:14px; font-weight:500; color:#475569;">Title</label>
            <input type="text" name="title" required>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display:block; margin-bottom:8px; font-size:14px; font-weight:500; color:#475569;">Content</label>
            <textarea name="content" required style="height:120px; resize:vertical;"></textarea>
        </div>

        <button type="submit">Post Announcement</button>
    </form>
</div>


<div class="card" style="width: 100%;">
    <h3 style="margin-top:0; margin-bottom:20px; color:#1e293b;">Announcement List</h3>

    <table>
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Date</th>
            <th width="100">Action</th>
        </tr>

        @foreach($announcements as $ann)
        <tr>
            <td style="font-weight:500; color:#1e293b;">{{ $ann['title'] }}</td>
            <td style="color:#475569; line-height:1.5;">{{ $ann['content'] }}</td>
            <td style="color:#64748b; font-size:13px; white-space:nowrap;">{{ $ann['created_at'] }}</td>
            <td>
                <form method="POST" action="/admin/announcement/delete" onsubmit="return confirm('Delete this announcement?')">
                    @csrf
                    <input type="hidden" name="id" value="{{ $ann['$id'] }}">
                    <button style="background:#fef2f2; color:#dc2626; padding:8px 12px; border-radius:6px; font-size:13px; font-weight:600; border:1px solid #fecaca; width:100%; transition:all 0.2s;">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>

@endsection