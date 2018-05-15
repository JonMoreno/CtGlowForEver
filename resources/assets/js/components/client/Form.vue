// CLIENT: NEW RECORD TEMPLATE
</<template>

<div>
    <!-- TWO WAY GRID HOLDER -->
    <div class="row">


        <!-- VISUAL COL -->
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
            <br/>
            <br/>
            <div class="card bg-primary text-white ml-3">
                <div class="card-header">
                        <i class="fa fa-address-card-o fa-lg"></i>
                        New Client Record:
                </div>
                <ul class="list-group-item list-group-flush px-2">
                    <li class="list-group-item">
                        <span class="text-primary">First Name:</span>
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.first_name }}
                            <span v-show="editing.first_name">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <span class="text-primary"> Middle Initial:</span
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.mid_initial }}
                            <span v-show="editing.mid_initial">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item">
                        <span class="text-primary">Last Name:</span
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.last_name }}
                            <span v-show="editing.last_name">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item text-dark">
                        <span class="text-primary"> Email:</span>
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.email }}
                            <span v-show="editing.email">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item text-dark">
                       <span class="text-primary"> Gender: </span>
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.gender }}
                            <span v-show="editing.gender">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item text-dark">
                        <span class="text-primary">Date of birth:</span>
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.dob }}
                            <span v-show="editing.dob">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item text-dark">
                        <span class="text-primary">Apt/Floor:</span>
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.apt_floor }}
                            <span v-show="editing.apt_floor">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item text-dark">
                        <span class="text-primary">Street:</span>
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.address }}
                            <span v-show="editing.address">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item text-dark">
                        <span class="text-primary">City</span>
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.city}}
                            <span v-show="editing.city">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item text-dark">
                        <span class="text-primary">State:</span>
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.state }}
                            <span v-show="editing.state">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item text-dark">
                        <span class="text-primary">Zip Code:</span>
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.zip }}
                            <span v-show="editing.zip">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item text-dark">
                        <span class="text-primary">Mobile:</span>
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.cellular }}
                            <span v-show="editing.cellular">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item text-dark">
                        <span class="text-primary">Work Phone:</span>
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.work_phone }}
                            <span v-show="editing.work_phone">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item text-dark">
                        <span class="text-primary">Emergency Phone:</span>
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.emergency_phone}}
                            <span v-show="editing.emergency_phone">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item text-dark">
                        <span class="text-primary">Occupation:</span>
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.occupation }}
                            <span v-show="editing.occupation">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item text-dark">
                        <span class="text-primary">First facial:</span>
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.first_facial ? 'Yes': 'No' }}
                            <span v-show="editing.first_facial">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    <li class="list-group-item text-dark">
                        <span class="text-primary">Reason for visit:</span>
                        <span v-bind:class="{'font-weight-bold':edit}" class="d-inline-block" >
                            {{ client.visit_reason }}
                            <span v-show="editing.visit_reason">
                                <i class="fa fa-caret-left fa-lg text-primary"></i> 
                                <hr	class="my-0"/>
                            </span>
                        </span>
                    </li>
                    
                </ul>
            </div>
        </div>



        <!-- FORM COL -->
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-8">
            <!-- NEW CLIENT FORM ROW -->
            <form   action="#" 
                    method="POST"
                    class="form-row pl-2"
                    enctype="multipart/form-data"

                    v-on:keyup="validateField($event.target.name)" 
                    v-on:change="validateField($event.target.name)"
                    v-on:click="applyCaret($event.target.name)"
            >
            
            <!-- CREDENTIALS -->    
             <legend class="pt-2">
                <small class="text-primary">
                   
                    Credentials:
                </small>
            </legend> 
            <!-- FIRST NAME -->
                <!-- COL -->
                <div class="form-group col-5">
                    <label class="col-form-label">
                        <i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i> 
                        First Name 
                    </label>
                    <input  type="text" 
                            name="first_name" 
                            class="form-control" 
                            placeholder="John"

                            v-model.trim="client.first_name"
                            v-bind:class="feedback.style('first_name')"
                    >
                    <div class="invalid-feedback">
                        {{ feedback.get('first_name') }}
                    </div>
                </div><!-- ../COL -->
            <!-- MID INITIAL -->
                <!-- COL -->
                <div class="form-group col-2">
                    <label class="col-form-label">
                        <i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i> 
                        Mid Initial
                    </label>
                    <input  type="text" 
                            name="mid_initial" 
                            class="form-control" 
                            placeholder="S"

                            v-model.trim="client.mid_initial"
                            v-bind:class="feedback.style('mid_initial')"
                    >
                    <div class="invalid-feedback">
                        {{ feedback.get('mid_initial') }}
                    </div>
                </div><!-- ../COL -->
            <!-- LAST NAME -->
                <!-- COL -->
                <div class="form-group col-5">
                    <label class="col-form-label">
                        <i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i> 
                        Last Name
                    </label>
                    <input  type="text" 
                            name="last_name" 
                            class="form-control" 
                            placeholder="Smith"

                            v-model.trim="client.last_name"
                            v-bind:class="feedback.style('last_name')"
                    >
                    <div class="invalid-feedback">
                        {{ feedback.get('last_name') }}
                    </div>
                </div><!-- ../COL -->
            <!-- EMAIL -->
                <!-- COL -->
                <div class="form-group col-5">
                    <label class="col-form-label">
                        <i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i> 
                        Email
                    </label>
                    <input  type="text" 
                            name="email" 
                            class="form-control" 
                            placeholder="JohnSmith@email.com"

                            v-model.trim="client.email"
                            v-bind:class="feedback.style('email')"
                    >
                    <div class="invalid-feedback">
                        {{ feedback.get('email') }}
                    </div>
                </div><!-- ../COL -->
            <!-- GENDER -->
                <!-- -COL -->
                <div class="form-group col-3">
                        <label>
                            <i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i>
                            Gender
                        </label>
                        <div class="col">
                           <select name="gender"
                                    class="form-control"
                                
                                    v-model="client.gender"
                                    v-bind:class="feedback.style('gender')" 
								>
									<option value="">Please select one</option>
  									<option>female</option>
  									<option>male</option>
  									<option>other</option>
							</select>
							<div class="invalid-feedback" v-text="feedback.get('gender')"></div> 
                        </div>
					</div><!-- ../COL -->
            <!-- DATE OF BIRTH -->
                <!-- COL -->
                <div class="form-group col-4">
                    <label class="col-form-label">
                        <i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i> 
                        Date of birth
                    </label>
                    <input  type="text" 
                            name="dob" 
                            class="form-control" 
                            placeholder="mm/dd/yyyy"

                            v-model.trim="client.dob"
                            v-bind:class="feedback.style('dob')"
                    >
                    <div class="invalid-feedback">
                        {{ feedback.get('dob') }}
                    </div>
                </div><!-- ../COL -->

            <!-- LIVING -->    
             <legend class="pt-2">
                <small class="text-primary">
                   
                    Living:
                </small>
            </legend> 
            <!-- APT / FLOOR -->
                <!-- COL -->
                <div class="form-group col-4">
                    <label class="col-form-label">
                        <i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i> 
                        Apt floor
                    </label>
                    <input  type="text" 
                            name="apt_floor" 
                            class="form-control" 
                            placeholder="1"

                            v-model.trim="client.apt_floor"
                            v-bind:class="feedback.style('apt_floor')"
                    >
                    <div class="invalid-feedback">
                        {{ feedback.get('apt_floor') }}
                    </div>
                </div><!-- ../COL -->
            <!-- Address -->
                <!-- COL -->
                <div class="form-group col-8">
                    <label class="col-form-label">
                        <i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i> 
                        Address
                    </label>
                    <input  type="text" 
                            name="street" 
                            class="form-control" 
                            placeholder="123 Smith St."

                            v-model.trim="client.address"
                            v-bind:class="feedback.style('street')"
                    >
                    <div class="invalid-feedback">
                        {{ feedback.get('street') }}
                    </div>
                </div><!-- ../COL -->
            <!-- CITY -->
                <!-- COL -->
                <div class="form-group col-5">
                    <label class="col-form-label">
                        <i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i> 
                        City
                    </label>
                    <input  type="text" 
                            name="city" 
                            class="form-control" 
                            placeholder="new york city"

                            v-model.trim="client.city"
                            v-bind:class="feedback.style('city')"
                    >
                    <div class="invalid-feedback">
                        {{ feedback.get('city') }}
                    </div>
                </div><!-- ../COL -->
            <!-- STATE -->
                <!-- COL -->
                <div class="form-group col-2">
                    <label class="col-form-label">
                        <i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i> 
                        State
                    </label>
                    <select type="text"
                            name="state"
                            class="form-control"
                        
                            v-model.trim="client.state"
                            v-bind:class="feedback.style('state')" 
                    >
                        <option value="">Select your state</option>
                        <option v-for="(state, index) in states" v-bind:key="index" v-bind:value="state">{{ state }}</option>
                    </select>
                    <div class="invalid-feedback" v-text="feedback.get('state')"></div> 
                </div><!-- ../COL -->
            <!-- ZIP CODE -->
                <!-- COL -->
                <div class="form-group col-5">
                    <label class="col-form-label">
                        <i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i> 
                        Zip Code
                    </label>
                    <input  type="text" 
                            name="zip" 
                            class="form-control" 
                            placeholder="new york city"

                            v-model.trim="client.zip"
                            v-bind:class="feedback.style('zip')"
                    >
                    <div class="invalid-feedback">
                        {{ feedback.get('zip') }}
                    </div>
                </div>
            
        <!-- CONTACT -->    
             <legend class="pt-2">
                <small class="text-primary">
                   
                    Contact:
                </small>
            </legend>  
            <!-- MOBILE -->
					<!-- COL -->
					<div class="form-group col">
						<label class="col-form-label">
							<i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i>
                             Mobile
						 </label>
						<input  name="cellular" 
                                type="phone" 
                                class="form-control" 
                                placeholder="(123)-123-1234" 
                                
                                v-model.trim="client.cellular"
                                v-bind:class="feedback.style('cellular')"
                        >
                        <div class="invalid-feedback" v-text="feedback.get('cellular')"></div> 
					</div> <!-- ../COL -->
					
				<!-- WORK PHONE -->
					<!-- COL -->
				    <div class="form-group col">
						<label class="col-form-label"> 
							<i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i> 
                            Work Phone 
						</label>
						<input  name="work_phone" 
                                type="phone" 
                                class="form-control" 
                                placeholder="(123)-123-1234" 
                                
                                v-model.trim="client.work_phone"
                                v-bind:class="feedback.style('work_phone')"
                        
                        >
                        <div class="invalid-feedback" v-text="feedback.get('work_phone')"></div> 
					</div> <!-- ../COL -->
					
				<!-- EMERGENCY PHONE -->
					<!-- COL -->
					<div class="form-group col">
						<label class="col-form-label">
							<i class="fa fa-plus-square-o text-primary" aria-hidden="true"></i>
                             Emergency Phone 
						</label>
						<input  name="emergency_phone" 
                                type="phone" 
                                class="form-control" 
                                placeholder="(123)-123-1234" 
                                
                                v-model.trim="client.emergency_phone"
                                v-bind:class="feedback.style('emergency_phone')"
                        >
                        <div class="invalid-feedback" v-text="feedback.get('emergency_phone')"></div>
					</div> <!-- ../COL -->
                
            <!-- OTHER -->    
                <legend > 
                        <small class="text-primary">
                            <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                            Other:
                        </small>
                </legend>
                <!-- OCCUPATION-->
                    <!-- form-group col -->
                    <div class="form-group col-6">
                        <label class="col-form-label">
                            Occupation:
                        </label>
                            <input  type="text"
                                    name="occupation"
                                    class="form-control form-control-sm"
                                
                                    v-model="client.first_facial"
                                    v-bind:class="feedback.style('occupation')" 
                            >
                            <div class="invalid-feedback" v-text="feedback.get('occupation')"></div> 
                        
                    </div><!-- ../form-group col -->

                <!-- FIRST FACIAL -->
                    <!-- form-group col -->
                    <div class="form-group col-6">
                        <label class="col-form-label">
                            First Facial:
                        </label>
                            <select type="text"
                                    name="first_facial"
                                    class="form-control form-control-sm"
                                
                                    v-model="client.first_facial"
                                    v-bind:class="feedback.style('first_facial')" 
                            >
                                <option>Please make a selection</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option> 
                            </select>
                            <div class="invalid-feedback" v-text="feedback.get('first_facial')"></div> 
                        
                    </div><!-- ../form-group col -->
                
                <!-- REASON FOR VISIT -->
                    <!-- form-group col -->
                    <div class="form-group col-12">
                        <label class="col-form-label">
                            Reason for visit:
                        </label>
                        <textarea 	type="text"
                                    rows="4"
                                    name="visit_reason"
                                    class="form-control" 

                                    v-model="client.visit_reason " 
                                    v-bind:class="feedback.style('visit_reason')"

                        >
                        </textarea>
                        <div class="invalid-feedback" v-text="feedback.get('visit_reason')"></div> 
                    </div><!-- ../form-group col -->



                <!-- PROFILE IMAGE -->  
                    <div class="form-group col-12">
                          
                        <legend class="text-center text-primary pt-2">
                                <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                Client Profile Image:
                        </legend>
                        <div class="text-center">
                            File Name: <code>{{ client.image }}</code>
                        </div>
                        <div class="text-center">
                            <label class="custom-file">
                                <input 	name="image" 
                                        type="file" 
                                        class="custom-file-input" 
                                            
                                        v-on:change="onFileChange"
                                    >
                                <span class="custom-file-control"></span>
                            </label>
                        </div>
                    </div>

            </form>
        </div>


    </div>
