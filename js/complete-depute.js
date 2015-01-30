

/////Cal 1

var data_url = "presences.php?slug='"+mySlugDepute+"'";
var cal = new CalHeatMap();
cal.init({ data: data_url,
    itemSelector: "#cal-heatmap",
    start: new Date(2012, 5, 1), 
    domain: "month",
    subdomain: "day",
    range: 12,
    itemNamespace: "undepute",
    nextSelector: "#domainDynamicDimension-next",
    previousSelector: "#domainDynamicDimension-previous",
    onClick: function(date, nb) {
        var date_year = date.getFullYear();
        var date_month = date.getMonth()+1;
        var date_day = date.getDate();

        var date_str = ""+date_year+"-"+date_month+"-"+date_day;
        //$("#list-seances").html($.get("detail_seance.php", {slug: "jean-jacques-urvoas", date: "2012-11-27" }));
        $.get("detail_seance.php", {slug: mySlugDepute, date: date_str })
            .done(function(data){
                $("#list-seances").html(data);
                $("#modal-seance").modal("show");
            });
    },
    legend: [1, 2, 3, 4]   });

$("#slug-search-go").on("click", function(event) {
    mySlugDepute = $("#slug-depute").val(); 
    $("#un_depute #print-slug").html("<h2>"+mySlugDepute+"</h2>");
    var data_url = "presences.php?slug='"+mySlugDepute+"'";
    
    cal.destroy();
    cal = new CalHeatMap();

    //$("#un_depute #cal-heatmap").empty();

    cal.init({ data: data_url,
    itemSelector: "#cal-heatmap",
        start: new Date(2012, 5, 1), 
        domain: "month",
        subdomain: "day",
        range: 12,
        itemNamespace: "undepute",
        nextSelector: "#domainDynamicDimension-next",
        previousSelector: "#domainDynamicDimension-previous",
        onClick: function(date, nb) {
            var date_year = date.getFullYear();
            var date_month = date.getMonth()+1;
            var date_day = date.getDate();

            var date_str = ""+date_year+"-"+date_month+"-"+date_day;
            $.get("detail_seance.php", {slug: mySlugDepute, date: date_str })
                .done(function(data){
                    $("#list-seances").html(data);
                    $("#modal-seance").modal("show");
                });
        },
        legend: [1, 2, 3, 4]   });

    });


/////Cal 2

      //<script type="text/javascript">
var cal2 = new CalHeatMap();
cal2.init({ data: "presences.php",
    itemSelector: "#cal-heatmap2",
    start: new Date(2012, 5, 1), 
    domain: "month",
    subdomain: "day",
    range: 12,
    nextSelector: "#domainDynamicDimension-next",
    previousSelector: "#domainDynamicDimension-previous",
    itemNamespace: "tousdeputes",
    legend: [0, 200, 400, 600]   });
// $("#next").on("click", function(event) {cal.next());
//</script>
 



/// JQuery Autocomplete

$(document).ready(function() {
    $('#slug-depute').autocomplete({ serviceUrl: 'deputes.php', dataType: 'json' });
}); 
