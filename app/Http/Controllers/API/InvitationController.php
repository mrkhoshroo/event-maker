<?php

namespace App\Http\Controllers\API;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ResponseController;
use App\Http\Resources\Appointment as AppointmentResource;


class InvitationController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invitations = Auth::user()->invitations()
            ->select('id', 'title', 'due_date')->get();
        return $this->sendResponse($invitations);
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $user_id = Auth::user()->id;

        $appointment->invitees()->updateExistingPivot($user_id, ['visited_at' => now()]);

        return $this->sendResponse(new AppointmentResource($appointment));
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $input = $request->only(['status']);

        $validator = Validator::make($input, [
            'status' => [
                'required',
                'integer',
                Rule::in([0, 1]),
            ]
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $user_id = Auth::user()->id;

        $appointment->invitees()->updateExistingPivot($user_id, $input);

        return $this->sendResponse(new AppointmentResource($appointment));
    }
}
