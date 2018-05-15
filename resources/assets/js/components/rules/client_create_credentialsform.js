
/**
 * These rules belong to a specific component
 * the component's location is specified by
 * the file's name each underscore implies
 * a directory. Example:
 * /client/create/credentialsform
 */
const FormRules = {
    first_name: {  
        min: 1,
        max: 15,
        type: 'text',
        required: true,
    },
    mid_initial: {
        min: 1,
        max: 1,
        type: 'text',
        required: false,
    },
    last_name: { 
        min: 1,
        max: 25,
        type: 'text',
        required: true,
    },
    cellular: {
        min: 9,
        max: 15,
        type: 'phone',
        required: true, 
    },
    emergency_phone: {
        min: 9,
        max: 15,
        type: 'phone',
        required: false, 
    },
    apt_floor: {
        min: 1,
        max: 10,
        type: 'text',
        required: false, 
    },
    street: {
        min: 2,
        max: 25,
        type: 'text',
        required: true, 
    },
    city: {
        min: 3,
        max: 15,
        type: 'text',
        required: true, 
    },
    state: {
        min: 1,
        max: 2,
        type: 'text',
        required: true, 
    },
    zip: {
        min: 5,
        max: 5,
        type: 'number',
        required: true, 
    },
    day: {
        min: 1,
        max: 2,
        type: 'number',
        required: true,
    },
    month: {
        min: 1,
        max: 10,
        type: 'text',
        required: true,
    },
    year: {
        min: 4,
        max: 4,
        type: 'number',
        required: true,
    },
    gender: {
        min: 4,
        max: 7,
        type: 'text',
        required: true,
    },
    first_facial: {
        min: 1,
        max: 5,
        type: 'text',
        required: true,
    },  
    visit_reason: {
        min: 2,
        max: 250,
        type: 'text',
        required: true,
    },
    email: {
        min: 1,
        max: 250,
        type: 'email',
        required: false,
    },
    occupation: {
        min: 1,
        max: 25,
        type: 'text',
        required: false,
    }
};

export default FormRules;