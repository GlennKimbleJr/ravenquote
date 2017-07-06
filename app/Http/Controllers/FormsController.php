<?php

namespace App\Http\Controllers;

use App\Form;
use App\FormField;
use App\Form\FieldTypes;
use App\Http\Requests\UserFormRequest;
use Illuminate\Http\Request;

class FormsController extends Controller
{

    /**
     * Only authenticated users for all methods except show.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('show');
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
     * @param  \App\Http\Requests\UserFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        $form = Form::create([
            'user_id' => auth()->id(),
            'type' => request('type')
        ]);

        if (! empty(request('fields'))) {
            collect(request('fields'))->each(function($field) use ($form) {
                $this->storeField($field, $form->id);
            });
        }
    }
    
    /**
     * Store a newly created resource in storage.
     * 
     * @param  array  $request
     * @param  integer $form_id
     * @return \Illuminate\Http\Response
     */
    public function storeField($request, $form_id)
    {
        FormField::create([
            'form_id' => $form_id,
            'name' => trim(strtolower($request['name'])),
            'type' => trim(strtolower($request['type'])),
            'value' => trim(strtolower($request['value'])),
            'final_value' => trim(strtolower($request['final_value'])),
            'affects' => trim(strtolower($request['affects'])),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $form = Form::published($uuid)->firstOrFail();

        return $form->name;
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
}
