<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Client;
use Illuminate\Http\Response;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\Client as ClientResource;

class ClientController extends ApiController
{
    /**
     * @return ClientCollection
     */
    public function index()
    {
        $clients = Client::all();

        return (new ClientCollection($clients))->additional(['message' => 'Clients retrieved successfully.']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return bool
     */
    public function create()
    {
        return false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return ClientResource
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = \Validator::make($input, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            $this->sendError($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $client = Client::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'password' => \Hash::make($input['password']),
        ]);

        return (new ClientResource($client))->additional(['message' => 'Client created successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return ClientResource
     */
    public function show($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return $this->sendError('Client not found.');
        }

        return (new ClientResource($client))->additional(['message' => 'Client retrieved successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return bool
     */
    public function edit($id)
    {
        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return bool
     */
    public function update(Request $request, $id)
    {
        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return ClientResource
     */
    public function destroy($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return $this->sendError('Client not found.');
        }

        $client->delete();

        return (new ClientResource($client))->additional(['message' => 'Client deleted successfully.']);
    }
}
