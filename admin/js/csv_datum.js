function export_plusz_datum()
{
	//
	var datum_i = $('csv_pluszDatum');
	var mezo_i = $('csv_fajlNeve');

	// 
	datum_i.addEvent('change', function()
	{
	  // input mezo ertek
	  var i = datum_i.getValue();
	  var m = mezo_i.getValue();
	  //if (i==1)
	  //{
			// telepules ajaxbul
			new Ajax('remote/csv_datum.php',
			{
				method: 'post',
				data: 'datum=' + i + '&fajl=' + m,
				onComplete: function(response)
				{
					//alert(response);
					var t = $('csv_fajlNeve');
					t.value = response;
					//t.focus();
				}
			}).request();
		//}

	});
}

// betoltes utan lefut
/*window.addEvent('domready', function()
{
	//
	var export_plusz_datum_run = export_plusz_datum();

});*/