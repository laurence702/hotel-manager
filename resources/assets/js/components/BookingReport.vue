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
                      &emsp;&emsp;Earnings (Today)
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      &emsp;&emsp;3
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
                      &emsp;&emsp;Earnings (Annual)
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                      &emsp;&emsp;#215,000
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
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  created() {
    this.getReportDetails();
  },
  methods: {
    getReportDetails() {
      fetch("/api/v1/getperformance")
        .then(res => res.json())
        .then(res => {
          console.log(res);
        })
        .then()
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
