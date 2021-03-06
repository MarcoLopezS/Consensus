<?php namespace Consensus\Repositories;

use Consensus\Entities\Matter;
use Illuminate\Http\Request;

class MatterRepo extends BaseRepo {

    public function getModel()
    {
        return new Matter();
    }

    //TIPO DE MATERIA EN HOME
    public function homeMateria()
    {
        return $this->getModel()
                    ->where('estado','1')
                    ->with('expedientes','expedientes.tarea','expedientes.tarea.acciones')
                    ->get();
    }

    //EXPORTAR A EXCEL
    public function exportarExcel(Request $request)
    {
        return $this->getModel()
                    ->titulo($request->get('titulo'))
                    ->estado($request->get('estado'))
                    ->order($request->get('order'))
                    ->get();
    }
}