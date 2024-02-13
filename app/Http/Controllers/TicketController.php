<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Attachment;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {

    }

    public function store(TicketRequest $request)
    {
        try {
            DB::transaction(function() use ($request) {
                $ticket = Ticket::create(array_merge($request->only([
                        'no_ticket',
                        'nama',
                        'email',
                        'no_wa',
                        'jenis_pengaduan',
                        'deskripsi'
                    ]), ['status' => 'Pending']
                ));
    
                if ($request->hasFile('attachments')) {
                    foreach ($request->attachments as $attachment) {
                        $ticket->attachments()->create([
                            'url' => $attachment
                        ]);
                    } 
                }
            });

            return response()->json([
                'message' => 'Ticket berhasil di submit'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Maaf, terjadi kesalahan pada server'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {

    }
}
