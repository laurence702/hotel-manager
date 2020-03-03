<template>
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading">Welcome</div> <br>
                <div class="row">
                    <div class="col-md-3">&nbsp;&nbsp;Search reports by day: &nbsp;&nbsp;<input type="date" name="reports" id="reports"></div>
                    <div class="col-md-3">
                        <button class="btn-info">filter</button>
                    </div>
                </div>
                    <div class="panel-body">
                        <div class="col-md-4 col-xs-7"  style="background-color:#b5dfa3"> 
                            <h3><i class="fa fa-money"></i> ₦500</h3>
                            Todays Earnings
                        </div> 
                        <div class="col-md-4 col-xs-2 bg-info"> 
                            
                        </div>
                        <div class="col-md-4 col-xs-3"  style="background-color:#ff5252!important"> 
                            <h3><i class="fa fa-users"></i>4</h3>
                             Today
                        </div>                    
                    </div>

                    <div class="panel-body">
                    <div class="col-md-4 col-xs-7" style="background-color:#b5dfa3"> 
                        
                            <h3><i class="fa fa-money"></i> ₦5000 </h3>
                            Yesterdays
                        </div>
                        <div class="col-md-4 col-xs-2 bg-info"> 
                           
                        </div>
                        <div class="col-md-4 col-xs-3" style="background-color:#ff5252!important"> 
                            <h3><i class="fa fa-users"></i>19</h3>
                             Yesterday
                        </div>
                    </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {

        }         
    },
    created() {
			this.getReportDetails(); 
			
        },
    methods: {
        getReportDetails() {
            fetch('/api/getlastorder')
            .then(res => res.json())
            .then(res => {
               
                console.log(res)
            })
            .then(

            )            
            .catch(err => console.log(err))
        }
    }
}
</script>

<style scoped>

</style>