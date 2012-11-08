/*
// grafikus selectbox objektum  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #
var gvSelect_ZINDEX = 6500;
var gvSelect = new Class
({
	// init
	initialize: function(selectCont, onchange_function)
	{
		// onchange nincs
		this.ocev = false;
		//	nyitott allapot: csukva
		this.is_open = 0;
		// z-index
		//this.z = z;
		// container: a span amiben van az eredeti select
		this.container = $(selectCont);

		if (this.container)
		{
			// eredeti select
			this.origSelect = this.container.getElement('select');
			// szulo class, ha jon
			this.onchange_function = onchange_function;

			// meggyartjuk a cuccot
			this.build();
		}
	},


	//
	build: function()
	{
		// regi select eltunik
		this.origSelect.set('styles',{'display':'none'});

		// helyere bejon a div, amiben az egesz van
		this.select = new Element('div', {'class':'gvSelect', 'styles':{'z-index':gvSelect_ZINDEX}}).inject(this.container)
		//this.select = new Element('div', {'class':'gvSelect', 'styles':{'position':'absolute','z-index':this.z,'top':200,'left':200}}).inject(document.body)

		// fejlec terulet: benne a szoveg es a nyil
		this.headArea = new Element('div', {'class':'gvS_headArea', 'styles':{'z-index':gvSelect_ZINDEX}}).inject(this.select);
		// fejlec szoveg
		this.headtext = new Element('div', {'class':'gvS_headText', 'styles':{'z-index':gvSelect_ZINDEX}}).inject(this.headArea);
		// fejlec nyil
		this.headarrow = new Element('div', {'class':'gvS_headArrow', 'styles':{'z-index':gvSelect_ZINDEX}}).inject(this.headArea);

		// separator
		sep = new Element('div', {'styles':{'clear':'both','z-index':gvSelect_ZINDEX}}).inject(this.select);

		// innen csak ha nem disabled az egesz select
		if (!this.origSelect.getProperty('disabled'))
		{
			// option terulet: benne az optionok
			this.optionsArea = new Element('div', {'class':'gvS_optionsArea', 'styles':{'z-index':gvSelect_ZINDEX}}).inject(this.select);

			// eredeti optionok visszapakkantasa
			this.origSelect.getElements('option').each
			(
				function(oo)
				{
					// eredeti text
					var ooText = oo.get('text'); //alert(ooText);

					// eredeti class felszed
					var ooClass = false;
					ooClass=oo.getProperty('class');

					// valasztott option szovege es eredeti class a fejlecbe
					if (oo.selected)
					{
						this.headtext.set('text', ooText);
						if (ooClass)
							this.headtext.addClass(ooClass);
					}

					// option bele
					option = new Element('div', {'class':'gvS_option', 'styles':{'z-index':gvSelect_ZINDEX}}).inject(this.optionsArea).set('text', ooText);

					// eredeti class, ha volt az optionnak
					if (ooClass)
						option.addClass(ooClass);

					// effektek ha nem disabled
					if (!oo.disabled)
					{
						// over/out
						option.addEvent('mouseover', function(){this.addClass('over');});
						option.addEvent('mouseout', function(){this.removeClass('over');});

						// kattinas
						option.addEvent('click', function()
						{
							// jelenlegi erteket taroljuk
							var cur_value = this.origSelect.get('value');

							// beirjuk a textet
							this.headtext.set('text', ooText);

							// head szoveg class allitgatas: beallitjuk az alapot es ha volt az optionnek, akkor azt hozzaadjuk
							this.headtext.setProperty('class', 'gvS_headText');
							if (ooClass)
								this.headtext.addClass(ooClass);

							// bezarjuk a selectet
							this.dropdown();

							// beallitjuk az erteket az eredeti selectben
							this.origSelect.value = oo.value; //alert(oo.value);

							// onchange event lefuttatasa, ha van
							if(this.onchange_function)
							{
								// csak ha valtozik
								if (oo.value!=cur_value)
								{
									eval(this.onchange_function(this.origSelect.value, ooText));
								}
							}
							
							if(this.origSelect.id == "sel_continent_id") 
							{
							    $$("#cont_country_id .gvSelect").set("HTML", "<select name='acc_continent' id='sel_country_id' title='sel_country_id'></select>");
							    
							    // csak ha valtozik
							    if (oo.value!=cur_value) {
							
							        // select mezo ertek
							        var i = this.origSelect.value;
							
							        new Request({
									  url:'/ajax/ajax_select.php', 
									  onSuccess: function(response) {
									    eval(response);
									    var z = 100;
									    var containers = $A($('sel_country_id').getElements('span.gvSelect'));
									    // vegigzuzunk a containerken
									    containers.each (
							            function(c)   
							            {
							                new gvSelect_(c, z);
							                z--;
							            }
							            )
								        var t = $('sel_country_id');
								        t.value = response;
								        t.focus();
							          }
							            ,method: 'post',
										data: 'continent_id=' + i
										}).send();
							
							      }
							} 

						}.bind(this));
					}
					// disabled class ha kell
					else
						option.addClass('disabled');
				

				}.bind(this)
			);

			// ablakra kattintva becsikjuk
			document.addEvent('click', function()
			{
				if (this.optionsArea.getStyle('display')=='block')
					this.dropdown();
			}.bind(this));

		}
		// END ha nem disabled az egesz select
		else
		{
			//TODO: teljes disabled select kezelese
		}


		// a select layerrol "leszedjuk" az elozo cuccot, hogy ne tunjon el egybol mikor megnyilik
		this.select.addEvent('click', function(e)
		{
			e.stop();
		});

		// fejlecre kattintva lenyikik, ha nem disabled az egesz select
		this.headArea.addEvent('click', function()
		{
			this.dropdown();
		}.bind(this));

		// globalis z-indez csokkentese
		gvSelect_ZINDEX--;
	},


	// dropdown kezeles (lenyitas/becsukas)
	dropdown: function()
	{
		// lenyit
		if (this.is_open==0)
			this.optionsArea.setStyle('display', 'block');
		// becsuk
		else
			this.optionsArea.setStyle('display', 'none');

		// allapot beallitasa
		this.is_open = 1 - this.is_open;
	},


	debug: function(t)
	{
		if ($('debugtext'))
			$('debugtext').setHTML(t);
	}
})


// grafikus selectek letrehozasa egy containeren belul
function create_gvSelect(container, onchange_function)
{
	//  a konteneren belul fut a gvSelect peldanyok letrehozasa
	if ($(container))
	{
		// a select elemek 'gvSelect' classu span tagek kozott vannak
		var selectContainers = $(container).getElements('span.gvSelect');
		// vegigzuzunk a containerken
		if (selectContainers.length>0)
		{
		selectContainers.each(function(sc)
		{
			if (onchange_function)
				new gvSelect(sc, onchange_function);
			else
				new gvSelect(sc);
		})
		}
	}
}










// grafikus checkbox/radio kezeles #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #
function gv_check_radio(container, onclick_function)
{
	// ha jon valami container id, akkor csak azon belul fut (pl ajaxbol visszafrissitett tartalomnal hasznos)
	if (container)
	{
	if ($(container))
	{
		var spans = $(container).getElements('span.gvRadio');
		spans.extend($(container).getElements('span.gvCheck'));
	}
	}
	// egyebkent a teljes dokumentumra
	else
		var spans = $$('span.gvRadio', 'span.gvCheck');

	if ($chk(spans))
	{
		spans.each
		(
		function(span)
		{
			// input elem
			var input = span.getElement('input');
			//input.setStyle('opacity', 0);

			// alap class a befoglalo spanhoz: a becsekkolt allapot alapjan
			if (input.getProperty('checked'))
				span.addClass('checked');
			else
				span.removeClass('checked');

			// tipus chekbox, vagy radio
			var type = (input.get('type')=='checkbox') ? 'chk' : 'rad';

			// kattintasra class valtas
			input.addEvent('click', function()
			{
				// csekkboksznal siman kapcsolgatjuk
				if (type=='chk')
				{
					if (input.getProperty('checked'))
						span.addClass('checked');
					else
						span.removeClass('checked');
				}

				// redional csak bekapcs, es az azonos nevuek kikapcs
				if (type=='rad')
				{
					//
					var name = input.getProperty('name');
					spans.getElements('input').each
					(
						function(si)
						{
							if (si.getProperty('name')==name)
							{
								si.getParent('span.gvRadio').removeClass('checked');
							}
						}
					);

					//
					span.addClass('checked');
				}

				//
				if(onclick_function)
					eval(onclick_function());
			})
		}
		)
	}
}
*/








