/**
* Event (event dispatcher)
* Purpose: Facilitate component communication and
* serve as a wrapper class for $event() & $on()
* event handlers.
*/
window.Event = new class {
    
   /**
    * Create a new vue instance.
    */
    constructor() {
        this.vue = new Vue();
        
    }
    
   /**
    * fire an event to any component listening.
    */
    fire(event , data = null) {
	    this.vue.$emit(event, data);
	
    }
    
   /**
    * Listen for event fired by any component.
    */
    listen(event, callback) {
	    this.vue.$on(event, callback);
	
    }
    
}