</div>
  
</template>


// CLIENT: NEW RECORD COMPONENT
<script type="text/javascript">

//Lodash_________________________________________
window._ = require('lodash');

//Components_____________________________________
import AlertFail from '../alert/Fail.vue';

//Utilies________________________________________
import FeedBack from "../utilities/feedback.js";
import Validation from "../utilities/validation.js";
import FormRules from "./forms/client_basic_rules.js";
import UsaStates from "./forms/usa_states.js";

export default {

	components: {
		'alert-fail': AlertFail,
	},
	data: function() {
        return {
            // form fields:
            client: {
                first_name: '',
                last_name: '',
                mid_initial: '',
                email: '',
                dob: '',
                street: '',
                apt_floor: '',
                city: '',
                state: '',
                zip: '',
                work_phone: '',
                emergency_phone: '',
                cellular: '',
                occupation: '',
                gender: '',
                image: '',
                first_facial: '',
                visit_reason: '',

            },
            route: '/clients/',
            edit: false,
            editing: {},
            alert: {
                view: true,
                fail: {
                    state: false,
                    msg: '',
                }
            },
            feedback: new FeedBack(),
            form: new Validation(),
            states: [],
            style_image: '',
            feedback_image: '',
        }
    },
    methods: {
        // ______________________________________________
		// FORM EVENTS & VALIDATION:
		// ______________________________________________
		applyCaret: function(field){
			let property = Object.keys(this.editing);
			this.editing[field] = true;
			for(let name in property){
				if(property[name] !== field){
					this.editing[property[name]] = false;
				}
				
			}			

		},
		validateField: _.debounce(function(value) {
			if(value !== 'image') {
				let that = (this); 
				let field = value;	let input = that.client[value];			
				if(that.form.validate(field, input)){		// validation checkpoint.
					//value === 'first_name' || value === 'last_name' ? that.broadCastToAsideNavBar(): '';					
					that.feedback.style(field, 'is-valid');
					that.feedback.set(field, '');
					//that.updateData(field);
					
						
					
				}else{
					that.feedback.set(field , that.form.getMessage(field));
					that.feedback.style(field, 'is-invalid');
				}
			}

		}, 500),
		// ______________________________________________
		// HTTP REQUESTS:
		// ______________________________________________
		storeData: function(field) {
			console.log("End Point: updateData() breached!");
			let that = (this);
			axios.patch( that.route + that.client.id, {
					[field]: that.client[field],
				})
				.then(function(response) {
					that.client.updated_at = response.data.updated_at;
					console.log("End Point: updateData() updated!");
				})
				.catch(function(error) {
					if(error.response.data.errors){ 	// back-end validation failed.
						let errors = error.response.data.errors;
						for(let prop in errors){
							that.feedback.set( prop, errors[prop][0]);
							that.feedback.style(prop, 'is-invalid');
						}
						
					}else{								// server encounter an error
						that.alert.view = false;
						that.alert.fail.state = true;
						that.alert.fail.msg = "We could not update this record."

					}
				});
		},
		onFileChange (event) {
			const that = (this);
			const file = event.target.files[0];
			const fileName = (Math.random().toString(36).substring(7)) + event.target.files[0].name;
			
			const formData = new FormData();
			formData.append( 'file', file );
			formData.append( 'image', fileName );

			axios.post( '/clients/1/image', formData )
			.then( function(response){
				console.log(response);
				that.style_image = 'bg-light-success';
				that.feedback_image = 'Your image has been uploaded!';
				that.client.image = response.data.image;
				that.client.updated_at = response.data.updated_at;

			}).catch( function(error) {
				if(error.response.data.errors){ 	// back-end validation failed.
						const errors = error.response.data.errors;
						that.feedback_image = errors;
						that.style_image = 'bg-light-danger';
						
					}else{								// server encounter an error
						that.alert.view = false;
						that.alert.fail.state = true;
						that.alert.fail.msg = "We could not update this record."

					}
			});
			
		},
        // ______________________________________________
		// RUN UPON MOUNTING COMPONENT:
		// ______________________________________________
		initData: function() {
			this.states = UsaStates;
			let prop = Object.keys(FormRules);
			for(let name in prop){						// set editing props.
				this.$set(this.editing , [prop[name]] , false );
			}	 

        },
        onCloseAlertFail: function() {
	   		let that = (this);
	    	Event.listen('close_alert', function() {
				that.alert.view = true;
				that.alert.fail.msg = '';
				that.alert.fail.state = false;
		
	    	});
        },
        initValidationRules: function() {
			this.form.setRules(FormRules);	// set rules for form fields.

        },
        initFeedBackFields: function() {
			let fields = Object.keys(FormRules);
			for(let field in fields){	
				this.$set(this.feedback.class, [fields[field]], '', );   // class fields.
				this.$set(this.feedback.messages, [fields[field]], [] ); // messages fields.

			}

		},

    },
    mounted: function() {
        this.initData();
		this.onCloseAlertFail();	 
		this.initFeedBackFields();
		this.initValidationRules();
      
    }

}



</script>


// CLIENT: NEW RECORD STYLING
<style scoped>
legend{
    margin-bottom: 0px;
}
li{
    color: #34495e !important;
    padding-top: 1px !important;
    padding-bottom: 1px !important;
}


</style>