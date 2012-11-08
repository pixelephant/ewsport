/**
* Picit atirt gvForm osztaly
* - ie6 fix
*/
// grafikus selectbox objektum  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #  #
var gvSelect_ZINDEX = 6500;
var gvSelect = new Class
({
	// init
	initialize: function(selectCont, onchange_function)
	{
		// onchange nincs
		this.ocev = false;
		// container: a span amiben van az eredeti select
		this.container = $(selectCont);

		if (this.container)
		{
			// eredeti select
			this.origSelect = this.container.getElement('select');
			if (typeof(underIE7) == 'undefined'){
				this.onchange_function = onchange_function;
				this.build();
			}else{
				// ha IE < 7,  nem rakunk ki gvSelectet, mert iszonyat lassu
				if ($type(onchange_function) == 'function'){
					this.origSelect.addEvent('change', onchange_function);
				}
			}
		}
	},

	// Reads select's options
	readOptions: function(){
			// Ha IE7 alatt vagyunk akkor csak az eredeti select van, nincs teendonk
			if (!this.optionsArea) return;
			// eredeti optionok visszapakkantasa
			this.optionsArea.empty();
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

						}.bind(this));
					}
					// disabled class ha kell
					else
						option.addClass('disabled');
				

				}.bind(this)
			);	
	},
	//
	build: function()
	{
		// regi select eltunik
		this.origSelect.set('styles',{'display':'none'});

		// helyere bejon a div, amiben az egesz van
		this.select = new Element('div', {'class':'gvSelect', 'styles':{'z-index':gvSelect_ZINDEX}}).inject(this.container);
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
			
			// optionsok bepakolasa
			this.readOptions();

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
		if (this.optionsArea.getStyle('display') == 'none'){
			// az oldal tobbi options div-jet bezarjuk
			$each($$('DIV[class=gvS_optionsArea]'), function(opt){	opt.setStyle('display', 'none');	});
			// ezt kinyitjuk
			this.optionsArea.setStyle('display', 'block');
		}else{
			// ezt bezarjuk
			this.optionsArea.setStyle('display', 'none');
		}
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
	if (container){
		if ($(container)){
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


function AddSelectOption( selectElement, optionText, optionValue ) 
{
    var oOption = document.createElement("OPTION") ;
    oOption.text = optionText ;
    oOption.value = optionValue;
    selectElement.options.add(oOption) ;
    return oOption ;
}
