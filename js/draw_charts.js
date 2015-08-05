

  function RefreshChart() {
    alert('Yeah');
    var chart = $('#LATENCY_container').highcharts();
    chart.addSeries({
      name: obj.server_name,
      data: obj.loss_percent
    });
  }
