<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="hu" />
<meta name="author" content="" />
<meta name="description" content="<?php echo $metadescription; ?>" />
<meta name="keywords" content="<?php echo $metakeyword; ?>" /> 
<meta name="reply-to" content="info@.hu" />
<meta name="copyright" content="Copyright &copy; 2010  Kft. - " />
<meta name="robots" content="index, follow, all" />
<meta name="distribution" content="Global" />
<meta name="revisit-after" content="1 Week" />
<meta name="rating" content="General" />
<meta name="doc-type" content="Web Page" />
<meta http-equiv="imagetoolbar" content="no" />
<title><?php echo $metatitle; ?></title>
<base href="http://<? echo getenv("HTTP_HOST"); ?>/" />
<link rel="stylesheet" type="text/css" href="css/site.css" />
<?php 
if (count($sitecss) > 0) {
	foreach ($sitecss as $key => $value) {
		echo '<link rel="stylesheet" type="text/css" href="css/' . $value . '.css" />';		
	}
}	
?>
<link rel="stylesheet" type="text/css" href="css/gvForms.css" />
<script type="text/javascript" src="js/mootools.js"></script>
<script type="text/javascript" src="js/mootools-1.2-more.js"></script>
<script type="text/javascript" src="js/gvForms.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="css/ie.css" />
<![endif]-->
</head>

<script type="text/javascript">
/**
* Az oldalon hasznalt altalanos ajax hivas formaja
*/
var CmooRequest = new Class({
	busy: null,
	errorLayer: null,
	/**
	* A konstruktor
	*/
	initialize: function(){
		this.busy = false;
		this.errorLayer = new CmooErrorLayer();
	},
	/**
	* A beepitett rendszeruzi layer meghivasa
	*/
	alert: function(text){
		this.errorLayer.pop(text);
	},
	/**
	* Az ajax kuldese
	* @param obj opts A kuldendo parameterek
	* @param string url Az ajax php eleresi utja
	* @param function callback A sikeres kuldes utan meghivando fuggveny
	*/
	send: function(opts, url, callback){
		if (this.busy) return;
		this.busy = true;
		var self = this;
		var myJSONRemote = new Request.JSON({
			url: url,
			method:'post',
			async: true,
			data: {'postdata' : opts},
			onComplete: function(obj,str){
				if (obj == null) {
					if (str.length > 0) self.errorLayer.pop(str);
					self.busy = false;
					return;
				}
				if (typeof(obj.error) != 'undefined') {
					if (obj.error == 'session') {
						window.location.pathname = '/';
						return;
					}
					self.errorLayer.pop(obj.error);
					self.busy = false;
					return;
				}
				if (obj.status == 'ok'){
					self.busy = false;
					if ($chk(obj.message)) self.errorLayer.pop(obj.message);
					callback(obj);
					return;
				}
			}
		}).send();
	}
});


