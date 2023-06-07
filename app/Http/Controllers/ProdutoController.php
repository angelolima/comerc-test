<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Produto;
use Symfony\Component\HttpFoundation\Response as ResponseRequest;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{

    /**
     *
     * Exibe os últimos registro com paginação.
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        try {
            $produtos = Produto::all();
            return response()->json($produtos, ResponseRequest::HTTP_OK);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => $exception,
            ],
            ResponseRequest::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Adiciona o registro.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nome' => 'required',
            'preco' => 'required',
            'foto' => 'required',
        ]);

        try {

            $itemProduto = Produto::create($request->all());

            if($request->hasFile('foto')){
                $file = $request->file('foto');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $location = public_path('/images');
                $file->move($location, $filename);
                $oldImage = $itemProduto->foto;
                Storage::delete($oldImage);
                $itemProduto->foto = $filename;
            }
            $itemProduto->save();
            return response()->json($itemProduto,
            ResponseRequest::HTTP_CREATED);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => $exception,
                'data' => $request->all(),
            ],
            ResponseRequest::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Exibe um registro específico com ID
     *
     * @param  \App\Models\Produto  $Produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $Produto): JsonResponse
    {
        try {
            $produto = Produto::findOrFail($Produto);
            return response()->json($produto, ResponseRequest::HTTP_CREATED);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => $exception,
            ],
            ResponseRequest::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * Atualiza um produto especifico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produto  $Produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produto $Produto)
    {
        $request->validate([
            'nome' => 'required',
            'preco' => 'required',
            'foto' => 'required',
        ]);

        try {

            if($request->hasFile('foto')){
                $file = $request->file('foto');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $location = public_path('/images');
                $file->move($location, $filename);
                $oldImage = $Produto->foto;
                Storage::delete($oldImage);
                $Produto->foto = $filename;
            }
            $Produto->save();
            $Produto->update($request->all());
            return response()->json($Produto, ResponseRequest::HTTP_CREATED);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => $exception,
            ],
            ResponseRequest::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove um item especifico da Produto.
     *
     * @param  \App\Models\Produto  $Produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $Produto)
    {
        try {
            $Produto->delete();
            return response()->json($Produto, ResponseRequest::HTTP_CREATED);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => $exception,
            ],
            ResponseRequest::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
