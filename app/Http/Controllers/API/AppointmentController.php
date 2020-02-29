<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ResponseController;
use App\Http\Resources\Appointment as AppointmentResource;

class AppointmentController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Auth::user()->appointments()->select('id', 'title', 'due_date')->get();
        return $this->sendResponse($appointments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $input = $request->only(['due_date', 'title', 'info', 'invitees']);

            $validator = Validator::make($input, [
                'due_date' => 'required|date',
                'title' => 'required|string|max:255',
                'info' => 'required|string',
                'invitees' => 'required',
                'invitees.*' => [
                    'required',
                    'integer',
                    Rule::in(User::pluck('id')),
                ]
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }

            $invitees = $input['invitees'];

            $appointment = Auth::user()->appointments()->create($input);

            $appointment->invitees()->attach($invitees);

            DB::commit();

            return $this->sendResponse(new AppointmentResource($appointment));

        } catch (\Exception $e) {

            DB::rollback();

            $error = $e->getMessage();
            return $this->sendError($error, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        $this->authorize('view', $appointment);

        return $this->sendResponse(new AppointmentResource($appointment));
    }
}
