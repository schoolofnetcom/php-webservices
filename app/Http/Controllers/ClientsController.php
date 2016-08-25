<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index()
    {
        return son_response()->make(Client::all());
    }

    public function show($id)
    {
        if(!($client = Client::find($id))){
            throw new ModelNotFoundException("Client requisitado não existe");
        }
        return son_response()->make($client);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $client = Client::create($request->all());
        return son_response()->make($client,201);
    }

    public function update(Request $request,$id)
    {
        if(!($client = Client::find($id))){
            throw new ModelNotFoundException("Client requisitado não existe");
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $client->fill($request->all());
        $client->save();
        return son_response()->make($client,200);
    }

    public function destroy($id)
    {
        if(!($client = Client::find($id))){
            throw new ModelNotFoundException("Client requisitado não existe");
        }
        $client->delete();
        return son_response()->make("",204);
    }
}
