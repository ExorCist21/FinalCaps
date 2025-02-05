<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Therapy Prescription Receipt</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            color: #333;
        }
        .container {
            width: 80%;
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            color: #007BFF;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
            font-size: 16px;
        }
        .section .bold {
            font-weight: 600;
            color: #555;
        }
        .medications {
            margin-top: 20px;
        }
        .medications table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
            margin-top: 10px;
        }
        .medications th,
        .medications td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .medications th {
            background-color: #f8f9fa;
            color: #007BFF;
        }
        .medications td {
            background-color: #fdfdfd;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
        .signature {
            text-align: right;
            font-size: 16px;
            margin-top: 40px;
        }
        .signature .bold {
            font-weight: 600;
        }
        .thank-you {
            font-style: italic;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Therapy Prescription Receipt</div>

        <!-- Clinic & Therapist Information -->
        <div class="section">
            <span class="bold">Clinic Name:</span> {{ $invoice->therapist->therapistInformation->clinic_name ?? 'N/A' }}
        </div>
        <div class="section">
            <span class="bold">Therapist Name:</span> {{ $invoice->therapist->name ?? 'N/A' }}  
            <span class="bold">License No:</span> {{ $invoice->therapist->therapistInformation->awards ?? 'N/A' }}
        </div>
        <div class="section">
            <span class="bold">Email:</span> {{ $invoice->therapist->email ?? 'N/A' }}
        </div>
        <div class="section">
            <span class="bold">Date:</span> {{ now()->format('F j, Y') }}
        </div>

        <!-- Patient Information -->
        <div class="section">
            <span class="bold">Patient Information</span>
            <br>
            <span class="bold">Name:</span> {{ $invoice->patient->name ?? 'N/A' }}  
            <span class="bold">Email:</span> {{ $invoice->patient->email ?? 'N/A' }}
        </div>

        <!-- Session & Prescription Details -->
        <div class="section">
            <span class="bold">Session & Prescription Details</span>
            <br>
            <span class="bold">Appointment ID:</span> {{ $invoice->appointmentID ?? 'N/A' }}
            <span class="bold">Appointment Date:</span> {{ $invoice->appointment->datetime ?? 'N/A' }}
        </div>

        <!-- Prescribed Medications -->
        <div class="section medications">
            <span class="bold">Prescribed Medications</span>
            <table>
                <thead>
                    <tr>
                        <th>Medicine Name</th>
                        <th>Medicine Duration</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> {{ $invoice->medicine_name ?? 'N/A' }} </td>
                        <td> {{ $invoice->medicine_duration ?? 'N/A' }} </td>
                        <td> {{ $invoice->notes ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Signature -->
        <div class="signature">
            <span class="bold">Prescribed By:</span> {{ $invoice->therapist->name ?? 'N/A' }}
        </div>

        <div class="thank-you">
            Thank you for choosing our services!
        </div>
        
        <div class="footer">
            <p>If you have any questions, please feel free to contact us.</p>
        </div>
    </div>
</body>
</html>
