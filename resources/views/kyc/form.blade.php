@extends('layouts.app')

@section('content')
<div class="container">
    <h1>KYC Submission Form</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('kyc.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="document_type">Document Type</label>
            <select name="document_type" id="document_type" class="form-control" required>
                <option value="ID">ID Card</option>
                <option value="passport">Passport</option>
                <option value="address_proof">Address Proof</option>
            </select>
        </div>

        <div class="form-group">
            <label for="document">Capture Document</label>
            <video id="video" width="100%" height="240" autoplay></video>
            <canvas id="canvas" width="640" height="480" style="display: none;"></canvas>
            <button type="button" id="capture" class="btn btn-secondary">Capture Document</button>
            <input type="hidden" name="document" id="documentInput">
        </div>

        <div class="form-group">
            <label for="selfie">Capture Selfie</label>
            <video id="selfieVideo" width="100%" height="240" autoplay></video>
            <canvas id="selfieCanvas" width="640" height="480" style="display: none;"></canvas>
            <button type="button" id="captureSelfie" class="btn btn-secondary">Capture Selfie</button>
            <input type="hidden" name="selfie" id="selfieInput">
        </div>

        <button type="submit" class="btn btn-primary">Submit KYC</button>
    </form>
</div>

<script>
    // Document Capture
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureButton = document.getElementById('capture');
    const documentInput = document.getElementById('documentInput');

    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            video.srcObject = stream;
        })
        .catch((err) => {
            console.error("Error accessing camera: ", err);
        });

    captureButton.addEventListener('click', () => {
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageData = canvas.toDataURL('image/png');
        documentInput.value = imageData;
        alert('Document captured!');
    });

    // Selfie Capture
    const selfieVideo = document.getElementById('selfieVideo');
    const selfieCanvas = document.getElementById('selfieCanvas');
    const captureSelfieButton = document.getElementById('captureSelfie');
    const selfieInput = document.getElementById('selfieInput');

    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            selfieVideo.srcObject = stream;
        })
        .catch((err) => {
            console.error("Error accessing camera for selfie: ", err);
        });

    captureSelfieButton.addEventListener('click', () => {
        selfieCanvas.getContext('2d').drawImage(selfieVideo, 0, 0, selfieCanvas.width, selfieCanvas.height);
        const selfieData = selfieCanvas.toDataURL('image/png');
        selfieInput.value = selfieData;
        alert('Selfie captured!');
    });
</script>
@endsection