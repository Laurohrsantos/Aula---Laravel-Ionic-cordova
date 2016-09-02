<?php

namespace CodeDelivery\Transformers;

use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\Product;


/**
 * Class ProductTransformer
 * @package namespace CodeDelivery\Transformers;
 */
class ProductTransformer extends TransformerAbstract
{


    public function transform(Product $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'         => $model->name,
            'price'         => $model->price,
            'description'         => $model->description,
        ];
    }
    
}