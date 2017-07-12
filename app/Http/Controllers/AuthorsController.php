<?php

namespace App;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \APP\Author;
use App\Http\Requests\StoreAuthorRequest;

class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //$authors = \App\Author::all();
      $authors = \App\Author::paginate(5);
      return view('authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAuthorRequest $request)
    {
      \App\Author::create($request->all());
      return redirect()->route('authors.index')->with(['message' => 'Author added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $author = \App\Author::findOrFail($id);
      return view('authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAuthorRequest $request, $id)
    {
      $author = \App\Author::findOrFail($id);
      $author->update($request->all());
      return redirect()->route('authors.index')->with(['message' => 'Author updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $author = \App\Author::findOrFail($id);
      $author->delete();
      return redirect()->route('authors.index')->with(['message' => 'Author deleted successfully']);
    }

    public function massDestroy(Request $request)
    {
        $authors = explode(',', $request->input('ids'));
        foreach ($authors as $author_id) {
            $author = \App\Author::findOrFail($author_id);
            $author->delete();
        }
        return redirect()->route('authors.index')->with(['message' => 'Authors deleted successfully']);
    }
}
