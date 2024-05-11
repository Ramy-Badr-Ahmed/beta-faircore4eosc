@isset($offline)

    <div wire:offline.class.remove="hidden" class="hidden centered-content text-center" style="width: 45%;">
        <div class="bg-danger" style="color: #35647e; font-size: 16px; font-weight: bolder; padding: 12px; margin-bottom: 20px; border-radius: 12px">
            <span style="letter-spacing: 2px">You're offline. Check your Connection.</span>
        </div>
    </div>

@else

    <div class="alert alert-warning centered-content" style="width: 35%; text-align: center; font-size: 16px; padding: 12px; letter-spacing: 1px; font-weight: bolder; border-radius: 12px">
        {{ $readOnceError }}
    </div>

@endisset




