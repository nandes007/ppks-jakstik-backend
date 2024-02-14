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
    public function index(TicketRequest $request)
    {
        $tickets = Ticket::with('attachments');
        $countPendingTicket = Ticket::where('status', 'Pending')->count();
        $countResolvedTicket = Ticket::where('status', 'Resolved')->count();

        if (!empty($request->status)) {
            $tickets = $tickets->where('status', $request->status);
        }

        $tickets = $tickets->paginate(20);

        return response()->json([
            'tickets' => $tickets,
            'count_pending_ticket' => $countPendingTicket,
            'count_resolved_ticket' => $countResolvedTicket
        ]);
    }

    public function store(TicketRequest $request)
    {
        try {
            $ticket = DB::transaction(function() use ($request) {
                $user = $request->user();
                $ticketNo = "PPKS-JAKSTIK-" . date('YmdHis') . rand(1, 100);
                $ticket = Ticket::create(array_merge($request->only([
                        'no_ticket',
                        'nama',
                        'email',
                        'no_wa',
                        'jenis_pengaduan',
                        'deskripsi'
                    ]), [
                        'status' => 'Pending',
                        'no_ticket' => $ticketNo,
                        'created_by' => $user->id
                    ]
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

                return $ticket;
            });

            return response()->json([
                'message' => 'Ticket berhasil di submit, berikut No Ticket Anda : ' . $ticket->no_ticket
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
        $ticket = Ticket::with('attachments')->where('id', $id)->first();

        if (empty($ticket)) {
            return response()->json([
                'message' => 'Ticket tidak ditemukan!'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'ticket' => $ticket
        ]);
    }

    public function update(TicketRequest $request, $id)
    {
        $ticket = Ticket::where('id', $id)->first();

        if (empty($ticket)) {
            return response()->json([
                'message' => 'Ticket tidak ditemukan!'
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        $ticket->status = $request->status;
        $ticket->save();

        return response()->json([
            'message' => 'Ticket dalam tahap konsultasi',
            'ticket' => $ticket
        ]);
    }
}
