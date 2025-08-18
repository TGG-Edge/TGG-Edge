    @php
        $user = auth('web2')->user();
        $investmentModules = $user->modules->filter(function ($module) {
            return $module->slug === 'investment' || $module->name === 'investment';
        });
        // Combine all feature objects from all modules into one list
        $features = $user->modules->flatMap->features;
        // Check for specific feature keys
        $hasLiteratures = $features->contains('feature_key', 'literatures');
        $hasLinks = $features->contains('feature_key', 'links');
        $hasVideos = $features->contains('feature_key', 'videos');
    @endphp
    <a href="{{ route('tgg-india.trainer.dashboard') }}"
        class="{{ request()->is('tgg-india/dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>


    @if ($hasLiteratures)
        <a href="{{ route('tgg-india.trainer.sections.index') }}"
            class="{{ request()->is('tgg-india/literature') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Literatures
        </a>
    @endif
    @if ($hasLinks)
        <a href="{{ route('tgg-india.trainer.links.index') }}"
            class="{{ request()->is('tgg-india/links') ? 'active' : '' }}">
            <i class="fas fa-link"></i> Links
        </a>
    @endif

    @if ($hasVideos)
        <a href="{{ route('tgg-india.trainer.videos.index') }}"
            class="{{ request()->is('tgg-india/videos') ? 'active' : '' }}">
            <i class="fas fa-video"></i> Videos
        </a>
    @endif
    @if ($investmentModules)
        <div class="dropdown">
            <a href="#"
                class="dropdown-toggle d-flex justify-content-between align-items-center {{ request()->is('user/research-assistance/*') ? 'active ' : '' }}"
                data-bs-toggle="collapse" data-bs-target="#researchDropdown" aria-expanded="false">
                <span><i class="fas fa-flask"></i> Investment </span>
                <i class="fas fa-caret-down"></i>
            </a>

            <div class="collapse ps-3 {{ request()->is('user/research-assistance/*') ? 'show ' : '' }}"
                id="researchDropdown">


                @if ($hasLiteratures)
                    {{-- Literature Dropdown --}}
                    @foreach ($user->literatures as $literature)
                        <a href="#" class="dropdown-toggle d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" data-bs-target="#literature-{{ $literature->id }}"
                            aria-expanded="false" title="{{ $literature->title }}">
                            <span><i class="fas fa-book"></i> Literature </span>
                            <i class="fas fa-caret-down"></i>
                        </a>
                        @if ($literature->sections && $literature->sections->count() > 0)
                            <div class="collapse ps-3" id="literature-{{ $literature->id }}">

                                {{-- Loop through sections --}}
                                @foreach ($literature->sections as $section)
                                    @if ($section->chapters && $section->chapters->count() > 0)
                                        <a href="#"
                                            class="dropdown-toggle d-flex justify-content-between align-items-center"
                                            data-bs-toggle="collapse" data-bs-target="#section-{{ $section->id }}"
                                            aria-expanded="false" title="{{ $section->title }}">
                                            <span><i class="fas fa-list"></i> Section</span>
                                            <i class="fas fa-caret-down"></i>
                                        </a>

                                        <div class="collapse ps-3" id="section-{{ $section->id }}">
                                            {{-- Loop chapters --}}
                                            @foreach ($section->chapters as $chapter)
                                                <a href="{{ route('tgg-india.trainer.chapters.show', $chapter->id) }}"
                                                    title="{{ $chapter->title }}"><i
                                                        class="fas fa-book"></i>Chapter</a>
                                            @endforeach
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @endif
                @if ($hasLinks)
                    {{-- Links --}}
                    <a href="{{ route('tgg-india.trainer.links.show') }}"><i class="fas fa-link"></i> Links</a>
                @endif
                @if ($hasVideos)
                    {{-- Videos --}}
                    <a href="{{ route('tgg-india.trainer.videos.show') }}"><i class="fas fa-video"></i> Videos</a>
                @endif


            </div>
        </div>
    @endif
