<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\KycVerificationStage; // Ensure this is being imported
use Illuminate\Http\Request;
use App\Models\KycDocument;

class AdminUserController extends Controller
{
    public function index()
{
    // Fetch users with KYC status by joining with kyc_verification_stages
    $users = User::leftJoin('kyc_verification_stages', 'users.id', '=', 'kyc_verification_stages.user_id')
                 ->select('users.id', 'users.name', 'users.email', 'kyc_verification_stages.status as kyc_status') // Select the status from kyc_verification_stages
                 ->get();

    return view('admin.users.index', compact('users'));
}


    public function show($id)
    {
        // Fetch the user by ID
        $user = User::findOrFail($id);

        // Fetch the KYC status
        $kycStatus = KycVerificationStage::where('user_id', $user->id)->first();

        // Fetch the latest 2 documents for the user from kyc_documents table
        $documents = KycDocument::where('user_id', $user->id)
                                ->orderBy('created_at', 'desc')
                                ->take(2)
                                ->get();

        return view('admin.users.show', compact('user', 'kycStatus', 'documents'));
    }

    public function approveKyc($id)
    {
        // Fetch the KYC verification record
        $kyc = KycVerificationStage::where('user_id', $id)->first();

        if ($kyc) {
            $kyc->status = 'approved';
            $kyc->save();

            // Flash message for success
            session()->flash('kycStatus', 'approved');
        } else {
            session()->flash('kycStatus', 'not found');
        }

        // Redirect back to the user details page
        return redirect()->route('admin.users.show', $id);
    }

    public function rejectKyc($id)
    {
        // Fetch the KYC verification record
        $kyc = KycVerificationStage::where('user_id', $id)->first();

        if ($kyc) {
            $kyc->status = 'rejected';
            $kyc->save();

            // Flash message for success
            session()->flash('kycStatus', 'rejected');
        } else {
            session()->flash('kycStatus', 'not found');
        }

        // Redirect back to the user details page
        return redirect()->route('admin.users.show', $id);
    }
}
