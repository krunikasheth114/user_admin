<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Http\Requests\DocumentRequest;
use App\Models\Document;
use App\DataTables\DocumentDataTable;
use App\Models\User;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DocumentDataTable  $datatable)
    {
        return $datatable->render('admin.document.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request)
    {
        $id = $request->user_id;
        $user = User::find($id);
        // dd($user);

        if (!empty($user->userDocument) && count($user->userDocument) > 0) {
            return  response()->json(['status' => false, 'message' => 'You can not add more than one document']);
        }

        $request->validate([
            'doc_name' => 'required|alpha',
            'doc_num' => 'required|numeric|unique:documents,doc_num',
            'document.*' => 'file|mimes:pdf|max:2048',
        ]);

        if ($request->document != '') {
            foreach ($request->document as $doc) {
                $destinationPath = 'images/';
                $imageName = date('YmdHis') . "." . $doc->getClientOriginalExtension();
                $doc->move($destinationPath, $imageName);
                Document::create([
                    'doc_name' => $request->input('doc_name'),
                    'doc_num' => $request->input('doc_num'),
                    'user_id' => $request->user_id,
                    'document' => $imageName,
                ]);
            }
        }
        return response()->json(['status' => true, 'message' => 'Document Added Successfuly']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Document::find($id);

        return response()->json(['status' => 'true', 'data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $id = $request->id;
        $request->validate([
            'doc_name' => 'required|alpha',
            'doc_num' => 'required|numeric|unique:documents,doc_num,' . $id,
            'documents' => 'file|mimes:pdf|max:2048|unique:documents,document,' . $id,
        ]);

        $data = Document::find($request->id);
        $data->doc_name = $request->input('doc_name');
        $data->doc_num = $request->input('doc_num');

        if (isset($request->documents)) {
            $document = $request->documents;
            $destinationPath = 'images/';
            if (!empty($data->document)) {
                $file_old = $destinationPath . $data->document;
                unlink($file_old);
            }
            $newdocument = date('YmdHis') . "." . $document->getClientOriginalExtension();
            $document->move($destinationPath, $newdocument);
            $data->document = $newdocument;
        }
        $data->update();
        return response()->json(['status' => 'true', 'data' => $data, 'messages' => 'document Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $data = Document::find($id);
        $data->delete();
    }
}
