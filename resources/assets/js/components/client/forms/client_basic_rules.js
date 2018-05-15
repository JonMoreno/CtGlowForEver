const client_basic_rules =  {
    first_name: {  
        min: 2,
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
        max: 15,
        type: 'text',
        required: true,
    },  
    cellular: {
        min: 9,
        max: 15,
        type: 'phone',
        required: true, 
    },
    work_phone: {
        min: 9,
        max: 15,
        type: 'phone',
        required: false, 
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
        min: 5,
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
    /// CONTINUE VALIDATION OF FIELDS FRONT AND BACK END: :)
    state: {
        min: 2,
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
    dob: {
        min: 10,
        max: 10,
        type: 'date',
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
        required: false,
    }, 
    occupation: {
        min: 2,
        max: 250,
        type: 'text',
        required: false,
        max: 60,
    },
    visit_reason: {
        min: 2,
        max: 250,
        type: 'text',
        required: false,
        max: 60,
    },
    image: {
        min: 1,
        type: 'text',
        required: true,
    },
    email: {
        min: 1,
        max: 250,
        type: 'text',
        required: true,
    }
    
};


export default client_basic_rules;