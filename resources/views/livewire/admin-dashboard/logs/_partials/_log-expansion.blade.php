@php
    $props = $log->properties->toArray();

@endphp

@if (empty($props))
    <div class="text-sm text-gray-500 italic">No extra properties.</div>
@else
    <div class="overflow-x-auto">
        <table class="table table-zebra table-sm w-full">
            <thead>
            <tr>
                <th class="text-xs uppercase text-gray-500">Property</th>
                <th class="text-xs uppercase text-gray-500">Value</th>
            </tr>
            </thead>
            <tbody>
            @foreach($props as $key => $value)
                <tr>
                    <td class="font-semibold text-sm text-primary">{{ $key }}</td>
                    <td class="text-sm">
                        @if(is_array($value) || is_object($value))
                            <pre class="bg-base-200 p-2 rounded text-xs text-gray-300">{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                        @else
                            {{ $value }}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
