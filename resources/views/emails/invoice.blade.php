<p>Dear {{ $invoice->patient->name }},</p>
<p>Your medical receipt is now available.</p>
<p><strong>Medicine:</strong> {{ $invoice->medicine_name }}</p>
<p><strong>Duration:</strong> {{ $invoice->medicine_duration }}</p>
<p><strong>Notes:</strong> {{ $invoice->notes }}</p>

<p>Download your invoice: <a href="{{ route('patient.invoice.download', $invoice->appointmentID) }}">Download PDF</a></p>
