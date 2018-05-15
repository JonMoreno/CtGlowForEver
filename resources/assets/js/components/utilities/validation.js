/**
* Validation
* Purpose: Facilitate form validation.
* 	Min: int Max: int Type: int Required: Boolean
*   Returns validation message.
info gtbm
*/
class Validation {

	/**
	 * Constructor will initialize vairables
	 * that wil be used by this object.
	 * 
	 */
	constructor() {
		this.rules = {};
		this.lang = {
			english: true,
			spanish: false
		}
	}

	/**
	 * Dinamically select language option for the 
	 * feedback you will receive when retrieving
	 * a validation message.
	 * 
	 */
	setLanguge(pick) {
		for(let option in this.lang){
			if(option == pick){
				this.lang[option] = true;
			}else{
				this.lang[option] = false;
			}
		}
	}
	

	/**
	 * fieldName{ min: , max: , type: , required: ,};
	 * Set all the rules for a given field. Each 
	 * field must have a min, max, type and
	 * required as properties.
	 *  
	 * @param {Object/Array} rules 
	 */
	setRules(rules) {
		this.rules = rules;

	}

	/**
	 * Retrieve message for the field that
	 * was validated. Do not try to store
	 * validation messages in this class
	 * it only serves for validation
	 * 
	 * @param {String} field 
	 * @returns {void}
	 */
	getMessage(field){
		if(field.length > 0){
			if(this.messages[field] !== "undefined"){
				var message = this.messages[field];
				delete this.messages;
				return message;
			}else{
				console.log('No get message here');
			}
		}
	}
   
	/**
	 * Wrapper for all of the methods this object
	 * holds. It's purpose is to validate the 
	 * given field and field value.
	 * 
	 * @param {String} field 
	 * @param {String/Boolean/Number} input
	 */
	validate(field, input){
		if(this.hasRule(field)){
			if(this.rules[field].type == 'array'){
				return this.verify(field, input);
			}else{
				return this.verify(field, input.toString().trim() );
			}
		}
	}

	/**
	 * Make sure that validation rules exists 
	 * for the given field.
	 * 
	 * @param {string} field
	 */
	hasRule(field) {
		if(this.rules[field] ){
			return true;
		}

	}

	/**
	 * Assure that the given field, and given field 
	 * value have a rule to follow, and also 
	 * verifies the rules for the field
	 * are met by the given values.
	 * 
	 * @param {String} field 
	 * @param {String/Boolean/Number} input 
	 */
	verify(field , input){
		if(this.meetsConditions(field, input) ){
			return true;
		}
		return false;
	}

	/**
	 * This method does some of the heavy lifting 
	 * by performing several validation steps
	 * according to the rules the were 
	 * set in place by setRules().
	 * 
	 * @param {String} field 
	 * @param {String} input 
	 * @returns {Boolean}
	 */
	meetsConditions(field, input){
		if(!this.isSkipAble(field,input)){
			if(	
				this.isRequired(field, input) &&
				this.isThisType(field, input) &&
				this.isThisMin(field, input) &&	
			   	this.isThisMax(field, input) 
			){
				this.messages = {[field]: 'Looks Good!'};
				return true;
			}
			return false;

		}
		return true;
		
	}

	/**
	 * Serves as a way to skip over validating certain
	 * aspects for the form field. If the field is
	 * not required and it is empty the no neeed
	 * to validated the field any further.
	 * 
	 * @param {String} field 
	 * @param {String} input
	 * @returns {Boolean} 
	 */
	isSkipAble(field, input){ // isRequired() 
		if(this.rules[field].required == false && input.length == 0){
			return true;
		}
		return false;
	}

	isRequired(field, input) {
		var  field_name = field.toString().replace(/[_-]/g, " ");
		
		if(this.rules[field].required == true && input.length == 0) {
			if(this.isLangEnglish()){
				this.messages = {[field]: 'The ' + field_name + ' is required...'};
			}else{
				this.messages = {[field]: 'Esto es requerido...'};
			}
			
			return false;
		}
		return true;
	}

