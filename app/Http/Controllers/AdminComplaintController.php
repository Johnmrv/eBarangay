<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Services\AppwriteService;

class AdminComplaintController extends Controller
{

    public function index()
    {

        if(!session('admin_id')){
            return redirect('/admin/login');
        }

        $appwrite = new AppwriteService();

        $complaints = $appwrite->databases->listDocuments(
            $appwrite->databaseId(),
            'complaints'
        );

        $evidence = $appwrite->databases->listDocuments(
            $appwrite->databaseId(),
            'complaint_evidence'
        );

        $messages = $appwrite->databases->listDocuments(
            $appwrite->databaseId(),
            'messages'
        );

        return view('admin.complaints',[
            'complaints' => $complaints['documents'],
            'evidence' => $evidence['documents'],
            'messages' => $messages['documents']
        ]);
    }



    public function updateStatus(Request $request)
{

$appwrite = new AppwriteService();

$appwrite->databases->updateDocument(
$appwrite->databaseId(),
'complaints',
$request->complaint_id,
[
"status"=>$request->status
]
);

return back();

}

}