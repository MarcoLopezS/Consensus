<?php namespace Consensus\Http\Requests;

use Consensus\Http\Requests\Request;
use Illuminate\Routing\Route;

class FacturacionRequest extends Request
{

    /**
     * @var Route
     */
    private $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }
    
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
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'cliente' => 'required|exists:clientes,id',
                    'expediente' => 'exists:expedientes,id',
                    'comprobante_tipo' => 'required|exists:comprobante_tipos,id',
                    'comprobante_numero' => 'required',
                    'moneda' => 'required|exists:money,id',
                    'importe' => 'required|numeric'
                ];
            }
            default:break;
        }
    }
}
