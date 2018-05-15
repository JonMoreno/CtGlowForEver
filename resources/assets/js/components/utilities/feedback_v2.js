   /**
* FeedBack 
* Purpose: The soul purpose of this class is to
* help output server side validation feedback
* in NO WAY does this class validate forms.
*/
class FeedBack{

    
	/**
	 * Initialze object's messages.
	 * 
	 */
	constructor(){	
        this.messages = {};
        this.styleInputs = {};
        this.styleFeedBacks = {};       
    }

	/**
	 * Retrieve feedback message for the desired 
	 * form field.
	 * 
	 * @param {String} field 
	 */
	feedback(field) {
		if(this.messages[field] )	{
			return this.messages[field];
		}
		
    }
    
	/**
	 * Store feedback message for the desired
	 * form fied.
	 * 
	 * @param {String} field 
	 * @param {String} value 
	 */
	setFeedBack(field , value) {
		this.messages[field] = value;
	}

	/**
	 * This method serves as a getter and 
	 * setter. If only the first argument 
	 * is given it will try to retrieve 
	 * otherwise it will dispatch.
	 * @param {String} field 
	 */
	style(field, type) {
        switch(type) {
            case 'feedback':
                return this.styleFeedBack(field);
                break;
            case 'input':
                return this.styleInput(field);
                break;
        }

    }

    setStyle(field, type, state) {
        switch(type) {
            case 'feedback':
                    this.styleFeedBacks[field] = this.styleFeedBack(field, state)
                break;
            case 'input':
                    this.styleInputs[field] = this.styleInput(field, state)
                break;
        }
    }
    

    styleFeedBack(field, state = false) {
        if(state) {
            if(state == 'valid'){
                return this.validFeedBack();
            }
            return this.inValidFeedBack();
        }
        return this.styleFeedBacks[field]; // pretty much return empty.
    }

    styleInput(field, state = false) {
        let toggle;
        let vi = this;
        if(state) {
            if(state == 'valid'){
                return this.validInput();
            }
            else if( state == 'clear'){
                return this.clearInput();
            }
            else{
                return this.inValidInput();
            }
        }
        return this.styleInputs[field]; // pretty much return empty.
        
    }


    clearInput(){
        return {
            border: "1px solid #ced4da !important",
        }
    }
    validInput(){
        return {
            borderTop: "2px solid #28a745",
            borderBottom: "4px solid #28a745",
            color: "#155724 !important"
        }
    }
    inValidInput(){
        return {
            borderTop: "2px solid #dc3545",
            borderBottom: "4px solid #dc3545",
            color: "#491217 !important"
        }
    }
    validFeedBack(field) {
        return {
            width: "100%",
            marginTop: ".25rem",
            fontSize: "80%",
            color: "#28a745",
        }
    }
    inValidFeedBack(field) {
        return {
            width: "100%",
            marginTop: ".25rem",
            fontSize: "80%",
            color: "#dc3545",
        }
    }



	
}

export default FeedBack;