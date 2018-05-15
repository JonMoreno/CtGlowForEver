/**
 * These rules belong to a specific component
 * the component's location is specified by
 * the file's name each underscore implies
 * a directory. Example:
 * /client/create/allergiesform
 */
const FormRules = {
    stress_level:{
        min: 1,
        max: 2,
        type: 'number',
        required: true
    }
};

export default FormRules;