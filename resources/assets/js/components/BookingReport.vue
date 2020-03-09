<template>
  <div class="row">
    <div class="col-md-8 ml-5">
      <div class="panel panel-primary">
        <div class="panel-heading" style="background-color:#2e6ae2 !important">
          Welcome
        </div>
        <br />
        <div class="panel-body">
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div
                      class="text-xs font-weight-bold text-primary text-uppercase mb-1"
                    >
                      &emsp;&emsp;Customers
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      &emsp;&emsp; {{ clients }}
                    </div>
                  </div>
                  <div class="col-auto">
                    &emsp;&emsp;
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div
                      class="text-xs font-weight-bold text-success text-uppercase mb-1"
                    >
                      &emsp;&emsp;Earnings
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      &emsp;&emsp;# {{ cashFlow }}
                    </div>
                  </div>
                  <div class="col-auto">
                    &emsp;&emsp;<i class="fas fa-money fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <form @submit.prevent="getReportDetails" class="mb-3">
      <div class="col-md-4">
        <div class="row input-daterange">
          <div class="col-md-5">
            From:
            <input
              type="date"
              v-model="stats.from_date"
              class="form-control"
              placeholder="From Date"
            />
          </div>
          <div class="col-md-5">
            To:
            <input
              type="date"
              v-model="stats.to_date"
              class="form-control"
              placeholder="To Date"
            />
          </div>
        </div>
        <br />
        <br />
        <div class="row col-md-4">
          <div class="col-md-4">
            <button type="submit" class="btn btn-primary">
              Filter
            </button>
          </div>
          &emsp;&emsp;&emsp;&emsp;
          <div class="col-md-2">
            <button
              type="button"
              class="btn btn-info"
              v-on:click="getReportTodaysDetails"
            >
              Refresh
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
export default {
  data() {
    return {
      from_date: "",
      to_date: "",
      cashFlow: "",
      clients: "",
      stats: {
        from_date: "",
        to_date: ""
      }
    };
  },
  mounted() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  },
  created() {
    this.getReportTodaysDetails();
  },
  methods: {
    getReportDetails() {
      console.log(this.stats.to_date);
      console.log(this.stats.from_date);
      fetch("/api/v1/getperformance", {
        method: "post",
        body: JSON.stringify(this.stats),
        headers: {
          "content-type": "application/json",
          "X-CSRF-Token": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content")
        }
      })
        .then(res => res.json())
        .then(res => {
          this.cashFlow = res.cashFlow;
          this.clients = res.clients;
          //console.log(res);
        })
        .catch(err => console.log(err));
    },
    getReportTodaysDetails() {
      fetch("/api/v1/getperformancetoday", {
        method: "get",
        headers: {
          "content-type": "application/json",
          "X-CSRF-Token": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content")
        }
      })
        .then(res => res.json())
        .then(res => {
          this.cashFlow = res.cashFlow;
          this.clients = res.clients;
          console.log(res);
        })
        .catch(err => console.log(err));
    }
  }
};
</script>

<style scoped>
.card-body {
  flex: 1 1 auto;
  padding: 1.25rem;
}
.card {
  position: relative;
  display: flex;
  flex-direction: column;
  width: 70%;
  min-width: 20%;
  word-wrap: break-word;
  background-color: #fff;
  background-clip: border-box;
  border: 1px solid #e3e6f0;
  border-radius: 0.35rem;
}

.card-body {
  flex: 1 1 auto;
  padding: 1.25rem;
}
*,
::after,
::before {
  box-sizing: border-box;
}
div {
  display: block;
}

.border-left-primary {
  border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
  border-left: 0.25rem solid #1cc88a !important;
  border-left-width: 0.25rem !important;
  border-left-style: solid !important;
  border-left-color: rgb(28, 200, 138) !important;
}
body {
  margin: 0;
  font-family: Nunito, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
    "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji",
    "Segoe UI Symbol", "Noto Color Emoji";
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #858796;
  text-align: left;
  background-color: #fff;
}
.text-gray-300 {
  color: #dddfeb !important;
}
.fa,
.fas {
  font-weight: 900;
}
</style>
