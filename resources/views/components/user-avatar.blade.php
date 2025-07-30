@props(['user'])

@if ($user->avatar)
    <img src="{{ $user->avatar }}" alt="{{ $user->first_name }} {{ $user->last_name }}" {{ $attributes->merge(['class' => 'rounded-full object-cover']) }}>
@else
    <span {{ $attributes->merge(['class' => 'bg-gray-200 text-lg text-gray-700 rounded-full w-full h-full flex items-center justify-center font-semibold uppercase']) }}>{{ substr($user->first_name, 0, 1) }}</span>
@endif
