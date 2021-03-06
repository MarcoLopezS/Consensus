<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Http\Requests\MatterRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Matter;
use Consensus\Repositories\MatterRepo;
use Maatwebsite\Excel\Facades\Excel;

class MatterController extends Controller {

    protected $matterRepo;

    /**
     * MatterController constructor.
     * @param MatterRepo $matterRepo
     */
    public function __construct(MatterRepo $matterRepo)
    {
        $this->matterRepo = $matterRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->matterRepo->findOrder($request);

        return view('system.matter.list', compact('rows'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create');

        return view('system.matter.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MatterRequest|Request $request
     * @return Response
     */
    public function store(MatterRequest $request)
    {
        $this->authorize('create');

        //GUARDAR DATOS
        $row = new Matter($request->all());
        $row->estado = 1;
        $this->matterRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->matterRepo->saveHistory($row, $request, 'create');

        //MENSAJE
        $mensaje = 'El registro se agregó satisfactoriamente.';

        //AJAX
        return [
            'message' => $mensaje
        ];
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $row = $this->matterRepo->findOrFail($id);

        return view('system.matter.show', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return Response
     */
    public function edit($id, Request $request)
    {
        $this->authorize('update');

        $row = $this->matterRepo->findOrFail($id);

        return view('system.matter.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MatterRequest|Request $request
     * @param  int $id
     * @return Response
     */
    public function update(MatterRequest $request, $id)
    {
        $this->authorize('update');

        //BUSCAR ID
        $row = $this->matterRepo->findOrFail($id);

        //GUARDAR DATOS
        $this->matterRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->matterRepo->saveHistory($row, $request, 'update');

        //MENSAJE
        $mensaje = 'El registro se actualizó satisfactoriamente.';

        //AJAX
        return [
            'message' => $mensaje
        ];
    }


    /*
     * Cambiar Estado
     */
    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function estado($id, Request $request)
    {
        //BUSCAR ID
        $row = $this->matterRepo->findOrFail($id);

        if($row->estado == 0){ $estado = 1; }else{ $estado = 0; }

        $row->estado = $estado;
        $this->matterRepo->update($row, $request->all());

        $this->matterRepo->saveHistoryEstado($row, $estado, 'update');

        $message = 'El registro se modificó satisfactoriamente.';

        return [
            'message' => $message,
            'estado'  => $estado
        ];
    }

    /**
     * @param Request $request
     */
    public function excel(Request $request)
    {
        //PERMISO PARA EXPORTAR
        $this->authorize('exportar');

        $rows = $this->matterRepo->exportarExcel($request);

        Excel::create('Consensus - Materias', function($excel) use($rows) {
            $excel->sheet('Materias', function($sheet) use($rows) {
                $sheet->loadView('excel.default', ['rows' => $rows]);
            });
        })->export('xlsx');
    }
}
