const client_drowpdown_rules = {
    first_name: {
        min: 1,
        max: 15,
        type: 'text',
        required: true,
    },
    last_name: {
        min: 2,  
        max: 15,
        type: 'text',
        required: true,
    },
    email: {   
        min: 6,
        max: 250,
        type: 'email',
        required: false,
    },
    cellular: {
        min: 9,
        max: 15,
        type: 'phone',
        required: false,
    },
    image: {
        min: 1,
        max: 60,
        type: 'text',
        required: false,
    }

};

export default client_drowpdown_rules;