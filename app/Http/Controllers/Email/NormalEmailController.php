<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Jobs\NormalEmailJob;
use App\Models\Email;
use Botble\ACL\Models\User;
use Botble\Member\Models\Member;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class NormalEmailController extends Controller
{
    public function index(Request $request)
    {
        $emails = Email::query()
            ->latest()
            ->when($request->filled('subject'), function (Builder $builder) use ($request) {
                $builder->where('subject', 'LIKE', '%' . $request->subject . '%');
            })->paginate(2);
        return view('emails.normal.index', compact('emails'));
    }

    public function create()
    {

        $emails = \Botble\ACL\Models\User::query()->with(['roles:name'])->select(['id', 'email'])->get()->map(function ($item) {
            $item->role = $item->roles->pluck('name')->first() ?? "default";
            return $item;
        })->groupBy('role')->toArray();
        $members = Member::query()
            ->select(['id', 'first_name', 'last_name', 'email'])
            ->get();
        return view('emails.normal.create', compact('emails','members'));
    }

    public function store(Request $request)
    {
        if ($request->filled('emails')) {
            $request->merge([
                'emails' => collect($request->emails)->mapWithKeys(function ($item, $key) {
                    return [$key => array_filter($item, 'strlen')];
                })->toArray(),
            ]);
        }
        $this->validate($request, [
            'emails' => ['nullable', 'array'],
            'emails.*' => ['nullable', 'array'],
            'emails.*.*' => ['email', 'exists:' . User::class . ',email'],
            'member_emails' => ['nullable', 'array'],
            'member_emails.*' => ['email', 'exists:' . Member::class . ',email'],
            'subject' => ['nullable', 'string'],
            'reply_to' => ['nullable', 'string'],
            'body' => ['required', 'string'],
        ]);
        $request->merge([
            'emails' => collect($request->emails)->flatten()->toArray(),
        ]);
        try {
            return DB::transaction(function () use ($request) {
                /** @var Email $email_obj */
                $email_obj = Email::query()->create([
                    'user_id' => $request->user()->id,
                    'subject' => $request->subject,
                    'reply_to' => $request->reply_to,
                    'body' => $request->body,
                    'mailer' => "smtp",
                ]);
                if ($request->filled('emails') && count($request->emails)){
                    $email_obj->users()->attach(collect($request->emails)->map(function ($email) {
                        return optional(User::query()->select(['id'])->where('email', $email)->first())->id;
                    })->filter(function ($item) {
                        return strlen($item);
                    })->toArray());
                    foreach ($request->emails as $email) {
                        NormalEmailJob::dispatch($email, $request->all());
                    }
                }
                if ($request->filled('member_emails') && count($request->member_emails)){
                    $email_obj->members()->attach(collect($request->member_emails)->map(function ($email) {
                        return optional(Member::query()->select(['id'])->where('email', $email)->first())->id;
                    })->filter(function ($item) {
                        return strlen($item);
                    })->toArray());
                    foreach ($request->member_emails as $email) {
                        NormalEmailJob::dispatch($email, $request->all());
                    }
                }
                return redirect()->route('admin.emails.normal.index');
            });
        } catch (Throwable $e) {
            dd($e);
            return redirect()->back();
        }
    }
}
