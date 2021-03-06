<template>
    <div class="chart-wrapper mb-30">
        <h2>{{ title_capitalized }}</h2>
        <template v-if="fetched">
            <h3>Total {{ title }}: {{ Object.values(chart_data).reduce((x, y) => x + y) }}</h3>
            <div class="relative">
                <canvas :id="id" class="chart-canvas mt-10 mb-10" height="250"></canvas>
            </div>
        </template>
        <h3 v-else class="intermittent mt-15">Fetching data...</h3>
    </div>
</template>

<script>
export default {
    props: {
        props: {
            type: Object
        }
    },
    data() {
        let { title, chart_data } = this.props;
        return {
            id: this._uid,
            title: title,
            title_capitalized: title.charAt(0).toUpperCase() + title.slice(1),
            chart_data: chart_data,
            fetched: false
        };
    },
    methods: {
        new_chart(values) {
            this.$nextTick(function() {
                const Chart = require("chart.js");
                const chart = new Chart(document.getElementById(this.id), {
                    type: "line",
                    data: {
                        labels: Object.keys(values),
                        datasets: [
                            {
                                label: this.title_capitalized,
                                data: Object.values(values),
                                fill: false,
                                borderColor: "rgb(75, 192, 192)",
                                lineTension: 0.1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [
                                {
                                    ticks: {
                                        beginAtZero: true,
                                        suggestedMax: Math.max(...Object.values(values)) + 1,
                                        stepSize: 1
                                    }
                                }
                            ]
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                    }
                );
            });
        }
    },
    watch: {
        props: {
            handler(newVal) {
                this.chart_data = newVal[this.title];
                if (this.chart_data && Object.keys(this.chart_data).length) {
                this.fetched = true;
                this.new_chart(this.chart_data);
                }
            },
            deep: true
            }
        }
    };
</script>

<style scoped>
    .chart-wrapper {
        max-width: 100%;
    }
    .intermittent {
        animation: intermittentAnimation 5s infinite 100ms;
    }

    @keyframes intermittentAnimation {
        0% {opacity: 1;}
        50% {opacity: 0;}
        100% {opacity: 1;}
    }
</style>
