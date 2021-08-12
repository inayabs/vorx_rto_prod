<template>
  <div>
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
        <div class="dropdown no-arrow">
          <a
            class="dropdown-toggle"
            href="#"
            role="button"
            id="dropdownMenuLink"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
          </a>
          <div
            class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
            aria-labelledby="dropdownMenuLink"
          >
            <div class="dropdown-header">Dropdown Header:</div>
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </div>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <div class="chart-area">
          <apexchart height="300" type="line" :options="options" :series="series"></apexchart>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.getData();
  },
  data() {
    return {
      options: {
        chart: {
          id: "vuechart-example"
        },
        xaxis: {
          categories: this.getCat()
        },
        yaxis: {
          labels: {
            formatter: function(value) {
              return `$ ${value}`;
            }
          }
        },
        markers: {
          size: 6,
          colors: undefined,
          strokeColors: "#fff",
          strokeWidth: 2,
          strokeOpacity: 0.9,
          strokeDashArray: 0,
          fillOpacity: 1,
          discrete: [],
          shape: "circle",
          radius: 2,
          offsetX: 0,
          offsetY: 0,
          onClick: undefined,
          onDblClick: undefined,
          showNullDataPoints: true,
          hover: {
            size: undefined,
            sizeOffset: 3
          }
        },
        stroke: {
          show: true,
          curve: "smooth",
          lineCap: "butt",
          colors: undefined,
          width: 4,
          dashArray: 0
        },
        noData: {
          text: "No Data"
        }
      },
      series: [
        {
          name: "Earnings",
          data: []
        }
      ]
    };
  },
  methods: {
    getCat() {
      let cat = [];
      window.chartData.forEach(e => {
        console.log(e);
        cat.push(e.abr);
      });

      return cat;
    },
    getData() {
      let newdata = [];
      window.chartData.forEach(e => {
        console.log(e);
        newdata.push(e.amount);
      });
      this.series = [
        {
          data: newdata
        }
      ];
    }
  }
};
</script>

<style >
.chart-area {
  height: auto !important;
}
</style>