<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Services\OrderServices;
use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use CodeDelivery\Http\Requests\CheckoutRequest;


class ClientCheckoutController extends Controller
{
    
    private $repository;
    private $userRepository;
    private $productRepository;
    private $orderServices;
    
    private $with = ['client', 'cupom', 'items'];


    public function __construct(OrderRepository $repository, 
                                UserRepository $userRepository,
                                ProductRepository $productRepository,
                                OrderServices $orderServices)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->orderServices = $orderServices;
    }
    
    public function index ()
    {
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        $orders = $this->repository->skipPresenter(false)->with($this->with)->with('items')->scopeQuery(function ($query) use ($clientId){
            return $query->where('client_id', '=', $clientId);
        })->paginate();
        
        return $orders;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutRequest $request)
    {
        $data = $request->all();
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        
        $data['client_id'] = $clientId;
        
        $o = $this->orderServices->create($data);
        //$o = $this->repository->with('items')->find($id);
        return $this->repository->skipPresenter(false)->with($this->with)->find($id);
       
    }
    
    public function show ($id)
    {
        /*
         * NAO PRECISOU MAIS USAR ESSA QUERY POR CAUSA DO MODEL FRACTAL
        $order = $this->repository->with('client','cupom', 'items')->find($id);        
         * $order->items->each(function($item){
            $item->product;        
        });*/
        return $this->repository->skipPresenter(false)->with($this->with)->find($id);
    }
    
    
    public function authenticated ()
    {
        return 'olá';
    }
    
}
