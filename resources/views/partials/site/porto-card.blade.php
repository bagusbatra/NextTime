{{-- Single portfolio card — $project: App\Models\Project --}}
@if ($project->status === 'available')
  <a href="{{ route('projects.show', $project->slug) }}" class="porto-card" data-category="{{ $project->category }}">
    <div class="porto-thumb">
      @if ($project->thumbnail_path)
        <img src="{{ asset('storage/'.$project->thumbnail_path) }}" alt="{{ $project->title }}" style="width:100%;height:100%;object-fit:cover">
      @else
        @include('partials.site.mockup', ['type' => $project->mockup_type])
      @endif
    </div>
    <div class="porto-body">
      <span class="porto-tag">{{ $project->tag }}</span>
      <h3>{{ $project->title }}</h3>
      <p>{{ $project->summary }}</p>
      @unless ($project->thumbnail_path)
        <span class="porto-mockup-label">✦ Mockup Konsep</span>
      @endunless
    </div>
  </a>
@else
  <div class="porto-card porto-card--soon" data-category="{{ $project->category }}">
    <div class="porto-thumb porto-thumb--soon">
      <i data-lucide="{{ $project->icon }}"></i>
      <span>Segera Hadir</span>
    </div>
    <div class="porto-body">
      <span class="porto-tag porto-tag--soon">{{ $project->tag }}</span>
      <h3>{{ $project->title }}</h3>
      <p>{{ $project->summary }}</p>
    </div>
  </div>
@endif
