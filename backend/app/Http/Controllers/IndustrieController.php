<?php

namespace App\Http\Controllers;

use App\Eq\Industrie;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class IndustrieController extends Controller
{

    function list() {

        return response()->json(
            Industrie::all(),
            HttpResponse::HTTP_OK
        );
    }

    public function create(Request $request)
    {

        return response()->json(
            Industrie::create($request->all()),
            HttpResponse::HTTP_OK
        );
    }

    public function getIndustrie($id)
    {

        return response()->json(
            Industrie::find($id),
            HttpResponse::HTTP_OK
        );
    }

    public function delete($id)
    {
        return response()->json(
            Industrie::find($id)->delete(),
            HttpResponse::HTTP_NO_CONTENT
        );

    }

    public function update(Request $request)
    {
        $industrie_id = $request->input('id');
        $industrie = Industrie::find($industrie_id);
        $industrie->update($request->all());

        return response()->json(
            $industrie,
            HttpResponse::HTTP_OK
        );
    }

}
