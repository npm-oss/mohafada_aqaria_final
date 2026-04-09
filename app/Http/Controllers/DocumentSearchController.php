<?php

namespace App\Http\Controllers;

use App\Models\DocumentSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentSearchController extends Controller
{
    /**
     * عرض صفحة البحث
     */
    public function index(Request $request)
    {
        $query = DocumentSearch::query();

        if ($request->filled('volume_number')) {
            $query->byVolume($request->volume_number);
        }

        if ($request->filled('publication_number')) {
            $query->byPublication($request->publication_number);
        }

        if ($request->filled('person_nin')) {
            $query->byNin($request->person_nin);
        }

        if ($request->filled('name')) {
            $query->byName($request->name);
        }

        if ($request->filled('person_birthdate')) {
            $query->byBirthdate($request->person_birthdate);
        }

        if ($request->filled('person_birthplace')) {
            $query->byBirthplace($request->person_birthplace);
        }

        if ($request->filled('document_type')) {
            $query->byType($request->document_type);
        }

        $documents = $query->latest()->paginate(20);

        return view('admin.document_searches.index', compact('documents'));
    }

    /**
     * عرض صفحة إضافة وثيقة جديدة
     */
    public function create()
    {
        return view('admin.document_searches.create');
    }

    /**
     * تخزين وثيقة جديدة
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'volume_number' => 'required|string|max:255',
            'publication_number' => 'required|string|max:255',
            'publication_date' => 'nullable|date',
            'document_type' => 'required|string|in:حجز,بيع,هبة,رهن_او_امتياز,تشطيب,عريضة,وثيقة_ناقلة_للملكية',
            'person_nin' => 'nullable|string|max:20',
            'person_lastname' => 'required|string|max:255',
            'person_firstname' => 'required|string|max:255',
            'person_father' => 'required|string|max:255',
            'person_birthdate' => 'nullable|date',
            'person_birthplace' => 'nullable|string|max:255',
            'document_front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'document_back_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('document_front_image')) {
            $validated['document_front_image'] = $request->file('document_front_image')->store('documents/front', 'public');
        }

        if ($request->hasFile('document_back_image')) {
            $validated['document_back_image'] = $request->file('document_back_image')->store('documents/back', 'public');
        }

        DocumentSearch::create($validated);

        return redirect()->route('admin.document_searches.index')->with('success', '✅ تم إضافة الوثيقة بنجاح');
    }

    /**
     * عرض تفاصيل الوثيقة
     */
    public function show($id)
    {
        $document = DocumentSearch::findOrFail($id);
        return view('admin.document_searches.show', compact('document'));
    }

    /**
     * عرض صفحة التعديل
     */
    public function edit($id)
    {
        $document = DocumentSearch::findOrFail($id);
        return view('admin.document_searches.edit', compact('document'));
    }

    /**
     * تحديث الوثيقة
     */
    public function update(Request $request, $id)
    {
        $document = DocumentSearch::findOrFail($id);

        $validated = $request->validate([
            'volume_number' => 'required|string|max:255',
            'publication_number' => 'required|string|max:255',
            'publication_date' => 'nullable|date',
            'document_type' => 'required|string|in:حجز,بيع,هبة,رهن_او_امتياز,تشطيب,عريضة,وثيقة_ناقلة_للملكية',
            'person_nin' => 'nullable|string|max:20',
            'person_lastname' => 'required|string|max:255',
            'person_firstname' => 'required|string|max:255',
            'person_father' => 'required|string|max:255',
            'person_birthdate' => 'nullable|date',
            'person_birthplace' => 'nullable|string|max:255',
            'document_front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'document_back_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('document_front_image')) {
            if ($document->document_front_image) {
                Storage::disk('public')->delete($document->document_front_image);
            }
            $validated['document_front_image'] = $request->file('document_front_image')->store('documents/front', 'public');
        }

        if ($request->hasFile('document_back_image')) {
            if ($document->document_back_image) {
                Storage::disk('public')->delete($document->document_back_image);
            }
            $validated['document_back_image'] = $request->file('document_back_image')->store('documents/back', 'public');
        }

        $document->update($validated);

        return redirect()->route('admin.document_searches.index')->with('success', '✅ تم تحديث الوثيقة بنجاح');
    }

    /**
     * حذف الوثيقة
     */
    public function destroy($id)
    {
        $document = DocumentSearch::findOrFail($id);

        if ($document->document_front_image) {
            Storage::disk('public')->delete($document->document_front_image);
        }
        if ($document->document_back_image) {
            Storage::disk('public')->delete($document->document_back_image);
        }

        $document->delete();

        return redirect()->route('admin.document_searches.index')->with('success', '✅ تم حذف الوثيقة بنجاح');
    }
    function formatArabicDate($date) {
    if (empty($date)) return 'غير متوفر';
    
    try {
        $carbon = \Carbon\Carbon::parse($date);
        
        // أسماء الأشهر بالعربية
        $months = [
            1 => 'جانفي',
            2 => 'فيفري',
            3 => 'مارس',
            4 => 'أفريل',
            5 => 'ماي',
            6 => 'جوان',
            7 => 'جويلية',
            8 => 'أوت',
            9 => 'سبتمبر',
            10 => 'أكتوبر',
            11 => 'نوفمبر',
            12 => 'ديسمبر'
        ];
        
        $day = $carbon->day;
        $month = $months[$carbon->month];
        $year = $carbon->year;
        
        return "$day $month $year";
    } catch (\Exception $e) {
        return $date;
    }
}

function formatArabicDateTime($date) {
    if (empty($date)) return 'غير متوفر';
    
    try {
        $carbon = \Carbon\Carbon::parse($date);
        
        $months = [
            1 => 'جانفي',
            2 => 'فيفري',
            3 => 'مارس',
            4 => 'أفريل',
            5 => 'ماي',
            6 => 'جوان',
            7 => 'جويلية',
            8 => 'أوت',
            9 => 'سبتمبر',
            10 => 'أكتوبر',
            11 => 'نوفمبر',
            12 => 'ديسمبر'
        ];
        
        $day = $carbon->day;
        $month = $months[$carbon->month];
        $year = $carbon->year;
        $time = $carbon->format('H:i');
        
        return "$day $month $year - $time";
    } catch (\Exception $e) {
        return $date;
    }
}
}