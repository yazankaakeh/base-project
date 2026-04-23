<?php

namespace Modules\Core\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Core\app\Http\Requests\ContactUsRequest;
use Modules\Core\app\Models\ContactUs;

class ContactUsController extends Controller
{
    /**
     * Public endpoint — the landing contact form posts here.
     */
    public function submitContactForm(ContactUsRequest $request): RedirectResponse
    {
        ContactUs::query()->create($request->all());

        return redirect()->back()->with('success', trans('core::core.contact_us.submitted'));
    }

    /**
     * Admin — list every submission with filters + stats.
     */
    public function index(Request $request): View
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
        ];

        $query = ContactUs::query();

        if (filled($filters['q'])) {
            $term = '%' . $filters['q'] . '%';
            $query->where(function ($q) use ($term) {
                $q->where('fullName', 'like', $term)
                  ->orWhere('email', 'like', $term)
                  ->orWhere('message', 'like', $term);
            });
        }

        $messages = $query->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total'       => ContactUs::query()->count(),
            'this_week'   => ContactUs::query()->where('created_at', '>=', now()->subWeek())->count(),
            'today'       => ContactUs::query()->whereDate('created_at', today())->count(),
            'unique_from' => ContactUs::query()->distinct('email')->count('email'),
        ];

        return view('core::contact-us.index', compact('messages', 'filters', 'stats'));
    }

    /**
     * Admin — drill-down on a single message.
     */
    public function show(ContactUs $contact): View
    {
        return view('core::contact-us.show', compact('contact'));
    }

    /**
     * Admin — delete a submission.
     */
    public function destroy(ContactUs $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()
            ->route('admin.contact_us.index')
            ->with('success', trans('core::core.contact_us.deleted'));
    }
}
