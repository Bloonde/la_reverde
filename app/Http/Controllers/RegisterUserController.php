<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RegisterUser;
use Illuminate\Support\Facades\Cache;
use Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\RegisterFormRequest;

class RegisterUserController extends Controller {

    public function __construct() {
        $this->middleware('auth.basic', ['only' => ['store', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        // return response()->json(['status' => 'ok', 'data' => RegisterUser::all()], 200);
        // Activamos la caché de los resultados.
        //  Cache::remember('tabla', $minutes, function()
       /* $registerUser = Cache::remember('registerUser', 20 / 60, function() {
                    // Caché válida durante 20 segundos.
                    return RegisterUser::all();
                });

        // Con caché.
        return response()->json(['status' => 'ok', 'data' => $registerUser], 200);*/
        
        
        $name = $request->has('name');
        $surname = $request->has('surname');
        $address = $request->has('address');
        $city = $request->has('city');
        $cp = $request->has('cp');
        $telephone = $request->has('telephone');
        $email = $request->has('email');
        
        $registerUser = DB::table('register_users');
        
        /*if($name){
            $registerUser->where('name','LIKE','%'.$request->get('name').'%');
        }
        if($surname){
            $registerUser->where('surname','LIKE','%'.$request->get('surname').'%');
        }
        if($address){
            $registerUser->where('address','LIKE','%'.$request->get('address').'%');
        }
        if($city){
            $registerUser->where('city','LIKE','%'.$request->get('city').'%');
        }
        if($cp){
            $registerUser->where('cp','LIKE','%'.$request->get('cp').'%');
        }
        if($telephone){
            $registerUser->where('telephone','LIKE','%'.$request->get('telephone').'%');
        }
        if($email){
            $registerUser->where('email','LIKE','%'.$request->get('email').'%');
        }*/
        
        $arrayFields = ['name','surname','address','city','cp','telephone','email'];
        for($i=0;$i<count($arrayFields);$i++){
            if('$'.$arrayFields[$i]){
                $registerUser->where($arrayFields[$i],'LIKE','%'.$request->get($arrayFields[$i]).'%');
            }
        }
        
        return response()->json(['status' => 'ok '.$request->get('city'), 'data' => $registerUser->get()], 200);

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(RegisterFormRequest $request) {
        
// Primero comprobaremos si estamos recibiendo todos los campos

        if (!$request->input('name') || !$request->input('surname') || !$request->input('address') || !$request->input('city') || !$request->input('cp') || !$request->input('telephone') || !$request->input('email')) {

            return response()->json(['errors' => array(['code' => 422, 'message' => 'Faltan datos necesarios para el proceso de alta.'])], 422);
        }

        $nuevoUser = RegisterUser::create($request->all());
        $data = ['data' => $nuevoUser];
        $location = 'http://localhost/la_reverde/public/api/v1.0/registerUser/' . $nuevoUser->id;
        $response = Response::make(json_encode($data), 201)->header('Location', $location)->header('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $registerUser = RegisterUser::find($id);
        if (!$registerUser) {
            return response()->json(['errors' => array('code' => 404, 'message' => 'No hay ningún usuario con esa ID')]);
        }
        return response()->json(['status' => 'ok', 'data' => $registerUser], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(RegisterFormRequest $request, $id) {

        $registerUser = RegisterUser::find($id);


        if (!$registerUser) {
            return response()->json(['errors' => array(['code' => 404, 'message' => 'No se encuentra un usuario con ese código.'])], 404);
        }

        // Listado de campos recibidos teóricamente.
        $name = $request->input('name');
        $surname = $request->input('surname');
        $address = $request->input('address');
        $city = $request->input('city');
        $cp = $request->input('cp');
        $telephone = $request->input('telephone');
        $email = $request->input('email');

        // Necesitamos detectar si estamos recibiendo una petición PUT o PATCH.
        if ($request->method() === 'PATCH') {
            // Creamos una bandera para controlar si se ha modificado algún dato en el método PATCH.
            $bandera = false;

            // Actualización parcial de campos.
            if ($name) {
                $registerUser->name = $name;
                $bandera = true;
            }

            if ($surname) {
                $registerUser->surname = $surname;
                $bandera = true;
            }


            if ($address) {
                $registerUser->address = $address;
                $bandera = true;
            }


            if ($city) {
                $registerUser->city = $city;
                $bandera = true;
            }


            if ($cp) {
                $registerUser->cp = $cp;
                $bandera = true;
            }


            if ($telephone) {
                $registerUser->telephone = $telephone;
                $bandera = true;
            }


            if ($email) {
                $registerUser->email = $email;
                $bandera = true;
            }

            if ($bandera) {
                // Almacenamos en la base de datos el registro.
                $registerUser->save();
                return response()->json(['status' => 'ok', 'data' => $registerUser], 200);
            } else {
                return response()->json(['errors' => array(['code' => 304, 'message' => 'No se ha modificado ningún dato de usuario.'])], 304);
            }
        }


        // Si el método no es PATCH entonces es PUT y tendremos que actualizar todos los datos.
        if (!$name || !$surname || !$address || !$city || !$cp || !$telephone || !$email) {
            return response()->json(['errors' => array(['code' => 422, 'message' => "Faltan valores para completar el procesamiento."])], 422);
        }

        $registerUser->name = $name;
        $registerUser->surname = $surname;
        $registerUser->address = $address;
        $registerUser->city = $city;
        $registerUser->cp = $cp;
        $registerUser->telephone = $telephone;
        $registerUser->email = $email;


        // Almacenamos en la base de datos el registro.
        $registerUser->save();
        return response()->json(['status' => 'ok', 'data' => $registerUser], 200);
    }

    public function destroy($id) {
        $registerUser = RegisterUser::find($id);

        if (!$registerUser) {
            return response()->json(['errors' => array(['code' => 404, 'message' => 'No se encuentra un usuario con ese código.'])], 404);
        }


        $registerUser->delete();

        return response()->json(['code' => 204, 'message' => 'Se ha eliminado el fabricante correctamente.'], 204);
    }

}

?>