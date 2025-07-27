<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponse;
use App\Models\Note;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;

class NoteController extends Controller
{
        use HttpResponses;

     public function store(Request $request)
     {
         try { $request->validate([
            'uuid' => 'required',
            'aya_number' => 'nullable|integer',
            'sura_number' => 'nullable|integer',
            'page_number' => 'nullable|integer',
            'note' => 'nullable|string',
         ]);
            $note = Note::create($request->all());
            return $this->success($note, 'Note created successfully');
        } catch (Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
     }

        public function update(Request $request, $id)
        {
            try {
                $request->validate([
                    'uuid' => 'required',
                    'aya_number' => 'nullable|integer',
                    'sura_number' => 'nullable|integer',
                    'page_number' => 'nullable|integer',
                    'note' => 'nullable|string',
                ]);

                $query = Note::where('id', $id)
                    ->where('uuid', $request->uuid);

                if ($request->filled('aya_number')) {
                    $query->where('aya_number', $request->aya_number);
                }

                if ($request->filled('sura_number')) {
                    $query->where('sura_number', $request->sura_number);
                }

                if ($request->filled('page_number')) {
                    $query->where('page_number', $request->page_number);
                }

                $note = $query->first();

                if (!$note) {
                    return response()->json(['message' => 'Note not found'], 404);
                }

                $note->update($request->except('uuid'));

                return response()->json([
                    'message' => 'Note updated successfully',
                    'note' => $note,
                ]);

            } catch (Exception $e) {
                return JsonResponse::respondError($e->getMessage());
            }
        }



    public function getNotesByUuid($uuid)
    {
        $notes = Note::where('uuid', $uuid)->get();

        return response()->json(['notes' => $notes]);
    }
}
