<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $blackTask->email ?? '') }}" required>
</div>
<div class="form-group">
    <label for="workplace">Workplace</label>
    <input type="text" name="workplace" class="form-control" value="{{ old('workplace', $blackTask->workplace ?? '') }}" required>
</div>
<div class="form-group">
    <label for="directorate">Directorate</label>
    <input type="text" name="directorate" class="form-control" value="{{ old('directorate', $blackTask->directorate ?? '') }}" required>
</div>
<div class="form-group">
    <label for="month">Month</label>
    <input type="text" name="month" class="form-control" value="{{ old('month', $blackTask->month ?? '') }}" required>
</div>
<div class="form-group">
    <label for="week">Week</label>
    <input type="text" name="week" class="form-control" value="{{ old('week', $blackTask->week ?? '') }}" required>
</div>
<div class="form-group">
    <label for="day">Day</label>
    <input type="text" name="day" class="form-control" value="{{ old('day', $blackTask->day ?? '') }}" required>
</div>
<div class="form-group">
    <label for="work_mode">Work Mode</label>
    <select name="work_mode" class="form-control" required>
        <option value="Remotely" {{ (old('work_mode', $blackTask->work_mode ?? '') == 'Remotely') ? 'selected' : '' }}>Remotely</option>
        <option value="Onsite" {{ (old('work_mode', $blackTask->work_mode ?? '') == 'Onsite') ? 'selected' : '' }}>Onsite</option>
        <option value="Combo" {{ (old('work_mode', $blackTask->work_mode ?? '') == 'Combo') ? 'selected' : '' }}>Combo</option>
    </select>
</div>
<div class="form-group">
    <label for="staff_username">Staff Username</label>
    <input type="text" name="staff_username" class="form-control" value="{{ old('staff_username', $blackTask->staff_username ?? '') }}" required>
</div>
<div class="form-group">
    <label for="availability_times">Availability Times</label>
    <textarea name="availability_times" class="form-control" required>{{ old('availability_times', isset($blackTask->availability_times) ? implode(', ', $blackTask->availability_times) : '') }}</textarea>
</div>
<div class="form-group">
    <label for="note_to_superior">Note to Superior</label>
    <textarea name="note_to_superior" class="form-control">{{ old('note_to_superior', $blackTask->note_to_superior ?? '') }}</textarea>
</div>
