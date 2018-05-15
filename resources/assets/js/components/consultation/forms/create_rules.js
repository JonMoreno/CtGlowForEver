const create_rules =  {
    next_appointment: {  
        min: 10,
        max: 10,
        type: 'date',
        required: false,
    },
    time: {
        min: 4,
        max: 15,
        type: 'time',
        required: false,
    },
    notes: {
        min: 10,
        max: 500,
        type: 'text',
        required: false,
    }
}
export default create_rules;