	/**
	 * Serves as way to verify if a given field meets
	 * the required rule of minimum characters.
	 * 
	 * @param {String} field 
	 * @param {String} input 
	 * @returns {Boolean}
	 */
	isThisMin(field, input) {
		if(	
			this.rules[field].type == 'date' || 
			this.rules[field].type ==  'time' || 
			this.rules[field].type ==  'boolean'
		 ){
			return true;

		}else{

			var  field_name = field.toString().replace(/[_-]/g, " ");
			if(input.length < this.rules[field].min){
				if(this.rules[field].type == 'array'){
					if(this.isLangEnglish()){
						this.messages = {[field]: 'The ' + field_name + ' must have at least ' + this.rules[field].min + ' entries...'};
					}else{
						this.messages = {[field]: 'Esto debe tener al menos ' + this.rules[field].min + ' elementos de lista...'};
					}
					return false
				}else{
					if(this.isLangEnglish()){
						this.messages = {[field]: 'The ' + field_name + ' is too short...'};
					}else{
						this.messages = {[field]: 'Esto es demasiado corto..'};
					}
					return false
				}
			}
			return true;
		}
	}
	
	/**
	 * Serves as way to verify if a given field meets
	 * the required rule of maximum characters.
	 * 
	 * @param {String} field 
	 * @param {String} input 
	 * @returns {Boolean}
	 */
	isThisMax(field, input) {
		if(	
			this.rules[field].type == 'date' || 
			this.rules[field].type ==  'time' || 
			this.rules[field].type ==  'boolean'
		 ){
			return true;
			
		}else{
			var  field_name = field.toString().replace(/[_-]/g, " ");
			if(input.length > this.rules[field].max){
				if(this.rules[field].type == 'array'){
					if(this.isLangEnglish()){
						this.messages = {[field]: 'The ' + field_name + ' must have no more than ' + this.rules[field].max + ' entries...'};
					}else{
						this.messages = {[field]: 'Esto no debe tener más que ' + this.rules[field].max + ' elementos de lista...'};
					}
					return false
				}else{
					if(this.isLangEnglish()){
						this.messages = { [field]: 'The ' + field_name + ' must contain ' + this.rules[field].max + ' or less characters...' };
					}else{
						this.messages = { [field]: 'The ' + field_name + 'esto debe contener ' + this.rules[field].max + '  o menos caracteres...'};
					}
					return false;	
				}		
			}
			return true;
		}
	}

	/**
	 * Serves as way to verify if a given field meets
	 * the required rules of type wich involve 
	 * text , number, date, and email. 
	 * for now...
	 * 
	 * @param {String} field 
	 * @param {String} input 
	 * @returns {Boolean}
	 */
	isThisType(field, input){
		switch(this.rules[field].type) {
			case 'text':
					return this.isText(field, input);
				break;
			case 'date':
					return this.isDate(field, input);
				break;
			case 'time':
					return this.isTime(field, input);
				break;
			case 'email':
					return this.isEmail(field, input);
				break;
			case 'phone':
					return this.isPhone(field, input);
				break;
			case 'price': 
				return this.isPrice(field, input);
				break;
			case 'number': 
					return this.isNumber(field, input);
				break;
			case 'boolean':
					return this.isBoolean(field, input);
			case 'array':
					return this.isArrey(field, input);			
			default:
				return false;
		}

	}
	
	/**
	 * Serves as way to validate if the given
	 * field's value is of type text;
	 * 
	 * @param {String} field 
	 * @returns {Boolean}
	 */
	isText(field, input) {
		var field_name = field.toString().replace(/[_-]/g, " ");
		if(typeof input !== 'string'){
			if(this.isLangEnglish()){
				this.messages = {[field]: 'The ' + field_name + ' must contain letters only...'};
			}else{
				this.messages = {[field]: 'Esto debe contener solo letras...'};
			}
			return false; 
		}
		return true; 
	}

	/**
	 * Serves as way to validate if the given
	 * field's value meets date format.
	 * 
	 * @param {String} field 
	 * @returns {Boolean}
	 */
	isDate(field, date) {
		var dateRegex = /^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/;
		var unixRegex = /^\d{4}\-\d{1,2}\-\d{1,2}$/;

		var field_name = field.toString().replace(/[_-]/g, " ");
		if(!dateRegex.test(date) && !unixRegex.test(date)) {
			if(this.isLangEnglish()){
				this.messages = { [field]: 'The ' + field_name + ' must follow this format mm/dd/yyyy'};
			}else{
				this.messages = { [field]: 'Esto debe seguir este formato mm/dd/aaaa'};
			}
			return false;
		}
		return true;
		 
	}



