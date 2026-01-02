<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Jobs\SendNotificationMessage;

class NotificationController extends Controller
{
    /**
     * Show the notification creation form (admin only).
     */
    public function create()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }
        
        $users = User::orderBy('name')->get(['id', 'name', 'email', 'phone', 'telegram_chat_id']);
        return view('admin.notifications.create', compact('users'));
    }

    /**
     * Send a notification.
     */
    public function send(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        $data = $request->validate([
            'channel' => 'required|in:sms,whatsapp,telegram,gekychat,email',
            'user_id' => 'required_without:broadcast|nullable|exists:users,id',
            'broadcast' => 'nullable|boolean',
            'message' => 'required|string|max:2000',
            'subject' => 'nullable|string|max:255',
        ]);

        $channel = $data['channel'];
        $message = $data['message'];
        $subject = $data['subject'] ?? null;
        $count = 0;
        
        // Determine what field to use based on channel
        $needsPhone = in_array($channel, ['sms', 'whatsapp', 'gekychat']);
        $needsTelegram = $channel === 'telegram';
        $needsEmail = $channel === 'email';
        
        if ($request->boolean('broadcast')) {
            $query = User::query();
            
            if ($needsPhone) {
                $query->whereNotNull('phone');
            } elseif ($needsTelegram) {
                $query->whereNotNull('telegram_chat_id');
            } elseif ($needsEmail) {
                $query->whereNotNull('email');
            }
            
            $query->orderBy('id')
                ->chunkById(100, function($chunk) use ($channel, $message, $subject, &$count, $needsPhone, $needsTelegram, $needsEmail) {
                    foreach ($chunk as $user) {
                        $to = null;
                        if ($needsPhone) {
                            $to = $this->formatPhone($user->phone);
                        } elseif ($needsTelegram) {
                            $to = $user->telegram_chat_id;
                        } elseif ($needsEmail) {
                            $to = $user->email;
                        }
                        
                        if (!$to) {
                            continue;
                        }
                        
                        SendNotificationMessage::dispatch($channel, $to, $message, $subject);
                        $count++;
                    }
                });
        } else {
            $user = User::findOrFail($data['user_id']);
            
            if ($needsPhone) {
                $to = $this->formatPhone($user->phone);
                if (!$to) {
                    return back()->with('error', 'User has no phone number');
                }
            } elseif ($needsTelegram) {
                $to = $user->telegram_chat_id;
                if (!$to) {
                    return back()->with('error', 'User has no Telegram chat ID');
                }
            } elseif ($needsEmail) {
                $to = $user->email;
                if (!$to) {
                    return back()->with('error', 'User has no email address');
                }
            }
            
            SendNotificationMessage::dispatch($channel, $to, $message, $subject);
            $count = 1;
        }
        
        return back()->with('success', "Queued {$count} message(s) for delivery.");
    }

    /**
     * Format phone number to E.164 format.
     */
    protected function formatPhone(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }

        // Remove all non-digit characters
        $phone = preg_replace('/\D/', '', $phone);
        
        // If it starts with 0, replace with country code
        if (strpos($phone, '0') === 0) {
            $phone = config('notifications.default_country_code', '233') . substr($phone, 1);
        }
        
        // If it doesn't start with +, add it
        if (strpos($phone, '+') !== 0) {
            $phone = '+' . $phone;
        }
        
        return $phone;
    }
}

