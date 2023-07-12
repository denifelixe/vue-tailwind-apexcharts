<script setup>
    import ApexCharts from "vue3-apexcharts";
    import { computed } from 'vue';

    const props = defineProps([
        // Class
        'class',

        // Chart Options
        'xAxis',
        'tooltip',
        'colors',

        // Data Series
        'series',
    ]);


    // Chart Options
    const xAxis = computed(() => {
        if (props.xAxis) {
            return props.xAxis;
        }

        //Example
        return {
            type: 'datetime',
            labels: {
                format: 'dd MMMM yyyy'
            },
            categories: ["2018-08-19", "2018-08-20", "2018-08-21", "2018-08-22", "2018-08-23", "2018-08-24", "2018-08-25"]
        }
    });
    const tooltip = computed(() => {
        if (props.tooltip) {
            return props.tooltip;
        }

        //Example
        return {
            x: {
                format: 'dd MMMM yyyy'
            },
        }
    });
    const colors = computed(() => {
        if (props.colors) {
            return props.colors;
        }

        //Example
        return ['#1BC5BD', '#F64E60'];
    })
    const chartOptions = computed(() => {
        return {
            chart: {
                height: 500,
                type: 'area',
                toolbar: {
                    //zoom out false when chart loads
                    tools: {
                        zoomout: false,
                        //reset icon
                        reset: '<img src="/images/icon/custom-icons/arrows-rotate-solid.svg" />',
                    }
                    
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            legend: {
                itemMargin: {
                    vertical: 50
                }
            },
            xaxis: xAxis.value,
            tooltip: tooltip.value,
            colors: colors.value,
        }
    });

    // Data Series
    const series = computed(() => {
        if (props.series) {
            return props.series;
        }

        //Example
        return [
            {
                name: 'Audiences Registered',
                data: [31, 40, 28, 51, 42, 109, 100]
            }, 
            {
                name: 'Audiences Unregistered',
                data: [11, 32, 45, 32, 34, 52, 41]
            }
        ];
    });
</script>

<template>
    <div :class="class">
        <ApexCharts type="area" height="500" :options="chartOptions" :series="series"></ApexCharts>
    </div>
</template>