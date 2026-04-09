<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\LandRegister;
use App\Models\UserRequest; // ✅ إضافة هذا

class LandRegisterController extends Controller
{
    // صفحة طلب جديد
    public function create()
    {
        return view('land-register.create');
    }

    // حفظ طلب جديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'national_id' => 'required|string|size:18|regex:/^\d{18}$/',
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'phone' => 'required|string',
            'email' => 'required|email',
            'wilaya' => 'required|string',
            'commune' => 'required|string',
            'applicant_type' => 'required|string',
            'survey_status' => 'required|in:ممسوح,غير ممسوح',
            
            // حقل العقار الممسوح
            'surveyed_commune' => 'required_if:survey_status,ممسوح|nullable|string',
            'section' => 'required_if:survey_status,ممسوح|nullable|string',
            'parcel_number' => 'required_if:survey_status,ممسوح|nullable|string',
            'surveyed_area' => 'required_if:survey_status,ممسوح|nullable|numeric',
            
            // حقل العقار الغير ممسوح
            'non_surveyed_commune' => 'required_if:survey_status,غير ممسوح|nullable|string',
            'subdivision' => 'required_if:survey_status,غير ممسوح|nullable|string',
            'non_surveyed_section' => 'nullable|string',
            'non_surveyed_parcel_number' => 'nullable|string',
            'non_surveyed_area' => 'nullable|numeric',
            
