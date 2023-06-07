<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Cliente;
use Symfony\Component\HttpFoundation\Response as ResponseRequest;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    /**
     *
     * Exibe os últimos registro com paginação.
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        try {
            $Clientes = Cliente::all();
            return response()->json($Clientes, ResponseRequest::HTTP_OK);
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
            'email' => 'required',
            'dataNascimento' => 'required',
        ]);

        try {

            $itemCliente = Cliente::create($request->all());
            return response()->json($itemCliente, ResponseRequest::HTTP_CREATED);
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
     * @param  \App\Models\Cliente  $Cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $Cliente): JsonResponse
    {
        try {
            $Cliente = Cliente::findOrFail($Cliente);
            return response()->json($Cliente, ResponseRequest::HTTP_CREATED);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => $exception,
            ],
            ResponseRequest::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * Atualiza um Cliente especifico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $Cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $Cliente)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required',
            'dataNascimento' => 'required',
        ]);

        try {

            $Cliente->update($request->all());
            return response()->json($Cliente, ResponseRequest::HTTP_CREATED);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => $exception,
            ],
            ResponseRequest::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove um item especifico da Cliente.
     *
     * @param  \App\Models\Cliente  $Cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $Cliente)
    {
        try {
            $Cliente->delete();
            return response()->json($Cliente, ResponseRequest::HTTP_CREATED);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'msg' => $exception,
            ],
            ResponseRequest::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
