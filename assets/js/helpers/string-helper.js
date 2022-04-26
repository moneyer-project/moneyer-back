
class StringHelper {

    upperFirst(value) {
        return value.charAt(0).toUpperCase() + value.slice(1);
    }
}

export default new StringHelper();
