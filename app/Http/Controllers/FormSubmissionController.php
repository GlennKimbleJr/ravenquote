<?php

namespace App\Http\Controllers;

use App\Form;
use App\FormField;
use App\FormSubmission;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FormSubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'form_owner'])->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, $uuid)
    {
        $form = Form::published($uuid)->firstOrFail(['id']);

        $request = $this->getValidFormFieldsFromRequest($form->id, $request);

        $submission = FormSubmission::create([
            'form_id' => $form->id,
            'data' => json_encode($request)
        ]);

        return redirect("/submissions/{$submission->id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $submission = FormSubmission::whereId($id)->firstOrFail();

        if ($submission->read_at === NULL) {
            $submission->read_at = Carbon::now();
            $submission->save();
        }

        return $submission;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Return only the request attributes that are related to a valid form_field name.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param integer $form_id
     * @return array
     */
    protected function getValidFormFieldsFromRequest($form_id, $request)
    {
        $validFormFields = array_map(function ($field) {
            return strtolower($field['name']);
        }, FormField::whereFormId($form_id)->get()->toArray());

        $validFields = [];
        foreach ($validFormFields as $key) {
            if ($request->$key) $validFields[$key] = $request->$key;
        }

        return $validFields;
    }
}
