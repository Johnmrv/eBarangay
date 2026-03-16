@extends('admin.layouts.admin-layout')

@section('content')

<h2>Complaints Management</h2>

<table>

<tr>
<th>Title</th>
<th>Category</th>
<th>Location</th>
<th>Status</th>
<th>Date</th>
</tr>

@foreach($complaints as $complaint)

<tr onclick="showComplaint(
'{{ $complaint['$id'] }}',
'{{ $complaint['title'] }}',
'{{ $complaint['description'] }}',
'{{ $complaint['category'] }}',
'{{ $complaint['location'] }}',
'{{ $complaint['status'] }}'
)">

<td>{{ $complaint['title'] }}</td>
<td>{{ $complaint['category'] }}</td>
<td>{{ $complaint['location'] }}</td>
<td>{{ $complaint['status'] }}</td>
<td>{{ $complaint['date_submitted'] }}</td>

</tr>

@endforeach

</table>


<hr>


<div id="complaintDetails" style="display:none;">

<h3>Complaint Details</h3>

<p><b>Title:</b> <span id="c_title"></span></p>
<p><b>Description:</b> <span id="c_description"></span></p>
<p><b>Category:</b> <span id="c_category"></span></p>
<p><b>Location:</b> <span id="c_location"></span></p>
<p><b>Status:</b> <span id="c_status"></span></p>

<h4>Evidence</h4>

<div id="evidenceSection">

@foreach($evidence as $ev)

<div 
class="evidenceItem"
data-complaint="{{ $ev['complaint_id'] }}"
data-file="{{ $ev['image_id'] }}"
style="display:none;">

<img 
src="https://sgp.cloud.appwrite.io/v1/storage/buckets/{{ env('APPWRITE_BUCKET_ID') }}/files/{{ $ev['image_id'] }}/view?project={{ env('APPWRITE_PROJECT_ID') }}"
style="max-width:300px; border:1px solid #ccc; margin-top:10px;">

</div>

@endforeach

<p id="noEvidence">No evidence uploaded.</p>

</div>


<h4>Conversation</h4>

<div id="messageBox" style="border:1px solid #ccc;padding:10px;height:200px;overflow:auto;">

@foreach($messages as $msg)

<div class="messageItem"
data-complaint="{{ $msg['complaint_id'] }}"
style="display:none;margin-bottom:8px;">

<b>{{ $msg['sender_role'] }}:</b>

{{ $msg['message'] }}

</div>

@endforeach

<p id="noMessages">No messages yet.</p>

</div>


<h4>Reply</h4>

<form method="POST" action="/admin/message">

@csrf

<input type="hidden" name="complaint_id" id="message_complaint_id">

<textarea name="message" required style="width:100%;height:80px;"></textarea>

<br><br>

<button type="submit">Send Message</button>

</form>


<h4>Update Status</h4>

<form method="POST" action="/admin/update-status">

@csrf

<input type="hidden" name="complaint_id" id="status_complaint_id">

<select name="status">

<option>Pending</option>
<option>Processing</option>
<option>Resolved</option>

</select>

<br><br>

<button type="submit">Update Status</button>

</form>

</div>


<script>

function showComplaint(id,title,description,category,location,status){

document.getElementById("complaintDetails").style.display="block";

document.getElementById("c_title").innerText = title;
document.getElementById("c_description").innerText = description;
document.getElementById("c_category").innerText = category;
document.getElementById("c_location").innerText = location;
document.getElementById("c_status").innerText = status;

document.getElementById("message_complaint_id").value = id;
document.getElementById("status_complaint_id").value = id;


/* Evidence Viewer */

let evidenceItems = document.querySelectorAll(".evidenceItem");
let foundEvidence = false;

evidenceItems.forEach(item => {

if(item.dataset.complaint == id){

item.style.display="block";
foundEvidence = true;

}else{

item.style.display="none";

}

});

document.getElementById("noEvidence").style.display = foundEvidence ? "none" : "block";


/* Message Viewer */

let messageItems = document.querySelectorAll(".messageItem");
let foundMessages = false;

messageItems.forEach(item => {

if(item.dataset.complaint == id){

item.style.display="block";
foundMessages = true;

}else{

item.style.display="none";

}

});

document.getElementById("noMessages").style.display = foundMessages ? "none" : "block";

}

</script>

@endsection