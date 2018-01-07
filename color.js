class Color {

	constructor (hue, saturation, light) {
	
		this._hue = hue;
		this._saturation = saturation;
		this._light = light;
	
	}
	
	getColor (hue, saturation, light) {
	
		return 'hsl(' + this._hue + ', ' + this._saturation + '%, ' + this._light + '%)';
	
	}
	
}
	
