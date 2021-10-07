@extends('layouts.admin-app')
@section('title','Dashboard')
@section('content-admin')
<style type="text/css">
    .dash-widget-icon{
            align-items: center;
            border-radius: 10px;
            color: #fff;
            display: inline-flex;
            font-size: 40px;
            height: 80px;
            justify-content: center;
            text-align: center;
            width: 80px;
            background-color: #32847c;
            opacity: 1 !important;
    }
</style>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="form-inline">
                    </form>
                </div>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
            <div class="col-xl-12 col-lg-12">

                <div class="row">
                    <div class="col-lg-3">
                        <div class="card widget-flat">
                            <div class="card-body">
                                <div class="float-right">
                                    <i class="mdi mdi-account-multiple widget-icon"></i>
                                </div>
                                <h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">Questions</h5>
                                <h3 class="mt-3 mb-3">{{ DB::table('answerquestions')->where('delete_status'  ,'Active')->count() }}</h3>
                                
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <div class="card widget-flat">
                            <div class="card-body">
                                <div class="float-right">
                                    <i class="mdi mdi-cart-plus widget-icon bg-success-lighten text-success"></i>
                                </div>
                                <h5 class="text-muted font-weight-normal mt-0" title="Number of Orders">Answers</h5>
                                <h3 class="mt-3 mb-3">

                                    

                                    {{ DB::table('onlyanswers')->where('delete_status' , 'Active')->count() }}




                                </h3>
                                
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <div class="card widget-flat">
                            <div class="card-body">
                                <div class="float-right">
                                    <i class="mdi mdi-currency-usd widget-icon bg-success-lighten text-success"></i>
                                </div>
                                <h5 class="text-muted font-weight-normal mt-0" title="Average Revenue">Users</h5>
                                <h3 class="mt-3 mb-3">{{ DB::table('users')->count() }}</h3>
                                
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <div class="card widget-flat">
                            <div class="card-body">
                                <div class="float-right">
                                    <i class="mdi mdi-pulse widget-icon"></i>
                                </div>
                                <h5 class="text-muted font-weight-normal mt-0" title="Growth">Subjects</h5>
                                <h3 class="mt-3 mb-3">{{ DB::table('categories')->where('status'  ,'Active')->count() }}</h3>
                                
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                </div> <!-- end row -->

            </div> <!-- end col -->

        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">

                        <h4 class="header-title mb-4">Question Stats</h4>

                        <div class="my-4 chartjs-chart" style="height: 202px;">
                            <canvas id="project-status-chart" data-colors="#10c469,#536de6,#ff5b5b"></canvas>
                        </div>

                        <div class="row text-center mt-2 py-2">
                            <div class="col-4">
                                <i class="mdi mdi-trending-up text-success mt-3 h3"></i>
                                <h3 class="font-weight-normal">
                                    <span>{{ DB::table('answerquestions')->where('delete_status'  ,'Active')->where('visible_status' , 'Published')->count() }}</span>
                                </h3>
                                <p class="text-muted mb-0">Published</p>
                            </div>
                            <div class="col-4">
                                <i class="mdi mdi-trending-down text-primary mt-3 h3"></i>
                                <h3 class="font-weight-normal">
                                    <span>{{ DB::table('answerquestions')->where('delete_status'  ,'Active')->where('visible_status' , 'Under Review')->count() }}</span>
                                </h3>
                                <p class="text-muted mb-0">Under Review</p>
                            </div>
                            <div class="col-4">
                                <i class="mdi mdi-trending-down text-danger mt-3 h3"></i>
                                <h3 class="font-weight-normal">
                                    <span>{{ DB::table('answerquestions')->where('delete_status'  ,'Active')->where('visible_status' , 'Trash')->count() }}</span>
                                </h3>
                                <p class="text-muted mb-0">Trash</p>
                            </div>
                        </div>
                        <!-- end row-->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">

                        <h4 class="header-title mb-4">Answers Stats</h4>

                        <div class="my-4 chartjs-chart" style="height: 202px;">
                            <canvas id="onlyanswers-stats-chart" data-colors="#10c469,#536de6,#ff5b5b"></canvas>
                        </div>

                        <div class="row text-center mt-2 py-2">
                            <div class="col-4">
                                <i class="mdi mdi-trending-up text-success mt-3 h3"></i>
                                <h3 class="font-weight-normal">
                                    <span>{{ DB::table('onlyanswers')->where('delete_status'  ,'Active')->where('visible_status' , 'Published')->count() }}</span>
                                </h3>
                                <p class="text-muted mb-0">Published</p>
                            </div>
                            <div class="col-4">
                                <i class="mdi mdi-trending-down text-primary mt-3 h3"></i>
                                <h3 class="font-weight-normal">
                                    <span>{{ DB::table('onlyanswers')->where('delete_status'  ,'Active')->where('visible_status' , 'Under Review')->count() }}</span>
                                </h3>
                                <p class="text-muted mb-0">Under Review</p>
                            </div>
                            <div class="col-4">
                                <i class="mdi mdi-trending-down text-danger mt-3 h3"></i>
                                <h3 class="font-weight-normal">
                                    <span>{{ DB::table('onlyanswers')->where('delete_status'  ,'Active')->where('visible_status' , 'Trash')->count() }}</span>
                                </h3>
                                <p class="text-muted mb-0">Trash</p>
                            </div>
                        </div>
                        <!-- end row-->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div>
        </div>
                        <!-- end row-->
