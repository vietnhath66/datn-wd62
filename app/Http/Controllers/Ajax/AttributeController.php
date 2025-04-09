<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AttributeReponsitoryInterface  as AttributeRepository;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    protected $attributeRepository;

    public function __construct(
        AttributeRepository $attributeRepository
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale(); // vn en cn
            return $next($request);
        });
    }

    public function getAttribute(Request $request)
    {
        $payload = $request->input();

        $attributes = $this->attributeRepository->searchAttributes($payload['search'], $payload['option']);

        $attributeMapped = $attributes->map(function ($attribute) {
            return [
                'id' => $attribute->id,
                'text' => $attribute->name,
            ];
        })->all();

        return response()->json(array('items' => $attributeMapped));
    }

    public function loadAttribute(Request $request)
    {
        // dd($request);
        $payload['attribute'] = json_decode(base64_decode($request->input('attribute')), TRUE);
        // dd($payload);
        $payload['attributeCatalogueId'] = $request->input('attributeCatalogueId');
        $attributeArray = $payload['attribute'][$payload['attributeCatalogueId']];
        $attributes = [];
        // dd(123);
        if (count($attributeArray)) {
            $attributes = $this->attributeRepository->findAttributeByIdArray($attributeArray);
        }
        $temp = [];
        if (count($attributes)) {
            foreach ($attributes as $key => $val) {
                $temp[] = [
                    'id' => $val->id,
                    'text' => $val->name
                ];
            }
        }
        return response()->json(array('items' => $temp));
    }
}
