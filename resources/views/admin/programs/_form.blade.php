<div>
    <label class="block text-sm font-medium mb-1">Title *</label>
    <input type="text" name="title" value="{{ old('title', $program->title ?? '') }}" required class="w-full border rounded-lg px-3 py-2">
</div>
<div>
    <label class="block text-sm font-medium mb-1">Category *</label>
    <select name="category" required class="w-full border rounded-lg px-3 py-2">
        @foreach(['kindergarten','mechanics','tailoring','workshop','event','other'] as $cat)
            <option value="{{ $cat }}" @selected(old('category', $program->category ?? '')==$cat)>{{ ucfirst($cat) }}</option>
        @endforeach
    </select>
</div>
<div>
    <label class="block text-sm font-medium mb-1">Description *</label>
    <textarea name="description" rows="5" required class="w-full border rounded-lg px-3 py-2">{{ old('description', $program->description ?? '') }}</textarea>
</div>
<div>
    <label class="block text-sm font-medium mb-1">Eligibility</label>
    <textarea name="eligibility" rows="2" class="w-full border rounded-lg px-3 py-2">{{ old('eligibility', $program->eligibility ?? '') }}</textarea>
</div>
<div>
    <label class="block text-sm font-medium mb-1">Location</label>
    <input type="text" name="location" value="{{ old('location', $program->location ?? '') }}" class="w-full border rounded-lg px-3 py-2">
</div>
<div class="grid sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Start date</label>
        <input type="date" name="start_date" value="{{ old('start_date', isset($program) && $program->start_date ? $program->start_date->format('Y-m-d') : '') }}" class="w-full border rounded-lg px-3 py-2">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">End date</label>
        <input type="date" name="end_date" value="{{ old('end_date', isset($program) && $program->end_date ? $program->end_date->format('Y-m-d') : '') }}" class="w-full border rounded-lg px-3 py-2">
    </div>
</div>
<div>
    <label class="block text-sm font-medium mb-1">Capacity</label>
    <input type="number" name="capacity" value="{{ old('capacity', $program->capacity ?? '') }}" min="1" class="w-full border rounded-lg px-3 py-2">
</div>
<div>
    <label class="block text-sm font-medium mb-1">Status *</label>
    <select name="status" required class="w-full border rounded-lg px-3 py-2">
        @foreach(['draft','published','closed','archived'] as $s)
            <option value="{{ $s }}" @selected(old('status', $program->status ?? 'draft')==$s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
</div>
<div class="flex items-center gap-2">
    <input type="checkbox" name="is_open_for_registration" value="1" id="openreg" @checked(old('is_open_for_registration', $program->is_open_for_registration ?? true))>
    <label for="openreg" class="text-sm">Open for registration</label>
</div>