var CmooErrorLayer = new Class({
	state: false,
	oContainer: null,
	oPopuptext: null,
	oCloseBTN: null,
	isOpen: function(){ return this.state; },
	initialize: function() {
		if (!$chk($('mmt_cmooerrorlayer_popup'))) this.layerInject();
		this.oContainer = $('mmt_cmooerrorlayer_popup');
		this.oPopuptext = $('mmt_cmooerrorlayer_text');
		this.oCloseBTN = $('mmt_cmooerrorlayer_close');
		window.addEvent('resize',(this.moveCenter).bind(this));
		window.addEvent('scroll',(this.moveCenter).bind(this));
		this.oCloseBTN.addEvent('click', this.close.bind(this));
		this.moveCenter();
	},
	layerInject: function(){
		var layer = new Element('div',{'class':'mmt_layer mmt_layer_550 select-free','id':'mmt_cmooerrorlayer_popup'});
		layer.set('html','<div class="mmt_layer_top">\
							<div class="box_head_text head_rendszeruzenet"></div>\
						  </div>\
						  <div class="mmt_layer_bg">\
							<div class="mmt_layer_cont">\
							  <div id="mmt_cmooerrorlayer_text"></div>\
							  <div class="clear_10"></div>\
							  <div class="form_button">\
								<div class="form_button_close"><a href="" id="mmt_cmooerrorlayer_close"></a></div>\
							  </div>\
							  <div class="clear"></div>\
							 </div>\
						  </div>\
						  <div class="mmt_layer_bot"></div>\
						  <!--[if IE 6]><iframe></iframe><![endif]-->').setStyle('visibility','hidden');
		layer.inject($('container'), 'top');
	},
	moveCenter: function(){
		if (!this.isOpen()) return;
		//y pozicio szamitasa, beallitasa***** CREDITS: thx Gui, Lefi :))
		//itt most fixen 550x170 az ablak merete
		ypos = window.getScroll().y + ((window.getSize().y/2)-(170/2));
		xpos = window.getScroll().x + ((window.getSize().x/2)-(550/2));
		this.oContainer.setStyle('left', xpos);
		this.oContainer.setStyle('top', ypos);
		// ************************************
	},
	open: function(){
		if (!this.isOpen()){
			this.state=true;
			this.moveCenter();
			this.oContainer.setStyle('visibility','visible');
		}
	},
	close: function(event){
		if ($chk(event)) event.stop();
		if (this.isOpen()){
			this.state=false;
			this.oContainer.setStyle('visibility','hidden');
		}
	},
	pop: function(text){
		if (this.isOpen()) return false;
		this.oPopuptext.set('html',text);
		this.open();
	}
});



		/**
		* CmooSelectRange osztaly, 2 db gvSelect elemet kezelo intervallumot definialo osztaly, ahol a min < max
		*/
		var CmooSelectRange = new Class({
			Emin: null,
			Emax: null,
			range: null,
			minValue: null,
			maxValue: null,
			/**
			* A konstruktor
			* @param Object params A mukodesi parameterek atadasa.
			*/
			initialize: function(params){
				this.Emin = params.min_element;
				this.Emax = params.max_element;
				this.range = JSON.decode(params.range);
				this.minValue = params.min_value;
				this.maxValue = params.max_value;
				this.redrawMin();
				this.redrawMax();
			},
			redrawMin: function(){
				var span = new Element('span', {'class': 'gvSelect'});
				var select = new Element('select', {'name': this.Emin.getElement('select').get('name')});
				$each(this.range, function(item, index){
					if (index >= this.maxValue) return;
					new Element('option', {'html': item, 'value': index, 'selected': (index == this.minValue ? 'selected' : '')}).inject(select);
				}.bind(this));
				select.inject(span);
				this.Emin.empty();
				span.inject(this.Emin);
				new gvSelect(this.Emin, this.minChange.bind(this));
			},
			redrawMax: function(){
				var span = new Element('span', {'class': 'gvSelect'});
				var select = new Element('select', {'name': this.Emax.getElement('select').get('name')});
				$each(this.range, function(item, index){
					if (index <= this.minValue) return;
					new Element('option', {'html': item, 'value': index, 'selected': (index == this.maxValue ? 'selected' : '')}).inject(select);
				}.bind(this));
				select.inject(span);
				this.Emax.empty();
				span.inject(this.Emax);
				new gvSelect(this.Emax, this.maxChange.bind(this));
			},
			minChange: function(){
				this.minValue = parseInt(this.Emin.getElement('select').get('value'));
				this.redrawMax();
			},
			maxChange: function(){
				this.maxValue = parseInt(this.Emax.getElement('select').get('value'));
				this.redrawMin();
			}
		});

				
