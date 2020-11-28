<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Books;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class booksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Books::all();
    }

    public function show($id)
    {
        return Books::findOrFail($id);
    }

    public function update(Request $request, $id)
    {

        $book = Books::findOrFail($id);
        $book->update($request->all());
 
        return $book;
    }

    public function store(Request $request)
    {
        $requestData = $request->all();
        
        $path =  $request->file('image')->store($request->title.'/image');
        // $requestData['imageSrc'] = $path;
        // dd($request->name);
        $newBook = new Books; 
        $newBook->name  =  $request->name  ?? '';
        $newBook->author  =  $request->author  ?? '';
        $newBook->publishing  =  $request->publishing  ?? '';
        $newBook->description  =  $request->description  ?? '';
        $newBook->img_src  =  $path ?? '';
        $newBook->save();
        return $newBook;
    }
 
    public function destroy($id)
    {
        $book = Books::findOrFail($id);
        $book->delete();
        return 'Книга удалена';
    }

}
