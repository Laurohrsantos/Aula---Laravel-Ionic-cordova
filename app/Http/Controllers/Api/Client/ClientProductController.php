<?php

namespace CodeDelivery\Http\Controllers\Api\Client;


use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\ProductRepository;


class ClientProductController extends Controller
{
    
    private $repository;
    
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function index ()
    {
        return $this->repository->skipPresenter(false)->all();
    }
}
