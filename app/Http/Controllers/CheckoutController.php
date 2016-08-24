<?php

namespace CodeDelivery\Http\Controllers;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Services\OrderServices;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    
    private $repository;
    private $userRepository;
    private $productRepository;
    private $orderServices;
    
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
        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;
        $orders = $this->repository->scopeQuery(function ($query) use ($clientId){
            return $query->where('client_id', '=', $clientId);
        })->paginate();
        
        return view('customer/order/index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = $this->productRepository->listas();
        
        return view('customer/order/create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;
        
        $data['client_id'] = $clientId;
        
        $this->orderServices->create($data);
        
        return redirect()->route('customer/order/index');
    }

}
