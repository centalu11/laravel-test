<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends BaseController
{
    // use AuthorizesRequests, ValidatesRequests;

    public function create(Request $request)
    {
        try {
            $rules = [
                'sku' => 'required|unique:products',
                'name' => 'required',
            ];

            $validator = Validator::make($request->only(
                'sku',
                'name',
                'description'
            ), $rules);

            if ($validator->fails()) {
                $messages = $validator->messages();

                return response()
                ->json([
                    'message' => $messages,
                ], 400);
            }

            $product = new Product(
                $request->only(
                    'sku',
                    'name',
                    'description'
                )
            );

            $product->save();
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => $exception->getMessage(),
                ], 500);
        }

        return response()->noContent(Response::HTTP_CREATED);
    }

    public function list(Request $request)
    {
        $page = $request->has('page') ? $request->page : 1;
        $limit = $request->has('limit') ? $request->limit : 10;

        $offset = ($page - 1) * $limit;

        return Product::take($limit)->skip($offset)->orderBy('id')->get();
    }

    public function get(Request $request, int $id)
    {
        try {
            return Product::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()
            ->json([
                'message' => $exception->getMessage(),
            ], 404);
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => $exception->getMessage(),
                ], 500);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $rules = [
                'sku' => 'required|unique:products',
                'name' => 'required',
            ];

            $product = Product::findOrFail($id);

            $validator = Validator::make($request->only(
                'sku',
                'name',
                'description'
            ), $rules);

            if ($validator->fails()) {
                $messages = $validator->messages();

                return response()
                ->json([
                    'message' => $messages,
                ], 400);
            }

            if ($request->has('sku')) {
                $product->sku = $request->sku;
            }

            if ($request->has('name')) {
                $product->name = $request->name;
            }

            if ($request->has('description')) {
                $product->name = $request->name;
            }

            $product->save();
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => $exception->getMessage(),
                ], 400);
        }

        return response()->noContent(Response::HTTP_CREATED);
    }

    public function uploadPhoto(Request $request, Product $product)
    {
    }

    public function delete(Request $request, Product $product)
    {
    }
}
