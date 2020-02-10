<?php

namespace App\Http\Controllers;

use App\Eq\Equipment;
use App\Eq\EquipmentClass;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class EquipmentController extends Controller
{

    function list() {
        $equipments = Equipment::all();

        if (!empty($equipments)) {
            $equipments->each(function ($equipment) {
                $equipment->equipment = EquipmentClass::find($equipment->equipment_class_id);
            });
        }
        return response()->json(
            $equipments,
            HttpResponse::HTTP_OK
        );
    }

    public function create(Request $request)
    {

        return response()->json(
            Equipment::create($request->all()),
            HttpResponse::HTTP_OK
        );
    }

    public function saveEquipmentList(Request $request)
    {
        foreach($request->all() as $data){
            if($data['id']==''){
                Equipment::create($data);
            }else{
                Equipment::find($data['id'])->update($data);
            }
        }
        return response()->json(
            true,
            HttpResponse::HTTP_OK
        );
        
    }

    public function view($id)
    {

        return response()->json(
            Equipment::find($id),
            HttpResponse::HTTP_OK
        );
    }

    public function listEquipmentByEqClass($eq)
    {
        
        $equipment = EquipmentClass::where('eq', $eq)->first();

        $equipments = Equipment::where('equipment_class_id', $equipment->id)->get();

        return response()->json(
            $equipments,
            HttpResponse::HTTP_OK
        );

    }

    public function delete($id)
    {
        return response()->json(
            Equipment::find($id)->delete(),
            HttpResponse::HTTP_NO_CONTENT
        );

    }

    public function update(Request $request)
    {
        $equipment_id = $request->input('id');
        $equipment = Equipment::find($equipment_id);
        $equipment->update($request->all());

        return response()->json(
            $equipment,
            HttpResponse::HTTP_OK
        );
    }

    public function listClass()
    {

        return response()->json(
            EquipmentClass::all(),
            HttpResponse::HTTP_OK
        );
    }

    public function createClass(Request $request)
    {

        return response()->json(
            EquipmentClass::create($request->all()),
            HttpResponse::HTTP_OK
        );
    }

    public function viewEquipmentClass($id)
    {

        return response()->json(
            EquipmentClass::find($id),
            HttpResponse::HTTP_OK
        );
    }

    public function deleteClass($id)
    {
        return response()->json(
            EquipmentClass::find($id)->delete(),
            HttpResponse::HTTP_NO_CONTENT
        );

    }

    public function updateClass(Request $request)
    {
        $equipment_id = $request->input('id');
        $equipment = EquipmentClass::find($equipment_id);
        $equipment->update($request->all());

        return response()->json(
            $equipment,
            HttpResponse::HTTP_OK
        );
    }

}
