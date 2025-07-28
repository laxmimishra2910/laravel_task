
// ========== Department vs Employees Chart ==========
document.addEventListener("DOMContentLoaded", function () {
    const chartCanvas = document.getElementById('chart');

    if (chartCanvas) {
        const departmentNames = JSON.parse(chartCanvas.dataset.labels || "[]");
        const employeeCounts = JSON.parse(chartCanvas.dataset.values || "[]");

        const deptCtx = chartCanvas.getContext('2d');

        new Chart(deptCtx, {
            type: 'doughnut',
            data: {
                labels: departmentNames,
                datasets: [{
                    label: 'Employees by Department',
                    data: employeeCounts,
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'right' }
                }
            }
        });
    }

    // ========== Project Progress Chart ==========
   const ctx = document.getElementById('projectBarChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Completed', 'In Progress', 'Pending'],
            datasets: [{
                label: 'Project Status',
                data: [
                    window.chartData.completion,
                    window.chartData.process,
                    window.chartData.assigned
                ],
                backgroundColor: ['#4CAF50', '#FFC107', '#2196F3']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});