/**
 * These rules belong to a specific component
 * the component's location is specified by
 * the file's name each underscore implies
 * a directory. Example:
 * /client/create/surgeriesform
 */
const FormRules = {
    surgeries:{
        min: 0,
        max: 25,
        type: 'array',
        required: false
    }
};

export default FormRules;