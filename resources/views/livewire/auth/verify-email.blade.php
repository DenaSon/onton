<div
    x-data="{
        shown: false,
        cooldown: 0,
        startCooldown() {
            this.cooldown = 60
            const interval = setInterval(() => {
                this.cooldown--
                if (this.cooldown <= 0) clearInterval(interval)
            }, 1000)
        }
    }"
    x-intersect.once="shown = true"
    class="flex flex-col items-center justify-center gap-5 py-6 text-center transition-all duration-500"
    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'"
>

    <p class="text-base-content/80 text-sm sm:text-base max-w-xs">
        Didn’t receive the verification email? You can request a new one.
    </p>

    <template x-if="cooldown === 0">
        <x-button
            spinner="resend"
            wire:click="resend"
            x-on:click="startCooldown()"
            class="btn-primary w-full"
            label="Resend Verification Email"
        />
    </template>

    <template x-if="cooldown > 0">
        <button class="btn w-full cursor-not-allowed btn-disabled">
            Please wait <span x-text="cooldown"></span>sec
        </button>
    </template>

</div>
