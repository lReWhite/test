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
    public function show($id,$page)
    {
        
        $itemLimit = 2;
        $allBooks = Books::where('section_id', $id)->get()->values()->all();
        $lenthSemi = count($allBooks);
        $lenth =  $lenthSemi /$itemLimit;
        $lenth = ceil($lenth);

        //  dd($lenth);
        // dd($page);
        if ($page === '1')
        {
            $allBooks = Books::where('section_id', $id)->paginate($itemLimit)->values()->all();
        }else
        {
            // $num = "3.14";
            $int = (int)$page;
            // $float = (float)$num;
            // dd($page);
            $allBooks = Books::where('section_id', $id)->skip(($int-1)*$itemLimit)->take($itemLimit)->get();
        }
        

         return response() ->json([
                 'books' => $allBooks,
                 'lenth' => $lenth
        ]);
    
    }


    // public function index($id)
    // {
    //    return Books::all();
    // }

    public function update(Request $request, $id)
    {

        $book = Books::findOrFail($id);
        $book->update($request->all());
 
        return $book;
    }


    public function store(Request $request)
    {
        $requestData = $request->all();
        
        // $path =  $request->file('image')->store($request->title.'/image');
        $patch = $request->file('image')->store('public/uploads');
        $patch = substr($patch,7);
        // dd($patch);
        // Storage::disk('public')->put('filename',$request->file('image'));

        
        // $requestData['imageSrc'] = $path;
        // dd($request->name);
        $newBook = new Books; 
        $newBook->name  =  $request->name  ?? '';
        $newBook->author  =  $request->author  ?? '';
        $newBook->publishing  =  $request->publishing  ?? '';
        $newBook->description  =  $request->description  ?? '';
        $newBook->section_id  =  $request->section_id  ?? '';
        $newBook->img_src  =  $patch ?? '';
        // dd($patch);
        // dd($newBook);
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