</div>
<script src="{{url('/admin/js/vendor/Chart.bundle.min.js')}}"></script>
<script type="text/javascript">
    ! function(o) {
    "use strict";

    function t() {
        this.$body = o("body"), this.charts = []
    }
    t.prototype.respChart = function(r, a, e, n) {
        Chart.defaults.global.defaultFontColor = "#8391a2", Chart.defaults.scale.gridLines.color = "#8391a2";
        var i = r.get(0).getContext("2d"),
            s = o(r).parent();
        return function() {
            var t;
            switch (r.attr("width", o(s).width()), a) {
                case "Line":
                    t = new Chart(i, {
                        type: "line",
                        data: e,
                        options: n
                    });
                    break;
                case "Bar":
                    t = new Chart(i, {
                        type: "bar",
                        data: e,
                        options: n
                    });
                    break;
                case "Doughnut":
                    t = new Chart(i, {
                        type: "doughnut",
                        data: e,
                        options: n
                    })
            }
            return t
        }()
    }, t.prototype.initCharts = function() {
        var t, r, a, e = [];
        return  0 < o("#project-status-chart").length && (a = {
            labels: ["Published", "Under Review", "Trash"],
            datasets: [{
                data: [{{ DB::table('answerquestions')->where('delete_status'  ,'Active')->where('visible_status' , 'Published')->count() }}, {{ DB::table('answerquestions')->where('delete_status'  ,'Active')->where('visible_status' , 'Under Review')->count() }}, {{ DB::table('answerquestions')->where('delete_status'  ,'Active')->where('visible_status' , 'Trash')->count() }}],
                backgroundColor: (r = o("#project-status-chart").data("colors")) ? r.split(",") : ["#0acf97", "#727cf5", "#fa5c7c"],
                borderColor: "transparent",
                borderWidth: "3"
            }]
        }, e.push(this.respChart(o("#project-status-chart"), "Doughnut", a, {
            maintainAspectRatio: !1,
            cutoutPercentage: 80,
            legend: {
                display: !1
            }
        }))), e
    }, t.prototype.init = function() {
        var r = this;
        Chart.defaults.global.defaultFontFamily = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif', r.charts = this.initCharts(), o(window).on("resize", function(t) {
            o.each(r.charts, function(t, r) {
                try {
                    r.destroy()
                } catch (t) {}
            }), r.charts = r.initCharts()
        })
    }, o.ChartJs = new t, o.ChartJs.Constructor = t
}(window.jQuery),
function() {
    "use strict";
    window.jQuery.ChartJs.init()
}();
</script>
<script type="text/javascript">
    ! function(o) {
    "use strict";

    function t() {
        this.$body = o("body"), this.charts = []
    }
    t.prototype.respChart = function(r, a, e, n) {
        Chart.defaults.global.defaultFontColor = "#8391a2", Chart.defaults.scale.gridLines.color = "#8391a2";
        var i = r.get(0).getContext("2d"),
            s = o(r).parent();
        return function() {
            var t;
            switch (r.attr("width", o(s).width()), a) {
                case "Line":
                    t = new Chart(i, {
                        type: "line",
                        data: e,
                        options: n
                    });
                    break;
                case "Bar":
                    t = new Chart(i, {
                        type: "bar",
                        data: e,
                        options: n
                    });
                    break;
                case "Doughnut":
                    t = new Chart(i, {
                        type: "doughnut",
                        data: e,
                        options: n
                    })
            }
            return t
        }()
    }, t.prototype.initCharts = function() {
        var t, r, a, e = [];
        return  0 < o("#project-status-chart").length && (a = {
            labels: ["Published", "Under Review", "Trash"],
            datasets: [{
                data: [{{ DB::table('onlyanswers')->where('delete_status'  ,'Active')->where('visible_status' , 'Published')->count() }}, {{ DB::table('onlyanswers')->where('delete_status'  ,'Active')->where('visible_status' , 'Under Review')->count() }}, {{ DB::table('onlyanswers')->where('delete_status'  ,'Active')->where('visible_status' , 'Trash')->count() }}],
                backgroundColor: (r = o("#project-status-chart").data("colors")) ? r.split(",") : ["#0acf97", "#727cf5", "#fa5c7c"],
                borderColor: "transparent",
                borderWidth: "3"
            }]
        }, e.push(this.respChart(o("#onlyanswers-stats-chart"), "Doughnut", a, {
            maintainAspectRatio: !1,
            cutoutPercentage: 80,
            legend: {
                display: !1
            }
        }))), e
    }, t.prototype.init = function() {
        var r = this;
        Chart.defaults.global.defaultFontFamily = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif', r.charts = this.initCharts(), o(window).on("resize", function(t) {
            o.each(r.charts, function(t, r) {
                try {
                    r.destroy()
                } catch (t) {}
            }), r.charts = r.initCharts()
        })
    }, o.ChartJs = new t, o.ChartJs.Constructor = t
}(window.jQuery),
function() {
    "use strict";
    window.jQuery.ChartJs.init()
}();
</script>
@endsection