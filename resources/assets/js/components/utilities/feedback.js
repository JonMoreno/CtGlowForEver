   /**
* FeedBack 
* Purpose: The soul purpose of this class is to
* help output server side validation feedback
* in NO WAY does this class "actual" validate forms.
*/
class FeedBack{

	/**
	 * Initialze object's messages.
	 * 
	 */
	constructor(){	
		this.messages = {};
		this.class = {};

	}

	/**
	 * Store feedback message for the desired
	 * form fied.
	 * 
	 * @param {String} field 
	 * @param {String} value 
	 */
	set(field , value) {
		this.messages[field] = value;
	}

	/**
	 * Retrieve feedback message for the desired 
	 * form field.
	 * 
	 * @param {String} field 
	 */
	get(field) {
		if(this.messages[field] )	{
			return this.messages[field];
		}
		
	}

	/**
	 * This method serves as a getter and 
	 * setter. If only the first argument 
	 * is given it will try to retrieve 
	 * otherwise it will dispatch.
	 * @param {String} field 
	 */
	style(field , style = false) {
		if(!style){
			return this.class[field];
		}
		return this.class[field] = style;		
	}

	show(field){
		if(this.messages[field]){
			return true;
		}
		return false;
	}
	
}

export default FeedBack;