//
function textFocus(container)
{
	// ha jon valami container id, akkor csak azon belul fut
	if (container)
	{
		if ($(container))
		{
			var conts = $(container).getElements('span.input_bg');
			conts.extend($(container).getElements('div.textarea_bg'));
		}
	}
	// egyebkent a teljes documentumra
	else
		var conts = $$('span.input_bg', 'div.textarea_bg');

	if ($chk(conts))
	{
		conts.each
		(
		function(cont)
		{
			// input/textarea elem
			var field = cont.getElement('input');
			if (!$chk(field))
				var field = cont.getElement('textarea');

			//
			field.addEvent('focus', function()
			{
				var curClass = cont.getProperty('class');
				cont.setProperty('class', curClass+'_focus');
			})
			//
			field.addEvent('blur', function()
			{
				var curClass = cont.getProperty('class'); 
				cont.setProperty('class', curClass.replace('_focus',''));
			})

		}
		)
	}
}
//
// elso betolteskor lefut
window.addEvent('domready', function()
{
	textFocus();
});










// grafikus checkbox/radio kezeles #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #
function gvCheckRadio(container)
{
	// ha jon valami container id, akkor csak azon belul fut (pl ajaxbol visszafrissitett tartalomnal hasznos)
	if (container)
	{
		if ($(container))
		{
			var spans = $(container).getElements('span.gvRadio');
			spans.extend($(container).getElements('span.gvCheck'));
		}
	}
	// egyebkent a teljes documentumra
	else
		var spans = $$('span.gvRadio', 'span.gvCheck');

	if ($chk(spans))
	{
		spans.each
		(
		function(span)
		{
			// input elem
			var input = span.getElement('input');
			//input.setStyle('opacity', 0);

			// alap class a befoglalo spanhoz: a becsekkolt allapot alapjan
			if (input.getProperty('checked'))
				span.addClass('checked');
			else
				span.removeClass('checked');

			// tipus chekbox, vagy radio
			var type = (input.get('type')=='checkbox') ? 'chk' : 'rad';

			// kattintasra class valtas
			input.addEvent('click', function()
			{
				// csekkboksznal siman kapcsolgatjuk
				if (type=='chk')
				{
					if (input.getProperty('checked'))
						span.addClass('checked');
					else
						span.removeClass('checked');
				}

				// redional csak bekapcs, es az azonos nevuek kikapcs
				if (type=='rad')
				{
					//
					var name = input.getProperty('name');
					spans.getElements('input').each
					(
						function(si)
						{
							if (si.getProperty('name')==name)
							{
								si.getParent('span.gvRadio').removeClass('checked');
							}
						}
					);

					//
					span.addClass('checked');
				}
			})
		}
		)
	}
}
// elso betolteskor lefut
window.addEvent('domready', function()
{
	gvCheckRadio();
});









