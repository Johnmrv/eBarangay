@extends('admin.layouts.admin-layout')

@section('content')

<h2>Complaints Management</h2>

<style>
    .layout-wrapper {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }
    .table-container {
        flex: 1;
        min-width: 0; 
        overflow-x: auto;
    }
    #complaintDetails {
        width: 450px;
        flex-shrink: 0;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        border: 1px solid #e2e8f0;
        padding: 24px;
        position: sticky;
        top: 24px;
        max-height: calc(100vh - 48px);
        overflow-y: auto;
        box-sizing: border-box;
    }
    .clickable-row {
        cursor: pointer;
        transition: background 0.15s;
    }
    .clickable-row:hover {
        background-color: #f1f5f9 !important;
    }
    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 99px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
    }
    .detail-section h4 {
        margin-top: 0;
        color: #1e293b;
        font-size: 16px;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 8px;
        margin-bottom: 16px;
    }
    .detail-row {
        display: flex;
        margin-bottom: 12px;
        font-size: 14px;
    }
    .detail-row b {
        color: #64748b;
        width: 100px;
        flex-shrink: 0;
        font-weight: 500;
    }
    .detail-row span {
        color: #1e293b;
        font-weight: 500;
    }
    .action-btn {
        background: #22c55e;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        transition: background 0.2s;
    }
    .action-btn:hover {
        background: #16a34a;
    }
    #messageBox {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px;
        height: 250px;
        overflow-y: auto;
        background: #f8fafc;
        margin-bottom: 16px;
    }
    .msg-admin b { color: #16a34a; }
    .msg-resident b { color: #2563eb; }
    .msg-bubble-admin {
        background: #dcfce7;
        color: #166534;
        display: inline-block;
        padding: 8px 12px;
        border-radius: 12px 12px 0 12px;
        margin-top: 4px;
        font-size: 14px;
        text-align: left;
    }
    .msg-bubble-resident {
        background: #e0e7ff;
        color: #3730a3;
        display: inline-block;
        padding: 8px 12px;
        border-radius: 12px 12px 12px 0;
        margin-top: 4px;
        font-size: 14px;
    }
</style>

<div class="layout-wrapper">
    <!-- TABLE SECTION -->
    <div class="table-container card" style="margin-bottom: 0;">
        <table width="100%">
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Location</th>
                <th>Status</th>
                <th>Date</th>
                <th>Resident</th>
                <th>Contact</th>
                <th>Action</th>
            </tr>

            @foreach($complaints as $complaint)
            <tr class="clickable-row" onclick="showComplaint(
                '{{ $complaint['$id'] }}',
                '{{ addslashes($complaint['title']) }}',
                '{{ addslashes($complaint['description']) }}',
                '{{ addslashes($complaint['category']) }}',
                '{{ addslashes($complaint['location']) }}',
                '{{ addslashes($complaint['status']) }}',
                '{{ addslashes($complaint['resident_name']) }}',
                '{{ addslashes($complaint['resident_contact']) }}',
                '{{ addslashes($complaint['resident_address']) }}'
            )">
                <td style="font-weight:500; color:#1e293b;">{{ $complaint['title'] }}</td>
                <td style="color:#475569;">{{ $complaint['category'] }}</td>
                <td>
                    <a href="{{ $complaint['location'] }}" target="_blank" onclick="event.stopPropagation();" style="color:#2563eb; text-decoration:none; font-weight:500; font-size:13px;">
                        📍 View Map
                    </a>
                </td>
                <td>
                    @if(strtolower($complaint['status']) == 'pending')
                        <span class="status-badge" style="background:#fef3c7;color:#d97706;">{{ $complaint['status'] }}</span>
                    @elseif(strtolower($complaint['status']) == 'processing')
                        <span class="status-badge" style="background:#dbeafe;color:#2563eb;">{{ $complaint['status'] }}</span>
                    @elseif(strtolower($complaint['status']) == 'resolved')
                        <span class="status-badge" style="background:#d1fae5;color:#059669;">{{ $complaint['status'] }}</span>
                    @else
                        {{ $complaint['status'] }}
                    @endif
                </td>
                <td style="color:#64748b; font-size:13px; white-space:nowrap;">{{ $complaint['date_submitted'] }}</td>
                <td style="color:#334155;">{{ $complaint['resident_name'] }}</td>
                <td style="color:#334155; font-size:13px;">{{ $complaint['resident_contact'] }}</td>

                <td>
                    @if(strtolower($complaint['status']) != 'resolved')
                    <form method="POST" action="/admin/delete-complaint"
                        onsubmit="return confirm('Mark this complaint as resolved?')"
                        onclick="event.stopPropagation();">
                        @csrf
                        <input type="hidden" name="complaint_id" value="{{ $complaint['$id'] }}">
                        <button class="action-btn">✔ Resolve</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <!-- DETAILS SECTION -->
    <div id="complaintDetails" style="display:none;">
        
        <div class="detail-section">
            <h4>Complaint Details</h4>
            <div class="detail-row"><b>Title:</b> <span id="c_title"></span></div>
            <div class="detail-row"><b>Description:</b> <span id="c_description"></span></div>
            <div class="detail-row"><b>Category:</b> <span id="c_category"></span></div>
            <div class="detail-row"><b>Location:</b> <span id="c_location"></span></div>
            <div class="detail-row"><b>Status:</b> <span id="c_status" style="font-weight:600;"></span></div>
        </div>

        <div class="detail-section" style="margin-top: 24px;">
            <h4>Resident Information</h4>
            <div class="detail-row"><b>Name:</b> <span id="c_name"></span></div>
            <div class="detail-row"><b>Contact:</b> <span id="c_contact"></span></div>
            <div class="detail-row"><b>Address:</b> <span id="c_address"></span></div>
        </div>

        <div class="detail-section" style="margin-top: 24px;">
            <h4>Evidence</h4>
            <div id="evidenceSection">
                @foreach($evidence as $ev)
                <div class="evidenceItem" data-complaint="{{ $ev['complaint_id'] }}" style="display:none; text-align:center;">
                    <img src="https://sgp.cloud.appwrite.io/v1/storage/buckets/{{ env('APPWRITE_BUCKET_ID') }}/files/{{ $ev['image_id'] }}/view?project={{ env('APPWRITE_PROJECT_ID') }}&mode=admin"
                         style="max-width:100%; border-radius:8px; border:1px solid #e2e8f0; margin-top:10px;">
                </div>
                @endforeach
                <p id="noEvidence" style="color:#64748b; font-size:14px; font-style:italic;">No evidence uploaded.</p>
            </div>
        </div>

        <div class="detail-section" style="margin-top: 24px;">
            <h4>Update Status</h4>
            <form method="POST" action="/admin/update-status" style="display:flex; gap:10px;">
                @csrf
                <input type="hidden" name="complaint_id" id="status_complaint_id">
                <select name="status" style="flex:1;">
                    <option>Pending</option>
                    <option>Processing</option>
                    <option>Resolved</option>
                </select>
                <button type="submit" style="padding: 10px 16px;">Update</button>
            </form>
        </div>

        <div class="detail-section" style="margin-top: 32px;">
            <h4>Conversation</h4>
            <div id="messageBox"></div>

            <form id="adminMessageForm" style="margin-top: 10px;">
                @csrf
                <input type="hidden" id="message_complaint_id">
                <textarea id="adminMessageInput" required placeholder="Type a reply..." style="height:80px; resize:none; margin-bottom:10px;"></textarea>
                <button type="submit" style="width:100%;">Send Message</button>
            </form>
        </div>

    </div>
</div>

<script>
let currentComplaint = null;

function showComplaint(id,title,description,category,location,status,name,contact,address){
    currentComplaint = id;
    
    let detailsPanel = document.getElementById("complaintDetails");
    detailsPanel.style.display="block";
    detailsPanel.scrollTop = 0;
    
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

    let evidenceItems = document.querySelectorAll(".evidenceItem");
    let foundEvidence = false;
    
    evidenceItems.forEach(item => {
        if(item.dataset.complaint === id){
            item.style.display="block";
            foundEvidence = true;
        } else {
            item.style.display="none";
        }
    });
    
    document.getElementById("noEvidence").style.display = foundEvidence ? "none" : "block";
    
    loadMessages();
}

function loadMessages(){
    if(!currentComplaint) return;
    
    fetch("/admin/messages/" + currentComplaint)
    .then(res => res.json())
    .then(data => {
        let box = document.getElementById("messageBox");
        box.innerHTML = "";
        
        if(data.length === 0){
            box.innerHTML = "<p style='color:#64748b; font-size:14px; text-align:center; padding-top:20px;'>No messages yet.</p>";
            return;
        }
        
        data.forEach(msg => {
            let div = document.createElement("div");
            div.style.marginBottom = "12px";
            
            if(msg.sender_role === "admin"){
                div.innerHTML = `
                <div class="msg-admin" style="text-align:right;">
                    <b style="font-size:12px;">Admin</b><br>
                    <div class="msg-bubble-admin">${msg.message}</div>
                </div>
                `;
            } else {
                div.innerHTML = `
                <div class="msg-resident" style="text-align:left;">
                    <b style="font-size:12px;">Resident</b><br>
                    <div class="msg-bubble-resident">${msg.message}</div>
                </div>
                `;
            }
            box.appendChild(div);
        });
        
        box.scrollTop = box.scrollHeight;
    });
}

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
    }).then(() => {
        document.getElementById("adminMessageInput").value = "";
        loadMessages();
    });
});

setInterval(loadMessages, 3000);
</script>

@endsection