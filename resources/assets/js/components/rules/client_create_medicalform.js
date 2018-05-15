
/**
 * These rules belong to a specific component
 * the component's location is specified by
 * the file's name each underscore implies
 * a directory. Example:
 * /client/create/medicalform
 */
const FormRules = {
    dermatologist: {
        min: 1,
        max: 5,
        type: 'boolean',
        required: true
    },
    pregnant: {
        min: 1,
        max: 5,
        type: 'boolean',
        required: true
    },
    glasses: {
        min: 1,
        max: 5,
        type: 'boolean',
        required: true
    },
    smoke: {
        min: 1,
        max: 5,
        type: 'boolean',
        required: true
    },
};

export default FormRules;