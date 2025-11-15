<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Promo;
use App\Models\TicketPayment;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'schedule_id' => 'required',
            'rows_of_seat' => 'required',
            'quantity' => 'required',
            'total_price' => 'required',
            'tax' => 'required',
            'hour' => 'required'
        ]);
        $createData = Ticket::create([
            'user_id' => $request->user_id,
            'schedule_id' => $request->schedule_id,
            'rows_of_seat' => $request->rows_of_seat,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
            'tax' => $request->tax,
            'hour' => $request->hour,
            'date' => now(),
            'actived' => 0
        ]);
        return response()->json([
            'message' => 'Berhasil membuat data tiket',
            'data' => $createData
        ]);
    }

    public function orderPage($ticketId)
    {
        $ticket = Ticket::where('id', $ticketId)->with(['schedule', 'schedule.cinema', 'schedule.movie'])->first();
        $promos = Promo::where('actived', 1)->get();
        return view('schedule.order', compact('ticket', 'promos'));
    }

    public function createQrcode(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required'
        ]);

        $ticket = Ticket::find($request['ticket_id']);
        $kodeQr = 'TICKET-' . $ticket['id'];

        $qrcode = QrCode::format('svg')->size(30)->margin(2)->generate($kodeQr);

        $filename = $kodeQr . '.svg';
        $folder = 'qrcode/' . $filename;
        Storage::disk('public')->put($folder, $qrcode);

        $createData = TicketPayment::create([
            'ticket_id' => $ticket['id'],
            'qrcode' => $folder,
            'booked_date' => now(),
            'status' => 'process'
        ]);

        if ($request->promo_id != NULL) {
            $promo = Promo::find($request->promo_id);
            if ($promo['type'] == 'percent') {
                $discount = $ticket['total_price'] * $promo['discount'] / 100;
            } else {
                $discount = $promo['discount'];
            }
            $totalPriceNew = $ticket['total_price'] - $discount;
            $ticket->update([
                'total_price' => $totalPriceNew,
                'promo_id' => $request->promo_id
            ]);
        }
        return response()->json([
            'message' => 'Berhasil membuat data pembayaran dan update promo tiket',
            'data' => $ticket
        ]);
    }

    public function paymentPage($ticketId)
    {
        $ticket = Ticket::where('id', $ticketId)->with('ticketPayment', 'promo')->first();
        // dd($ticket);
        return view('schedule.payment', compact('ticket'));
    }

    public function updateStatusPayment(Request $request, $ticketId)
    {
        $updateData = TicketPayment::where('ticket_id', $ticketId)->update([
            'status' => 'paid-off',
            'paid_date' => now()
        ]);
        if ($updateData) {
            Ticket::where('id', $ticketId)->update(['actived' => 1]);
        }
        return redirect()->route('tickets.paymentProof', $ticketId);
    }

    public function proofPayment($ticketId)
    {
        $ticket = Ticket::where('id', $ticketId)->with(['schedule', 'schedule.cinema', 'schedule.movie', 'promo', 'ticketPayment'])->first();
        return view('schedule.proof-payment', compact('ticket'));
    }

    public function exportPdf($ticketId)
    {
        $ticket = Ticket::where('id', $ticketId)->with(['schedule', 'schedule.cinema', 'schedule.movie', 'promo', 'ticketPayment'])->first()->toArray();
        view()->share('ticket', $ticket);

        $pdf = Pdf::loadView('schedule.export-pdf', $ticket);
        $fileName = 'TICKET' . $ticket['id'] . '.pdf';
        return $pdf->download($fileName);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
