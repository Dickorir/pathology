$(function () {
    var jsonfiles = {
        "payment":[{
                "cancer_type":"blood",
                "cancer_stage":"3",
                "year":"1212-12-12"
            }]
    };
    var jsonfile = {
        "jsonarray": [{
            "name": "Joe",
            "age": 12
        }, {
            "name": "Tom",
            "age": 14
        }, {
            "name": "Tom",
            "age": 9
        }, {
            "name": "Tom",
            "age": 10
        }]
    };

    var labels = jsonfile.jsonarray.map(function(e) {
        return e.name;
    });
    var data = jsonfile.jsonarray.map(function(e) {
        return e.age;
    });


    var lineData = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [

            {
                label: "Data 1",
                backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [28, 48, 40, 19, 86, 27, 90]
            },{
                label: "Data 2",
                backgroundColor: 'rgba(220, 220, 220, 0.5)',
                pointBorderColor: "#fff",
                data: [65, 59, 80, 81, 56, 55, 40]
            },{
                label: "Data 3",
                backgroundColor: 'rgba(120,22,118,0.5)',
                pointBorderColor: "#fff",
                data: [55, 99, 20, 81, 56, 95, 40]
            }
        ]
    };

    var lineOptions = {
        responsive: true
    };


    var ctx = document.getElementById("lineChart").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});


});
