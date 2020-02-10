<?php

namespace App\Http\Controllers;

use App\Eq\DataType;
use App\Eq\Equipment;
use App\Eq\EquipmentClass;
use App\Eq\Parameter;
use App\Eq\ParameterData;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ParameterController extends Controller
{

    function list() {

        $parameters = Parameter::all();
        if (!empty($parameters)) {
            $parameters->each(function ($parameter) {
                $parameter->equipment = EquipmentClass::find($parameter->equipment_class_id);
            });
        }

        if (!empty($parameters)) {
            $parameters->each(function ($parameter) {
                $parameter->type = DataType::find($parameter->type_id);
            });
        }

        return response()->json(
            $parameters,
            HttpResponse::HTTP_OK
        );
    }

    public function listByEq(Request $request)
    {

        $eq = $request->route('eq');
        $equipment = EquipmentClass::where('eq', $eq)->first();

        $parameters = Parameter::where('equipment_class_id', $equipment->id)->get();
        if (!empty($parameters)) {
            $parameters->each(function ($parameter) {
                $parameter->equipment = EquipmentClass::find($parameter->equipment_class_id);
            });
        }

        if (!empty($parameters)) {
            $parameters->each(function ($parameter) {
                $parameter->type = DataType::find($parameter->type_id);
            });
        }

        return response()->json(
            $parameters,
            HttpResponse::HTTP_OK
        );

    }

    public function saveParameterList(Request $request)
    {
        foreach ($request->all() as $data) {
            if ($data['id'] == '') {
                Parameter::create($data);
            } else {
                Parameter::find($data['id'])->update($data);
            }
        }
        return response()->json(
            true,
            HttpResponse::HTTP_OK
        );

    }

    public function getParameterDatasByEq($eq)
    {

        $equipment = EquipmentClass::where('eq', $eq)->first();

        $parameters = Parameter::where('equipment_class_id', $equipment->id)->get();
        $parameters_id = [];
        foreach ($parameters as $par) {
            $parameter_id[] = $par->id;
        }

        return response()->json(
            ParameterData::whereIn('par', $parameter_id)->get(),
            HttpResponse::HTTP_OK
        );
    }

    public function create(Request $request)
    {

        return response()->json(
            Parameter::create($request->all()),
            HttpResponse::HTTP_OK
        );
    }

    public function view($id)
    {

        return response()->json(
            Parameter::find($id),
            HttpResponse::HTTP_OK
        );
    }

    public function delete($id)
    {
        return response()->json(
            Parameter::find($id)->delete(),
            HttpResponse::HTTP_NO_CONTENT
        );

    }

    public function update(Request $request)
    {
        $parameter_id = $request->input('id');
        $parameter = Parameter::find($parameter_id);
        $parameter->update($request->all());

        return response()->json(
            $parameter,
            HttpResponse::HTTP_OK
        );
    }

    public function saveParameterDataList(Request $request)
    {
        foreach ($request->all() as $data) {

            if ($data['id'] == '') {
                $parameters = ParameterData::where('eq', $data['eq'])->where('par', $data['par'])->get();
                foreach ($parameters as $parameter) {
                    $parameter->delete();
                }

                ParameterData::create($data);
            } else {
                ParameterData::find($data['id'])->update($data);
            }
        }
        return response()->json(
            true,
            HttpResponse::HTTP_OK
        );

    }

    public function listData()
    {
        $datas = ParameterData::all();

        if (!empty($datas)) {
            $datas->each(function ($data) {
                $data->equipment = Equipment::find($data->eq);
            });
        }

        if (!empty($datas)) {
            $datas->each(function ($data) {
                $data->parameter = Parameter::find($data->par);
            });
        }

        return response()->json(
            $datas,
            HttpResponse::HTTP_OK
        );
    }

    public function createData(Request $request)
    {
        $eq = $request->input('eq');
        $par = $request->input('par');
        $parameters = ParameterData::where('eq', $eq)->where('par', $par)->get();
        foreach ($parameters as $parameter) {
            $parameter->delete();
        }

        return response()->json(
            ParameterData::create($request->all()),
            HttpResponse::HTTP_OK
        );
    }

    public function viewParameterData($id)
    {

        return response()->json(
            ParameterData::find($id),
            HttpResponse::HTTP_OK
        );
    }

    public function deleteData($id)
    {
        return response()->json(
            ParameterData::find($id)->delete(),
            HttpResponse::HTTP_NO_CONTENT
        );

    }

    public function updateData(Request $request)
    {
        $parameter_id = $request->input('id');
        $parameter = ParameterData::find($parameter_id);
        $parameter->update($request->all());

        return response()->json(
            $parameter,
            HttpResponse::HTTP_OK
        );
    }

    public function listDataType()
    {
        return response()->json(
            Datatype::all(),
            HttpResponse::HTTP_OK
        );
    }

    public function createDataType(Request $request)
    {

        return response()->json(
            Datatype::create($request->all()),
            HttpResponse::HTTP_OK
        );
    }

    public function viewParameterDataType($id)
    {

        return response()->json(
            Datatype::find($id),
            HttpResponse::HTTP_OK
        );
    }

    public function deleteDataType($id)
    {
        return response()->json(
            Datatype::find($id)->delete(),
            HttpResponse::HTTP_NO_CONTENT
        );

    }

    public function updateDataType(Request $request)
    {
        $data_type_id = $request->input('id');
        $data_type = Datatype::find($data_type_id);
        $data_type->update($request->all());

        return response()->json(
            $data_type,
            HttpResponse::HTTP_OK
        );
    }

}
