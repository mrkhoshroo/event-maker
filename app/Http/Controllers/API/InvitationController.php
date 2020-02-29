<?php

namespace App\Http\Controllers\API;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ResponseController;
use App\Http\Resources\Appointment as AppointmentResource;
use App\Http\Resources\Invitation as InvitationResource;


class InvitationController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invitations = InvitationResource::collection(Auth::user()->invitations);

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
        DB::beginTransaction();

        try {

            $this->authorize('update', $appointment);

            $user_id = Auth::user()->id;

            $appointment->invitees()->updateExistingPivot($user_id, ['visited_at' => now()]);

            DB::commit();

            return $this->sendResponse(new AppointmentResource($appointment->refresh()));
        } catch (\Exception $e) {

            DB::rollback();

            $error = $e->getMessage();
            return $this->sendError($error, 500);
        }
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
        DB::beginTransaction();

        try {
            $this->authorize('update', $appointment);

            $input = $request->only(['status']);

            $validator = Validator::make($input, [
                'status' => [
                    'required',
                    Rule::in(['rejected', 'accepted']),
                ]
            ]);

            switch ($input['status']) {
                case 'rejected':
                    $input['status'] = 0;
                    break;
                case 'accepted':
                    $input['status'] = 1;
                    break;
                default:
                    $input['status'] = 2;
                    break;
            }

            if ($validator->fails()) {
                return $this->sendError($validator->errors());
            }

            $user_id = Auth::user()->id;

            $appointment->invitees()->updateExistingPivot($user_id, $input);

            DB::commit();

            $invitation = $appointment->invitees()->where('user_id', $user_id)->first();

            return $this->sendResponse(new InvitationResource($invitation));

        } catch (\Exception $e) {

            DB::rollback();

            $error = $e->getMessage();
            return $this->sendError($error, 500);
        }
    }
}
