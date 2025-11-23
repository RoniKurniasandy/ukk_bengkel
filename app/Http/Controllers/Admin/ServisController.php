<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servis;

class ServisController extends Controller
{
public function index()
{
    $servis = Servis::with(['booking.user', 'mekanik'])->get();
    return view('admin.servis.index', compact('servis'));
}

}
