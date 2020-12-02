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
        $user = response()->json(auth()->user())->getData();
        $itemLimit = 2;
        // if($user->role === 'user'){
            // $allBooks = Books::where('section_id', $id)->where('user_id',$user->id)->get()->values()->all();
        // }elseif($user->role === 'admin'){
            $allBooks = Books::where('section_id', $id)->get()->values()->all();
        // }
        
        $lenthSemi = count($allBooks);
        $lenth =  $lenthSemi /$itemLimit;
        $lenth = ceil($lenth);

        // if($user->role === 'user'){
        // if ($page === '1')
        // {
        //     $allBooks = Books::where('section_id', $id)->where('user_id',$user->id)->paginate($itemLimit)->values()->all();
        // }else
        // {
        //     $int = (int)$page;
        //     $allBooks = Books::where('section_id', $id)->where('user_id',$user->id)->skip(($int-1)*$itemLimit)->take($itemLimit)->get();
        // }
        // }elseif($user->role === 'admin'){

            if ($page === '1')
            {
                $allBooks = Books::where('section_id', $id)->paginate($itemLimit)->values()->all();
            }else
            {
                $int = (int)$page;
                $allBooks = Books::where('section_id', $id)->skip(($int-1)*$itemLimit)->take($itemLimit)->get();
            }

        // }


         return response() ->json([
                 'books' => $allBooks,
                 'lenth' => $lenth
        ]);
    
    }


    public function byId($id)
    {
        return Books::findOrFail($id);
    }

    public function update(Request $request)
    {

        $book = Books::findOrFail($request->id);
        $book->update($request->all());
 
        return $book;
    }


    public function store(Request $request)
    {
        $requestData = $request->all();
        $patch = $request->file('image')->store('public/uploads');
        $patch = substr($patch,7);
        $newBook = new Books; 
        $newBook->name  =  $request->name  ?? '';
        $newBook->author  =  $request->author  ?? '';
        $newBook->publishing  =  $request->publishing  ?? '';
        $newBook->description  =  $request->description  ?? '';
        $newBook->section_id  =  $request->section_id  ?? '';
        $newBook->img_src  =  $patch ?? '';
        $newBook->user_id  =  $request->user_id ?? '';
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
