@extends('layouts.admin-dashboard')

@section('page-title', 'Send Notification')
@section('page-description', 'Send notifications via SMS, WhatsApp, Telegram, GekyChat, or Email')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.notifications.send') }}" class="space-y-6">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="channel" class="form-label">
                    Channel <span class="text-danger">*</span>
                </label>
                <select name="channel" id="channel" class="form-control" required>
                    <option value="">-- Select Channel --</option>
                    <option value="sms">SMS</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="telegram">Telegram</option>
                    <option value="gekychat">GekyChat</option>
                    <option value="email">Email</option>
                </select>
                @error('channel')
                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="user_id" class="form-label">
                    User (leave blank to broadcast)
                </label>
                <select name="user_id" id="user_id" class="form-control">
                    <option value="">-- Select User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" 
                                data-phone="{{ $user->phone ?? '' }}" 
                                data-email="{{ $user->email ?? '' }}"
                                data-telegram="{{ $user->telegram_chat_id ?? '' }}">
                            {{ $user->name }}
                            @if($user->phone) ({{ $user->phone }}) @endif
                            @if($user->email) [{{ $user->email }}] @endif
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="broadcast" value="1" id="broadcast" class="form-check-input">
                <label class="form-check-label" for="broadcast">
                    Broadcast to all users
                </label>
            </div>
            <small class="form-text text-muted">When enabled, the message will be sent to all users who have the required contact information for the selected channel.</small>
        </div>

        <div class="mb-3" id="emailSubjectField" style="display: none;">
            <label for="subject" class="form-label">Email Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" placeholder="Notification from {{ config('app.name') }}">
            @error('subject')
                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label for="templateSelect" class="form-label">Quick Templates (optional)</label>
            <select id="templateSelect" class="form-control mb-2">
                <option value="">-- Choose a template (optional) --</option>
                <option value="Hello {{ '{{' }}username}}, welcome to {{ config('app.name') }}! We're excited to have you on board.">Welcome Message</option>
                <option value="Hi {{ '{{' }}username}}, your account has been updated on {{ config('app.name') }}!">Account Update</option>
                <option value="Dear {{ '{{' }}username}}, thank you for using {{ config('app.name') }}. We have an important announcement.">Important Announcement</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">
                Message <span class="text-danger">*</span>
            </label>
            <textarea 
                name="message" 
                id="message" 
                rows="6" 
                class="form-control" 
                placeholder="Enter your notification message here..."
                required
                maxlength="2000"
            >{{ old('message') }}</textarea>
            <small class="form-text text-muted">
                <span id="charCount">0</span> / 2000 characters
            </small>
            @error('message')
                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i> Send Notification
            </button>
            <a href="{{ route('admin-dashboard') }}" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const channelSelect = document.getElementById('channel');
    const emailSubjectField = document.getElementById('emailSubjectField');
    const messageTextarea = document.getElementById('message');
    const templateSelect = document.getElementById('templateSelect');
    const charCount = document.getElementById('charCount');
    const broadcastCheckbox = document.getElementById('broadcast');
    const userIdSelect = document.getElementById('user_id');

    // Show/hide email subject field based on channel
    if (channelSelect && emailSubjectField) {
        function toggleEmailSubject() {
            emailSubjectField.style.display = channelSelect.value === 'email' ? 'block' : 'none';
        }
        channelSelect.addEventListener('change', toggleEmailSubject);
        toggleEmailSubject();
    }

    // Character counter
    if (messageTextarea && charCount) {
        function updateCharCount() {
            charCount.textContent = messageTextarea.value.length;
        }
        messageTextarea.addEventListener('input', updateCharCount);
        updateCharCount();
    }

    // Template selection
    if (templateSelect && messageTextarea) {
        templateSelect.addEventListener('change', function() {
            const selected = this.value;
            if (selected) {
                const selectedUser = userIdSelect.options[userIdSelect.selectedIndex];
                let username = 'user';
                if (selectedUser && selectedUser.value) {
                    username = selectedUser.text.split('(')[0].trim().split('[')[0].trim();
                }
                messageTextarea.value = selected.replace(/\{\{username\}\}/g, username);
                if (charCount) {
                    charCount.textContent = messageTextarea.value.length;
                }
            }
        });
    }

    // Disable user selection when broadcast is checked
    if (broadcastCheckbox && userIdSelect) {
        broadcastCheckbox.addEventListener('change', function() {
            userIdSelect.disabled = this.checked;
            if (this.checked) {
                userIdSelect.value = '';
            }
        });
    }
});
</script>
@endsection

