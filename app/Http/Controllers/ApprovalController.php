<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function index()
    {
        $approvals = Approval::with('booking', 'approver')->where('approver_id', Auth::id())->get();
        return view('approvals.index', compact('approvals'));
    }

    public function approve($id)
    {
        $approval = Approval::findOrFail($id);
        if ($approval->approver_id != Auth::id()) {
            return redirect()->route('approvals.index')->with('error', 'You are not authorized to approve this request.');
        }

        $approval->status = 'approved';
        $approval->save();

        $booking = Booking::findOrFail($approval->booking_id);
        $nextApprover = Person::where('role', 'supervisor')->where('id', '>', $approval->approver_id)->first();
        if ($nextApprover) {
            $booking->approvals()->create([
                'approver_id' => $nextApprover->id,
                'status' => 'pending',
            ]);
        } else {
            $booking->status = 'approved';
            $booking->save();
        }

        return redirect()->route('approvals.index')->with('success', 'Booking approved successfully.');
    }

    public function reject($id)
    {
        $approval = Approval::findOrFail($id);
        if ($approval->approver_id != Auth::id()) {
            return redirect()->route('approvals.index')->with('error', 'You are not authorized to reject this request.');
        }

        $approval->status = 'rejected';
        $approval->save();

        $booking = Booking::findOrFail($approval->booking_id);
        $booking->status = 'rejected';
        $booking->save();

        return redirect()->route('approvals.index')->with('success', 'Booking rejected successfully.');
    }
}
