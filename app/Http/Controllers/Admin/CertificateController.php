<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRequest;

class CertificateController extends Controller
{
    // صفحة تفاصيل الطلب
  public function show($id)
{
    $certificate = UserRequest::findOrFail($id);
    return view('admin.certificates.show', compact('certificate'));
}

public function process($id)
{
    $certificate = UserRequest::findOrFail($id);
    $data = json_decode($certificate->certificate_data, true) ?? [];
    return view('admin.certificates.process', compact('certificate', 'data'));
}

public function certificate($id)
{
    $certificate = UserRequest::findOrFail($id);
    return view('admin.certificates.certificate', compact('certificate'));
}
}