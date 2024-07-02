<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$marcas = Marca::all();

        $marcas = $this->marca->all();

        return response()->json($marcas, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$marca = Marca::create($request->all());


        $request->validate($this->marca->rules(), $this->marca->feedback());

        $imagem = $request->file('imagem');

        // O armazenamento pode ser configurado em:
        // config/filesystems.php
        
        $imagem_urn = $imagem->store('imagens', 'public');

        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);

        return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);

        if($marca === null) {
            return response()->json([
                'erro' => 'Recurso pesquisado não existe'
                ],
                404
            );
        }

        return response()->json($marca, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //$marca->update($request->all());

        $marca = $this->marca->find($id);


        if ($marca === null) {
            return response()->json([
            'erro' => 
            'Impossível realizar a atualização. O recurso solicitado não existe'
            ],
            404
            );
        }


        $regrasDinamicas = array();


        if($request->method === 'PATCH') {

            // Percorrendo todas as regras do Model
            foreach($marca->rules() as $input => $regra) {

                /* Coletando apenas as regras aplicáveis
                 aos parâmetros parciais da requisição */
                if(array_key_exists($index, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
            
            $request->validate($regrasDinamicas, $marca->feedback());

        } else {

            // Validação por 'PUT'
            $request->validate($marca->rules(), $marca->feedback());
        }

        
        // Remove o arquivo antigo
        if($request->file('imagem')) {
            Storage::disk('local')->delete($marca->imagem);
        }


        $imagem = $request->file('imagem');
        
        $imagem_urn = $imagem->store('imagens', 'public');


        $marca->update([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);

        return response()->json($marca, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //$marca->delete();

        $marca = $this->marca->find($id);

        if ($marca === null) {
            return response()->json([
                'erro' => 
                'Impossível realizar a exclusão. O recurso solicitado não existe'
                ],
                404
                );
        }


        Storage::disk('local')->delete($marca->imagem);


        $marca->delete();

        return response()->json([
            'msg' => 'A marca foi removida com sucesso'
            ], 
            200
        );
    }
}
