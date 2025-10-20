@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#610a08] focus:ring-[#610a08] rounded-md shadow-sm']) }}>
