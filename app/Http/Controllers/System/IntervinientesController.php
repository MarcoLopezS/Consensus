<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\ExpedienteInterviniente;
use Consensus\Repositories\ExpedienteRepo;
use Consensus\Repositories\ExpedienteIntervinienteRepo;
use Consensus\Repositories\IntervenerRepo;

class IntervinientesController extends Controller {

    protected $rules = [
        'nombre' => 'required',
        'dni' => 'required|max:8',
        'email' => 'email',
        'interviniente' => 'required|exists:interveners,id'
    ];

    protected $expedienteRepo;
    protected $expedienteIntervinienteRepo;
    protected $intervenerRepo;

    public function __construct(ExpedienteRepo $expedienteRepo,
                                ExpedienteIntervinienteRepo $expedienteIntervinienteRepo,
                                IntervenerRepo $intervenerRepo)
    {
        $this->expedienteRepo = $expedienteRepo;
        $this->expedienteIntervinienteRepo = $expedienteIntervinienteRepo;
        $this->intervenerRepo = $intervenerRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($expedientes, Request $request)
    {
        $row = $this->expedienteRepo->findOrFail($expedientes);

        if($request->ajax())
        {
            return $row->expInterviniente->toJson();
        }

    }

    public function create($expedientes)
    {
        $row = $this->expedienteRepo->findOrFail($expedientes);
        $intervinientes = $this->intervenerRepo->orderBy('titulo', 'asc')->lists('titulo', 'id')->toArray();

        return view('system.expediente.interviniente.create', compact('row','intervinientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($expedientes, Request $request)
    {
        //VALIDACION
        $this->validate($request, $this->rules);

        //VARIABLES
        $interviniente = $request->input('interviniente');

        //GUARDAR DATOS
        $row = new ExpedienteInterviniente($request->all());
        $row->expediente_id = $expedientes;
        $row->intervener_id = $interviniente;
        $save = $this->expedienteIntervinienteRepo->create($row, $request->all());

        //GUARDAR HISTORIAL
        $this->expedienteIntervinienteRepo->saveHistory($row, $request, 'create');

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'id' => $save->id,
                'nombre' => $save->nombre,
                'tipo' => $save->tipo,
                'dni' => $save->dni,
                'telefono' => $save->telefono,
                'celular' => $save->celular,
                'email' => $save->email,
                'url_editar' => $save->url_editar
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($expedientes, $id)
    {
        $row = $this->expedienteRepo->findOrFail($expedientes);
        $prin = $this->expedienteIntervinienteRepo->findOrFail($id);
        $intervinientes = $this->intervenerRepo->orderBy('titulo', 'asc')->lists('titulo', 'id')->toArray();

        return view('system.expediente.interviniente.edit', compact('row','prin','intervinientes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($expedientes, $id, Request $request)
    {
        //BUSCAR ID
        $row = $this->expedienteIntervinienteRepo->findOrFail($id);

        //VALIDACION
        $this->validate($request, $this->rules);

        //VARIABLES
        $interviniente = $request->input('interviniente');

        //GUARDAR DATOS
        $row->intervener_id = $interviniente;
        $save = $this->expedienteIntervinienteRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->expedienteIntervinienteRepo->saveHistory($row, $request, 'update');

        //AJAX
        if($request->ajax())
        {
            return response()->json([
                'id' => $save->id,
                'nombre' => $save->nombre,
                'tipo' => $save->tipo,
                'dni' => $save->dni,
                'telefono' => $save->telefono,
                'celular' => $save->celular,
                'email' => $save->email,
                'url_editar' => $save->url_editar
            ]);
        }
    }

}