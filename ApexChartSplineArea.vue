<script setup>
    import ApexCharts from "vue3-apexcharts";
    import { computed } from 'vue';

    const props = defineProps([
        // Chart Options
        'xAxis',
        'tooltip',

        // Data Series
        'series'
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
    const chartOptions = {
        chart: {
            height: 350,
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
        xaxis: xAxis.value,
        tooltip: tooltip.value,
    };

    // Data Series
    const seriesData = computed(() => {
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
    const series = seriesData.value;
</script>

<template>
    <ApexCharts type="area" height="350" :options="chartOptions" :series="series"></ApexCharts>
</template>