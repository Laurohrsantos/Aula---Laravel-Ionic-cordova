<?php

namespace CodeDelivery\Http\Controllers\Api\Deliveryman;

use Illuminate\Http\Request;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Services\OrderServices;
use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use CodeDelivery\Http\Requests\CheckoutRequest;


class DeliverymanCheckoutController extends Controller
{
    
    private $repository;
    private $userRepository;
    private $orderServices;
    
    public function __construct(OrderRepository $repository, 
                                UserRepository $userRepository,
                                OrderServices $orderServices)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->orderServices = $orderServices;
    }
    
    public function index ()
    {
        $id = Authorizer::getResourceOwnerId();
        $orders = $this->repository->with('items')->scopeQuery(function ($query) use ($id){
            return $query->where('user_deliveryman_id', '=', $id);
        })->paginate();
        
        return $orders;
    }
    
    public function show ($id)
    {
        $idDeliveryman = Authorizer::getResourceOwnerId();
        return $this->repository->getByIdAndDeliveryman($id, $idDeliveryman);        
    }
    
    public function updateStatus (Request $request, $id)
    {
        $idDeliveryman = Authorizer::getResourceOwnerId();
        $order = $this->orderServices->updateStatus($id, $idDeliveryman, $request->get('status'));
        if($order)
        {
            return $order;
        }
        abort(400, "Order não encontrado");
    }

}
