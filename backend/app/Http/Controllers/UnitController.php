<?php

namespace App\Http\Controllers;

use App\Eq\Unit;
use App\Eq\UnitType;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class UnitController extends Controller
{

    function list() {
        $units = Unit::all();

        if (!empty($units)) {
            $units->each(function ($unit) {
                $unit->type_name = UnitType::find($unit->type)->name;
            });
        }

        return response()->json(
            $units,
            HttpResponse::HTTP_OK
        );
    }

    public function create(Request $request)
    {

        return response()->json(
            Unit::create($request->all()),
            HttpResponse::HTTP_OK
        );
    }

    public function view($id)
    {

        return response()->json(
            Unit::find($id),
            HttpResponse::HTTP_OK
        );
    }

    public function delete($id)
    {
        return response()->json(
            Unit::find($id)->delete(),
            HttpResponse::HTTP_NO_CONTENT
        );

    }

    public function update(Request $request)
    {
        $unit_id = $request->input('id');
        $unit = Unit::find($unit_id);
        $unit->update($request->all());

        return response()->json(
            $unit,
            HttpResponse::HTTP_OK
        );
    }


    function listType() {

        return response()->json(
            UnitType::all(),
            HttpResponse::HTTP_OK
        );
    }

    public function createType(Request $request)
    {

        return response()->json(
            UnitType::create($request->all()),
            HttpResponse::HTTP_OK
        );
    }

    public function viewType($id)
    {

        return response()->json(
            UnitType::find($id),
            HttpResponse::HTTP_OK
        );
    }

    public function deleteType($id)
    {
        return response()->json(
            UnitType::find($id)->delete(),
            HttpResponse::HTTP_NO_CONTENT
        );

    }

    public function updateType(Request $request)
    {
        $unit_id = $request->input('id');
        $unit = UnitType::find($unit_id);
        $unit->update($request->all());

        return response()->json(
            $unit,
            HttpResponse::HTTP_OK
        );
    }

}
