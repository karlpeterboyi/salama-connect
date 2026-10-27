<div class="grid sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">First name *</label>
        <input type="text" name="first_name" value="{{ old('first_name', $child->first_name ?? '') }}" required class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Last name</label>
        <input type="text" name="last_name" value="{{ old('last_name', $child->last_name ?? '') }}" class="w-full border rounded-lg px-3 py-2">
    </div>
</div>
<div class="grid sm:grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Date of birth</label>
        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', isset($child) && $child->date_of_birth ? $child->date_of_birth->format('Y-m-d') : '') }}" class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Age</label>
        <input type="number" name="age" value="{{ old('age', $child->age ?? '') }}" min="0" max="25" class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Gender</label>
        <select name="gender" class="w-full border rounded-lg px-3 py-2">
            <option value="">—</option>
            @foreach(['male','female','other'] as $g)
                <option value="{{ $g }}" @selected(old('gender', $child->gender ?? '')==$g)>{{ ucfirst($g) }}</option>
            @endforeach
        </select>
    </div>
</div>
<div>
    <label class="block text-sm font-medium mb-1">Program</label>
    <select name="program_id" class="w-full border rounded-lg px-3 py-2">
        <option value="">— None —</option>
        @foreach($programs as $prog)
            <option value="{{ $prog->id }}" @selected(old('program_id', $child->program_id ?? '')==$prog->id)>{{ $prog->title }}</option>
        @endforeach
    </select>
</div>
<div class="grid sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Guardian name</label>
        <input type="text" name="guardian_name" value="{{ old('guardian_name', $child->guardian_name ?? '') }}" class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Guardian phone</label>
        <input type="text" name="guardian_phone" value="{{ old('guardian_phone', $child->guardian_phone ?? '') }}" class="w-full border rounded-lg px-3 py-2">
    </div>
</div>
<div>
    <label class="block text-sm font-medium mb-1">Relationship to child</label>
    <input type="text" name="guardian_relationship" value="{{ old('guardian_relationship', $child->guardian_relationship ?? '') }}" placeholder="e.g. mother, uncle" class="w-full border rounded-lg px-3 py-2">
</div>
<div>
    <label class="block text-sm font-medium mb-1">Admission date</label>
    <input type="date" name="admission_date" value="{{ old('admission_date', isset($child) && $child->admission_date ? $child->admission_date->format('Y-m-d') : '') }}" class="w-full border rounded-lg px-3 py-2">
</div>
<div>
    <label class="block text-sm font-medium mb-1">Status *</label>
    <select name="status" required class="w-full border rounded-lg px-3 py-2">
        @foreach(['active','graduated','left','inactive'] as $s)
            <option value="{{ $s }}" @selected(old('status', $child->status ?? 'active')==$s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
</div>
<div>
    <label class="block text-sm font-medium mb-1">Notes</label>
    <textarea name="notes" rows="3" class="w-full border rounded-lg px-3 py-2">{{ old('notes', $child->notes ?? '') }}</textarea>
</div>
