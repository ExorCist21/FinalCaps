<title>Terms and Conditions</title>
<x-app-layout>
    <div class="max-w-2xl mx-auto p-8 bg-white rounded-lg shadow-md">
        <h2 class="text-3xl font-bold text-center mb-6">MentalWell Terms and Conditions</h2>

        <div class="space-y-6 text-gray-700 text-sm px-4 text-center">
            @php $role = Auth::user()->role; @endphp

            @if($role === 'patient')
                <p><strong>1. User Eligibility:</strong> You must be 18 years or older to use MentalWell.</p>
                <p><strong>2. Account Responsibility:</strong> You are responsible for all actions under your account.</p>
                <p><strong>3. Patient Obligations:</strong> You must respect therapists and provide accurate appointment details.</p>
                <p><strong>4. Payment Policy:</strong> You agree that payments will be 80% for the therapist and 20% for MentalWell. Refunds are subject to admin review.</p>
                <p><strong>5. Confidentiality:</strong> Your data is protected by our Privacy Policy.</p>
                <p><strong>6. Platform Access:</strong> Full access is only granted after accepting these terms.</p>
                <p><strong>7. Prohibited Activities:</strong> No impersonation, fraud, harassment, or unethical behavior is allowed.</p>
                <p><strong>8. Termination:</strong> Accounts violating policies may be suspended or removed.</p>
                <p><strong>9. Updates:</strong> Terms may change. Continued use means you accept changes.</p>
                <p><strong>10. Service Satisfaction:</strong> If a therapist fails to perform their duties professionally or ethically, you may request a refund. All such cases will be reviewed by the admin team for resolution. Just reach out to them through email.</p>
            @elseif($role === 'therapist')
                <p><strong>1. User Eligibility:</strong> You must be 18 years or older and a licensed therapist to use MentalWell.</p>
                <p><strong>2. Account Responsibility:</strong> You are responsible for all actions under your account.</p>
                <p><strong>3. Therapist Obligations:</strong> You must provide truthful credentials, maintain professional ethics, and complete scheduled appointments.</p>
                <p><strong>4. Payment Policy:</strong> You will receive your fee after the session is finished and completed. Refunds are subject to admin review.</p>
                <p><strong>5. Confidentiality:</strong> All client data must be handled according to our Privacy Policy.</p>
                <p><strong>6. Platform Access:</strong> Full access is only granted after accepting these terms.</p>
                <p><strong>7. Prohibited Activities:</strong> No impersonation, fraud, harassment, or unethical behavior is allowed.</p>
                <p><strong>8. Termination:</strong> Accounts violating policies may be suspended or removed.</p>
                <p><strong>9. Updates:</strong> Terms may change. Continued use means you accept changes.</p>
                <p><strong>10. Performance Issues:</strong> If a patient reports unsatisfactory performance or you are found to be slacking off in your duties, you will first receive a warning. If performance does not improve, your account will be deactivated.</p>
                <p><strong>11. Free Accounts:</strong> MentalWell provide one (1) free session to new patient accounts. If a patient abuses the free session policy (e.g., creating multiple accounts), therapists can report the incident with proof through our Gmail for investigation.</p>
            @else
                <p>Unauthorized access. Please contact the administrator.</p>
            @endif
        </div>

        <form action="{{ route('terms.accept') }}" method="POST" class="mt-8 text-center">
            @csrf
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                I Accept the Terms and Conditions
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
            Swal.fire({
                title: "Success!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonColor: "#4CAF50",
                confirmButtonText: "OK"
            });
            @endif

            @if(session('error'))
            Swal.fire({
                title: "Error!",
                text: "{{ session('error') }}",
                icon: "error",
                confirmButtonColor: "#E53935",
                confirmButtonText: "OK"
            });
            @endif
        });
    </script>
</x-app-layout>
