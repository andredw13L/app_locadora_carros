<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use App\Repositories\ModeloRepository;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{

    public function __construct(Modelo $modelo) {
        $this->modelo = $modelo;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ModeloRepository = new ModeloRepository ($this->modelo);


        if($request->has('atributos_marca')) {
            $atributos_marca = 'marca:id,' . $request->atributos_marca;

            $ModeloRepository->selectAtributosRegistrosRelacionados(
                $atributos_marca
            );

        } else {
            $ModeloRepository->selectAtributosRegistrosRelacionados('marca');
        }


        if($request->has('filtro')) {
            $ModeloRepository->filtro($request->filtro);
        }


        if($request->has('atributos')) {
            $ModeloRepository->selectAtributos($request->atributos);
        } 


        return response()->json($ModeloRepository->getResultado(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->modelo->rules());

        $imagem = $request->file('imagem');

        // O armazenamento pode ser configurado em:
        // config/filesystems.php
        
        $imagem_urn = $imagem->store('imagens/modelos', 'public');

        $modelo = $this->modelo->create([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);

        return response()->json($modelo, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $modelo = $this->modelo->with('marca')->find($id);

        if($modelo === null) {
            return response()->json([
                'erro' => 'Recurso pesquisado não existe'
                ],
                404
            );
        }

        return response()->json($modelo, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $modelo = $this->modelo->find($id);


        if ($modelo === null) {
            return response()->json([
            'erro' => 
            'Impossível realizar a atualização. O recurso solicitado não existe'
            ],
            404
            );
        }


        if($request->method === 'PATCH') {

            $regrasDinamicas = array();

            // Percorrendo todas as regras do Model
            foreach($modelo->rules() as $input => $regra) {

                /* Coletando apenas as regras aplicáveis
                 aos parâmetros parciais da requisição */
                if(array_key_exists($index, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
            
            $request->validate($regrasDinamicas);

        } else {

            // Validação por 'PUT'
            $request->validate($modelo->rules());
        }

        
        // Remove o arquivo antigo
        if($request->file('imagem')) {
            Storage::disk('public')->delete($modelo->imagem);
        }


        $imagem = $request->file('imagem');
        
        $imagem_urn = $imagem->store('imagens/modelos', 'public');

        // Preenchendo o objeto $modelo com os dados do request
        $modelo->fill($request->all());
        $modelo->imagem = $imagem_urn;
        
        $modelo->save();

        /*
        $modelo->update([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs
        ]);
        */


        return response()->json($modelo, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $modelo = $this->modelo->find($id);

        if ($modelo === null) {
            return response()->json([
                'erro' => 
                'Impossível realizar a exclusão. O recurso solicitado não existe'
                ],
                404
                );
        }


        // Remove o arquivo antigo
        Storage::disk('public')->delete($modelo->imagem);


        $modelo->delete();

        return response()->json([
            'msg' => 'O modelo foi removido com sucesso'
            ], 
            200
        );
    }
}