	isTime(field, time) {
		var timeRegex = /^(0?[1-9]|1[012])(:[0-5]\d)[APap][mM]$/;
		var militaryRegex = /^([01]\d|2[0-3]):?([0-5]\d)$/;
		//var militaryTimeRegex = /^(10|11|12|[1-9]):[0-5][0-9]$/;
		var field_name = field.toString().replace(/[_-]/g, " ");
		if(!timeRegex.test(time) && !militaryRegex.test(time)) {
			if(this.isLangEnglish()){
				this.messages = { [field]: 'The ' + field_name + ' must follow this format hr/min/ + AM or PM'};
			}else{
				this.messages = { [field]: 'Esto debe seguir este formato hr / min / + AM o PM'};
			}
			return false;
		}
		return true;
	}




	/**
	 * Serves as way to validate if the given
	 * field's value meets email format;
	 * 
	 * @param {String} field 
	 * @returns {Boolean}
	 */
	isEmail(field, input) {
		var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		var field_name = field.toString().replace(/[_-]/g, " ");
		if(!emailRegex.test(input)) {
			if(this.isLangEnglish()){
				this.messages = { [field]: 'The ' + field_name + ' must follow this format:  johnsmith@smith.com'};
			}else{
				this.messages = { [field]: 'Esto debe seguir este formato: johnsmith@smith.com'};
			}
			return false;
		}
		return true;
	}

	/**
	 * Serves as way to validate if the given
	 * field's value meets phone format.
	 * 
	 * @param {String} field 
	 * @returns {Boolean}
	 */
	isPhone(field, input) {
		var phoneRegex = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
		var field_name = field.toString().replace(/[_-]/g, " ");
		
		if(!phoneRegex.test(input)){
			if(this.isLangEnglish()){
				this.messages = {[field]: 'The ' + field_name + ' must follow this formats: (123)-456-7890'};
			}else{
				this.messages = {[field]: 'Esto debe seguir este formato: (123) -456-7890'};
			}
			return false;
		}
		return true;
	}

	/**
	 * Serves as way to validate if the given
	 * field's value is of type number;
	 * 
	 * @param {String} field 
	 * @returns {Boolean}
	 */
	isPrice(field, input) {
		var priceRegex = /^(\d+\.\d{1,2})$/;
		var field_name = field.toString().replace(/[_-]/g, " ");
		if(!priceRegex.test(input)){
			if(this.isLangEnglish()){
				this.messages = {[field]: 'The ' + field_name + ' must follow format USD 00.00'};
			}else{
				this.messages = {[field]: 'Esto debe seguir este formato: USD 00.00'};
			}
			return false;
		}
		return true;
	}

	/**
	 * Serves as way to validate if the given
	 * field's value is of type number;
	 * 
	 * @param {String} field 
	 * @returns {Boolean}
	 */
	isNumber(field, input) {
		var field_name = field.toString().replace(/[_-]/g, " ");
		if(isNaN(input)){
			if(this.isLangEnglish()){
				this.messages = {[field]: 'The ' + field_name + ' must contain numbers only.'};
			}else{
				this.messages = {[field]: 'Esto debe contener solo números.'};
			}
			return false;
		}
		return true;
	}



	/**
	 * Validate if give field's input is a boolean value.
	 * 
	 * @param {String} field 
	 * @param {String} input 
	 */
	isBoolean(field, input){
		var field_name = field.toString().replace(/[_-]/g, " ");
		var toBool = Boolean(input);
		if(typeof toBool !== 'boolean' && input !== 1 && input !== 0) {
			if(this.isLangEnglish()){
				this.messages = { [field]: 'The ' + field_name + ' must be Yes or No'};
			}else{
				this.messages = { [field]: 'Esto debe ser Sí o No'};
			}
			return false;
		}
		return true;
	}

	/**
	 * Validate if give field's input is an Array.
	 * 
	 * @param {String} field 
	 * @param {Array} input 
	 */
	isArrey(field, input){
		var field_name = field.toString().replace(/[_-]/g, " ");
		if(!Array.isArray(input)){
			if(this.isLangEnglish()){
				this.messages = { [field]: 'The ' + field_name + ' must have some entries...'};
			}else{
				this.messages = { [field]: 'Esto debe tener alguna entrada...'};
			}
			return false;
		}
		return true;
	}

	isLangEnglish(){
		if(this.lang.english){
			return true;
		}
		return false;
	}
}


export default Validation;