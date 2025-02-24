@extends('app')
@section('content')
    <div class="container mt-5">
        <h6 class="text-center">New Enrollment</h6>
        <div class="row justify-content-center" style="margin-bottom: 20px;">
            <div class="col-md-6"> 
                <div class="card">
                    <div class="card-body">
                        {{-- <form> --}}
                            <div class="form-group">
                                {{-- <label for="student_roll">Student Roll Number:</label> --}}
                                <input type="number" class="form-control" id="student_roll" placeholder="Enter Your Roll Number" required>
                            </div>
                            {{-- <div class="form-group">
                                <label for="input2">Input 2:</label>
                                <input type="text" class="form-control" id="input2" placeholder="Enter text">
                            </div> --}}
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Webcam Section -->
        <div id="webcam-container" class="text-center">
            <video id="webcam" autoplay playsinline></video>
            <div class="btns">
                <a href="{{ route('attendance')}}"><button class="btn btn-primary mt-3">Mark Attendence</button></a>   
                <button id="capture-button" class="btn btn-success mt-3"></button>
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
        const student = document.getElementById('student_roll');
        const captureButton = document.getElementById('capture-button');
        const responseMessage = document.getElementById('response-message');

        captureButton.innerHTML = `
            <span id="button-text">Enroll The Face</span>
            <div id="loading-spinner" class="spinner-border spinner-border-sm text-light d-none" role="status"></div>
        `;

        // Get references to the spinner and button text
        const buttonText = document.getElementById('button-text');
        const loadingSpinner = document.getElementById('loading-spinner');

        // Access Webcam
        async function setupWebcam() {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
        }

        setupWebcam();

        // Capture Frame and Send to API
        captureButton.addEventListener('click', async () => {
            if (!student.value) {
                responseMessage.innerHTML = `
                    <div class="alert alert-danger">Please enter the roll number to enroll.</div>
                `;
                return;
            }

            buttonText.style.display = 'none'; // Hide button text
            loadingSpinner.classList.remove('d-none'); // Show spinner
            captureButton.disabled = true; // Disable the button

            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
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
                    body: JSON.stringify({ image: base64Image, roll_no: student.value })
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
            } finally {
                buttonText.style.display = 'block'; // Show button text
                loadingSpinner.classList.add('d-none'); // Hide spinner
                captureButton.disabled = false; // Enable the button
            }
        });
    </script>
@endsection
