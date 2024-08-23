<div class="row mt-3">
    <div class="col-md-12">
        <div class="timeline">
            <div class="time-label">
                <span class="bg-red">Activity logs of No. # {{ $doc }}</span>
            </div>
            @foreach ($histories as $key => $hist)
                <div>
                    <i class="fas fa-user bg-green"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fas fa-clock"></i> {{ $hist['date'] }} {{ $hist['time'] }}</span>
                        <h3 class="timeline-header">{{ $hist['user'] }}</h3>
                        <div class="timeline-body">
                            {{ $hist['desc'] }}
                        </div>
                    </div>
                </div>
            @endforeach
            <div>
                <i class="fas fa-clock bg-gray"></i>
            </div>
        </div>
    </div>
</div>
