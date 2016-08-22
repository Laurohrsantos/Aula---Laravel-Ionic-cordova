<?php

namespace CodeDelivery\Http\Controllers;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests\AdminClientRequest;
use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Services\ClientServices;

class ClientsController extends Controller
{
    
    private $repository;
    private $clientServices;    

    public function __construct(ClientRepository $repository, ClientServices $clientServices)
    {
        $this->repository = $repository;
        $this->clientServices = $clientServices;
    }
    
    public function index()
    {
        $clients = $this->repository->paginate();
        
        return view('admin/clients/index', compact('clients'));
    }
    
    public function create ()
    {
        return view('admin/clients/create');
    }
    
    public function store(AdminClientRequest $request)
    {
        $data = $request->all();
        $this->clientServices->create($data);
        
        return redirect()->route('admin/clients/index');
    }
    
    public function edit ($id)
    {
        $client = $this->repository->find($id);

        return view('admin/clients/edit', compact('client'));
    }
    
    public function update(AdminClientRequest $request, $id)
    {
        $data = $request->all();
        $this->clientServices->update($data, $id);
        
        return redirect()->route('admin/clients/index');
    }
    
    public function delet ($id)
    {
        $this->repository->delete($id);
        return redirect()->route('admin/clients/index');
    }
    
}
