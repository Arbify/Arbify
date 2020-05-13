<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLanguage;
use App\Language;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $languages = Language::paginate(30);

        return view('languages.index', [
            'languages' => $languages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('languages.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLanguage $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLanguage $request)
    {
        if (!$request->validated()) {
            return redirect('languages.create')
                ->withErrors($request)
                ->withInput();
        }

        $language = new Language();
        $language->code = $request->code;
        $language->name = $request->name;
        $language->flag = $request->flag;
        $language->save();

        return redirect()->route('languages.index')
            ->with('success', "Added <b>$language->code</b> successfully.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        return view('languages.form', [
            'language' => $language,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreLanguage $request
     * @param  \App\Language $language
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLanguage $request, Language $language)
    {
        if (!$request->validated()) {
            return redirect('languages.edit')
                ->withErrors($request)
                ->withInput();
        }

        $language->code = $request->code;
        $language->name = $request->name;
        $language->flag = $request->flag;
        $language->save();

        return redirect()->route('languages.index')
            ->with('success', "Updated <b>$language->code</b> successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        $language->delete();

        return redirect()->route('languages.index')
            ->with('success', "Deleted <b>$language->code</b> successfully.");
    }
}
