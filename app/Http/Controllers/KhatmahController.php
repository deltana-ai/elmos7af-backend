<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Models\Khatmah;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;

class KhatmahController extends Controller
{
    use HttpResponses;

        public function store(Request $request)
        {
            try {
                $request->validate([
                    'uuid' => 'required|unique:khatmahs,uuid',
                    'name' => 'required|string',
                    'start_page' => 'required|integer',
                    'duration_days' => 'required|integer',
                    'reminder_time' => 'required|date_format:H:i',
                ]);

                $khatmah = Khatmah::create([
                    'uuid' => $request->uuid,
                    'name' => $request->name,
                    'start_page' => $request->start_page,
                    'duration_days' => $request->duration_days,
                    'reminder_time' => $request->reminder_time,
                    'status' => 'not_started',    // الحالة تبدأ not_started
                    'current_page' => $request->start_page,
                ]);


            return $this->success($khatmah, 'Khatmah created successfully');
            } catch (Exception $e) {
                return JsonResponse::respondError($e->getMessage());
            }
        }

        public function getKhatmahByUuid($uuid)
        {
            $khatmahs = Khatmah::where('uuid', $uuid)->get();

            return response()->json(['khatmahs' => $khatmahs]);
        }

        public function update(Request $request)
        {
            try {
                $request->validate([
                    'uuid' => 'required',
                    'name' => 'nullable|string',
                    'start_page' => 'nullable|integer',
                    'duration_days' => 'nullable|integer',
                    'reminder_time' => 'nullable|date_format:H:i',
                    'status' => 'nullable|in:not_started,in_progress,completed',
                    'current_page' => 'nullable|integer',
                ]);

                $khatmah = Khatmah::where('uuid', $request->uuid)->firstOrFail();

                $khatmah->update($request->except('uuid'));

                return response()->json(['message' => 'Khatmah updated successfully', 'khatmah' => $khatmah]);

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }

}
