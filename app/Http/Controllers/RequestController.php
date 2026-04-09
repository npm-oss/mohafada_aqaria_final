<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\DocumentsRequest;


class RequestController extends Controller
{
    /**
     * البحث عن البطاقة حسب نوع البطاقة وحالة العقار ومعلومات العقار
     */
    public function searchCard(Request $request)
    {
        // 1️⃣ البحث أولاً عن العقار (بدون card_type)
        $propertyQuery = Property::query();

        if ($request->property_status == 'ممسوح') {
            if($request->section) $propertyQuery->where('section', $request->section);
            if($request->municipality) $propertyQuery->where('municipality', $request->municipality);
            if($request->plan_number) $propertyQuery->where('plan_number', $request->plan_number);
            if($request->parcel_number) $propertyQuery->where('parcel_number', $request->parcel_number);
        } elseif ($request->property_status == 'غير ممسوح') {
            if($request->municipality_ns) $propertyQuery->where('municipality_ns', $request->municipality_ns);
            if($request->subdivision_number) $propertyQuery->where('subdivision_number', $request->subdivision_number);
            if($request->parcel_number_ns) $propertyQuery->where('parcel_number_ns', $request->parcel_number_ns);
        }

        $property = $propertyQuery->first();

        if (!$property) {
            return response()->json([
                'success' => false,
                'message' => 'العقار غير موجود'
            ]);
        }

        // 2️⃣ البحث عن البطاقة المختارة ضمن نفس العقار
        $cardQuery = Property::query()
            ->where('property_status', $property->property_status);

        if($property->property_status == 'ممسوح') {
            $cardQuery->where('section', $property->section)
                      ->where('municipality', $property->municipality)
                      ->where('plan_number', $property->plan_number)
                      ->where('parcel_number', $property->parcel_number);
        } else {
            $cardQuery->where('municipality_ns', $property->municipality_ns)
                      ->where('subdivision_number', $property->subdivision_number)
                      ->where('parcel_number_ns', $property->parcel_number_ns);
        }

        // فقط البطاقة المختارة
        if($request->card_type) {
            $cardQuery->where('card_type', $request->card_type);
        }

        $card = $cardQuery->first();

        if (!$card) {
            return response()->json([
                'success' => false,
                'message' => 'هذه البطاقة غير موجودة لهذا العقار'
            ]);
        }

        // ✅ تجهيز بيانات الصورتين
        $cardImage1 = $card->card_image ?? '';
        $cardImage2 = $card->card_image_2 ?? '';

        // إذا لم تكن هناك صورة ثانية محددة، نحاول توليدها تلقائياً
        if (empty($cardImage2) && !empty($cardImage1)) {
            $fileName = basename($cardImage1);
            $nameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            
            // إذا كان ينتهي برقم، نزيده
            if (preg_match('/(\d+)$/', $nameWithoutExt, $matches)) {
                $baseName = preg_replace('/\d+$/', '', $nameWithoutExt);
                $newNum = intval($matches[1]) + 1;
                $cardImage2 = 'images/' . $baseName . $newNum . '.' . $ext;
            } else {
                // نضيف 2 في النهاية
                $cardImage2 = 'images/' . $nameWithoutExt . '2.' . $ext;
            }
        }

        return response()->json([
            'success' => true, 
            'card' => [
                'owner_nin' => $card->owner_nin,
                'owner_firstname' => $card->owner_firstname,
                'owner_lastname' => $card->owner_lastname,
                'owner_father' => $card->owner_father,
                'owner_birthdate' => $card->owner_birthdate,
                'owner_birthplace' => $card->owner_birthplace,
                'property_status' => $card->property_status,
                'card_type' => $card->card_type,
                'section' => $card->section,
                'municipality' => $card->municipality,
                'plan_number' => $card->plan_number,
                'parcel_number' => $card->parcel_number,
                'municipality_ns' => $card->municipality_ns,
                'subdivision_number' => $card->subdivision_number,
                'parcel_number_ns' => $card->parcel_number_ns,
                // ✅ إرجاع الصورتين
                'card_image' => $cardImage1,
                'card_image_2' => $cardImage2,
            ]
        ]);
    }

    /**
     * عرض صفحة معالجة الطلب
     */
    public function process($id)
    {
        $request = DocumentsRequest::findOrFail($id);
        return view('admin.documents.process', compact('request'));
    }

}