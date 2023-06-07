<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseRequest;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Pedido;

class PedidoController extends Controller
{

    /**
     *
     * Exibe os últimos registro com paginação.
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        try {
            $Pedidos = Pedido::with(['cliente'])->findOrFail(1);
            return response()->json($Pedidos, ResponseRequest::HTTP_OK);
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
            'cliente_id' => 'required',
            'produto_id' => 'required',
        ]);

        try {

            $itemPedido = Pedido::create($request->all());
            return response()->json($itemPedido, ResponseRequest::HTTP_CREATED);
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
     * @param  \App\Models\Pedido  $Pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $Pedido): JsonResponse
    {
        try {
            $Pedido = Pedido::findOrFail($Pedido);
            return response()->json($Pedido, ResponseRequest::HTTP_CREATED);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => $exception,
            ],
            ResponseRequest::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * Atualiza um Pedido especifico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pedido  $Pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $Pedido)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required',
            'dataNascimento' => 'required',
        ]);

        try {

            $Pedido->update($request->all());
            return response()->json($Pedido, ResponseRequest::HTTP_CREATED);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => $exception,
            ],
            ResponseRequest::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove um item especifico da Pedido.
     *
     * @param  \App\Models\Pedido  $Pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido $Pedido)
    {
        try {
            $Pedido->delete();
            return response()->json($Pedido, ResponseRequest::HTTP_CREATED);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => $exception,
            ],
            ResponseRequest::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
