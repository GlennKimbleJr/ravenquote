<?php

namespace App\Http\Controllers;

use App\Form;
use App\FormField;
use App\FormSubmission;
use Illuminate\Http\Request;

class FormSubmissionController extends Controller
{
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
        return FormSubmission::whereId($id)->firstOrFail();
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
