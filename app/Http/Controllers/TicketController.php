<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Attachment;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
                    foreach ($request->file('attachments') as $attachment) {
                        $filename = $attachment->getClientOriginalName();
                        $customeFileName = date('YmdHis').'_'.$filename;
                        $path = 'uploads/'.date('YmdHis').'_'.$filename;
                        Storage::disk('public')->putFileAs('uploads', $attachment, $customeFileName);
                        $ticket->attachments()->create([
                            'url' => $path
                        ]);
                    } 
                }
            });

            return response()->json([
                'message' => 'Ticket berhasil di submit'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Maaf, terjadi kesalahan pada server',
                'exception' => $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {

    }
}
