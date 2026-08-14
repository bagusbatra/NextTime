{{-- Single portfolio card — $project: App\Models\Project --}}
@if ($project->status === 'available')
  <a href="{{ route('projects.show', $project->slug) }}" class="porto-card" data-category="{{ $project->category }}">
    <div class="porto-thumb">
      @include('partials.site.mockup', ['type' => $project->mockup_type])
    </div>
    <div class="porto-body">
      <span class="porto-tag">{{ $project->tag }}</span>
      <h3>{{ $project->title }}</h3>
      <p>{{ $project->summary }}</p>
      <span class="porto-mockup-label">✦ Mockup Konsep</span>
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
