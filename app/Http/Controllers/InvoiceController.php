<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function show($appointmentID)
    {
        $invoice = Invoice::where('appointmentID', $appointmentID)->firstOrFail();
        return view('patient.invoice', compact('invoice'));
    }

    public function download($invoiceID)
    {
        $invoice = Invoice::findOrFail($invoiceID);

        $pdf = PDF::loadView('invoices.template', ['invoice' => $invoice]);

        return $pdf->download('Therapy_Prescription_Invoice.pdf');
    }
}
