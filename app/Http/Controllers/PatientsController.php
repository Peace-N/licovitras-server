<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;

class PatientsController extends Controller
{
    public function index()
    {
        return Patient::all();
    }

    public function show(Patient $patient)
    {
        return $patient;
    }

    public function store(Request $request)
    {
        $patient = Patient::create($request->all());

        return response()->json($patient, 201);
    }

    public function update(Request $request, Patient $patient)
    {
        $patient->update($request->all());

        return response()->json($patient, 200);
    }

    public function delete(Patient $patient)
    {
        $patient->delete();

        return response()->json(null, 204);
    }
}
