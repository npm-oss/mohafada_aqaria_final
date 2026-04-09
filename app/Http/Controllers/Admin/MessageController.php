<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    /**
     * عرض قائمة جميع الرسائل
     */
    public function index(Request $request)
    {
        $query = ContactMessage::query()->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by subject
        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * عرض رسالة واحدة بالتفصيل
     */
    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        
        // وضع علامة كـ مقروءة
        if ($message->status === 'new') {
            $message->markAsRead();
        }

        return view('admin.messages.show', compact('message'));
    }

    /**
     * عرض صفحة الرد على الرسالة
     */
    public function replyForm($id)
    {
        $message = ContactMessage::findOrFail($id);
        
        // وضع علامة كـ مقروءة إذا لم تكن
        if ($message->status === 'new') {
            $message->markAsRead();
        }

        return view('admin.messages.reply', compact('message'));
    }

    /**
     * إرسال الرد على الرسالة
     */
    public function sendReply(Request $request, $id)
    {
        $message = ContactMessage::findOrFail($id);

        $validated = $request->validate([
            'reply_message' => 'required|string|max:2000',
        ], [
            'reply_message.required' => 'يجب إدخال نص الرد',
            'reply_message.max' => 'الرد طويل جداً (الحد الأقصى 2000 حرف)',
        ]);

        try {
            // حفظ الرد
            $message->update([
                'status' => 'replied',
                'reply_message' => $request->reply_message,
                'replied_at' => now(),
            ]);

            // إرسال البريد الإلكتروني (اختياري)
             Mail::to($message->email)->send(
    new \App\Mail\MessageReplyMail($message, $request->reply_message)
);

            return redirect()
                ->route('admin.messages.show', $id)
                ->with('success', '✓ تم إرسال الرد بنجاح');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '⚠ حدث خطأ أثناء إرسال الرد: ' . $e->getMessage());
        }
    }

    /**
     * وضع علامة كـ مقروءة
     */
    public function markAsRead($id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            $message->markAsRead();

            return redirect()
                ->back()
                ->with('success', '✓ تم وضع علامة كـ مقروءة');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * وضع علامة كـ غير مقروءة
     */
    public function markAsUnread($id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            
            $message->update([
                'status' => 'new',
            ]);

            return redirect()
                ->back()
                ->with('success', '✓ تم وضع علامة كـ غير مقروءة');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * حذف رسالة
     */
    public function destroy($id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            $message->delete();

            return redirect()
                ->route('admin.messages.index')
                ->with('success', '✓ تم حذف الرسالة بنجاح');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ أثناء الحذف: ' . $e->getMessage());
        }
    }

    /**
     * حذف رسائل متعددة
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:contacts,id',
        ]);

        try {
            ContactMessage::whereIn('id', $request->message_ids)->delete();

            return redirect()
                ->back()
                ->with('success', '✓ تم حذف ' . count($request->message_ids) . ' رسالة بنجاح');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * وضع علامة مقروءة على رسائل متعددة
     */
    public function bulkMarkAsRead(Request $request)
    {
        $validated = $request->validate([
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:contacts,id',
        ]);

        try {
            ContactMessage::whereIn('id', $request->message_ids)
                ->update(['status' => 'read']);

            return redirect()
                ->back()
                ->with('success', '✓ تم وضع علامة مقروءة على ' . count($request->message_ids) . ' رسالة');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * إحصائيات الرسائل
     */
    public function statistics()
    {
        $stats = [
            'total' => ContactMessage::count(),
            'new' => ContactMessage::where('status', 'new')->count(),
            'read' => ContactMessage::where('status', 'read')->count(),
            'replied' => ContactMessage::where('status', 'replied')->count(),
            'closed' => ContactMessage::where('status', 'closed')->count(),
            'today' => ContactMessage::whereDate('created_at', today())->count(),
            'this_week' => ContactMessage::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => ContactMessage::whereMonth('created_at', now()->month)->count(),
            'by_subject' => ContactMessage::selectRaw('subject, COUNT(*) as count')
                ->groupBy('subject')
                ->pluck('count', 'subject')
                ->toArray(),
        ];

        return view('admin.messages.statistics', compact('stats'));
    }

    /**
     * تصدير الرسائل إلى Excel
     */
    public function export()
    {
        // TODO: Implement Excel export
        return redirect()->back()->with('info', 'قريباً: تصدير إلى Excel');
    }

    /**
     * فلترة الرسائل حسب الحالة
     */
    public function filterByStatus($status)
    {
        $messages = ContactMessage::where('status', $status)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * فلترة الرسائل حسب الموضوع
     */
    public function filterBySubject($subject)
    {
        $messages = ContactMessage::where('subject', $subject)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * البحث في الرسائل
     */
    public function search(Request $request)
    {
        $query = ContactMessage::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * إغلاق الرسالة
     */
    public function close($id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            
            $message->update([
                'status' => 'closed',
            ]);

            return redirect()
                ->back()
                ->with('success', '✓ تم إغلاق الرسالة');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * إعادة فتح الرسالة
     */
    public function reopen($id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            
            $message->update([
                'status' => 'read',
            ]);

            return redirect()
                ->back()
                ->with('success', '✓ تم إعادة فتح الرسالة');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', '⚠ حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * طباعة الرسالة
     */
    public function print($id)
    {
        $message = ContactMessage::findOrFail($id);
        return view('admin.messages.print', compact('message'));
    }

    /**
     * الرسائل الجديدة فقط
     */
    public function newMessages()
    {
        $messages = ContactMessage::where('status', 'new')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * الرسائل المقروءة فقط
     */
    public function readMessages()
    {
        $messages = ContactMessage::where('status', 'read')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    /**
     * الرسائل التي تم الرد عليها فقط
     */
    public function repliedMessages()
    {
        $messages = ContactMessage::where('status', 'replied')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }
}