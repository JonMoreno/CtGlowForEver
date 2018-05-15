
/* 
* First, Boot Strap all JavaScript dependencies and 
* libraries.
*/
require('./bootstrap.js');  

import axios from 'axios';
Object.defineProperty(Vue.prototype, '$http', { value: axios }); 

import moment from  'moment';
Object.defineProperty(Vue.prototype, '$moment', { value: moment });

import lodash from  'lodash';
Object.defineProperty(Vue.prototype, '_lodash', { value: lodash });


/* 
* Next, we will load primary components for this 
* specific JavaScript dependency file.  
*/
//Primary Components______________________________
import EventRegistry from './components/main/EventRegistry.vue';
import Calendar from './components/calendar/FullCalendar.vue';
import AsideMenu from './components/main/AsideMenu.vue';

import AnimateBounce from './components/main/animations/Bounce.vue';

/* 
* Next, we will load secondary components for this 
* specific JavaScript dependency file.
*/
//Secondary Components___________________________
// clients
import ClientForm from './components/client/Form.vue';
import ClientList from './components/client/List.vue'; 
import ClientCard from './components/client/Card.vue'; 
import ClientDropDown from './components/client/DropDown.vue'; 
import ClientRevise from './components/client/Revise.vue';
// appointments
import ClientListGroup from './components/appts/ClientListGroup.vue';

// medicals
import MedicalCard from './components/Medical/MedicalCard.vue';
import SurgeryCard from './components/Medical/SurgeryCard.vue';
import IllnessCard from './components/Medical/IllnessCard.vue';
import AllergieCard from './components/Medical/AllergieCard.vue';
import MedicalCardGroup from './components/Medical/CardGroup.vue';
import MedicationCard from './components/Medical/MedicationCard.vue';
import SkinProductCard from './components/Medical/SkinProductCard.vue';
import StressLevelCard from './components/medical/StressLevelCard.vue';

// consultations
import ConsultationList from './components/consultation/show/List.vue';
import ConsultationModal from './components/consultation/create/Modal.vue';

// services
import ProductList from './components/services/product/ProductList.vue';
import DiscountList from './components/services/discount/DiscountList.vue';
import TreatmentList from './components/services/treatment/TreatmentList.vue';

// dashboard
import ReminderWidget from './components/dashboard/ReminderWidget.vue';
import WelcomeWidget from './components/dashboard/WelcomeWidget.vue';

// lock screen
import ClientLockScreen from './components/main/modals/LockScreen.vue';

import QuickLogin from './components/client/QuickLogin.vue';
import FormStatus from './components/client/create/FormStatus.vue';
import LangSelect from './components/client/create/LangSelect.vue';

import ClientCredentialsForm from './components/client/create/CredentialsForm.vue';

import MedicalForm from './components/client/create/MedicalForm.vue';
import AllergiesForm from './components/client/create/AllergiesForm.vue';
import IllnessesForm from './components/client/create/IllnessesForm.vue';
import SurgeriesForm from './components/client/create/SurgeriesForm.vue';
import MedicationsForm from './components/client/create/MedicationsForm.vue';
import StressLevelForm from './components/client/create/StressLevelForm.vue';
import SkinProductsForm from './components/client/create/SkinProductsForm.vue';

import TermsNConditions from './components/client/create/TermsNConditions.vue';
import SignaturePad from './components/main/SignaturePad.vue';


/* 
* Finally, create a new Vue instance which will work
* as your web aplication's main entry hook point.
*/
const app = new Vue({  
	
	el: '#app',
//------------------------------------------------------
// CHILD COMPONENTS:
//------------------------------------------------------
    components: {
		// App:
		'aside-menu': AsideMenu,	
		// Calendar:
		'full-calendar': Calendar,
		// Client:  
		'client-form': ClientForm,  
		'client-list': ClientList,
		'client-revise': ClientRevise,
		'client-dropdown': ClientDropDown,
		// Medical:
		'medical-card-group': MedicalCardGroup,
		'medical-card': MedicalCard,
		'stress-level-card': StressLevelCard,
		'skin-product-card': SkinProductCard,
		'medication-card': MedicationCard,
		'allergie-card': AllergieCard,
		'surgery-card': SurgeryCard,
		'illness-card': IllnessCard,
		// Consultation:
		'consultation-list' : ConsultationList,
		'consultation-modal': ConsultationModal,
		// Services:
		'product-list': ProductList,
		'discount-list': DiscountList,
		'treatment-list': TreatmentList,
		// Appointment:
		'appt-list': ClientListGroup,
		// Quote Widget:
		'welcome-widget': WelcomeWidget,
		// Events Reminder:
		'reminder-widget': ReminderWidget,
		// Lock Screen:
		'client-lock-screen': ClientLockScreen,

		'event-registry': EventRegistry,

		'client-form-status': FormStatus,

		'select-lang': LangSelect,

		'credentials-form': ClientCredentialsForm,

		'quick-login': QuickLogin,

		'lang-select': LangSelect,

		'medical-form': MedicalForm,
		'illnesses-form': IllnessesForm,
		'allergies-form': AllergiesForm,
		'surgeries-form': SurgeriesForm,
		'medications-form': MedicationsForm,
		'stress-level-form': StressLevelForm,
		'skin-products-form': SkinProductsForm,
		
		'terms-conditions': TermsNConditions,
		'signature-pad': SignaturePad,

		//Animation
		'animate-bounce': AnimateBounce

	}, 
//------------------------------------------------------
// REACTIVE DATA:s
//------------------------------------------------------
    data: {
		render: { 
			welcome_page: false,
			search_client: false
		},
		views:{
			mobileMenu: false,
		},
		isActivePointer: true,
	}, 
//------------------------------------------------------
// METHODS:
//------------------------------------------------------
    methods: { 
		onConsultation: function(){
			Event.fire('onAsideNavPreLoadConsultation');

		},
		listenOnRenderSearchClient: function(){
			const vi = this;
			Event.listen('onRenderSearchClient', function(val){ 
				vi.render.search_client = !val;
			});

		},
		toggleMobileMenu: function(){
			this.views.mobileMenu = !this.views.mobileMenu;
		},
		showLockScreenModal: function(){
			Event.fire('OnLockScreenModal');
		}
	},
//------------------------------------------------------
// LYFECYCLE HOOKS:
//------------------------------------------------------
	mounted: function() {
		const vi = this;

		vi.render.welcome_page = true;
		
		vi.listenOnRenderSearchClient();

		$("#html-ready" ).css( "display", "block" );// prevents from showing raw html:

		setTimeout( function(){ // enable calendar mouse:
           vi.isActivePointer = false;
		},2500);

		$(function () { // enable tooltips:
			$('[data-toggle="tooltip"]').tooltip()
		});

	}	
});  

