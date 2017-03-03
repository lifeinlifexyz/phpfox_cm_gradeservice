$Ready(function () {
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        //draw votes
        var raw_data = $('#cm-gs-chart-votes').data('data');
        var rows = [];
        for(var controller in raw_data) {
            rows.push([controller, parseInt(raw_data[controller])]);
        }
        var data = new google.visualization.DataTable(rows);
        data.addColumn('string', 'Pizza');
        data.addColumn('number', 'Populartiy');
        data.addRows(rows);

        var title = $('#cm-gs-chart-votes').attr('title');
        var options = {
            title: title,
            pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('cm-gs-chart-votes'));
        chart.draw(data, options);

        //draw rating
        raw_data = $('#cm-gs-chart-rating').data('data');
        rows = [];
        for(var controller in raw_data) {
            rows.push([controller, parseInt(raw_data[controller])]);
        }
        data = new google.visualization.DataTable(rows);
        data.addColumn('string', 'Pizza');
        data.addColumn('number', 'Populartiy');
        data.addRows(rows);
        title = $('#cm-gs-chart-rating').attr('title');
        options = {
            title: title,
            is3D: true,
        };

        chart = new google.visualization.PieChart(document.getElementById('cm-gs-chart-rating'));
        chart.draw(data, options);
    }

});