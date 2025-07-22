<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Models\DailyStatistic;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;

class DailyStatisticController extends Controller
{
        use HttpResponses;

    public function store(Request $request)
    {
        try {
            $request->validate([
                'uuid' => 'required|unique:daily_statistics,uuid',
                'date' => 'required|date',
                'pages_read' => 'required|integer|min:1',
            ]);

            $statistic = DailyStatistic::create([
                'uuid' => $request->uuid,
                'date' => $request->date,
                'pages_read' => $request->pages_read,
            ]);



           return $this->success($statistic, 'Khatmah created successfully');
            } catch (Exception $e) {
                return JsonResponse::respondError($e->getMessage());
            }
    }

    public function update(Request $request, )
    {
        try {
            $request->validate([
                'uuid' => 'required',
                'date' => 'nullable|date',
                'pages_read' => 'nullable|integer|min:1',
            ]);

            $statistic = DailyStatistic::
                 where('uuid', $request->uuid)
                ->firstOrFail();

            $statistic->update($request->except('uuid'));

            return response()->json([
                'message' => 'Daily statistic updated successfully',
                'statistic' => $statistic
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


}