            'property_type' => 'required|string',
            'request_type' => 'required|string',
            'documents' => 'required|array|min:4',
            'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240'
        ], [
            'national_id.size' => 'رقم التعريف الوطني يجب أن يكون 18 رقماً',
            'documents.min' => 'يجب رفع 4 وثائق على الأقل',
            'surveyed_commune.required_if' => 'بلدية العقار الممسوح مطلوبة',
            'section.required_if' => 'القسم مطلوب للعقار الممسوح',
            'parcel_number.required_if' => 'الرقم مطلوب للعقار الممسوح',
            'non_surveyed_commune.required_if' => 'بلدية العقار الغير ممسوح مطلوبة',
            'subdivision.required_if' => 'التجزئة/الحي مطلوب للعقار الغير ممسوح',
        ]);

        try {
            $documentPaths = [];
            
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $index => $document) {
                    if ($document->isValid()) {
                        $filename = time() . '_' . $index . '_' . uniqid() . '.' . $document->getClientOriginalExtension();
                        $path = $document->storeAs('land-registers', $filename, 'public');
                        
                        if ($path) {
                            $documentPaths[] = [
                                'path' => $path,
                                'original_name' => $document->getClientOriginalName(),
                                'size' => $document->getSize(),
                                'type' => $document->getMimeType()
                            ];
                        }
                    }
                }
            }

            if (count($documentPaths) < 4) {
                throw new \Exception("يجب رفع 4 وثائق على الأقل");
            }

            $registerNumber = 'LR-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $fullName = $validated['last_name'] . ' ' . $validated['first_name'];

            $propertyAddress = '';
            $propertyName = '';
            $propertyNumber = '';

            if ($validated['survey_status'] === 'ممسوح') {
                $propertyAddress = ($validated['surveyed_commune'] ?? '') . ' - القسم: ' . ($validated['section'] ?? '') . ' - رقم: ' . ($validated['parcel_number'] ?? '');
                $propertyName = 'عقار ممسوح - قسم ' . ($validated['section'] ?? '') . ' - رقم ' . ($validated['parcel_number'] ?? '');
                $propertyNumber = $validated['parcel_number'] ?? 'غير محدد';
            } else {
                $propertyAddress = ($validated['non_surveyed_commune'] ?? '') . ' - ' . ($validated['subdivision'] ?? '');
                if (!empty($validated['non_surveyed_section']) || !empty($validated['non_surveyed_parcel_number'])) {
                    $propertyAddress .= ' - قسم: ' . ($validated['non_surveyed_section'] ?? 'غير محدد') . 
                                        ' - رقم: ' . ($validated['non_surveyed_parcel_number'] ?? 'غير محدد');
                }
                $propertyName = 'عقار غير ممسوح - ' . ($validated['subdivision'] ?? 'غير محدد');
                if (!empty($validated['non_surveyed_parcel_number'])) {
                    $propertyNumber = $validated['non_surveyed_parcel_number'];
                } elseif (!empty($validated['non_surveyed_section'])) {
                    $propertyNumber = 'NS-' . $validated['non_surveyed_section'] . '-' . rand(10, 99);
                } else {
                    $propertyNumber = 'NS-' . rand(1000, 9999);
                }
            }

            $landRegister = DB::table('land_registers')->insertGetId([
                'national_id' => $validated['national_id'],
                'last_name' => $validated['last_name'],
                'first_name' => $validated['first_name'],
                'father_name' => $validated['father_name'],
                'birth_date' => $validated['birth_date'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'wilaya' => $validated['wilaya'],
                'commune' => $validated['commune'],
                'applicant_type' => $validated['applicant_type'],
                'survey_status' => $validated['survey_status'],
                'surveyed_commune' => $validated['surveyed_commune'] ?? null,
                'section' => $validated['section'] ?? null,
                'parcel_number' => $validated['parcel_number'] ?? null,
                'surveyed_area' => $validated['surveyed_area'] ?? null,
                'non_surveyed_commune' => $validated['non_surveyed_commune'] ?? null,
                'subdivision' => $validated['subdivision'] ?? null,
                'non_surveyed_section' => $validated['non_surveyed_section'] ?? null,
                'non_surveyed_parcel_number' => $validated['non_surveyed_parcel_number'] ?? null,
                'non_surveyed_area' => $validated['non_surveyed_area'] ?? null,
                'property_type' => $validated['property_type'],
                'request_type' => $validated['request_type'],
                'property_number' => $propertyNumber,
                'property_name' => $propertyName,
                'property_address' => $propertyAddress,
                'register_number' => $registerNumber,
                'full_name' => $fullName,
                'documents' => json_encode($documentPaths),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()
                ->route('land.register.create')
                ->with('success', '✅ تم تقديم طلبك بنجاح! رقم الطلب: #' . $landRegister . ' | رقم الدفتر: ' . $registerNumber);

        } catch (\Exception $e) {
            if (!empty($documentPaths)) {
                foreach ($documentPaths as $doc) {
                    Storage::disk('public')->delete($doc['path']);
                }
            }
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '❌ حدث خطأ: ' . $e->getMessage());
        }
    }

    // صفحة طلب نسخة
    public function createCopy()
    {
        return view('land-register.copy');
    }

    // حفظ طلب نسخة
    public function storeCopy(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'national_id' => 'required|string|size:18',
            'phone' => 'required|string',
            'email' => 'required|email',
            'section' => 'required|string',
            'property_group' => 'required|string',
            'register_number' => 'nullable|string',
            'request_reason' => 'required|string',
            'other_reason' => 'nullable|string'
        ], [
            'full_name.required' => 'الاسم الكامل مطلوب',
            'national_id.size' => 'رقم التعريف الوطني يجب أن يكون 18 رقماً',
            'property_group.required' => 'رقم مجموعة الملكية مطلوب',
            'request_reason.required' => 'سبب الطلب مطلوب'
        ]);

        try {
            $nameParts = explode(' ', $validated['full_name'], 2);
            $lastName = $nameParts[0] ?? '';
            $firstName = $nameParts[1] ?? '';

            $registerNumber = $validated['register_number'] ?? ('COPY-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT));
            
            $reason = $validated['request_reason'];
            if ($reason === 'أخرى' && !empty($validated['other_reason'])) {
                $reason = $validated['other_reason'];
            }

            $landRegister = DB::table('land_registers')->insertGetId([
                'national_id' => $validated['national_id'],
                'last_name' => $lastName,
                'first_name' => $firstName,
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'section' => $validated['section'],
                'property_group' => $validated['property_group'],
                'register_number' => $registerNumber,
                'property_number' => $validated['property_group'],
                'property_name' => 'طلب نسخة - مجموعة ' . $validated['property_group'],
                'request_type' => 'نسخة دفتر',
                'admin_notes' => 'سبب الطلب: ' . $reason,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()
                ->route('land.register.copy')
                ->with('success', '✅ تم تقديم طلبك بنجاح! رقم الطلب: #' . $landRegister);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '❌ حدث خطأ: ' . $e->getMessage());
        }
    }

    // صفحة معالجة يدوية
    public function manualProcess(LandRegister $register)
    {
        return view('admin.land-registers.manual-process', compact('register'));
    }

    // ✅ إضافة الدالة المفقودة processCopyView
    public function processCopyView($id)
    {
        $register = LandRegister::findOrFail($id);
        return view('admin.land-registers.process-copy', compact('register'));
    }
    
    // ═══════════════════════════════════════════════════════════
    // 📱 API Methods (لـ Flutter)
    // ═══════════════════════════════════════════════════════════

    /**
     * استقبال طلب إنشاء دفتر عقاري من Flutter
     */
    public function apiStore(Request $request)
    {
        try {
            // قواعد التحقق
            $validator = Validator::make($request->all(), [
                'national_id' => 'required|string|size:18|regex:/^\d{18}$/',
                'last_name' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'father_name' => 'required|string|max:255',
              'birth_date' => 'required|date_format:Y-m-d', // ✅ تحديد الصيغة
                'phone' => 'required|string',
                'email' => 'required|email',
                'wilaya' => 'required|string',
                'commune' => 'required|string',
                'applicant_type' => 'required|string|in:مالك,وارث,وكيل',
                'survey_status' => 'required|in:ممسوح,غير ممسوح',
                
                // حقول العقار الممسوح
                'surveyed_commune' => 'required_if:survey_status,ممسوح|nullable|string',
                'section' => 'required_if:survey_status,ممسوح|nullable|string',
                'parcel_number' => 'required_if:survey_status,ممسوح|nullable|string',
                'surveyed_area' => 'required_if:survey_status,ممسوح|nullable|numeric',
                
                // حقول العقار غير الممسوح
                'non_surveyed_commune' => 'required_if:survey_status,غير ممسوح|nullable|string',
                'subdivision' => 'required_if:survey_status,غير ممسوح|nullable|string',
                'non_surveyed_section' => 'nullable|string',
                'non_surveyed_parcel_number' => 'nullable|string',
                'non_surveyed_area' => 'nullable|numeric',
                
                'property_type' => 'required|string',
                'request_type' => 'required|string|in:طلب جديد,نسخة دفتر',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطأ في البيانات المدخلة',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // إنشاء رقم الدفتر
            $registerNumber = 'LR-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $fullName = $request->last_name . ' ' . $request->first_name;

            // بناء عنوان العقار
            $propertyAddress = '';
            $propertyName = '';
            $propertyNumber = '';

            if ($request->survey_status === 'ممسوح') {
                $propertyAddress = ($request->surveyed_commune ?? '') . ' - القسم: ' . ($request->section ?? '') . ' - رقم: ' . ($request->parcel_number ?? '');
                $propertyName = 'عقار ممسوح - قسم ' . ($request->section ?? '') . ' - رقم ' . ($request->parcel_number ?? '');
                $propertyNumber = $request->parcel_number ?? 'غير محدد';
            } else {
                $propertyAddress = ($request->non_surveyed_commune ?? '') . ' - ' . ($request->subdivision ?? '');
                if (!empty($request->non_surveyed_section) || !empty($request->non_surveyed_parcel_number)) {
                    $propertyAddress .= ' - قسم: ' . ($request->non_surveyed_section ?? 'غير محدد') . 
                                        ' - رقم: ' . ($request->non_surveyed_parcel_number ?? 'غير محدد');
                }
                $propertyName = 'عقار غير ممسوح - ' . ($request->subdivision ?? 'غير محدد');
                if (!empty($request->non_surveyed_parcel_number)) {
                    $propertyNumber = $request->non_surveyed_parcel_number;
                } elseif (!empty($request->non_surveyed_section)) {
                    $propertyNumber = 'NS-' . $request->non_surveyed_section . '-' . rand(10, 99);
                } else {
                    $propertyNumber = 'NS-' . rand(1000, 9999);
                }
            }

            // إنشاء السجل
            $landRegister = LandRegister::create([
                'national_id' => $request->national_id,
                'last_name' => $request->last_name,
                'first_name' => $request->first_name,
                'father_name' => $request->father_name,
                'full_name' => $fullName,
                'birth_date' => $request->birth_date,
                'phone' => $request->phone,
                'email' => $request->email,
                'wilaya' => $request->wilaya,
                'commune' => $request->commune,
                'applicant_type' => $request->applicant_type,
                'survey_status' => $request->survey_status,
                'surveyed_commune' => $request->surveyed_commune,
                'section' => $request->section,
                'parcel_number' => $request->parcel_number,
                'surveyed_area' => $request->surveyed_area,
                'non_surveyed_commune' => $request->non_surveyed_commune,
                'subdivision' => $request->subdivision,
                'non_surveyed_section' => $request->non_surveyed_section,
                'non_surveyed_parcel_number' => $request->non_surveyed_parcel_number,
                'non_surveyed_area' => $request->non_surveyed_area,
                'property_type' => $request->property_type,
                'request_type' => $request->request_type,
                'property_number' => $propertyNumber,
                'property_name' => $propertyName,
                'property_address' => $propertyAddress,
                'register_number' => $registerNumber,
                'status' => 'pending',
                'documents' => json_encode([]) // الملفات ستضاف لاحقاً
            ]);

            // ✅ حفظ في جدول user_requests (ربط مع المستخدم)
            if (auth()->check()) {
                UserRequest::create([
                    'user_id' => auth()->id(),
                    'type' => 'property_book',
                    'status' => 'pending',
                    'data' => json_encode($landRegister->toArray())
                ]);
                
                Log::info('✅ تم حفظ طلب الدفتر العقاري في user_requests للمستخدم ' . auth()->id());
            } else {
                Log::warning('⚠️ المستخدم غير مسجل دخول، لم يتم حفظ طلب الدفتر العقاري في user_requests');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم تقديم طلب إنشاء دفتر عقاري بنجاح',
                'register' => $landRegister,
                'register_id' => $landRegister->id,
                'register_number' => $landRegister->register_number
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('🔥 خطأ في حفظ طلب الدفتر العقاري: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * استقبال طلب نسخة دفتر عقاري من Flutter
     */
    public function apiStoreCopy(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string|max:255',
                'national_id' => 'required|string|size:18|regex:/^\d{18}$/',
                'phone' => 'required|string',
                'email' => 'required|email',
                'section' => 'required|string',
                'property_group' => 'required|string',
                'register_number' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطأ في البيانات المدخلة',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $nameParts = explode(' ', $request->full_name, 2);
            $lastName = $nameParts[0] ?? '';
            $firstName = $nameParts[1] ?? '';

            $registerNumber = $request->register_number ?? ('COPY-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT));

            $landRegister = LandRegister::create([
                'national_id' => $request->national_id,
                'last_name' => $lastName,
                'first_name' => $firstName,
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'section' => $request->section,
                'property_group' => $request->property_group,
                'register_number' => $registerNumber,
                'property_number' => $request->property_group,
                'property_name' => 'طلب نسخة - مجموعة ' . $request->property_group,
                'request_type' => 'نسخة دفتر',
                'status' => 'pending'
            ]);

            // ✅ حفظ في جدول user_requests (ربط مع المستخدم)
            if (auth()->check()) {
                UserRequest::create([
                    'user_id' => auth()->id(),
                    'type' => 'property_book_copy',
                    'status' => 'pending',
                    'data' => json_encode($landRegister->toArray())
                ]);
                
                Log::info('✅ تم حفظ طلب نسخة الدفتر العقاري في user_requests للمستخدم ' . auth()->id());
            } else {
                Log::warning('⚠️ المستخدم غير مسجل دخول، لم يتم حفظ طلب نسخة الدفتر العقاري في user_requests');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم تقديم طلب نسخة دفتر عقاري بنجاح',
                'register_id' => $landRegister->id,
                'register_number' => $landRegister->register_number
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('🔥 خطأ في حفظ طلب نسخة الدفتر العقاري: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }

    public function apiStoreWithFiles(Request $request)
    {
        try {
            // قواعد التحقق
            $validator = Validator::make($request->all(), [
                'national_id' => 'required|string|size:18|regex:/^\d{18}$/',
                'last_name' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'father_name' => 'required|string|max:255',
                'birth_date' => 'required|date',
                'phone' => 'required|string',
                'email' => 'required|email',
                'wilaya' => 'required|string',
                'commune' => 'required|string',
                'applicant_type' => 'required|string|in:مالك,وارث,وكيل',
                'survey_status' => 'required|in:ممسوح,غير ممسوح',
                'surveyed_commune' => 'required_if:survey_status,ممسوح|nullable|string',
                'section' => 'required_if:survey_status,ممسوح|nullable|string',
                'parcel_number' => 'required_if:survey_status,ممسوح|nullable|string',
                'surveyed_area' => 'required_if:survey_status,ممسوح|nullable|numeric',
                'non_surveyed_commune' => 'required_if:survey_status,غير ممسوح|nullable|string',
                'subdivision' => 'required_if:survey_status,غير ممسوح|nullable|string',
                'property_type' => 'required|string',
                'request_type' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطأ في البيانات المدخلة',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            // معالجة الملفات
            $documentPaths = [];
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $index => $document) {
                    if ($document->isValid()) {
                        $filename = time() . '_' . $index . '_' . uniqid() . '.' . $document->getClientOriginalExtension();
                        $path = $document->storeAs('land-registers', $filename, 'public');
                        
                        if ($path) {
                            $documentPaths[] = [
                                'path' => $path,
                                'original_name' => $document->getClientOriginalName(),
                                'size' => $document->getSize(),
                                'type' => $document->getMimeType()
                            ];
                        }
                    }
                }
            }

            // إنشاء رقم الدفتر
            $registerNumber = 'LR-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $fullName = $request->last_name . ' ' . $request->first_name;

            // بناء عنوان العقار
            $propertyAddress = '';
            $propertyName = '';
            $propertyNumber = '';

            if ($request->survey_status === 'ممسوح') {
                $propertyAddress = ($request->surveyed_commune ?? '') . ' - القسم: ' . ($request->section ?? '') . ' - رقم: ' . ($request->parcel_number ?? '');
                $propertyName = 'عقار ممسوح - قسم ' . ($request->section ?? '') . ' - رقم ' . ($request->parcel_number ?? '');
                $propertyNumber = $request->parcel_number ?? 'غير محدد';
            } else {
                $propertyAddress = ($request->non_surveyed_commune ?? '') . ' - ' . ($request->subdivision ?? '');
                $propertyName = 'عقار غير ممسوح - ' . ($request->subdivision ?? 'غير محدد');
                $propertyNumber = 'NS-' . rand(1000, 9999);
            }

            // إنشاء السجل
            $landRegister = LandRegister::create([
                'national_id' => $request->national_id,
                'last_name' => $request->last_name,
                'first_name' => $request->first_name,
                'father_name' => $request->father_name,
                'full_name' => $fullName,
                'birth_date' => $request->birth_date,
                'phone' => $request->phone,
                'email' => $request->email,
                'wilaya' => $request->wilaya,
                'commune' => $request->commune,
                'applicant_type' => $request->applicant_type,
                'survey_status' => $request->survey_status,
                'surveyed_commune' => $request->surveyed_commune,
                'section' => $request->section,
                'parcel_number' => $request->parcel_number,
                'surveyed_area' => $request->surveyed_area,
                'non_surveyed_commune' => $request->non_surveyed_commune,
                'subdivision' => $request->subdivision,
                'non_surveyed_section' => $request->non_surveyed_section ?? null,
                'non_surveyed_parcel_number' => $request->non_surveyed_parcel_number ?? null,
                'non_surveyed_area' => $request->non_surveyed_area ?? null,
                'property_type' => $request->property_type,
                'request_type' => $request->request_type,
                'property_number' => $propertyNumber,
                'property_name' => $propertyName,
                'property_address' => $propertyAddress,
                'register_number' => $registerNumber,
                'status' => 'pending',
                'documents' => json_encode($documentPaths),
            ]);

            // ✅ حفظ في جدول user_requests (ربط مع المستخدم)
            if (auth()->check()) {
                UserRequest::create([
                    'user_id' => auth()->id(),
                    'type' => 'property_book_with_files',
                    'status' => 'pending',
                    'data' => json_encode($landRegister->toArray())
                ]);
                
                Log::info('✅ تم حفظ طلب الدفتر العقاري مع الملفات في user_requests للمستخدم ' . auth()->id());
            } else {
                Log::warning('⚠️ المستخدم غير مسجل دخول، لم يتم حفظ طلب الدفتر العقاري في user_requests');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم تقديم طلب إنشاء دفتر عقاري بنجاح',
                'register_id' => $landRegister->id,
                'register_number' => $landRegister->register_number
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('🔥 خطأ في حفظ طلب الدفتر العقاري مع الملفات: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }
}