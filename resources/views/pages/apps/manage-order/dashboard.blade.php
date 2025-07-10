@extends('layouts.app')

@section('pageTitle', $pageTitle)

@section('content')
  <div class="row gy-5 g-xl-10">
    <div class="col-xl-6 mb-xl-10">
      <div class="card card-bordered">
        <div class="card-header flex-nowrap gap-5">
          <div class="card-title">Jumlah Asset Berdasarkan Status</div>
        </div>
        <div class="card-body">
          <ul class="nav nav-pills nav-pills-custom mb-3 mx-9" role="tablist">
            <!--begin::Item-->
            <!--end::Item-->
            <!--begin::Item-->
            <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
              <!--begin::Link-->
              <a class="nav-link btn btn-outline btn-flex btn-active-color-primary flex-column overflow-hidden pt-5 pb-5"
                data-bs-toggle="pill" id="status_3" href="#status_content_3" aria-selected="false" role="tab"
                tabindex="-1">

                <!--begin::Title-->
                <span class="nav-text text-gray-800 fw-bold fs-6 lh-1 status" data-status="3">
                  Status Pemakaian </span>
                <!--end::Title-->

                <!--begin::Bullet-->
                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                <!--end::Bullet-->
              </a>
              <!--end::Link-->
            </li>
            <!--end::Item-->
          </ul>
          <div class="tab-content ps-4 pe-6">
            <!--begin::Tap pane-->
            <div class="tab-pane fade active show" id="status_content_1" role="tabpanel" aria-labelledby="status_1">
              <!--begin::Chart-->
              <div id="kt_charts_widget_10_chart_1" class="min-h-auto" style="height: 280px; min-height: 285px;">
                <div id="kt_amcharts_1" style="height: 280px;"></div>
              </div>
              <!--end::Chart-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
  <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

  <script>

am5.ready(function () {

    // Create root element
    // https://www.amcharts.com/docs/v5/getting-started/#Root_element
    var root = am5.Root.new("kt_amcharts_1");

    // Set themes
    // https://www.amcharts.com/docs/v5/concepts/themes/
    root.setThemes([
        am5themes_Animated.new(root)
    ]);

    // Create chart
    // https://www.amcharts.com/docs/v5/charts/xy-chart/
    var chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: false,
        panY: false,
        wheelX: "panX",
        wheelY: "zoomX",
        layout: root.verticalLayout
    }));

    // Add legend
    // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
    var legend = chart.children.push(
        am5.Legend.new(root, {
            centerX: am5.p50,
            x: am5.p50
        })
    );

    var stsPemakaian = {!! $stsPemakaian !!}

    var data = [
        {
          "year": "2025"
        }
      ];

    $.each(stsPemakaian, function(indexInArray, stsVal) {
        var total = parseInt(stsVal.total);
      console.log(indexInArray);
      
        const keysArrayData = Object.keys(indexInArray);
        data[0][stsVal.kendaraan_slug] = total ? total : 0;
    });

    // Create axes
    // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
    var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
        categoryField: "year",
        renderer: am5xy.AxisRendererX.new(root, {
            cellStartLocation: 0.1,
            cellEndLocation: 0.9
        }),
        tooltip: am5.Tooltip.new(root, {})
    }));

    xAxis.data.setAll(data);

    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererY.new(root, {})
    }));

    // Add series
    // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
    function makeSeries(name, fieldName) {
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
            name: name,
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: fieldName,
            categoryXField: "year"
        }));

        series.columns.template.setAll({
            tooltipText: "{name}, {categoryX}:{valueY}",
            width: am5.percent(90),
            tooltipY: 0
        });

        series.data.setAll(data);

        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear();

        series.bullets.push(function () {
            return am5.Bullet.new(root, {
                locationY: 0,
                sprite: am5.Label.new(root, {
                    text: "{valueY}",
                    fill: root.interfaceColors.get("alternativeText"),
                    centerY: 0,
                    centerX: am5.p50,
                    populateText: true
                })
            });
        });

        legend.data.push(series);
    }

      $.each(stsPemakaian, function(indexInArray, stsVal) {
        makeSeries(stsVal.kendaraan, stsVal.kendaraan_slug);
      });


    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    chart.appear(1000, 100);

}); // end am5.ready()
  </script>
@endpush