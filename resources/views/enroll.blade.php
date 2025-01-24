@extends('app')
@section('content')
    <div class="container mt-5">
        <h2 class="text-center">New Attendance Enrollment</h2>

        <input type="text" id="student_id" class="form-control mt-3" placeholder="Student Roll Number">

        <input type="text" id="student_name" class="form-control mt-3" placeholder="Student Name">

        <!-- Webcam Section -->
        <div id="webcam-container" class="text-center">
            <video id="webcam" autoplay playsinline width="640" height="480"></video>
            <div class="btns">
                <a href="{{ route('attendance')}}"><button class="btn btn-primary mt-3">Mark Attendence</button></a>   
                <button id="capture-button" class="btn btn-success mt-3">Enroll The Face</button>
            </div>
        </div>

        <!-- Hidden Canvas for Image Capture -->
        <canvas id="canvas" width="640" height="480" style="display: none;"></canvas>

        <!-- Response Message -->
        <div id="response-message" class="mt-3"></div>
    </div>

    <script>
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('canvas');
        const student = document.getElementById('student_name');
        const captureButton = document.getElementById('capture-button');
        const responseMessage = document.getElementById('response-message');

        // Access Webcam
        async function setupWebcam() {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
        }

        setupWebcam();

        // Capture Frame and Send to API
        captureButton.addEventListener('click', async () => {
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = canvas.toDataURL('image/jpeg');
            const base64Image = imageData.split(',')[1]; // Remove metadata
            

            try {
                const response = await fetch('/enroll-face', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ image: base64Image, name: student.value })
                });

                const result = await response.json();
                responseMessage.innerHTML = `
                    <div class="alert ${result.status === 'success' ? 'alert-success' : 'alert-danger'}">
                        ${result.message}
                    </div>
                `;
            } catch (error) {
                responseMessage.innerHTML = `
                    <div class="alert alert-danger">An error occurred. Please try again.</div>
                `;
            }
        });
    </script>
@endsection
