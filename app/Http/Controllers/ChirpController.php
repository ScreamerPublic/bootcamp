<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('chirps.index',[
            // 'chirps' => Chirp::orderBy('created_at','desc')->get(),
            // precargar las consulta para evitar consultas N+1 problema with('user')->
            'chirps' => Chirp::with('user')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'message' => ['required','min:3','max:255']
        ]);

        //
        $message = $request->get('message');

        // insert into database
        // auth()->user()->chirps()->create([ hace lo mismo
        // $request->user()->chirps()->create([
        //     'message' => $message,
        // ]); hace lo mismo
        $request->user()->chirps()->create($validate);

        // session()->flash('status','Chirp created succesfully!'); // hace los mismo
        return to_route('chirps.index')->with('status',__('Chirp created succesfully!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Chirp $chirp)
    // se quita Chirp para que solo reciba el id seleccionado
    public function edit(Chirp $chirp)
    {
        //
        return view('chirps.edit',['chirp'=>$chirp]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        //
        $validate = $request->validate([
            'message' => ['required','min:3','max:255']
        ]);

        $chirp->update($validate);

        return to_route('chirps.index')->with('status',__('Chirp updated succesfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        //
    }
}
