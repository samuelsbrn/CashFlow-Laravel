{{-- resources/views/components/form/input.blade.php --}}
@props([
    'label',
    'name',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
])

<div class="space-y-1.5">
  {{-- Label --}}
  <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">
    {{ $label }}
    @if ($required)
      <span class="text-rose-500">*</span>
    @endif
  </label>

  {{-- Input field --}}
  <input
    type="{{ $type }}"
    id="{{ $name }}"
    name="{{ $name }}"
    value="{{ old($name, $value) }}"
    placeholder="{{ $placeholder }}"
    {{ $required ? 'required' : '' }}
    {{ $attributes->merge([
        'class' => 'w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900
                   placeholder-slate-400 shadow-sm
                   focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500
                   transition disabled:opacity-60 disabled:cursor-not-allowed'
    ]) }}
  >

  {{-- Error message --}}
  @error($name)
    <div class="mt-1 flex items-center gap-2 text-xs font-medium text-rose-600 bg-rose-50 border border-rose-100 rounded-md px-3 py-2 animate-fadeIn">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M18 10A8 8 0 11.001 9.999 8 8 0 0118 10zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 001.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
      </svg>
      <span>{{ $message }}</span>
    </div>
  @enderror
</div>

{{-- Animasi kecil --}}
<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-4px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .animate-fadeIn {
    animation: fadeIn .25s ease-out both;
  }
</style>
