@extends('layouts.app')
@extends('layouts.nav')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">KYC - Step 2: Capture Document</h1>
    
    <!-- Form Container -->
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg mx-auto">
        
        <!-- Instruction Text -->
        <p class="text-center text-lg text-gray-600 mb-6">Please ensure your document is clearly visible in the camera frame (ID, Passport, etc.).</p>

        <!-- Camera Display Section -->
        <div class="mb-6 text-center">
            <!-- Video feed for document capture -->
            <video id="video" width="100%" height="240" autoplay class="rounded-lg shadow-md mb-4 border-2 border-gray-300"></video>
            <!-- Canvas for capturing image -->
            <canvas id="canvas" width="640" height="480" style="display: none;"></canvas>
        </div>

        <!-- Capture Button -->
        <div class="text-center mb-6">
            <button id="capture" class="button1 px-8 py-4 text-lg font-medium bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow-md transform transition-all duration-300">Capture Document</button>
        </div>

        <!-- Retake Button -->
        <div class="text-center mb-6">
            <button id="retake" class="button1 px-8 py-4 text-lg font-medium bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-md transform transition-all duration-300 hidden">Retake</button>
        </div>
        
        <!-- Form for Next Step -->
        <form action="{{ route('kyc.step2') }}" method="POST" class="text-center">
            @csrf
            <input type="hidden" name="document" id="documentInput">

            <button type="submit" class="button1 px-8 py-4 text-lg font-medium bg-green-500 hover:bg-green-600 text-white rounded-lg shadow-md transform transition-all duration-300 mt-4">Next</button>
        </form>
    </div>
</div>

<script>
    // JavaScript for capturing document using camera
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureButton = document.getElementById('capture');
    const retakeButton = document.getElementById('retake');
    const documentInput = document.getElementById('documentInput');
    let videoStream;

    // Access the webcam and start streaming
    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            videoStream = stream; // Save the stream to stop it later
            video.srcObject = stream;
        })
        .catch((err) => {
            console.error("Error accessing camera: ", err);
        });

    // Capture the document
    captureButton.addEventListener('click', (e) => {
        e.preventDefault();
        
        // Stop the video and capture the image
        video.pause();
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Get the image data from the canvas and set it in the hidden input
        const imageData = canvas.toDataURL('image/png');
        documentInput.value = imageData;
        
        // Stop the video stream to freeze the image
        const tracks = videoStream.getTracks();
        tracks.forEach(track => track.stop());
        
        // Show the Retake button
        retakeButton.classList.remove('hidden');
        
        // Alert the user that the document has been captured
        alert('Document captured!');
    });

    // Retake the document (restart video)
    retakeButton.addEventListener('click', (e) => {
        e.preventDefault();
        
        // Restart the video stream
        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                videoStream = stream; // Save the stream to stop it later
                video.srcObject = stream;
            })
            .catch((err) => {
                console.error("Error accessing camera: ", err);
            });

        // Hide the Retake button and reset the canvas
        retakeButton.classList.add('hidden');
        canvas.style.display = 'none';
    });
</script>

@endsection
