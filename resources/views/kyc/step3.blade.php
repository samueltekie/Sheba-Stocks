@extends('layouts.app')
@extends('layouts.nav')
@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">KYC - Step 3: Capture Selfie</h1>
    
    <!-- Form Container -->
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-sm mx-auto">
        
        <!-- Instruction Text -->
        <p class="text-center text-lg text-gray-600 mb-6">Please ensure your face is clearly visible in the camera frame for the selfie.</p>

        <!-- Selfie Camera Section -->
        <div class="mb-6 text-center">
            <!-- Increased height and centered the video -->
            <video id="selfieVideo" width="220" height="300" autoplay class="rounded-full border-4 border-gray-300 shadow-lg mb-4 mx-auto"></video>
            <canvas id="selfieCanvas" width="220" height="300" style="display: none;"></canvas>
        </div>

        <!-- Capture Button -->
        <div class="text-center mb-6">
            <button id="captureSelfie" class="button1 px-8 py-4 text-lg font-medium bg-blue-500 hover:bg-blue-600 text-white rounded-full shadow-md transform transition-all duration-300">Capture Selfie</button>
        </div>
        
        <!-- Retake Button -->
        <div class="text-center mb-6">
            <button id="retakeSelfie" class="button1 px-8 py-4 text-lg font-medium bg-red-500 hover:bg-red-600 text-white rounded-full shadow-md transform transition-all duration-300 hidden">Retake</button>
        </div>

        <!-- Form for Final Submission -->
        <form action="{{ route('kyc.submitFinal') }}" method="POST" class="text-center">
            @csrf
            <input type="hidden" name="selfie" id="selfieInput">

            <button type="submit" class="button1 px-8 py-4 text-lg font-medium bg-green-500 hover:bg-green-600 text-white rounded-full shadow-md transform transition-all duration-300 mt-4">Submit KYC</button>
        </form>
    </div>
</div>

<script>
    // JavaScript for capturing selfie using the camera
    const selfieVideo = document.getElementById('selfieVideo');
    const selfieCanvas = document.getElementById('selfieCanvas');
    const captureSelfieButton = document.getElementById('captureSelfie');
    const retakeSelfieButton = document.getElementById('retakeSelfie');
    const selfieInput = document.getElementById('selfieInput');
    let videoStream;

    // Access the webcam and start streaming
    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            videoStream = stream; // Save the stream to stop it later
            selfieVideo.srcObject = stream;
        })
        .catch((err) => {
            console.error("Error accessing camera: ", err);
        });

    // Capture the selfie
    captureSelfieButton.addEventListener('click', (e) => {
        e.preventDefault();
        
        // Stop the video and capture the image
        selfieVideo.pause();
        selfieCanvas.getContext('2d').drawImage(selfieVideo, 0, 0, selfieCanvas.width, selfieCanvas.height);
        
        // Get the image data from the canvas and set it in the hidden input
        const imageData = selfieCanvas.toDataURL('image/png');
        selfieInput.value = imageData;
        
        // Stop the video stream to freeze the image
        const tracks = videoStream.getTracks();
        tracks.forEach(track => track.stop());
        
        // Show the Retake button
        retakeSelfieButton.classList.remove('hidden');
        
        // Alert the user that the selfie has been captured
        alert('Selfie captured!');
    });

    // Retake the selfie (restart video)
    retakeSelfieButton.addEventListener('click', (e) => {
        e.preventDefault();
        
        // Restart the video stream
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                videoStream = stream; // Save the stream to stop it later
                selfieVideo.srcObject = stream;
            })
            .catch((err) => {
                console.error("Error accessing camera: ", err);
            });

        // Hide the Retake button and reset the canvas
        retakeSelfieButton.classList.add('hidden');
        selfieCanvas.style.display = 'none';
    });
</script>
@endsection
