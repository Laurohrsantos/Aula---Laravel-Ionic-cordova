<?php

namespace CodeDelivery\Services;

use CodeDelivery\Models\Order;
use CodeDelivery\Repositories\CupomRepository;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Dmitrovskiy\IonicPush\PushProcessor;

class OrderServices {

    private $orderRepository;
    private $cupomRepository;
    private $productRepository;
    private $pushProcessor;

    public function __construct(OrderRepository $orderRepository, CupomRepository $cupomRepository, ProductRepository $productRepository, PushProcessor $pushProcessor) {
        $this->orderRepository = $orderRepository;
        $this->cupomRepository = $cupomRepository;
        $this->productRepository = $productRepository;
        $this->pushProcessor = $pushProcessor;
    }

    public function create(array $data) {

        \DB::beginTransaction();
        try {
            
            $data['status'] = 0;
            
            if (isset($data['cupom_id'])):
                unset($data['cupom_id']);
            endif;
            
            if (isset($data['cupom_code'])):
                $cupom = $this->cupomRepository->findByField('code', $data['cupom_code'])->first();
                $data['cupom_id'] = $cupom->id;
                $cupom->used = 1;
                $cupom->save();

                unset($data['cupom_code']);
            endif;

            $items = $data['items'];
            unset($data['items']);

            $order = $this->orderRepository->create($data);
            $total = 0;

            foreach ($items as $item):
                $item['price'] = $this->productRepository->skipPresenter(true)->find($item['product_id'])->price;
                $order->items()->create($item);
                $total += $item['price'] * $item['qtd'];
            endforeach;

            $order->total = $total;
            if (isset($cupom)):
                $order->total = $total - $cupom->value;
            endif;
            $order->save();
            \DB::commit();
            return $order;
            
        } catch (\Exception $e) {
            
            \DB::rollback();
            throw $e;
        }
    }
    
    public function updateStatus ($id, $idDeliveryman, $status)
    {
        $order = $this->orderRepository->getByIdAndDeliveryman($id, $idDeliveryman);
//        if ($order instanceof Order){
        $order->status = $status;
        switch ((int)$status){
            case 1:
                if ((int)(!$order->hash)) {
                    $order->hash = md5((new \DateTime())->getTimeStamp());
                }
                $order->save();
                break;
            case 2:
                $user = $order->client->user;
                $order->save();
                $this->pushProcessor->notify([$user->device_token], [
                   'message' => "Seu pedido {$order->id} acabou de ser entregue."  
                ]);
                break;
        }        
        
        return $order;
//        }
//        return false;
    }

}
