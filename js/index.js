// 

function countryChange(i,cityId) {
	if(isNaN(cityId)) cityId=0;
    new Request({
	url:'/ajax/ajax_select.php', 
	async: true,
	onSuccess: function(response) {
		eval(response);
//		var containers = $A($('divCountry').getElements('span.gvSelect'));
//		var x = $("cont_country_id").getNext();
		var x = $("sel_country_id").getNext();
		x.destroy();
		// vegigzuzunk a containerken
		var containers = $A($('qs_city').getElements('span.gvSelect'));
		containers.each (
			function(c)   
			{
				new gvSelect(c);
			}
		);
//		var t = $('sel_country_id');
//		t.value = response;
//		t.focus();
	},
	method: 'post',
	data: 'continent_id=' + i +'&city_id=' + cityId
    }).send();
}


window.addEvent('domready', function()
{

/*
	// selectek letrehozasa az "ebbenvannak_select" id-ju elemen belul
	create_gvSelect('search_box');
	create_gvSelect('inquiry_form');
	
	// checkbox/radio leterhozasok az "ebbenvannak_checkradio" diven belul
	gv_check_radio('reg_form');
*/


	// z index legyen 100
	var z = 6500;

	// a select elemek 'gvSelect' classu span tagek kozott vannak
	var selectContainers = $A($$('span.gvSelect'));
	// vegigzuzunk a containerken
	if (selectContainers.length>0)
	{
		selectContainers.each
		(
			function(sc)
			{
				new gvSelect(sc, function () {
				if (sc.parentNode.id == "qs_country") {
				  // alert(sc.parentNode.id);
				  var i = this.origSelect.value;
				  countryChange(i);
				}

					// countryChange
				});
				z--;
			}
		)
	}
	
})

/*
*/