// select csereje divekre #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #
var gvSelect_ = new Class
({
	// init
	initialize: function(selectCont, z)
	{
		// onchange nincs
		this.ocev = false;
		//	nyitott allapot: csukva
		this.is_open = 0;
		// z-index
		this.z = z;
		// container: a span amiben van az eredeti select
		this.container = selectCont;
		// eredeti select
		this.origSelect = this.container.getElement('select');

		// meggyartjuk a cuccot
		this.build();
	},



	//
	build: function()
	{
		// regi select eltunik
		//this.origSelect.set('styles',{'display':'none'});
		var origsize = this.origSelect.getSize();
		this.origSelect.set('styles',{'visibility':'hidden', 'position':'absolute', 'left':origsize[1] + 'px' });
/*
		// van-e onchange
		if (this.origSelect.onchange)
		{
			this.ocev = true;
		}
*/
		// helyere bejon a div, amiben az egesz van
		this.select = new Element('div', {'class':'gvSelect', 'styles':{'z-index':this.z}}).inject(this.container)

		// fejlec terulet: benne a szoveg es a nyil
		this.headArea = new Element('div', {'class':'gvS_headArea', 'styles':{'z-index':this.z}}).inject(this.select);
		// fejlec szoveg
		this.headtext = new Element('div', {'class':'gvS_headText', 'styles':{'z-index':this.z}}).inject(this.headArea);
		// fejlec nyil
		this.headarrow = new Element('div', {'class':'gvS_headArrow', 'styles':{'z-index':this.z}}).inject(this.headArea);

		// separator
		sep = new Element('div', {'styles':{'clear':'both'}}).inject(this.select);

		// option terulet: benne az optionok
		this.optionsArea = new Element('div', {'class':'gvS_optionsArea', 'styles':{'z-index':this.z}}).inject(this.select);
		// eredeti optionok visszapakkantasa
		this.origSelect.getElements('option').each
		(
			function(oo)
			{
				// eredeti text
				var ooText = oo.get('text'); //alert(ooText);

				// eredeti class felszed
				var ooClass = false;
				ooClass=oo.getProperty('class');

				// valasztott option szovege es eredeti class a fejlecbe
				if (oo.selected)
				{
					this.headtext.set('text', ooText);
					if (ooClass)
						this.headtext.addClass(ooClass);
				}

				// option bele
				option = new Element('div').addClass('gvS_option').inject(this.optionsArea).set('text', ooText);

				// eredeti class, ha volt az optionnak
				if (ooClass)
					option.addClass(ooClass);

				// effektek ha nem disabled
				if (!oo.disabled)
				{
					// over/out
					option.addEvent('mouseover', function(){this.addClass('over');});
					option.addEvent('mouseout', function(){this.removeClass('over');});

					// kattinas
					option.addEvent('click', function()
					{
						// jelenlegi erteket taroljuk
						var cur_value = this.origSelect.get('value');

						// beirjuk a textet
						this.headtext.set('text', ooText);

						// head szoveg class allitgatas: beallitjuk az alapot es ha volt az optionnek, akkor azt hozzaadjuk
						this.headtext.setProperty('class', 'gvS_headText');
						if (ooClass)
							this.headtext.addClass(ooClass);

						// bezarjuk a selectet
						this.dropdown();

						// beallitjuk az erteket az eredeti selectben
						this.origSelect.value = oo.value;

						// onchange event lefuttatasa, ha van
						if(this.ocev)
						{
							// csak ha valtozik
							if (oo.value!=cur_value)
								eval(this.origSelect.onchange());
						}
						if(this.origSelect.id == "sel_continent_id") 
						{
						    $$("#divCountry.gvSelect").set("HTML", "<select name='acc_country' id='sel_country_id' title='sel_country_id'></select>");
						    
						    // csak ha valtozik
						    if (oo.value!=cur_value) {
						
						        // select mezo ertek
						        var i = this.origSelect.value;
						
						        new Request({
								  url:'/ajax/ajax_select.php', 
								  onSuccess: function(response) {
						        	//alert(response);
						        	eval(response);
								    var z = 100;
								    var containers = $A($('divCountry').getElements('span.gvSelect'));
								    var x = $("cont_country_id").getNext();
								    x.destroy();
								    // vegigzuzunk a containerken
								    containers.each (
						            function(c)   
						            {
						                new gvSelect_(c, z);
						                z--;
						            }
						            )
							        var t = $('sel_country_id');
							        t.value = response;
							        t.focus();
						          }
						            ,method: 'post',
									data: 'continent_id=' + i
									}).send();
						
						      }
						} 
						if(this.origSelect.id == "sel_month_id") 
						{
						    $$("#divDays.gvSelect").set("HTML", "<select name='acc_day' id='sel_day_id' title='sel_day_id'></select>");
						    
						    // csak ha valtozik
						    if (oo.value!=cur_value) {
						
						        // select mezo ertek
						        var i = this.origSelect.value;
						
						        new Request({
								  url:'/ajax/ajax_date.php', 
								  onSuccess: function(response) {
						        	//alert(response);
						        	eval(response);
								    var z = 100;
								    var containers = $A($('divDays').getElements('span.gvSelect'));
								    var x = $("cont_days_id").getNext();
								    x.destroy();
								    // vegigzuzunk a containerken
								    containers.each (
						            function(c)   
						            {
						                new gvSelect_(c, z);
						                z--;
						            }
						            )
							        var t = $('sel_day_id');
							        t.value = response;
							        t.focus();
						          }
						            ,method: 'post',
									data: 'month_id=' + i
									}).send();
						
						      }
						} 

					}.bind(this));
				}
				// disabled class ha kell
				else
					option.addClass('disabled');

			}.bind(this)
		);


		// dokumentumra kattintva eltunik
		window.addEvent('click', function()
		{
			if (this.optionsArea.getStyle('display')=='block')
			{
				//this.debug(this.origSelect.id+Math.random());
				this.dropdown();
			}
		}.bind(this));

		// a select layerrol "leszedjuk" az elozo cuccot, hogy ne tunjon el egybol mikor megnyilik
		this.select.addEvent('click', function(e)
		{
			e.stop();
		});

		// fejlecre kattintva lenyikik
		this.headArea.addEvent('click', function()
		{
			this.dropdown();
		}.bind(this));
	},



	// dropdown kezeles (lenyitas/becsukas)
	dropdown: function()
	{
		// lenyit
		if (this.is_open==0)
			this.optionsArea.setStyle('display', 'block');
		// becsuk
		else
			this.optionsArea.setStyle('display', 'none');

		// allapot beallitasa
		this.is_open = 1 - this.is_open;
	},


	debug: function(t)
	{
		if ($('debugtext'))
			$('debugtext').setHTML(t);
	}
})
//
// betoltes utan letrehozzuk a peldanyokat
window.addEvent('domready', function()
{
	// z index legyen 100
	var z = 100;

	// a select elemek 'gvSelect' classu span tagek kozott vannak
	var selectContainers = $A($$('span.gvSelect'));
	// vegigzuzunk a containerken
	if (selectContainers.length>0)
	{
		selectContainers.each
		(
			function(sc)
			{
				new gvSelect_(sc, z);
				z--;
			}
		)
	}
});


function AddSelectOption( selectElement, optionText, optionValue ) 
{
    var oOption = document.createElement("OPTION") ;
    oOption.text = optionText ;
    oOption.value = optionValue;
    selectElement.options.add(oOption) ;
    return oOption ;
}
