Hi, I am Grace Anandita from TGG India 🙏, How can I help you
<div class="chat-actions">
    <button onclick="ChatBot.startOnboarding()">Start Onboarding</button>
    <button onclick="ChatBot.startTechnologySolution()">Technology Solution</button>
    <button onclick="ChatBot.startOtherTalk()">Other Questions</button>
</div>
<hr>

<div class="chat-faq">

    <div class="faq-heading">💬 Frequently Asked Questions</div>

    @foreach ($categories as $category)
        @if ($category->faqs->count())
            <div class="faq-category-group" data-category="{{ $category->id }}">

                <div class="faq-category-title" data-category-id="{{ $category->id }}">
                    <i class="fas fa-folder me-2"></i>
                    {{ $category->title }}

                    <span class="ms-auto">
                        <i class="fas fa-chevron-down category-icon"></i>
                    </span>
                </div>

                <div class="faq-category-body" id="category-body-{{ $category->id }}">

                    @foreach ($category->faqs as $faq)
                        @include('chatbot.chat.partials.faq-item', [
                            'faq' => $faq,
                            'level' => 0,
                        ])
                    @endforeach

                </div>

            </div>
        @endif
    @endforeach


</div>
