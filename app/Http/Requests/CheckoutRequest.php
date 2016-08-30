<?php

namespace CodeDelivery\Http\Requests;

//UTLIZANDO HttpRequet - Para não dar conflito
use Illuminate\Http\Request as HttpRequest;

class CheckoutRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *  //Se exixstir o cupom code e se ele ja foi utilizado
     * @return array
     */

    public function rules(HttpRequest $request)
    {
        $rules =  [
            'cupom_code' => 'exists:cupoms,code,used,0'
        ];

        $this->buildRulesItems(0,$rules);
        //VERIFICA SE TEM O ITEMS
        $items = $request->get('items', []);
        //FORÇAR SER O ARRAY
        $items = !is_array($items)?[]:$items;
        //VARREDURA DAS REGRAS
        foreach ($items as $key => $val)
        {
            $this->buildRulesItems($key, $rules);
        }

        return $rules;
    }

    /**
     * @param $key
     * @param array $rules
     * Criando validação, personalizada para o array
     * Pega cada item e adiciona o require
     */
    public function buildRulesItems($key, array &$rules)
    {
        $rules["items.$key.product_id"]    = 'required';
        $rules["items.$key.qtd"]           = 'required';
    }

}
