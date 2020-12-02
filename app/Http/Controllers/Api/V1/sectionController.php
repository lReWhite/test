<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;

class sectionController extends Controller
{
    public function index()
    {
        return Section::all();
    }
 
    public function show($id)
    {
        return Section::findOrFail($id);
    }
 
    public function update(Request $request)
    {   
        // dd($request);
        $section = Section::findOrFail($request->id);
        $section->update($request->all());
        return $section;
    }
 
    public function store(Request $request)
    {
        $section = Section::create($request->all());
        return $section;
    }
 
    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();
        return '';
    }
}
