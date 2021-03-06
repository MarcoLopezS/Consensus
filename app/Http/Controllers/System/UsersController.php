<?php namespace Consensus\Http\Controllers\System;

use Auth;
use Consensus\Entities\Ajuste;
use Consensus\Entities\Expediente;
use Consensus\Entities\TarifaAbogado;
use Consensus\Entities\Tariff;
use Consensus\Repositories\AjusteRepo;
use Consensus\Repositories\ClienteRepo;
use Consensus\Repositories\DistritoRepo;
use Consensus\Repositories\PaisRepo;
use Consensus\Repositories\TarifaAbogadoRepo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Consensus\Http\Controllers\Controller;

use Consensus\Entities\Abogado;
use Consensus\Repositories\AbogadoRepo;

use Consensus\Repositories\TariffRepo;

use Consensus\Http\Requests\UserRequest;

use Consensus\Entities\User;
use Consensus\Repositories\UserRepo;

use Consensus\Entities\UserProfile;
use Consensus\Repositories\UserProfileRepo;

use Consensus\Entities\UserRole;
use Consensus\Repositories\UserRoleRepo;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{
    protected $rulesPassword = [
        'password' => 'required|confirmed',
        'password_confirmation' => 'required'
    ];

    protected $ajusteRepo;
    protected $abogadoRepo;
    protected $clienteRepo;
    protected $distritoRepo;
    protected $paisRepo;
    protected $tarifaAbogadoRepo;
    protected $tariffRepo;
    protected $userRepo;
    protected $userProfileRepo;
    protected $userRoleRepo;

    /**
     * UsersController constructor.
     * @param AjusteRepo $ajusteRepo
     * @param AbogadoRepo $abogadoRepo
     * @param ClienteRepo $clienteRepo
     * @param DistritoRepo $distritoRepo
     * @param PaisRepo $paisRepo
     * @param TarifaAbogadoRepo $tarifaAbogadoRepo
     * @param TariffRepo $tariffRepo
     * @param UserRepo $userRepo
     * @param UserProfileRepo $userProfileRepo
     * @param UserRoleRepo $userRoleRepo
     * @internal param TareaRepo $tareaRepo
     */
    public function __construct(AjusteRepo $ajusteRepo,
                                AbogadoRepo $abogadoRepo,
                                ClienteRepo $clienteRepo,
                                DistritoRepo $distritoRepo,
                                PaisRepo $paisRepo,
                                TarifaAbogadoRepo $tarifaAbogadoRepo,
                                TariffRepo $tariffRepo,
                                UserRepo $userRepo,
                                UserProfileRepo $userProfileRepo,
                                UserRoleRepo $userRoleRepo)
    {
        $this->ajusteRepo = $ajusteRepo;
        $this->abogadoRepo = $abogadoRepo;
        $this->clienteRepo = $clienteRepo;
        $this->distritoRepo = $distritoRepo;
        $this->paisRepo = $paisRepo;
        $this->tarifaAbogadoRepo = $tarifaAbogadoRepo;
        $this->tariffRepo = $tariffRepo;
        $this->userRepo = $userRepo;
        $this->userProfileRepo = $userProfileRepo;
        $this->userRoleRepo = $userRoleRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rows = $this->userRepo->filterUsers($request);
        
        return view('system.users.list', compact('rows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return array
     */
    public function store(UserRequest $request)
    {
        //VARIABLES
        $nombre_completo = $request->input('nombre')." ".$request->input('apellidos');
        $inputRole = $request->input('role');
        $inputCrear = 1;
        $inputEditar = 1;
        $inputExportar = $request->input('usuario_exportar');

        if($inputRole == "admin"){
            $abog = new Abogado($request->all());
            $abog->nombre = $nombre_completo;
            $abog->abogado = 1;
            $abog->asistente = 0;
            $saveAbog = $this->abogadoRepo->create($abog, $request->all());
            $abogado = $saveAbog->id;

            $tarifas = $this->tariffRepo->all();

            foreach($tarifas as $tarifa){
                $tarAbogado = new TarifaAbogado();
                $tarAbogado->tariff_id = $tarifa->id;
                $tarAbogado->abogado_id = $abogado;
                $tarAbogado->save();
            }

            //GUARDAR USUARIO
            $user = new User($request->all());
            $user->admin = 1;
            $user->abogado_id = $abogado;
            $user->active = 1;
            $save = $this->userRepo->create($user, $request->all());

            //GUARDAR PERFIL
            $profile = new UserProfile($request->all());
            $profile->user_id = $save->id;
            $this->userProfileRepo->create($profile, $request->all());

            //GUARDAR ROL
            $rol = new UserRole($request->all());
            $rol->user_id = $save->id;
            $rol->create = $inputCrear;
            $rol->update = $inputEditar;
            $rol->exporta = $inputExportar;
            $this->userRoleRepo->create($rol, $request->all());

            //CREAR AJUSTES
            $ajustes = new Ajuste();
            $ajustes->model = Expediente::class;
            $ajustes->user_id = $save->id;
            $ajustes->contenido = '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}';
            $this->ajusteRepo->create($ajustes, $request->all());

            //GUARDAR HISTORIAL
            $this->userRepo->saveHistory($user, $request, 'create');
            $this->userProfileRepo->saveHistory($profile, $request, 'create');
            $this->userRoleRepo->saveHistory($rol, $request, 'create');
            $this->ajusteRepo->saveHistory($ajustes, $request, 'create');

        }elseif($inputRole == "abogado"){
            $abog = new Abogado($request->all());
            $abog->nombre = $nombre_completo;
            $abog->abogado = 1;
            $abog->asistente = 0;
            $saveAbog = $this->abogadoRepo->create($abog, $request->all());
            $abogado = $saveAbog->id;

            $tarifas = $this->tariffRepo->all();

            foreach($tarifas as $tarifa){
                $tarAbogado = new TarifaAbogado();
                $tarAbogado->tariff_id = $tarifa->id;
                $tarAbogado->abogado_id = $abogado;
                $tarAbogado->save();
            }

            //GUARDAR USUARIO
            $user = new User($request->all());
            $user->admin = 0;
            $user->abogado_id = $abogado;
            $user->active = 1;
            $save = $this->userRepo->create($user, $request->all());

            //GUARDAR PERFIL
            $profile = new UserProfile($request->all());
            $profile->user_id = $save->id;
            $this->userProfileRepo->create($profile, $request->all());

            //GUARDAR ROL
            $rol = new UserRole($request->all());
            $rol->user_id = $save->id;
            $rol->create = $inputCrear;
            $rol->update = $inputEditar;
            $rol->exporta = $inputExportar;
            $this->userRoleRepo->create($rol, $request->all());

            //CREAR AJUSTES
            $ajustes = new Ajuste();
            $ajustes->model = Expediente::class;
            $ajustes->user_id = $save->id;
            $ajustes->contenido = '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}';
            $this->ajusteRepo->create($ajustes, $request->all());

            //GUARDAR HISTORIAL
            $this->userRepo->saveHistory($user, $request, 'create');
            $this->userProfileRepo->saveHistory($profile, $request, 'create');
            $this->userRoleRepo->saveHistory($rol, $request, 'create');
            $this->ajusteRepo->saveHistory($ajustes, $request, 'create');

        }elseif($inputRole == "asistente"){
            $abog = new Abogado($request->all());
            $abog->nombre = $nombre_completo;
            $abog->abogado = 0;
            $abog->asistente = 1;
            $saveAbog = $this->abogadoRepo->create($abog, $request->all());
            $abogado = $saveAbog->id;

            $tarifas = $this->tariffRepo->all();

            foreach($tarifas as $tarifa){
                $tarAbogado = new TarifaAbogado();
                $tarAbogado->tariff_id = $tarifa->id;
                $tarAbogado->abogado_id = $abogado;
                $tarAbogado->save();
            }

            //GUARDAR USUARIO
            $user = new User($request->all());
            $user->asistente_id = $abogado;
            $user->active = 1;
            $save = $this->userRepo->create($user, $request->all());

            //GUARDAR PERFIL
            $profile = new UserProfile($request->all());
            $profile->user_id = $save->id;
            $this->userProfileRepo->create($profile, $request->all());

            //GUARDAR ROL
            $rol = new UserRole($request->all());
            $rol->user_id = $save->id;
            $rol->create = $inputCrear;
            $rol->update = $inputEditar;
            $rol->exporta = $inputExportar;
            $this->userRoleRepo->create($rol, $request->all());

            //CREAR AJUSTES
            $ajustes = new Ajuste();
            $ajustes->model = Expediente::class;
            $ajustes->user_id = $save->id;
            $ajustes->contenido = '{"ch-expediente":"1","ch-cliente":"1","ch-abogado":"1","ch-servicio":"1","ch-estado":"1"}';
            $this->ajusteRepo->create($ajustes, $request->all());

            //GUARDAR HISTORIAL
            $this->userRepo->saveHistory($user, $request, 'create');
            $this->userProfileRepo->saveHistory($profile, $request, 'create');
            $this->userRoleRepo->saveHistory($rol, $request, 'create');
            $this->ajusteRepo->saveHistory($ajustes, $request, 'create');

        }

        //MENSAJE
        $mensaje = 'El registro se agregó satisfactoriamente.';

        //AJAX
        return [
            'message' => $mensaje
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = $this->userRepo->findOrFail($id);
        $pais = $this->paisRepo->estadoListArray();
        $distrito = $this->distritoRepo->estadoListArray();

        if($row->abogado_id > 0){
            $tarifas = $this->tarifaAbogadoRepo->where('abogado_id', $row->abogado_id)->where('estado', 1)->get();
        }elseif($row->asistente_id > 0){
            $tarifas = $this->tarifaAbogadoRepo->where('abogado_id', $row->asistente_id)->where('estado', 1)->get();
        }else{
            $tarifas = "";
        }

        return view('system.users.edit', compact('row','tarifas','distrito','pais'));
    }

    /**
     * UPDATE DE ADMIN
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return array
     */
    public function updateAdmin(Request $request, $id)
    {
        $profile = $this->userProfileRepo->where('user_id', $id)->first();
        $this->userProfileRepo->update($profile, $request->all());

        //GUARDAR HISTORIAL
        $this->userProfileRepo->saveHistory($profile, $request, 'update');

        $mensaje = "El registro se actualizo satisfactoriamente.";

        return [
            'message' => $mensaje,
        ];
    }

    /**
     * UPDATE DE ABOGADO
     * @param Request $request
     * @param $id
     * @return array
     */
    public function updateAbogado(Request $request, $id)
    {
        //BUSCAR ID
        $row = $this->userRepo->findOrFail($id);

        //VARIABLE
        $nombre = $request->input('nombres');
        $apellidos = $request->input('apellidos');

        $profile = $this->userProfileRepo->where('user_id', $id)->first();
        $profile->nombre = $nombre;
        $profile->apellidos = $apellidos;
        $this->userProfileRepo->update($profile, $request->all());

        $abogado = $this->abogadoRepo->findOrFail($row->abogado_id);
        $abogado->nombre = $nombre." ".$apellidos;
        $this->abogadoRepo->update($abogado, $request->all());

        //GUARDAR HISTORIAL
        $this->userProfileRepo->saveHistory($profile, $request, 'update');
        $this->abogadoRepo->saveHistory($abogado, $request, 'update');

        $mensaje = "El registro se actualizo satisfactoriamente.";

        return [
            'message' => $mensaje,
        ];
    }

    /**
     * UPDATE DE ASISTENTE
     * @param Request $request
     * @param $id
     * @return array
     */
    public function updateAsistente(Request $request, $id)
    {
        //BUSCAR ID
        $row = $this->userRepo->findOrFail($id);

        //VARIABLE
        $nombre = $request->input('nombres');
        $apellidos = $request->input('apellidos');

        $profile = $this->userProfileRepo->where('user_id', $id)->first();
        $profile->nombre = $nombre;
        $profile->apellidos = $apellidos;
        $this->userProfileRepo->update($profile, $request->all());

        $abogado = $this->abogadoRepo->findOrFail($row->asistente_id);
        $abogado->nombre = $nombre." ".$apellidos;
        $this->abogadoRepo->update($abogado, $request->all());

        //GUARDAR HISTORIAL
        $this->userProfileRepo->saveHistory($profile, $request, 'update');
        $this->abogadoRepo->saveHistory($abogado, $request, 'update');

        $mensaje = "El registro se actualizo satisfactoriamente.";

        return [
            'message' => $mensaje,
        ];
    }

    /**
     * UPDATE DE CLIENTE
     * @param Request $request
     * @param $id
     * @return array
     */
    public function updateCliente(Request $request, $id)
    {
        //BUSCAR ID EN USUARIO / PROFILE / CLIENTE
        $row = $this->userRepo->findOrFail($id);
        $profile = $this->userProfileRepo->where('user_id', $id)->first();
        $cliente = $this->clienteRepo->findOrFail($row->cliente_id);

        //GUARDAR DATOS EN PERFIL DE USUARIO
        $profile->nombre = $request->input('cliente');
        $this->userProfileRepo->update($profile, $request->all());

        //GUARDAR DATOS EN CLIENTE
        $cliente->pais_id = $request->input('pais');
        $cliente->distrito_id = $request->input('distrito');
        $this->clienteRepo->update($cliente, $request->all());

        //GUARDAR HISTORIAL
        $this->clienteRepo->saveHistory($cliente, $request, 'update');

        $mensaje = "El registro se actualizo satisfactoriamente.";

        return [
            'message' => $mensaje,
        ];
    }

    /*
     * UPDATE DE TARIFAS DE ABOGADO
     * @param Request $request
     * @param $id
     * @return array
     */
    public function abogadoTarifaUpdate(Request $request, $id)
    {
        //BUSCAR ID
        $row = $this->userRepo->findOrFail($id);
        if($row->abogado_id > 0){
            $abogado = $row->abogado_id;
        }elseif($row->asistente_id > 0){
            $abogado = $row->asistente_id;
        }

        $tarifas = $this->tarifaAbogadoRepo->where('abogado_id', $abogado)->get();

        foreach($tarifas as $tarifa){
            $input = $request->input('tarifa-'.$tarifa->id);

            $tarAbog = $this->tarifaAbogadoRepo->findOrFail($tarifa->id);
            $tarAbog->valor = $input;
            $this->tarifaAbogadoRepo->update($tarAbog, $request->all());

            $this->tarifaAbogadoRepo->saveHistory($tarAbog, $request, 'update');
        }

        $mensaje = "El registro se actualizo satisfactoriamente.";

        return [
            'message' => $mensaje,
        ];
    }

    /*
     * UPLOAD DE FOTO DE ABOGADO
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function abogadoFotoUpload(Request $request, $id)
    {
        //SUBIR IMAGEN
        $archivo = $this->userRepo->UploadFile('imagenes', $request->file('file'));

        //BUSCAR USUARIO EN PROFILE
        $usuario = $this->userProfileRepo->where('user_id',$id)->first();

        //GUARDAR
        $usuario->imagen = $archivo['archivo'];
        $usuario->imagen_carpeta = $archivo['carpeta'];
        $this->userProfileRepo->update($usuario, $request->all());

        //GUARDAR HISTORIAL
        $this->userProfileRepo->saveHistory($usuario, $request, 'update');

        return $archivo;
    }

    /*
     * ELIMINAR FOTO DE ABOGADO
     * @param Request $request
     * @param $id
     * @return array
     */
    public function abogadoFotoDelete(Request $request, $id)
    {
        //BUSCAR USUARIO EN PROFILE
        $usuario = $this->userProfileRepo->where('user_id',$id)->first();

        $usuario->imagen = "";
        $usuario->imagen_carpeta = "";
        $this->userProfileRepo->update($usuario, $request->all());

        //GUARDAR HISTORIAL
        $this->userProfileRepo->saveHistory($usuario, $request, 'update');

        return [
            'estado' => true
        ];
    }

    /*
     * UPDATE DE PASSWORD
     */
    public function abogadoPassword(Request $request, $id)
    {
        //BUSCAR USUARIO EN PROFILE
        $usuario = $this->userRepo->findOrFail($id);

        //VALIDACION
        $this->validate($request, $this->rulesPassword);

        //GUARDAR
        $save = $this->userRepo->update($usuario, $request->all());

        //ENVIAR POR CORREO
        if($request->input('correo') == 1){

            //DATOS PARA EMAIL
            $data = [
                'nombres' => $usuario->profile->nombre,
                'fecha' => $this->userRepo->fechaTexto($save->updated_at),
                'clave' => $request->input('password')
            ];

            //ENVIAR DESDE
            $fromEmail = 'noreply@consensus.com';
            $fromNombre = 'Consensus';

            //ENVIAR A
            $toEmail = $usuario->profile->email;
            $toNombre = $usuario->profile->nombre;

            \Mail::send('emails.clave', $data, function($message) use ($fromNombre, $fromEmail, $toNombre, $toEmail){
                $message->to($toEmail, $toNombre);
                $message->from($fromEmail, $fromNombre);
                $message->subject('Consensus - Cambio de contraseña');
            });

            $correo = true;
        }else{
            $correo = false;
        };

        //GUARDAR HISTORIAL
        $this->userRepo->saveHistory($usuario, $request, 'update');

        return [
            'estado' => true,
            'correo' => $correo
        ];
    }

    /*
     * UPDATE DE PERMISOS
     */
    public function abogadoPermisos(Request $request, $id)
    {
        $user = $this->userRepo->findOrFail($id);
        $row = $this->userRoleRepo->where('user_id', $id)->first();

        if($user->abogado_id == 0 OR $user->abogado_id == NULL){
            $abogado = $this->abogadoRepo->findOrFail($user->asistente_id);
        }else{
            $abogado = $this->abogadoRepo->findOrFail($user->abogado_id);
        }

        //VARIABLES
        $inputRole = $request->input('role');
        $inputExportar = $request->input('usuario_exportar');

        //CONDICIONAL DE ROLE
        if($inputRole == "administrador"){
            //ACTUALIZAR ABOGADO
            $abogado->abogado = 1;
            $abogado->asistente = 0;
            $save = $this->abogadoRepo->update($abogado, $request->all());

            //ACTUALIZAR ADMIN
            $user->admin = 1;
            $user->abogado_id = $save->id;
            $user->asistente_id = 0;
            $this->userRepo->update($user, $request->all());
        }elseif($inputRole == "abogado"){
            //ACTUALIZAR ABOGADO
            $abogado->abogado = 1;
            $abogado->asistente = 0;
            $save = $this->abogadoRepo->update($abogado, $request->all());

            //ACTUALIZAR ADMIN
            $user->admin = 0;
            $user->abogado_id = $save->id;
            $user->asistente_id = 0;
            $this->userRepo->update($user, $request->all());
        }elseif($inputRole == "asistente"){
            //ACTUALIZAR ABOGADO
            $abogado->abogado = 0;
            $abogado->asistente = 1;
            $save = $this->abogadoRepo->update($abogado, $request->all());

            //ACTUALIZAR ADMIN
            $user->admin = 0;
            $user->abogado_id = 0;
            $user->asistente_id = $save->id;
            $this->userRepo->update($user, $request->all());
        }

        //UPDATE DE ROLE
        $row->exporta = $inputExportar;
        $this->userRoleRepo->update($row, $request->all());

        //GUARDAR HISTORIAL
        $this->userRoleRepo->saveHistory($row, $request, 'update');

        return [
            'estado' => true
        ];
    }


    /*
     * PERFIL DE USUARIO
     */
    public function perfil()
    {
        $user = Auth::user();

        if($user->cliente_id <> 0)
        {
            return view('system.users.perfil-cliente', compact('user'));
        }
        else if($user->abogado_id <> 0)
        {
            return view('system.users.perfil-abogado', compact('user'));
        }
        else{
            return view('system.users.perfil', compact('user'));
        }
    }

    /*
     * Cambiar Estado
     */
    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function estado($id, Request $request)
    {
        //BUSCAR ID
        $row = $this->userRepo->findOrFail($id);

        if($row->active == 0){ $estado = 1; }else{ $estado = 0; }

        $row->active = $estado;
        $this->userRepo->update($row, $request->all());

        $this->userRepo->saveHistoryEstado($row, $estado, 'update');

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

        $rows = $this->userRepo->exportarExcel($request);

        Excel::create('Consensus - Usuarios', function($excel) use($rows) {
            $excel->sheet('Usuarios', function($sheet) use($rows) {
                $sheet->loadView('excel.usuarios', ['rows' => $rows]);
            });
        })->export('xlsx');
    }
}
