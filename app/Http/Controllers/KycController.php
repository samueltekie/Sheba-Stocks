<?php

namespace App\Http\Controllers;

use App\Models\KycVerificationStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;


class KycController extends Controller
{
    public function showKycDashboard()
    {
        $user = Auth::user();
        $kycDocuments = $user->kycDocuments; // Ensure the relationship exists in your User model
    
        // Set the flag to indicate if documents have been uploaded
        $documentsUploaded = !$kycDocuments->isEmpty();
    
        // Pass the variable to the view
        return view('kyc.dashboard', compact('documentsUploaded'));
    }
    public function showDashboard()
{
    $user = Auth::user();
    $stages = KycVerificationStage::where('user_id', $user->id)->get();
    
    // Check if the user has uploaded any documents
    $documentsUploaded = DB::table('kyc_documents')
                           ->where('user_id', $user->id)
                           ->exists();

    return view('kyc.dashboard', compact('user', 'stages', 'documentsUploaded'));
}



    public function completeStage(Request $request, $stage)
    {
        $request->validate([
            'document' => 'required_if:stage,document_upload|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'selfie' => 'required_if:stage,selfie_verification|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $kycStage = KycVerificationStage::updateOrCreate(
            ['user_id' => $user->id, 'stage' => $stage],
            ['status' => 'pending']
        );

        // Handle document and selfie uploads if applicable
        if ($stage === 'document_upload' && $request->hasFile('document')) {
            $path = $request->file('document')->store('kyc_documents', 'public');
            // Save the document path in a separate table or in the KYC stage table as needed.
        }

        if ($stage === 'selfie_verification' && $request->hasFile('selfie')) {
            $path = $request->file('selfie')->store('kyc_selfies', 'public');
            // Save the selfie path accordingly.
        }

        return redirect()->route('kyc.dashboard')->with('success', 'Stage completed successfully. Verification is pending.');
    }
    public function showForm()
{
    return view('kyc.form');
}

public function submitKyc(Request $request)
{
    $request->validate([
        'document_type' => 'required|string',
        'document' => 'required|string', // Base64 string
        'selfie' => 'required|string', // Base64 string
    ]);

    $user = Auth::user();

    // Decode and save document image
    $documentPath = 'kyc_documents/' . uniqid() . '.png';
    \Storage::disk('public')->put($documentPath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->input('document'))));

    // Decode and save selfie image
    $selfiePath = 'kyc_selfies/' . uniqid() . '.png';
    \Storage::disk('public')->put($selfiePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->input('selfie'))));

    // Create a new KYC entry
    KycVerificationStage::create([
        'user_id' => $user->id,
        'stage' => 'document_upload',
        'status' => 'pending',
    ]);

    // Save document info in the kyc_documents table
    DB::table('kyc_documents')->insert([
        'user_id' => $user->id,
        'document_type' => $request->input('document_type'),
        'document_path' => $documentPath,
        'verified' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Save selfie info in the kyc_documents table
    DB::table('kyc_documents')->insert([
        'user_id' => $user->id,
        'document_type' => 'selfie',
        'document_path' => $selfiePath,
        'verified' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('kyc.dashboard')->with('success', 'KYC documents submitted successfully. Your verification is pending.');
}
public function showStep1()
{
    return view('kyc.step1');
}

public function submitStep1(Request $request)
{
    $request->validate([
        'document_type' => 'required|string',
    ]);

    // Save the document type to the session
    session(['document_type' => $request->input('document_type')]);

    return redirect()->route('kyc.step2');
}

public function showStep2()
{
    return view('kyc.step2');
}

public function submitStep2(Request $request)
{
    $request->validate([
        'document' => 'required|string', // This will be the base64 encoded image
    ]);

    // Save the document to the session
    session(['document' => $request->input('document')]);

    return redirect()->route('kyc.step3');
}

public function showStep3()
{
    return view('kyc.step3');
}

public function submitFinal(Request $request)
{
    $request->validate([
        'selfie' => 'required|string', // This will be the base64 encoded image
    ]);

    // Get the user and retrieve session data for document type and document
    $user = Auth::user();
    $documentType = session('document_type');
    $document = session('document');
    $selfie = $request->input('selfie');

    // Save the document image to storage
    $documentPath = 'kyc_documents/' . uniqid() . '.png';
    Storage::disk('public')->put($documentPath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $document)));

    // Save the selfie image to storage
    $selfiePath = 'kyc_selfies/' . uniqid() . '.png';
    Storage::disk('public')->put($selfiePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $selfie)));

    // Save the document info in the kyc_documents table
    DB::table('kyc_documents')->insert([
        'user_id' => $user->id,
        'document_type' => $documentType,
        'document_path' => $documentPath,
        'verified' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Save the selfie info in the kyc_documents table
    DB::table('kyc_documents')->insert([
        'user_id' => $user->id,
        'document_type' => 'selfie',
        'document_path' => $selfiePath,
        'verified' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Update the KYC verification stages table with "pending" status
    KycVerificationStage::updateOrCreate(
        ['user_id' => $user->id, 'stage' => 'kyc_submission'],
        ['status' => 'pending']
    );

    return redirect()->route('kyc.dashboard')->with('success', 'KYC submitted successfully and is under review.');
}

}