/**
* Ez a js vezereli az orszag - allam - varos keresoket
* Ha az orszag US akkor az allam / varos autocomplete select, kulonben eltunnek.
* - state es city csak akkor ha a country US
* - a city opcionalis, hogy a nyiton levo is mukodjon rola
* 
*/
/*
var CmooLocationSearch = new Class({
	Implements: Options,
	options: {
		containers:{
			country: null,
			city: null
		},
		defaults: {
			city: null
		},
		hasCity: true
	},
	request: null,
	/**
	* Konstruktor
	*/
	initialize: function(options){
		this.setOptions(options);
		this.request = new CmooRequest();
		new gvSelect(this.options.containers.country.getElement('span'), this.onCountryChange.bind(this));
		this.onCountryChange(this.options.defaults);
	},
	/**
	* Orszag select valtozott
	*/
	onCountryChange: function(defaults){
		var countrycode = this.options.containers.country.getElement('select').get('value');
		if (countrycode == 'US'){
			this.getStates(defaults);
		}else{
			//this.options.containers.state.setStyle('display', 'none');
			if (this.options.hasCity) this.options.containers.city.setStyle('display', 'none');
		}
	},
	/**
	* Az allam select valtozott
	*/
	onStateChange: function(){
		if (this.options.hasCity) this.getCities();
	},
	/**
	* Az allamok lekerdezese ajaxxal
	*/
	getStates: function(defaults){
		this.request.send({
			'function': 'getState',
			'zipcode': ''
		}, '/ajax/ajax_zipcode_autocomplete.php', function(obj){
			this.fillStates(obj.states, defaults);
			if (this.options.hasCity) this.getCities(defaults);
		}.bind(this));
	},
	/**
	* A varosok lekerdezese ajaxxal
	*/
	getCities: function(defaults){
		var result = this.request.send({
			'function': 'getCity',
			'state': this.options.containers.state.getElement('select').get('value'),
			'zipcode': ''
		},  '/ajax/ajax_zipcode_autocomplete.php', function(obj){
			this.fillCities(obj.cities, defaults); 
		}.bind(this));
	},
	/**
	* Az allamok feltoltese a states tomb alapjan
	*/
	fillStates: function(states, defaults){
		var stateSpan = this.options.containers.state.getElement('span');
		var selName = stateSpan.getElement('select').get('name');
		var select = new Element('select', {'name': selName});
		if (states != null){
			states.each(function(state){
				new Element('option', {'html': state, 'value': state}).set('selected', ($chk(defaults) && (defaults.state == state))).inject(select);
			});
		}
		stateSpan.empty();
		select.inject(stateSpan);
		new gvSelect(stateSpan, this.onStateChange.bind(this));
		this.options.containers.state.setStyle('display', 'block');
	},
	/**
	* Varosok feltoltese a cities tomb alapjan
	*/
	fillCities: function(cities, defaults){
		var citySpan = this.options.containers.city.getElement('span');
		var selName = this.options.containers.city.getElement('select').get('name');
		var select = new Element('select', {'name': selName});
		if (cities != null){
			cities.each(function(city){
				new Element('option', {'html': city, 'value': city}).set('selected', ($chk(defaults) && (defaults.city == city))).inject(select);
			});
		}
		citySpan.empty();
		select.inject(citySpan);
		new gvSelect(citySpan);
		this.options.containers.city.setStyle('display', 'block');
	}
});
*/
var CmooQuickSearchBox = new Class({
	Implements: Options,
	options: {
		elements: {
			country: null,
			city: null,
		},
		values: {
			hasCity: true
		}
	},
	initialize: function(options){
		this.setOptions(options);
		new CmooLocationSearch({
			containers:{
				country: this.options.elements.country,
				state: this.options.elements.state,
				city: this.options.elements.city
			},
			hasCity: this.options.values.hasCity
		});
		new CmooSelectRange({
			min_element: this.options.elements.age_min,
			max_element: this.options.elements.age_max,
			range: this.options.values.age_range,
			min_value: this.options.values.age_min,
			max_value: this.options.values.age_max
		});
	}
});


/**
* A publikus nyito oldalhoz tartozo js
*/

var nyito = new Class({
	/**
	* Konstruktor
	*/
	initialize: function(){
		new CmooQuickSearchBox({
			elements:{
				country: $('qs_country'),
				city: $('qs_city'),
			},
			values: {
				hasCity: false
			}
		});
	}
});

document.addEvent('domready', function(){
	new nyito();
});

</script>