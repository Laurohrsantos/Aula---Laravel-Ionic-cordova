<?php

namespace CodeDelivery\Http\Controllers\Api\Deliveryman;

use CodeDelivery\Events\GetLocationDeliveryMan;
use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Models\Geo;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderServices;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;


class DeliverymanCheckoutController extends Controller
{
    
    private $repository;
    private $userRepository;
    private $orderServices;
    
    private $with = ['client', 'cupom', 'items'];
    
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
        $orders = $this->repository->skipPresenter(false)->scopeQuery(function ($query) use ($id){
            return $query->where('user_deliveryman_id', '=', $id);
        })->paginate();
        
        return $orders;
    }
    
    public function show ($id)
    {
        $idDeliveryman = Authorizer::getResourceOwnerId();
        return $this->repository->skipPresenter(false)->getByIdAndDeliveryman($id, $idDeliveryman);        
    }
    
    public function updateStatus (Request $request, $id)
    {
        $idDeliveryman = Authorizer::getResourceOwnerId();
        return $this->orderServices->updateStatus($id, $idDeliveryman, $request->get('status'));
//        if($order)
//        {
//            return $this->repository->find($id);
//        }
//        abort(400, "Order não encontrado");
    }
    
    public function geo (Request $request, Geo $geo, $id)
    {
        $idDeliveryman = Authorizer::getResourceOwnerId();
        $order = $this->repository->getByIdAndDeliveryman($id,$idDeliveryman);
        $geo->lat = $request->get('lat');
        $geo->long = $request->get('long');
        event(new GetLocationDeliveryMan($geo,$order));
        return $geo;
    }

}
