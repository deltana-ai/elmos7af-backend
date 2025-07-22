<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Models\CurrentPosition;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;

class CurrentPositionController extends Controller
{
    use HttpResponses;

    public function storeOrUpdate(Request $request)
    {
        try {
            $request->validate([
                'uuid' => 'required',
                'page_number' => 'nullable|integer',
                'sura_number' => 'nullable|integer',
                'juz_number' => 'nullable|integer',
            ]);

            $position = CurrentPosition::updateOrCreate(
                ['uuid' => $request->uuid],
                [
                    'page_number' => $request->page_number,
                    'sura_number' => $request->sura_number,
                    'juz_number' => $request->juz_number,
                ]
            );


            return $this->success($position, 'Position saved successfully');
            } catch (Exception $e) {
                return JsonResponse::respondError($e->getMessage());
            }
    }

}
