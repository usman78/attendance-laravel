@extends('app')
@section('content')
    
    <div class="container mt-5">
        {{-- <h2 class="text-center">Student Attendance</h2> --}}

        <!-- Webcam Section -->
        <div id="webcam-container" class="text-center">
            <video id="webcam" autoplay playsinline></video>
            <div class="btns">
                <a href="{{ route('dashboard') }}"><button class="btn btn-primary mt-3">Back</button></a>
                {{-- <button id="capture-button" class="btn btn-success mt-3">Mark Attendance</button> --}}
            </div>
        </div>

        <!-- Hidden Canvas for Image Capture -->
        <canvas id="canvas" style="display: none;"></canvas>

        <!-- Response Message -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div id="response-message" class="mt-3"></div>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('canvas');
        const responseMessage = document.getElementById('response-message');

        let isProcessing = false; // To prevent multiple API calls
        let isAttendanceMarked = false; // To prevent duplicate marking

        // Access Webcam
        async function setupWebcam() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
            } catch (error) {
                responseMessage.innerHTML = `<div class="alert alert-danger">Webcam access denied. Please enable camera permissions.</div>`;
            }
        }

        setupWebcam();

        // Function to capture frame and send to API
        async function captureAndVerify() {
            if (isProcessing || isAttendanceMarked) return; // Prevent multiple calls

            isProcessing = true;
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const imageData = canvas.toDataURL('image/jpeg');
            const base64Image = imageData.split(',')[1]; // Remove metadata

            console.log('Sending image to API...');

            try {
                const response = await fetch('/verify-face', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ image: base64Image })
                });

                const result = await response.json();
                console.log("Server response:", result);
                
                if (result.status === 'success') {
                    isAttendanceMarked = true; // Stop further attempts
                    responseMessage.innerHTML = `
                        <div class="alert alert-success">${result.message}</div>
                    `;
                    setTimeout(() => {
                    isAttendanceMarked = false; // Allow next attempt
                    responseMessage.innerHTML = ''; 
                    }, 2000);
                } else {
                    responseMessage.innerHTML = `
                        <div class="alert alert-warning">${result.message}</div>
                    `;
                }
            } catch (error) {
                console.error('Error:', error);
                responseMessage.innerHTML = `<div class="alert alert-danger">An error occurred. Please try again.</div>`;
            }

            isProcessing = false; // Allow next attempt
        }

        // Start automatic face detection every 2 seconds
        setInterval(captureAndVerify, 2000);
    </script>
@endsection
