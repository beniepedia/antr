@props([
    'id' => 'modal-congratulations',
    'title' => 'Congratulations!',
    'message' => 'You have successfully subscribed 🎉<br>You will never miss our updates, latest news, and exclusive offers.',
    'thankYouMessage' => 'Thank you for joining our community!',
    'buttonText' => 'Subscribe',
    'buttonAction' => '#',
    'triggerText' => 'Open modal'
])

<div {{ $attributes->merge(['class' => 'bg-base-200 h-dvh py-8 sm:py-16 lg:py-24']) }}>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center">
            <button
                type="button"
                class="btn btn-primary"
                aria-haspopup="dialog"
                aria-expanded="false"
                aria-controls="{{ $id }}"
                data-overlay="#{{ $id }}"
            >
                {{ $triggerText }}
            </button>
        </div>

        <div
            id="{{ $id }}"
            class="overlay modal overlay-open:opacity-100 overlay-open:duration-300 modal-middle hidden"
            role="dialog"
            tabindex="-1"
        >
            <div class="modal-dialog w-full max-w-145">
                <div class="modal-content">
                    <div class="modal-body relative">
                        <div class="flex flex-col gap-6">
                            <!-- Success Icon -->
                            <div class="flex justify-center">
                                <div class="avatar avatar-placeholder border-primary/30 rounded-full border p-2.5">
                                    <div class="gradient-bg gradient-bg-primary flex size-12 items-center justify-center rounded-full">
                                        <span class="icon-[tabler--check] size-8 text-white"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Header -->
                            <div class="space-y-4 text-center">
                                <h3 class="text-base-content text-2xl font-semibold">{{ $title }}</h3>
                                <p class="text-base-content/80">{!! $message !!}</p>
                            </div>

                            <!-- Thank you message -->
                            <p class="text-base-content text-center font-medium">{{ $thankYouMessage }}</p>

                            <!-- Action Button -->
                            <div class="flex justify-center">
                                <button type="button" class="btn btn-gradient btn-primary btn-lg" 
                                    @if($buttonAction !== '#') onclick="window.location='{{ $buttonAction }}'" @endif>
                                    {{ $buttonText }}
                                </button>
                            </div>
                        </div>
                        <button
                            class="btn btn-circle btn-sm btn-text absolute end-4 top-4"
                            aria-label="Close"
                            data-overlay="#{{ $id }}"
                        >
                            <span class="icon-[tabler--x] text-base-content size-4"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>