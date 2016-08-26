<?php

namespace CodeDelivery\Http\Middleware;

use Closure;
use CodeDelivery\Repositories\UserRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class OAuthCheckRole
{
    
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        //1º ACESSO USUARIO QUE ESTA AUTENTICANDO NA NOSSA API
        //2º UTILIZAR FACADE AUTHORIZER - PEGA CONGIGURAÇÃO E DADOS DE QUEM ESTA AUTENTICADO
        //3º BUSCAR O USUARIO E VERIFICAR A ROLE E COMPARAR COM A ROLE QUE FOI PASSADA PELA ROTA

        $id = Authorizer::getResourceOwnerId();
        $user = $this->userRepository->find($id);

        if($user->role != $role)
        {
            abort(403, 'Access Forbidden');
        }
        
        return $next($request);
    }
}
