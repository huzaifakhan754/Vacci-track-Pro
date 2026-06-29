<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentRequest;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        // 🔥 MAIN FIX: IDs ke bajaye database se unke names (relations) load karein
        $bookings = ParentRequest::with(['child.parent', 'vaccine'])->latest()->get();

        return view('admin.bookings.index', compact('bookings'));
    }
}