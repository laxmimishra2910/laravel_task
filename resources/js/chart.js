
    document.addEventListener('DOMContentLoaded', () => {
        const data = window.dashboardData;
        const employeeCtx = document.getElementById('employeeChart').getContext('2d');
        const projectCtx = document.getElementById('projectChart').getContext('2d');
        const employeeChartTypeSelector = document.getElementById('employeeChartSelector');
        const projectChartTypeSelector = document.getElementById('projectChartSelector');

        const colors = ['#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#3B82F6'];

        let employeeChart, projectChart;

        function renderEmployeeChart(type = 'bar') {
            if (employeeChart) employeeChart.destroy();
            employeeChart = new Chart(employeeCtx, {
                type,
                data: {
                    labels: data.departmentNames,
                    datasets: [{
                        label: 'Employees',
                        data: data.employeeCounts,
                        backgroundColor: colors,
                        borderColor: '#00000022',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Employees by Department'
                        }
                    },
                    scales: ['bar', 'line'].includes(type) ? {
                        y: { beginAtZero: true }
                    } : {}
                }
            });
        }

        function renderProjectChart(type = 'pie') {
            if (projectChart) projectChart.destroy();
            projectChart = new Chart(projectCtx, {
                type,
                data: {
                    labels: ['Completed', 'In Progress', 'Pending'],
                    datasets: [{
                        label: 'Projects',
                        data: [data.completedProjects, data.inProgressProjects, data.pendingProjects],
                        backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                        borderColor: '#00000022',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Project Status Overview'
                        }
                    },
                    scales: ['bar', 'line'].includes(type) ? {
                        y: { beginAtZero: true }
                    } : {}
                }
            });
        }

        // Initial render
        renderEmployeeChart();
        renderProjectChart();

        // Dynamic chart updates
        employeeChartTypeSelector.addEventListener('change', (e) => {
            renderEmployeeChart(e.target.value);
        });

        projectChartTypeSelector.addEventListener('change', (e) => {
            renderProjectChart(e.target.value);
        });




        
    });

