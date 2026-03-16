<div class="faq-item level-{{ $level }}">

    {{-- Question --}}
    <div class="faq-question" data-id="{{ $faq->id }}">
        <span class="faq-title">
            {{ $faq->title }}
        </span>

        <span class="faq-icon">
            <i class="fas fa-chevron-down"></i>
        </span>
    </div>

    {{-- Answer Section --}}
    <div class="faq-answer" id="faq-answer-{{ $faq->id }}">

        @if($faq->description)
            <div class="faq-content">
                {!! $faq->description !!}
            </div>
        @endif

        {{-- Nested Children FAQs --}}
        @if($faq->children && $faq->children->count())
            <div class="faq-children">
                @foreach($faq->children as $child)
                    @include('chatbot.chat.partials.faq-item', [
                        'faq' => $child,
                        'level' => $level + 1
                    ])
                @endforeach
            </div>
        @endif

    </div>

</div>
