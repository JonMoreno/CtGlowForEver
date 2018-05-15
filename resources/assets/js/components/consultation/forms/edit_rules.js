const edit_rules = {
    next_appointment: {  
        min: 10,
        max: 10,
        type: 'date',
        required: false,
    },
    notes: {
        min: 10,
        max: 500,
        type: 'text',
        required: true,
    },
    time: {
        min: 4,
        max: 15,
        type: 'time',
        required: false,
    }
}

export default edit_rules;