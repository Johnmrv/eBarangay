@extends('admin.layouts.admin-layout')

@section('content')

<h2>Complaints Management</h2>

<table border="1" cellpadding="8" cellspacing="0" width="100%">

<tr>
<th>Title</th>
<th>Category</th>
<th>Location</th>
<th>Status</th>
<th>Date</th>
<th>Resident</th>
<th>Contact</th>
<th>Address</th>
<th>Action</th>
</tr>

@foreach($complaints as $complaint)

<tr>

<td onclick="showComplaint(
'{{ $complaint['$id'] }}',
'{{ $complaint['title'] }}',
'{{ $complaint['description'] }}',
'{{ $complaint['category'] }}',
'{{ $complaint['location'] }}',
'{{ $complaint['status'] }}',
'{{ $complaint['resident_name'] }}',
'{{ $complaint['resident_contact'] }}',
'{{ $complaint['resident_address'] }}'
)">
{{ $complaint['title'] }}
</td>

<td>{{ $complaint['category'] }}</td>
<td>
<a href="{{ $complaint['location'] }}" target="_blank">
📍 View Map
</a>
</td>
<td>{{ $complaint['status'] }}</td>
<td>{{ $complaint['date_submitted'] }}</td>

<td>{{ $complaint['resident_name'] }}</td>
<td>{{ $complaint['resident_contact'] }}</td>
<td>{{ $complaint['resident_address'] }}</td>

<td>

@if(strtolower($complaint['status']) != 'resolved')

<form method="POST" action="/admin/delete-complaint"
onsubmit="return confirm('Mark this complaint as resolved?')"
onclick="event.stopPropagation();">

@csrf

<input type="hidden" name="complaint_id" value="{{ $complaint['$id'] }}">

<button style="
background:#22c55e;
color:white;
border:none;
padding:6px 10px;
border-radius:6px;
cursor:pointer;
">
✔
</button>

</form>

@endif

</td>

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

<hr>

<h4>Resident Information</h4>

<p><b>Name:</b> <span id="c_name"></span></p>
<p><b>Contact:</b> <span id="c_contact"></span></p>
<p><b>Address:</b> <span id="c_address"></span></p>

<hr>

<h4>Evidence</h4>

<div id="evidenceSection">

@foreach($evidence as $ev)

<div 
class="evidenceItem"
data-complaint="{{ $ev['complaint_id'] }}"
style="display:none;">

<img 
src="https://sgp.cloud.appwrite.io/v1/storage/buckets/{{ env('APPWRITE_BUCKET_ID') }}/files/{{ $ev['image_id'] }}/view?project={{ env('APPWRITE_PROJECT_ID') }}&mode=admin"
style="max-width:300px; border:1px solid #ccc; margin-top:10px;">

</div>

@endforeach

<p id="noEvidence">No evidence uploaded.</p>

</div>


<hr>

<h4>Conversation</h4>

<div id="messageBox" style="border:1px solid #ccc;padding:10px;height:200px;overflow:auto;"></div>


<h4>Reply</h4>

<form id="adminMessageForm">

@csrf

<input type="hidden" id="message_complaint_id">

<textarea id="adminMessageInput" required style="width:100%;height:80px;"></textarea>

<br><br>

<button type="submit">Send Message</button>

</form>


<hr>

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

let currentComplaint = null;


/* CLICK COMPLAINT */

function showComplaint(id,title,description,category,location,status,name,contact,address){

currentComplaint = id;

document.getElementById("complaintDetails").style.display="block";

document.getElementById("c_title").innerText = title;
document.getElementById("c_description").innerText = description;
document.getElementById("c_category").innerText = category;
document.getElementById("c_location").innerText = location;
document.getElementById("c_status").innerText = status;

document.getElementById("c_name").innerText = name;
document.getElementById("c_contact").innerText = contact;
document.getElementById("c_address").innerText = address;

document.getElementById("message_complaint_id").value = id;
document.getElementById("status_complaint_id").value = id;


/* Evidence */

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


/* LOAD MESSAGES */

loadMessages();

}


/* LOAD MESSAGES */

function loadMessages(){

if(!currentComplaint) return;

fetch("/admin/messages/" + currentComplaint)
.then(res => res.json())
.then(data => {

let box = document.getElementById("messageBox");

box.innerHTML = "";

if(data.length === 0){
box.innerHTML = "<p>No messages yet.</p>";
return;
}

data.forEach(msg => {

let div = document.createElement("div");
div.style.marginBottom = "8px";

if(msg.sender_role === "admin"){

div.innerHTML = `
<div style="text-align:right;">
<b style="color:green;">Admin</b><br>
<span style="background:#d4edda;padding:6px;border-radius:6px;">
${msg.message}
</span>
</div>
`;

}else{

div.innerHTML = `
<div>
<b style="color:blue;">Resident</b><br>
<span style="background:#f1f1f1;padding:6px;border-radius:6px;">
${msg.message}
</span>
</div>
`;

}

box.appendChild(div);

});

box.scrollTop = box.scrollHeight;

});

}


/* SEND MESSAGE */

document.getElementById("adminMessageForm").addEventListener("submit", function(e){

e.preventDefault();

let message = document.getElementById("adminMessageInput").value;

fetch("/admin/message", {
method: "POST",
headers: {
"Content-Type": "application/json",
"X-CSRF-TOKEN": "{{ csrf_token() }}"
},
body: JSON.stringify({
complaint_id: currentComplaint,
message: message
})
})
.then(() => {

document.getElementById("adminMessageInput").value = "";

loadMessages();

});

});


/* AUTO REFRESH */

setInterval(loadMessages, 3000);

</script>

@endsection