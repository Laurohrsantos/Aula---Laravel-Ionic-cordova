 <?php

namespace CodeDelivery\Transformers;

use CodeDelivery\Models\User;
use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\Deliveryman;



class DeliverymanTransformer extends TransformerAbstract
{

    public function transform(User $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'         => $model->name,
            'email'         => $model->email,
        ];
    }
}