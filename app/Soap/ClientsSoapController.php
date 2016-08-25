<?php

namespace App\Soap;

use App\Client;
use App\Types\ClientType;
use Illuminate\Contracts\Support\Arrayable;
use Zend\Config\Config;
use Zend\Config\Writer\Xml;

//use Illuminate\Database\Eloquent\ModelNotFoundException;
//use Illuminate\Http\Request;

class ClientsSoapController
{
    /**
     * @return string
     */
    public function listAll()
    {
        return $this->getXML(Client::all());
    }

    /*public function show($id)
    {
        if(!($client = Client::find($id))){
            throw new ModelNotFoundException("Client requisitado não existe");
        }
        return son_response()->make($client);
    }*/

    /**
     * @param \App\Types\ClientType $type
     * @return string
     */
    public function create(ClientType $type)
    {
        $data = [
          'name' => $type->name,
          'email' => $type->email,
          'phone' => $type->phone,
        ];
        $client = Client::create($data);
        return $this->getXML($client);
    }

    /*public function update(Request $request,$id)
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
    }*/

    protected function getXML($data)
    {
        if($data instanceof Arrayable){
            $data = $data->toArray();
        }
        $config = new Config(['result' => $data],true);
        $xmlWriter = new Xml();
        return $xmlWriter->toString($config);
    }
}
