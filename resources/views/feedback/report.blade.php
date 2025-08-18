<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container mt-5">
        <h2 class="text-center mb-4"><u>Feedback Summary</u></h2>
        <div class="text-center mb-3">
            <a href="{{ route('feedback.index') }}" class="btn btn-secondary">Back</a>
        </div>

        @if($report->count())
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <ul class="list-group mb-4">
                        @foreach($report as $rating => $count)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $rating }}
                                <span class="badge bg-primary rounded-pill">{{ $count }} feedback(s)</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Chart Box -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg p-4 text-center">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Feedback Ratings</h4>
                            <select id="feedbackChartSelector" class="form-select w-auto">
                                <option value="doughnut">Doughnut</option>
                                <option value="pie">Pie</option>
                                <option value="bar">Bar</option>
                                <option value="line">Line</option>
                            </select>
                        </div>
                        <div style="height: 400px;">
                            <canvas id="feedbackChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <p class="text-center">No feedback data to show.</p>
        @endif
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const feedbackData = @json($report->toArray());

        const ctx = document.getElementById('feedbackChart').getContext('2d');
        let chartType = 'doughnut';
        let feedbackChart = new Chart(ctx, {
            type: chartType,
            data: {
                labels: Object.keys(feedbackData),
                datasets: [{
                    label: 'Feedback Count',
                    data: Object.values(feedbackData),
                    backgroundColor: [
                        '#4e79a7', '#f28e2b', '#e15759',
                        '#76b7b2', '#59a14f', '#edc949'
                    ],
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                }
            }
        });

        // Chart Selector
        document.getElementById('feedbackChartSelector').addEventListener('change', function () {
            const newType = this.value;
            feedbackChart.destroy();
            feedbackChart = new Chart(ctx, {
                type: newType,
                data: {
                    labels: Object.keys(feedbackData),
                    datasets: [{
                        label: 'Feedback Count',
                        data: Object.values(feedbackData),
                        backgroundColor: [
                            '#4e79a7', '#f28e2b', '#e15759',
                            '#76b7b2', '#59a14f', '#edc949'
                        ],
                        borderColor: '#333',
                        fill: false,
                        tension: 0.3, // for smooth line
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'top' } }
                }
            });
        });
    </script>
</x-app-layout>
